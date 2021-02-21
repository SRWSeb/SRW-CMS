<?php
require "header.php";
?>

<main>
  <div class="container">
    <div class="jumbotron">
      <?php
        $av = new AdminView();
        $t = new TeamCtrl();

        if(isset($_GET['edit'])) {
          $teaminfo = $t->getTeamInfo($_GET['edit']);
          $av->teamEdit($teaminfo);
        }

        if(isset($_GET['add'])) {
          if(!$t->addTeam($_GET['add'])) {
            echo "Team already exists<br>";
          }
        }

        $allteams = TeamCtrl::getAllTeams();

        $av->teamShowAll($allteams);
        $av->teamAdd();
      ?>
   </div>
  </div>
</main>


<?php
require "footer.php";
?>
