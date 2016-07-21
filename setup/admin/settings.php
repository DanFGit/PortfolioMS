<?php
  session_start();
  require('../classes/pms.class.php');
  $errors = [];

  $PMS = new PMS();

  //Stores if user is logged in
  $isLoggedIn = (isset($_SESSION['user'])) ? true : false;

  if($isLoggedIn){
    if(isset($_POST['selectTheme'])){
      $PMS->setTheme($_POST['selected']);
    }
  }

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
            Admin will be able to change their theme and page title here, as
            well as browse the theme browser and install them. Possibly have an
            'enable developer mode' option that shows advanced options in the
            navigation bar, letting developers modify themes directly from the
            admin dashboard.
          </p>
        </section>

        <section>
          <h2>Theme Selection</h2>
          <form method="post" action="#" class="content">
            <label for="selected">Select a Theme:</label>
            <select name="selected">
              <?php $files = scandir('../themes');
              foreach($files as $file){
                if ($file{0} == '.' || !is_dir('../themes/' . $file)) continue;
                if($file == $PMS->getTheme()) {
                  echo "<option selected value='$file'>$file</option>";
                } else {
                  echo "<option value='$file'>$file</option>";
                }
              } ?>
            </select>
            <br><br>
            <input class="submit" type="submit" name="selectTheme" value="Change Theme">
          </form>
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
