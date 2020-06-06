<?php
require "header.php";
$userCtrl = new UserCtrl();
$view = new UserView();
?>

<div class="container">
  <div class="jumbotron mt-1">
    <?php
      if(isset($_POST['username']) && isset($_POST['passwd'])) {
        if($userCtrl->loginUser($_POST['username'], $_POST['passwd'])) {
          $view->loginSuccess();
        } else {
          $view->loginFail();
        }
      }
     ?>
  </div>
</div>

<?php
require "footer.php";
?>
