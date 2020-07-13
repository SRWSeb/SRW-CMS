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
      <form action="protestenter.php" enctype="multipart/form-data" method="get">
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

  public function protestSaved() {
    $view = '<div class="row border border-success rounded bg-success text-white">';
    $view .= '<div class="col"';
    $view .= '<h5>Protest entered successfully!</h5>';
    $view .= '</div>';
    $view .= '</div>';

    echo $view;
  }

  public function enterToken() {
    $view = '<div class="jumbotron justify-content-center">';
    $view .= '<form action="protest.php" enctype="multipart/form-data" method="get">';
    $view .= '<label for="token">To review protests, please enter your protest token:</label>';
    $view .= '<input type="text" class="form-control" name="token" id="token">';
    $view .= '<button type="submit" class="btn btn-secondary">Submit</button>';
    $view .= '</form>';
    $view .= '</div>';

    echo $view;
  }

  public function displayProtests($protests) {

    $tablehead = '<table class="table">
          <tr>
            <th scope="row">#</th>
            <th scope="row">Protested Driver</th>
            <th scope="row">Evidence</th>
            <th scope="row">Status</th>
            <th scope="row">Penalty</th>
          </tr>';
    $tablefoot = '</table>';

    $view = '<div class="row">';
    $view .= $tablehead;
      foreach ($protests as $key => $value) {
        $view .= '<tr>';
        $view .= '<th scope="row">Round '.$value['round_num'].'</th>';
        $view .= '<td>'.$value['display_name'].'</td>';
        $view .= '<td><a href="'.$value['yt_direct'].'" target="_blank">Video</a></td>';
        if($value['guilty'] == 1) {
          $view .= '<td>Upheld</td>';
          $view .= '<td>+10x</td>';
        } else {
          $view .= '<td>Dismissed</td>';
          $view .= '<td>-</td>';
        }
        $view .= '</tr>';
      }
    $view .= $tablefoot;
    $view .= '</div>';

    echo $view;
  }

  public function enterProtest($seasonID, $driverlist, $roundslist) {
    $datalist = '<datalist id="drivers">';
    foreach ($driverlist as $key => $value) {
      $datalist .= '<option value="'.$value['id'].'">'.$value['display_name'].'</option>';
    }
    $datalist .= '</datalist>';

    $tracklist = '';
    foreach ($roundslist as $key => $value) {
      $tracklist .= '<option value="'.$value['id'].'">Round '.$value['round_num'].' - '.$value['trackname'].'</option>';
    }

    $view = $datalist;
    $view .= '<form action="includes/protestenter.inc.php?season='.$seasonID.'" enctype="multipart/form-data" method="post">';
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
    $view .= '<label for"Youtube">Youtube Link:</label>';
    $view .= '<textarea class="form-control" name="youtube" id="Youtube">';
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

  public function protestVote($protest) {
    $view = '<div class="row">';
    $view .= '<div class="col">';
    $view .= '<h1>Simracersworld GT PRO series</h1>';
    $view .= '<h2>'.$protest['round'].'<h2>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="row">';
    $view .= '<div class="col d-flex justify-content-center">';
    $view .= $protest['ytembed'];
    $view .= '</div>';
    $view .= '<div class="col">';
    $view .= '<h4>Issued by: </h4><p>'.$protest['issuedByName'].'</p>';
    $view .= '<h4>Protested Driver: </h4><p>'.$protest['protestedDriverName'].'</p>';
    $view .= '<h4>Lap: </h4><p>'.$protest['lap'].'</p>';
    $view .= '<h4>Location: </h4><p>'.$protest['location'].'</p>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<div class="row">';
    $view .= '<div class="col">';
    $view .= '<h4>Description given by driver:</h4>';
    $view .= '<p>'.$protest['description'].'<p>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<form>';
    $view .= '<div class="row">';
    $view .= '<fieldset class="form-group">';
    $view .= '<legend class="col">Verdict:</legend>';
    $view .= '<div class="col">';
    $view .= '<div class="form-check">';
    $view .= '<input class="form-check-input" type="radio" name="verdict" id="guilty" value="1">';
    $view .= '<label class="form-check-label" for="guilty">Guilty</label>';
    $view .= '</div>';
    $view .= '<div class="form-check">';
    $view .= '<input class="form-check-input" type="radio" name="verdict" id="nguilty" value="0">';
    $view .= '<label class="form-check-label" for="nguilty">Not guilty</label>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</fieldset>';
    $view .= '</div>';
    $view .= '<div class="row">';
    $view .= '<div class="col">';
    $view .= '<div class="form-group">';
    $view .= '<label for="reasoning">Comment:</label>';
    $view .= '<textarea class="form-control" id="reasoning" rows="5"></textarea>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '<button type="submit" class="btn btn-secondary">Submit</button>';
    $view .= '</form>';

    echo $view;
  }

}
