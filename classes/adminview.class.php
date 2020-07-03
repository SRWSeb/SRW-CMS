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

  public function buildDriverList($driverArray) {
    $tablehead = '<div class="jumbotron">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">iRacing Name</th>
          <th scope="col">Display Name</th>
          <th scope="col">Car</th>
          <th scope="col">Class</th>
          <th scope="col">Active Driver</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>';
    $tablecontent = '';
    $tablefoot = '</tbody>
    </table>
    </div>';

    foreach ($driverArray as $key => $value) {
      $tablecontent .= '<tr>';
      $tablecontent .= '<td>'.$value['iracing_name'].'</td>';
      $tablecontent .= '<td>'.$value['display_name'].'</td>';
      $tablecontent .= '<td>'.$value['car_name'].'</td>';
      $tablecontent .= '<td>'.$value['driver_class'].'</td>';
      $tablecontent .= '<td>';
      if ($value['active'] == 1) {
        $tablecontent .= 'Yes';
      } else {
        $tablecontent .= 'No';
      }
      $tablecontent .= '</td>';
      $tablecontent .= '<td><a class="btn btn-secondary" href="driveradmin.php?season='.$value['season_id'].'&edit='.$value['driver_id'].'" role="button">Edit</a>';
      $tablecontent .= '</tr>';

    }

    $view = $tablehead . $tablecontent . $tablefoot;

    echo $view;
  }

}
