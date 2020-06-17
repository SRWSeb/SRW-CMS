<?php
require 'header.php';
//$view = new AdminView();
?>

<div class="container">

  <?php

  $driverCtrl = new DriverCtrl();

  $driverList = $driverCtrl->getDriverList();

  echo '<datalist id="drivers">';
  foreach ($driverList as $key => $driver) {
    echo '<option value="'.$driver['display_name'].'">';
  }
  echo '</datalist>';
  ?>

  <label for="driver">Select driver to edit:</label>
  <input list="drivers" name="driver" id="driver">

</div>

<?php
require 'footer.php';
?>
