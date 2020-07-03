<?php

class AdminView {

  public function leagueSelect($leagueArray) {
    $seasons = '<optgroup label="Active Series">';
    foreach ($leagueArray as $key => $value) {
      if ($value['active'] == 1) {
        $seasons .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
      }
    }
    $seasons .= '</optgroup>';
    $seasons .= '<optgroup label="Past Series">';
    foreach ($leagueArray as $key => $value) {
      if ($value['active'] == 0) {
        $seasons .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
      }
    }
    $seasons .= '</optgroup>';

    $view='<div class="jumbotron">
      <form action="/SRW-CMS/driveradmin.php" enctype="multipart/form-data" method="get">
        <div class="row">
          <div class="col-sm">
            <select id="seasons" name="season" class="form-control">'.
            $seasons.
            '</select>
          </div>
          <div class="col-sm">
            <input type="submit" value="Get Drivers" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>';

    echo $view;
  }

  public function buildDriverEdit($driverArray) {
    $tablehead = '<div class="jumbotron">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">iRacing Name</th>
          <th scope="col">Display Name</th>
          <th scope="col">Selected Car</th>
          <th scope="col">Class</th>
        </tr>
      </thead>
      <tbody>';
      $tablecontent = '';
      $tablefoot = '</tbody>
      </table>
      </div>';

      $view = $tablehead . $tablecontent . $tablefoot;
      echo $view;
  }

}
