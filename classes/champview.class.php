<?php

class ChampView {

  public function leagueSelect($leagueArray) {
    $seasons = "";

    foreach ($leagueArray as $key => $value) {
      $seasons .= '<option value="'.$key.'">'.$value.'</option>';
    }

    $view='<div class="jumbotron">
      <form action="/SRW-CMS/standings.php" enctype="multipart/form-data" method="get">
        <div class="row">
          <div class="col-sm">
            <select id="seasons" name="season" class="form-control">'.
            $seasons.
            '</select>
          </div>
          <div class="col-sm">
            <input type="submit" value="Get_Standings" name="standings" class="btn btn-primary">
          </div>
        </div>
      </form>
    </div>';

    echo $view;
  }

  public function buildChampTable($seasonInfo, $standings) {
    $roundsView = "";
    $standingsView = "";
    $position = 1;

    for ($i=1; $i <= $seasonInfo['rounds'] ; $i++) {
      $roundsView .= '<th scope="col">Round '.$i.'</th>';
    }

    foreach ($standings as $key => $value) {
        $standingsView .= '<tr>';
        $standingsView .= '<th scope="row">'.$position.'</th>';
        $standingsView .= '<td><a href="driverinfo.php?id='.$value['driverID'].'&season='.$seasonInfo['id'].'">'.$value['name'].'</td>';
        $standingsView .= '<td>'.$value['class'].'</td>';
        $standingsView .= '<td>'.$value['car'].'</td>';

        for ($i=1; $i <= $seasonInfo['rounds'] ; $i++) {
          $standingsView .= '<td>'.$value['Round '.$i].'</td>';
        }
        if ($value['total_inc'] < 40) {
          $standingsView .= '<td style="background-color:#33cc33">'.$value['total_inc'].'</td>';
        } elseif ($value['total_inc'] >= 40 && $value['total_inc'] < 50) {
          $standingsView .= '<td style="background-color:#ff9900">'.$value['total_inc'].'</td>';
        } elseif ($value['total_inc'] >= 50 && $value['total_inc'] < 60) {
          $standingsView .= '<td style="background-color:#cc6600">'.$value['total_inc'].'</td>';
        } else {
          $standingsView .= '<td style="background-color:#ff0000">'.$value['total_inc'].'</td>';
        }
        $standingsView .= '<td>'.$value['total_pts'].'</td>';
        $standingsView .= '</tr>';
        $position++;
    }

    $view = '<div class="jumbotron">
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Class</th>
            <th scope="col">Car</th>'
            .$roundsView.
            '<th scope="col">Incident Points</th>
            <th scope="col">Championship Points</th>
          </tr>
        </thead>
        <tbody>'
          .$standingsView.
        '</tbody>
      </table>
    </div>';

    echo $view;
  }

  public function buildDriverSite($transactions) {
    $tablehead = '<div class="jumbotron">
    <h1>Driver Name</h1>
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
    }

    $view = $tablehead . $tablecontent . $tablefoot;

    echo $view;
  }

}
