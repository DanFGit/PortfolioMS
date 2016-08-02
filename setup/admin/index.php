<?php
  session_start();
  require('../classes/pms.class.php');
  $statuses = [];

  $PMS = new PMS();

  //Check if login form has been submitted
  if(isset($_POST['loginForm'])){
    $login = $PMS->login($_POST['email'], $_POST['password']);
    if($login[0]){
      $_SESSION['user'] = $login[1];
    } else {
      $statuses[] = ["error", "Incorrect email or password. Please try again."];
    }
  }

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
        <?php foreach ($statuses as $status) { ?>
          <section>
            <p class='content <?php echo $status[0]; ?>'><?php echo $status[1]; ?></p>
          </section>
        <?php } ?>
        <section>
          <h2>Admin Dashboard</h2>
          <p class="content">
            Welcome to PortfolioMS! This section of your site is the hub of everything,
            allowing you to control preferences, themes, project posts, and much more!
            To get started, click one of the links in the navigation.
          </p>
        </section>
      </main>
    <?php } else { ?>
      <main>
        <?php foreach ($statuses as $status) { ?>
          <section>
            <p class='content <?php echo $status[0]; ?>'><?php echo $status[1]; ?></p>
          </section>
        <?php } ?>
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
