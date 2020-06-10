<?php

class ChampView {

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

/*<tbody>
  <?php foreach ($season_driver_rows as $key => $value):
    $driver_rounds = getDriverTransactions($conn, $value['driver_id'], $value['season_id']);
    ?>
    <tr>
      <th scope="row"><?php echo $key+1; ?></th>
      <td><?php echo $value['display_name']; ?></td>
      <td><?php echo $value['car_name']; ?></td>
      <?php for ($i = 0; $i < $value['rounds']; $i++): ?>
        <td><?php
        if (isset($driver_rounds[0])) {
          if ($driver_rounds[0]['round_num'] == $i+1) {
            $current = array_shift($driver_rounds);
            echo $current['pts_amount'];
          } else {
            echo "0";
          }
        } else {
          echo "0";
        }
        ?></td>
      <?php endfor; ?>
      <td><?php echo $value['driver_champ_pts']; ?></td>
      <td><?php echo $value['driver_inc_pts']; ?></td>
    </tr>
  <?php endforeach; ?>
</tbody>*/
