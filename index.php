<?php
require 'header.php';
$view = new UserView();
?>

<div class="container">
  <?php
  if(isset($_GET['action'])) {
    if ($_GET['action'] == "logout") {
      $view->loggedOut();
    } elseif ($_GET['action'] == "loginFailed") {
      $view->loginFail();
    } elseif ($_GET['action'] == "loginSuccess") {
      $view->loginSuccess();
    }
  }
  ?>
  <div class="jumbotron text-center">
  <h1>Current series</h1>
  <a href="standings.php?season=7"><img src="media/BMW_LOGO.png" class="img-fluid pt-3"></a>
  <a href="standings.php?season=6"><img src="media/NASCAR_LOGO.png" class="img-fluid pt-3"></a>
  </div>
</div>

<?php
require 'footer.php';
?>
