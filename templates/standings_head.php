<div class="jumbotron">
  <?php if($s->season['season_logo'] != NULL): ?>
    <img src="media/<?php echo $s->season['season_logo']; ?>" class="img-fluid">
  <?php endif; ?>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Class</th>
        <th scope="col">Car</th>
        <?php
        foreach ($s->rounds as $key => $value) {
          echo '<th scope="col">'.$value.'</th>';
        }
         ?>
        <th scope="col">Incident Points</th>
        <th scope="col">Championship Points</th>
      </tr>
    </thead>
