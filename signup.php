<?php
require "header.php";

$view = new UserViews();
?>

<div class="container">
  <div class="jumbotron">
    <?php
    if (!isset($_POST['username'])) {
      $view->register();
      $view->registerSuccess();
    } else {
      $userCtrl = new UserCtrl();

      $username = $_POST['username'];
      $email = $_POST['email'];
      $pwd = $_POST['passwd'];
      $pwdrpt = $_POST['passwdrpt'];

      echo $userCtrl->registerUser($username, $email, $pwd, $pwdrpt);
      echo "<br> Registered successfully!<br>";
    }
    ?>
  </div>
</div>

<?php
require "footer.php";
?>
