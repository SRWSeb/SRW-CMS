<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">SRW</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="standings.php">Standings</a>
      <a class="nav-item nav-link" href="protest.php">Protests</a>

      <?php
      //Admin section
      if (isset($_SESSION['userlevel']) && $_SESSION['userlevel'] == 1):?>
          <a class="nav-item nav-link" href="entercsv.php">Add CSV</a>
          <a class="nav-item nav-link" href="driveradmin.php">Driver Admin</a>
          <a class="nav-item nav-link" href="protestenter.php">Enter Protest</a>
      <?php endif; ?>

    </div>
  </div>

  <?php
  //User login section
  if (!isset($_SESSION['loggedin'])):?>
    <!--<a href="signup.php" class="btn btn-outline-secondary mr-2">Signup</a>-->
    <form class="form-inline my-2 my-lg-0" action="includes/loginout.inc.php?action=login" enctype="multipart/form-data" method="post">
      <input class="form-control mr-sm-2" type="text" placeholder="Username" id="username" name="username" aria-label="Search">
      <input class="form-control mr-sm-2" type="password" placeholder="Password" id="passwd" name="passwd" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
    </form>
  <?php elseif ($_SESSION['loggedin']):?>
    <span class="navbar-text">
      You are logged in, <?=$_SESSION['username']?>
    </span>
    <a href="includes/loginout.inc.php?action=logout" class="btn btn-primary">Logout</a>
  <?php endif; ?>

</nav>
