<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!isset($_POST['process-csv'])) {
  header("Location: ../entercsv.php");
  exit();
}

require 'dbh.inc.php';

//Takes day and time straight out of the results csv and returns it in a MySQL compatible format.
function parseDate ($datetime) {
  //Get rid of the GMT
  $datetime = chop($datetime,"GMT");
  //Parse Date into usable array
  $datetime = date_parse_from_format("Y.m.d h:i a",$datetime);
  //Build string for MySQL and return it
  return $datetime['year'] . "-" . $datetime['month'] . "-" . $datetime['day'] . " " . $datetime['hour'] . ":" . $datetime['minute'] . ":00";
}

//Checks the results table if the checksum is already in there. Returns true for a double, false for no double.
function checkDoubles ($conn, $checksum) {
  //Get field checksum from table events if the provided checksum matches
  $stmt = "SELECT checksum FROM race_events WHERE checksum=\"$checksum\"";
  $result = $conn->query($stmt);
  $result = $result->fetch_assoc();
  //If we get a result, we obviously have a double and return true.
  if($result) {
    return true;
  }
  //If otherwise we had no match and no double. So we return false.
  return false;
}

//Checks if start position is zero, the it's a practice or quali session. Returns true if it's a race session, false otherwise.
function isRace ($data) {
  foreach ($data as $key => $value) {
    $row = str_getcsv($value);
    if($row[8] == 0) {
      return false;
    } else {
      return true;
    }
  }
}

//Checks the drivers table if driver is already in the database
function checkDriverExists ($conn, $iracingid) {
  $sql = "SELECT iracing_name FROM drivers WHERE iracing_id=?";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "i", $iracingid);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $rows = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);

  if($rows > 0) {
    return true;
  }
  return false;
}

//Enters a new driver into the database.
function newDriver ($conn, $data) {
  $iracingid = $data[6];
  $name = utf8_encode($data[7]);

  $sql = "INSERT INTO drivers (iracing_id, iracing_name, display_name) VALUES (?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "iss", $iracingid, $name, $name);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

}

//Checks if driver is already attached to the season. Returns true if he is, false otherwise
function checkDriverInSeason ($conn, $driver_id, $season_id) {
  $sql = "SELECT * FROM season_driver_info WHERE driver_id = ? AND season_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ii", $driver_id, $season_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $rows = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  if($rows > 0) {
    return true;
  }
  return false;
}

//Adds a driver to an existing season, champ pts and inc are initialized to NULL by default
function addDriverToSeason ($conn, $driver_id, $season_id, $car_id, $driver_class) {
  $sql = "INSERT INTO season_driver_info (driver_id, season_id, selected_car_id, driver_class) VALUES (?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "iiis", $driver_id, $season_id, $car_id, $driver_class);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
}

//Checks if track is already in database. Returns trackID if exist, 0 if not
function checkTrackExists ($conn, $trackname) {
  $sql = "SELECT * FROM tracks WHERE trackname=?";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $trackname);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_array($result);
  mysqli_stmt_free_result($stmt);
  mysqli_stmt_close($stmt);

  if (isset($row['id'])) {
    return $row['id'];
  }
  return 0;
}

//Enters a new track into the database and returns the trackID.
function newTrack ($conn, $trackname) {
  $sql = "INSERT INTO tracks (trackname) VALUES (?)";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $trackname);
  mysqli_stmt_execute($stmt);
  $trackid = mysqli_stmt_insert_id($stmt);
  mysqli_stmt_close($stmt);
  return $trackid;
}

//Get intern ID of car
function getCarID ($conn, $iracing_car_id) {
  $sql = "SELECT * FROM cars WHERE iracing_car_id=?";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "i", $iracing_car_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row =mysqli_fetch_array($result);
  return $row['id'];
}

//Get intern ID of driver
function getDriverID ($conn, $iracing_id) {
  $sql = "SELECT * FROM drivers WHERE iracing_id=?";
  $stmt = mysqli_stmt_init($conn);

  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "i", $iracing_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row =mysqli_fetch_array($result);
  return $row['id'];
}

//Searches db with iracing season ID and returns the internal season id
function getInternalSeasonID ($conn, $season_id) {
  $sql = "SELECT * FROM seasons WHERE iracing_season_id=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $season_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row =mysqli_fetch_array($result);
  return $row['id'];
}

//Returns the points system for the season and returns it as an array
function getPointsArray ($conn, $iracing_season_id) {
  $sql = "SELECT * FROM seasons WHERE iracing_season_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $iracing_season_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
  return str_getcsv($rows[0]['points_system']);
}

//Identifies the correct round by season ID and track and returns the round ID
function getRoundID ($conn, $season_id, $track_id) {
  $sql = "SELECT * FROM rounds WHERE season_id = ? AND track_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ii", $season_id, $track_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  mysqli_stmt_close($stmt);
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
  foreach ($rows as $key => $value) {
    if ($value['event_id'] == NULL) {
      return $value['id'];
    }
  }
  return NULL;
}

//Gets the minimum race distance a driver has to complete to get classified
function getPercentRule ($conn, $leagueid) {
  $sql = "SELECT * FROM seasons WHERE id=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $leagueid);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row =mysqli_fetch_array($result);
  return $row['percent_rule'];
}

function minDistance ($data, $percent_rule) {
  $temp = str_getcsv($data);
  return $temp[18] / 100 * $percent_rule;
}

//Get the .csv file from the POST
$input = file($_FILES['inputcsv']['tmp_name']);

