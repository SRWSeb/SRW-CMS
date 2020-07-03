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

  public function buildDriverList($driverArray, $classes) {
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
      foreach ($classes as $classkey => $classvalue) {
        if ($value['driver_class'] == $classvalue['id']) {
          $tablecontent .= '<td>'.$classvalue['class_name'].'</td>';
        }
      }
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

  public function buildDriverEdit($driverInfo, $cars, $classes, $seasonID) {
    $view = '';
    $view .= '<form action="includes/editdriver.inc.php?season='.$seasonID.'" enctype="multipart/form-data" method="post">';
    $view .= '<div class="form-row align-items-center">';
    $view .= '<div class="col form-group">';
    $view .= '<label for="iracing_name">iRacing Name</label>';
    $view .= '<input type="text" class="form-control" value="'.$driverInfo['iracing_name'].'" id="iracing_name" name="iracing_name" readonly>';
    $view .= '</div>';
    $view .= '<div class="col form-group">';
    $view .= '<label for="display_name">Display Name</label>';
    $view .= '<input type="text" class="form-control" value="'.$driverInfo['display_name'].'" id="display_name" name="display_name">';
    $view .= '</div>';
    $view .= '<div class="col form-group">';
    $view .= '<label for="car_name">Selected Car</label>';
    $view .= '<select class="form-control" id="car_name" name="car_id">';
    foreach ($cars as $key => $value) {
      if ($value['car_id'] == $driverInfo['selected_car_id']) {
        $view .= '<option value="'.$value['car_id'].'" selected>'.$value['car_name'].'</option>';
      } else {
        $view .= '<option value="'.$value['car_id'].'">'.$value['car_name'].'</option>';
      }
    }
    $view .= '</select>';
    $view .= '</div>';
    $view .= '<div class="col form-group">';
    $view .= '<label for="driver_class">Driver Class</label>';
    $view .= '<select class="form-control" id="driver_class" name="class_id">';
    foreach ($classes as $key => $value) {
      if ($value['id'] == $driverInfo['driver_class']) {
        $view .= '<option value="'.$value['id'].'" selected>'.$value['class_name'].'</option>';
      } else {
        $view .= '<option value="'.$value['id'].'">'.$value['class_name'].'</option>';
      }
    }
    $view .= '</select>';
    $view .= '</div>';
    $view .= '<div class="col">';
    $view .= '<div class="form-check">';
    if ($driverInfo['active'] == 1) {
      $view .= '<input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>';
    } else {
      $view .= '<input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active">';
    }
    $view .= '<label class="form-check-label" for="is_active">Active Driver?</label>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="form-row">';
    $view .= '<button type="submit" class="btn btn-secondary">Save</button>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</form>';

    echo $view;
  }

}
