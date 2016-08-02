<?php
  session_start();
  require('../classes/pms.class.php');
  $statuses = [];
  $errors = [];

  $PMS = new PMS();

  //Stores if user is logged in
  $isLoggedIn = (isset($_SESSION['user'])) ? true : false;

  if($isLoggedIn){
    if(isset($_POST['changeEmail'])){
      if($PMS->verifyPassword($_SESSION['user'], $_POST['password'])){
        if($PMS->changeEmail($_SESSION['user'], $_POST['email'])){
          $statuses[] = ["success", "Email changed successfully"];
          $_SESSION['user'] = $_POST['email'];
        } else {
          $statuses[] = ["error", "Email could not be changed, please try again or contact your system administrator."];
        }
      } else {
        $statuses[] = ["error", "Incorrect password!"];
      }
    }

    if(isset($_POST['changePassword'])){
      if($_POST['newPassword'] === $_POST['newPasswordConfirm']) {
        if($PMS->verifyPassword($_SESSION['user'], $_POST['currentPassword'])){
          if($PMS->changePassword($_SESSION['user'], $_POST['newPassword'])){
            $statuses[] = ["success", "Password changed successfully"];
          } else {
            $statuses[] = ["error", "Password could not be changed, please try again or contact your system administrator."];
          }
        } else {
          $statuses[] = ["error", "Incorrect password!"];
        }
      } else {
        $statuses[] = ["error", "Your password confirmation did not match, please try again."];
      }
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

        <?php foreach ($statuses as $status) {
          echo "<section><p class='content $status[0]'>$status[1]</p></section>";
        } ?>

        <section>
          <h2>Change Email</h2>
          <form method="post" action="#" class="content">
            <label>New Email</label>
            <input type="email" id="value" name="email" />
            <br><br>
            <label>Your Password</label>
            <input type="password" id="value" name="password" />
            <br><br>
            <input class="submit" type="submit" name="changeEmail" value="Change Email">
          </form>
        </section>

        <section>
          <h2>Change Password</h2>
          <form method="post" action="#" class="content">
            <label>Current Password</label>
            <input type="password" id="value" name="currentPassword" />
            <br><br>
            <label>New Password</label>
            <input type="password" id="value" name="newPassword" />
            <br><br>
            <label>Confirm New Password</label>
            <input type="password" id="value" name="newPasswordConfirm" />
            <br><br>
            <input class="submit" type="submit" name="changePassword" value="Change Password">
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
