<?php

class ProtestView {

  public function selectSeason($leagueArray) {
    $seasons = '<optgroup label="Active Series">';
    foreach ($leagueArray as $key => $value) {
      if ($value['active'] == 1) {
        $seasons .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
      }
    }
    $seasons .= '</optgroup>';


    $view = '<h1>Select Season</h1>
      <form action="/SRW-CMS/protestenter.php" enctype="multipart/form-data" method="get">
        <div class="row">
          <div class="col-sm">
            <select id="seasons" name="season" class="form-control">'.
            $seasons.
            '</select>
          </div>
          <div class="col-sm">
            <input type="submit" value="Select" class="btn btn-secondary">
          </div>
        </div>
      </form>';

    echo $view;
  }

  public function enterProtest($season, $driverlist, $roundslist) {
    $datalist = '<datalist id="drivers">';
    foreach ($driverlist as $key => $value) {
      $datalist .= '<option>'.$value['display_name'].'</option>';
    }
    $datalist .= '</datalist>';

    $tracklist = '';
    foreach ($roundslist as $key => $value) {
      $tracklist .= '<option>Round '.$value['round_num'].' - '.$value['trackname'].'</option>';
    }

    $view = $datalist;
    $view .= '<form>';
    $view .= '<div class="row">';
    $view .= '<div class="col">';
    $view .= '<h1>Protest Entry:</h1>';
    $view .= '<div class="form-group">';
    $view .= '<label for="round">Round:</label>';
    $view .= '<select id="round" name="round" class="form-control">';
    $view .= $tracklist;
    $view .= '</select>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="row">';
    $view .= '<div class="col">';
    $view .= '<div class="form-group">';
    $view .= '<label for="issuedBy">Issued By:</label>';
    $view .= '<input type="text" list="drivers" class="form-control" name="issuedBy" id="issuedBy">';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="col">';
    $view .= '<div class="form-group">';
    $view .= '<label for="protestedDriver">Protested Driver:</label>';
    $view .= '<input type="text" list="drivers" class="form-control" name="protestedDriver" id="protestedDriver">';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="row">';
    $view .= '<div class="col">';
    $view .= '<div class="form-group">';
    $view .= '<label for="lap">Lap:</label>';
    $view .= '<input type="number" class="form-control" name="lap" id="lap">';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="col">';
    $view .= '<div class="form-group">';
    $view .= '<label for="location">Location:</label>';
    $view .= '<input type="text" class="form-control" name="location" id="location">';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="row">';
    $view .= '<div class="col">';
    $view .= '<div class="form-group">';
    $view .= '<label for"ytembed">Youtube Embed Link:</label>';
    $view .= '<textarea class="form-control" name="ytembed" id="ytembed">';
    $view .= '</textarea>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="row">';
    $view .= '<div class="col">';
    $view .= '<div class="form-group">';
    $view .= '<label for"description">Description:</label>';
    $view .= '<textarea class="form-control" name="description" id="description">';
    $view .= '</textarea>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<button type="submit" class="btn btn-secondary">Submit</button>';
    $view .= '</form>';

    echo $view;
  }

}
