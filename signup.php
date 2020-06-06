<?php
require "header.php";

$view = new UserView();
$userCtrl = new UserCtrl();
?>

<div class="container mt-1">
  <div class="jumbotron">
    <?php
    if (!isset($_POST['username'])) {
        $view->register();
    } else {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $pwd = $_POST['passwd'];
      $pwdrpt = $_POST['passwdrpt'];

      $userCtrl->registerUser($username, $email, $pwd, $pwdrpt);
      $view->registerSuccess($username, $email);
    }
    ?>
  </div>
</div>

<?php
require "footer.php";
?>
