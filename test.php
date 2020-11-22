<?php
  require "header.php";

  echo $m->render('hello_world', array('planet' => 'Earth'));

  require "footer.php";
?>
