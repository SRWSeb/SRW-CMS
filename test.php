<?php
  require "header.php";
  $user = new User();

  $result = $user->getUser("Seb", "seb@web.de");
  var_export($result);

  require "footer.php";
?>
