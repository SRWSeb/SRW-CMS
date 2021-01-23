<div class="jumbotron">
  <?php if($s->season['season_logo'] != NULL): ?>
    <img src="media/<?php echo $s->season['season_logo']; ?>" class="img-fluid">
  <?php endif; ?>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <?php if($s->season['classes'] == 1): ?>
          <th scope="col">Class</th>
        <?php endif; ?>
        <th scope="col">Car</th>
        <?php
        foreach ($s->rounds as $key => $value) {
          echo '<th scope="col" class="text-nowrap">'.$value.'</th>';
        }
         ?>
        <th scope="col">Incident Points</th>
        <th scope="col">Championship Points</th>
      </tr>
    </thead>
