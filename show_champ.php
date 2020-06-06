<?php
require "header.php";
require 'includes/dbh.inc.php';
?>
<main>
  <?php
  $sql = "SELECT leagues_seasons.*, seasons.season_name, leagues.league_name  FROM leagues_seasons
  JOIN seasons ON leagues_seasons.season_id = seasons.id
  JOIN leagues ON leagues_seasons.league_id = leagues.id";
  $stmt = mysqli_stmt_init($conn);
  if(mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $leagues_seasons_rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
  } else {
    echo mysqli_stmt_error($stmt)."<br>";
    mysqli_stmt_close($stmt);
    exit();
  }

  if(isset($_GET['season'])) {
    $seasonid = $_GET['season'];
    $sql = "SELECT season_driver_info.*, drivers.display_name, cars.car_name, seasons.rounds FROM season_driver_info
    JOIN drivers ON season_driver_info.driver_id = drivers.id
    JOIN cars ON season_driver_info.selected_car_id = cars.id
    JOIN seasons ON season_driver_info.season_id = seasons.id
    WHERE season_id = ? ORDER BY driver_champ_pts DESC";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, "i", $seasonid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $season_driver_rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_stmt_close($stmt);
    } else {
      echo mysqli_stmt_error($stmt)."<br>";
      mysqli_stmt_close($stmt);
      exit();
    }
  }

  function getDriverTransactions ($conn, $driver_id, $season_id) {
    $sql = "SELECT champ_pts_transactions.*, rounds.* FROM champ_pts_transactions
    JOIN rounds ON champ_pts_transactions.rounds_id = rounds.id
    WHERE season_id = ? AND driver_id = ? ORDER BY round_num ASC";

    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt,"ii", $season_id, $driver_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      $driver_results = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_stmt_close($stmt);
      return $driver_results;
    } else {
      echo mysqli_stmt_error($stmt)."<br>";
      mysqli_stmt_close($stmt);
      exit();
    }
  }

  ?>

  <div class="container">
    <form action="/SRW-CMS/show_champ.php" enctype="multipart/form-data" method="get">
      <div class="row">
        <div class="col-sm">
          <select id="leagues" name="league" class="form-control">
            <?php foreach ($leagues_seasons_rows as $key => $value): ?>
              <option value="<?php echo $value['league_id'];?>"><?php echo $value['league_name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm">
          <select id="seasons" name="season" class="form-control">
            <?php foreach ($leagues_seasons_rows as $key => $value): ?>
              <option value="<?php echo $value['season_id']; ?>"><?php echo $value['season_name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-sm">
          <input type="submit" value="Get_Standings" name="standings" class="btn btn-primary">
        </div>
      </div>
    </form>
    <div class="row">
      <br>
    </div>

    <?php if (isset($_GET['season'])): ?>
      <div class="row">
        <div class="jumbotron">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Car</th>
                <?php for ($i = 0; $i < $season_driver_rows[0]['rounds']; $i++): ?>
                  <th scope="col">Round <?php echo $i+1; ?></th>
                <?php endfor; ?>
                <th scope="col">Championship Points</th>
                <th scope="col">Incident Points</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($season_driver_rows as $key => $value):
                $driver_rounds = getDriverTransactions($conn, $value['driver_id'], $value['season_id']);
                ?>
                <tr>
                  <th scope="row"><?php echo $key+1; ?></th>
                  <td><?php echo $value['display_name']; ?></td>
                  <td><?php echo $value['car_name']; ?></td>
                  <?php for ($i = 0; $i < $value['rounds']; $i++): ?>
                    <td><?php
                    if (isset($driver_rounds[0])) {
                      if ($driver_rounds[0]['round_num'] == $i+1) {
                        $current = array_shift($driver_rounds);
                        echo $current['pts_amount'];
                      } else {
                        echo "0";
                      }
                    } else {
                      echo "0";
                    }
                    ?></td>
                  <?php endfor; ?>
                  <td><?php echo $value['driver_champ_pts']; ?></td>
                  <td><?php echo $value['driver_inc_pts']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>

  </div>
</main>

<?php
require "footer.php";
?>
