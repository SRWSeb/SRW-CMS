<div class="row my-2">
  <div class="col-12">
    <h1><?=$teaminfo['team_name']?></h1>
    <h5>created <?=$teaminfo['created']?></h5>
  </div>
</div>
<div class="row">
  <div class="col-6">
    <div class="container">
      <h5>Team Drivers</h5>
      <ul class="list-group col-12">
        <?php foreach ($teaminfo['drivers'] as $driver): ?>
          <li class="list-group-item"><?=$driver['display_name']?></li>
        <?php endforeach; ?>
        <form action="teamadmin.php" enctype="multipart/form-data" method="get">
          <div class="row">
            <input type="text" class="form-control col-9" id="driver_name" name="adddriver">
            <input type="submit" value="Add Driver" class="btn btn-dark col-3">
          </div>
        </form>
      </ul>
    </div>
  </div>
  <div class="col-6">
  </div>
</div>