//Create Checksum to verify doubles, if a double is detected, send back to the previous page with error Info
$checksum = "'".sha1_file($_FILES['inputcsv']['tmp_name'])."'";
if(checkDoubles($conn, $checksum)) {
  header("Location: ../entercsv.php?error=double");
  exit();
}
//Remove first line, don't need that
array_shift($input);
//Extract Event Infos into
$eventInfo = str_getcsv(array_shift($input));
//Remove third-fifth line, not needed
array_shift($input);
array_shift($input);
array_shift($input);
array_shift($input);
//Extract League Info into array
$leagueInfo = str_getcsv(array_shift($input));
//Remove seventh & eighth line, not needed
array_shift($input);
array_shift($input);

//Check if the entered event is a race, if not -> send back
if (!isRace($input)) {
  header("Location: ../entercsv.php?error=notrace");
  exit();
}

//Prepare data to enter into race_events mysql_list_tables
$datetime = parseDate($eventInfo[0]);
$leagueid = $leagueInfo[1];
$seasonid = getInternalSeasonID($conn, $leagueInfo[3]);
$track = utf8_encode($eventInfo[1]);
$trackid = checkTrackExists($conn, $track);
$points = getPointsArray($conn, $leagueInfo[3]);
$rounds_id = getRoundID($conn, $seasonid, $trackid);
$percent_rule = getPercentRule($conn, $seasonid);
$min_distance = minDistance($input[0], $percent_rule);

//If trackid is 0 it means that track does not exist. So enter new track into DB.
if($trackid == 0) {
  $trackid = newTrack($conn, $eventInfo[1]);
}

//Prepare SQL and execute
$sql = "INSERT INTO race_events (checksum, time_and_day, track_id, league_id, season_id) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../entercsv.php?error=sqlerror");
  exit();
}
mysqli_stmt_bind_param($stmt, "ssiii", $checksum, $datetime, $trackid, $leagueid, $seasonid);
mysqli_stmt_execute($stmt);
$eventid = mysqli_stmt_insert_id($stmt);
mysqli_stmt_close($stmt);

$sql = "UPDATE rounds SET event_id = ? WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)) {
  header("Location: ../entercsv.php?error=sqlerror1");
  exit();
}
mysqli_stmt_bind_param($stmt, "ii", $eventid, $rounds_id);
if(mysqli_stmt_execute($stmt)) {
  mysqli_stmt_close($stmt);
} else {
  echo mysqli_stmt_error($stmt)."<br>";
  mysqli_stmt_close($stmt);
  exit();
}

//Prepare and enter data into the race_results & champ_pts_transactions tables
foreach ($input as $key => $value) {
  $line = str_getcsv($value);
  $car_id = getCarID($conn, $line[1]);
  if(!checkDriverExists($conn, $line[6])) {
    newDriver($conn, $line);
  }
  $driver_id = getDriverID($conn, $line[6]);
  if(!checkDriverInSeason($conn, $driver_id, $seasonid)) {
    addDriverToSeason($conn, $driver_id, $seasonid, $car_id, "Standard");
  }
  $carclass_id = 1;
  $start_pos = $line[8];
  $race_pos = $line[0];
  $laps_comp = $line[18];
  $race_fastest_lap = "00:".$line[16]."000";
  $race_fastest_lap_num = $line[17];
  $race_average_lap = "00:".$line[15]."000";
  $race_inc = $line[19];
  $point_value = $points[$race_pos-1];
  $inc_value = $line[19];
  $bonus_pts = 3;
  $inc_reason = "Incident points from race.";

  $sql = "INSERT INTO race_results (event_id, driver_id, car_id, carclass_id, start_pos, race_pos, laps_comp, race_fastest_lap, race_fastest_lap_num, race_average_lap, race_inc) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "iiiiiiisisi", $eventid, $driver_id, $car_id, $carclass_id, $start_pos, $race_pos, $laps_comp, $race_fastest_lap, $race_fastest_lap_num, $race_average_lap, $race_inc);
  if(mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
  } else {
    echo mysqli_stmt_error($stmt)."<br>";
    mysqli_stmt_close($stmt);
    exit();
  }

  $sql = "INSERT INTO inc_transactions (driver_id, rounds_id, inc_amount, inc_reason) VALUES (?,?,?,?)";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../entercsv.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "iiis", $driver_id, $rounds_id, $inc_value, $inc_reason);
  if(mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
  } else {
    echo mysqli_stmt_error($stmt)."<br>";
    mysqli_stmt_close($stmt);
    exit();
  }

  if ($laps_comp > $min_distance) {
    $sql = "INSERT INTO champ_pts_transactions (driver_id, rounds_id, pts_amount) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: ../entercsv.php?error=sqlerror");
      exit();
    }
    mysqli_stmt_bind_param($stmt, "iii", $driver_id, $rounds_id, $point_value);
    if(mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);
    } else {
      echo mysqli_stmt_error($stmt)."<br>";
      mysqli_stmt_close($stmt);
      exit();
    }
    if ($inc_value <= 5) {
      $sql = "INSERT INTO champ_pts_transactions (driver_id, rounds_id, pts_amount) VALUES (?,?,?)";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../entercsv.php?error=sqlerror");
        exit();
      }
      mysqli_stmt_bind_param($stmt, "iii", $driver_id, $rounds_id, $bonus_pts);
      if(mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
      } else {
        echo mysqli_stmt_error($stmt)."<br>";
        mysqli_stmt_close($stmt);
        exit();
      }
    }
  }
}

//Send back with success flag and event ID
header("Location: ../entercsv.php?success=event&eventid=".$eventid);
