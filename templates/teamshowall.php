<div class="row">
  <?php foreach ($teams as $key => $team): ?>
    <div class="col-3">
      <a class="btn btn-dark h-100 w-100 m-2" href="teamadmin.php?edit=<?=$team['id']?>"><?=$team['team_name']?></a>
    </div>
  <?php endforeach; ?>
</div>
