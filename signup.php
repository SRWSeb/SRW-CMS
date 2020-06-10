<?php
require "header.php";

$view = new UserView();
$userCtrl = new UserCtrl();
?>

<div class="container mt-1">
    <?php
    if (!isset($_POST['username'])) {
        $view->register();
    } else {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $pwd = $_POST['passwd'];
      $pwdrpt = $_POST['passwdrpt'];

      if (empty($username) || empty($email) || empty($pwd) || empty($pwdrpt)) {
        $view->missingInfo();
        $view->register();
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $view->invalidEmail();
        $view->register();
      } elseif (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $view->invalidUsername();
        $view->register();
      } elseif ($pwd !== $pwdrpt) {
        $view->passwordMismatch();
        $view->register();
      } else {
        if ($userCtrl->registerUser($username, $email, $pwd, $pwdrpt)) {
          $view->registerSuccess($username, $email);
        } else {
          $view->usernameTaken($username);
          $view->register();
        }

      }
    }
    ?>
</div>

<?php
require "footer.php";
?>
