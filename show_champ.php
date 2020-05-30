<?php
require "header.php";
require 'includes/dbh.inc.php';
?>
<main>
  <?php
  $iracing_season_id = 48937;
  $sql = "SELECT * FROM seasons WHERE iracing_season_id = ?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../show_champ.php?error=sqlerror");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $iracing_season_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
  $csv = str_getcsv($rows[0]['points_system']);
  foreach ($csv as $key => $value) {
    echo $value."<br>";
  }
   ?>
</main>

<?php
require "footer.php";
?>
