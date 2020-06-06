<?php
require "header.php";

$view = new UserView();
?>

<div class="container">
  <div class="jumbotron mt-1">
    <?php
        unset($_SESSION['loggedin']);
        unset($_SESSION['name']);
        $view->loggedOut();
     ?>
  </div>
</div>

<?php
require "footer.php";
?>
