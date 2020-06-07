<?php
require 'header.php';
$view = new UserView();
?>

<div class="container">
  <?php
  if(isset($_GET['action'])) {
    if ($_GET['action'] == "logout") {
      $view->loggedOut();
    } elseif ($_GET['action'] == "credentials") {
      $view->loginFail();
    } elseif ($_GET['action'] == "loginFailed") {
      $view->loginFail();
    } elseif ($_GET['action'] == "loginSuccess") {
      $view->loginSuccess();
    }
  }
  ?>
</div>

<?php
require 'footer.php';
?>
