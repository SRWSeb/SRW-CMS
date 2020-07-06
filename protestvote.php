<?php
require 'header.php';
$view = new ProtestView();
?>

<div class="container">
  <?php

  if(!isset($_GET['token'])) {
    $view->enterToken();
  } elseif ($_GET['token'] == 'asd') {
    $protestCtrl = new ProtestCtrl();
    $protestID = 5;
    $seasonID = 3;

    $protestCtrl->loadProtest($protestID);
    $protest = $protestCtrl->getProtestData();

    $view->protestVote($protest);
  }

  ?>
</div>


<?php
require 'footer.php';
?>
