<?php

class ChampView {

  public function leagueSelect($leagueArray) {
    $view='<div class="container"><div class="jumbotron text-center">';
    $view .= '<h1>Current series</h1>';
    foreach ($leagueArray as $key => $value) {
      if ($value['active'] == 1) {
        $view .= '<a href="standings.php?season='.$value['id'].'"><img class="img-fluid pt-3" src="media/'.$value['logo'].'"></a>';
      }
    }
    $view .= '<h1>Past series</h1>';
    $seasons = '<optgroup label="Past Series">';
    foreach ($leagueArray as $key => $value) {
      if ($value['active'] == 0) {
        $seasons .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
      }
    }
    $seasons .= '</optgroup>';

    $view .=
      '<form action="standings.php" enctype="multipart/form-data" method="get">
        <div class="row">
          <div class="col-sm">
            <select id="seasons" name="season" class="form-control">'.
            $seasons.
            '</select>
          </div>
          <div class="col-sm">
            <input type="submit" value="Get Standings" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>
    </div>';

    echo $view;
  }

  public function buildStandings($s, $classes) {
    if($s->season['races_per_round'] > 1) {
      require_once('templates/standings_doublehead.php');
    } else {
      require_once('templates/standings_head.php');
    }
    require_once('templates/standings_body.php');
  }

  public function buildDriverSite($transactions, $name) {
    $tablehead = '<div class="jumbotron">
    <h1>'.$name.'</h1>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Round</th>
          <th scope="col">Track</th>
          <th scope="col">Inc</th>
          <th scope="col">Reason</th>
        </tr>
      </thead>
      <tbody>';
    $tablecontent = '';
    $tablefoot = '</tbody>
    </table>
    </div>';

    foreach ($transactions as $key => $value) {
      $tablecontent .= '<tr>';
      $tablecontent .= '<th scope="row">'.$value['round_num'].'</th>';
      $tablecontent .= '<td>'.$value['trackname'].'</td>';
      $tablecontent .= '<td>'.$value['inc_amount'].'</td>';

      if ($value['inc_reason'] != NULL) {
        $tablecontent .= '<td>'.$value['inc_reason'].'</td>';
      } elseif ($value['inc_comment'] != NULL) {
        $tablecontent .= '<td>'.$value['inc_comment'].'</td>';
      }
      $tablecontent .= '</tr>';
    }

    $view = $tablehead . $tablecontent . $tablefoot;

    echo $view;
  }

}
