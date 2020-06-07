<?php
session_start();
require_once 'includes/autoloader.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="description" content="Simracersworld Championship Management System for iRacing">
  <meta name=viewport content="width=device-width, initial scale=1">
  <title>Simracersworld Championship Management System</title>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="index.php">SRW</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link" href="show_champ.php">Home</a>
          <a class="nav-item nav-link" href="entercsv.php">Add CSV</a>
        </div>
      </div>
      <?php if (!isset($_SESSION['loggedin'])): ?>
        <a href="signup.php" class="btn btn-outline-secondary mr-2">Signup</a>
        <form class="form-inline my-2 my-lg-0" action="includes/loginout.inc.php?action=login" enctype="multipart/form-data" method="post">
          <input class="form-control mr-sm-2" type="text" placeholder="Username" id="username" name="username" aria-label="Search">
          <input class="form-control mr-sm-2" type="password" placeholder="Password" id="passwd" name="passwd" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</button>
        </form>
      <?php endif; ?>
      <php <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
        <span class="navbar-text">
          You are logged in, <?php echo $_SESSION['username']; ?>
        </span>
        <a href="includes/loginout.inc.php?action=logout" class="btn btn-primary">Logout</a>
      <?php endif; ?>

    </nav>

  </header>
