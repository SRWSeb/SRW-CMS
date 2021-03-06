<div class="jumbotron">
  <?php if($s->season['season_logo'] != NULL): ?>
    <img src="media/<?=$s->season['season_logo']?>" class="img-fluid">
    <br>
    <?php //The following is a hack for BMW-Trophy. To be replaced later ?>
    <a href="standings.php?season=<?=$s->season['id']?>" class="btn btn-dark my-1">Overall</a>
    <a href="standings.php?season=<?=$s->season['id']?>&scope=2" class="btn btn-dark my-1" style="color: #FFD700">Gold</a>
    <a href="standings.php?season=<?=$s->season['id']?>&scope=3" class="btn btn-dark my-1" style="color: #C0C0C0">Silver</a>
    <a href="standings.php?season=<?=$s->season['id']?>&scope=4" class="btn btn-dark my-1" style="color: #bf8970">Bronze</a>
  <?php endif; ?>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col" rowspan="2">#</th>
        <th scope="col" rowspan="2">Name</th>
        <?php if($s->season['classes'] == 1): ?>
          <th scope="col" rowspan="2">Class</th>
        <?php endif; ?>
        <th scope="col" rowspan="2">Car</th>
        <?php
        foreach ($s->rounds as $key => $value) {
          echo '<th scope="col" colspan="2" class="text-nowrap">'.$value.'</th>';
        }
        ?>
        <th scope="col" rowspan="2">Incident Points</th>
        <th scope="col" rowspan="2">Championship Points</th>
      </tr>
      <tr>
        <?php foreach ($s->rounds as $key => $value): ?>
          <?php for ($i = 1; $i <= $s->season['races_per_round']; $i++): ?>
            <th scope="col" class="text-nowrap">Race <?=$i?></th>
          <?php endfor; ?>
        <?php endforeach; ?>
      </tr>
    </thead>
