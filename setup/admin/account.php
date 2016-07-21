<?php
  session_start();
  require('../classes/pms.class.php');
  $errors = [];

  $PMS = new PMS();

  //Stores if user is logged in
  $isLoggedIn = (isset($_SESSION['user'])) ? true : false;

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Dashboard - PortfolioMS</title>
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <link href="css/master.css" rel="stylesheet">
  </head>
  <body>
    <?php require('nav.php'); ?>
    <?php if($isLoggedIn) { ?>
      <main>
        <section>
          <h2>Under Construction</h2>
          <p class="content">
            Admin will be able to change their email and password here.
          </p>
        </section>
      </main>
    <?php } else { ?>
      <main>
        <section>
          <h2>Access Denied</h2>
          <p class="content">
            You must be logged in to access this area.
          </p>
        </section>
      </main>
    <?php } ?>
  </body>
</html>
