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

  public function buildChampTable($rounds, $standings) {
    $roundsView = "";
    $standingsView = "";
    $position = 1;

    for ($i=1; $i <= $rounds ; $i++) {
      $roundsView .= '<th scope="col">Round '.$i.'</th>';
    }

    foreach ($standings as $key => $value) {
        $standingsView .= '<tr>';
        $standingsView .= '<th scope="row">'.$position.'</th>';
        $standingsView .= '<td>'.$value['name'].'</td>';
        $standingsView .= '<td>'.$value['class'].'</td>';
        $standingsView .= '<td>'.$value['car'].'</td>';

        for ($i=1; $i <= $rounds ; $i++) {
          $standingsView .= '<td>'.$value['Round '.$i].'</td>';
        }

        $standingsView .= '<td>'.$value['total_inc'].'</td>';
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
            '<th scope="col">Championship Points</th>
            <th scope="col">Incident Points</th>
          </tr>
        </thead>
        <tbody>'
          .$standingsView.
        '</tbody>
      </table>
    </div>';

    echo $view;
  }

}
