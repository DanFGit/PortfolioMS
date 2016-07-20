<?php
  session_start();
  require('../classes/pms.class.php');

  $PMS = new PMS();

  if(isset($_POST['loginForm'])){
    // echo $PMS->login($_POST['email'], $_POST['password']);
    $login = $PMS->login($_POST['loginEmail'], $_POST['loginPassword']);
    if($login[0]){
      //TODO: Use username from database rather than form submitted username
      $_SESSION['user'] = $login[1];
    } else {
      $loginFailed = true;
    }
  }

  $isLoggedIn = (isset($_SESSION['user'])) ? true : false;

  if($isLoggedIn){
    if(isset($_POST['updateField'])){
      $PMS->updateAdminField($_POST['fieldID'], $_POST['fieldValue']);
    } else if(isset($_POST['deleteField'])){
      $PMS->removeAdminField($_POST['fieldID']);
    } else if(isset($_POST['addField'])){
      $PMS->addAdminField($_POST['newField']);
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin CP</title>
  </head>
  <body>
    <?php if(!$isLoggedIn) { ?>
      <?php if(isset($loginFailed)){
        echo "login failed";
      } ?>

      <form action="#" method="post">
        <label for="loginEmail">Email</label>
        <input required type="text" id="loginEmail" name="loginEmail" />
        <br><br>
        <label for="loginPassword">Password</label>
        <input required type="password" id="loginPassword" name="loginPassword" />
        <br><br>
        <input type="submit" value="Log In" name="loginForm"/>
      </form>

    <?php } else { ?>

      Welcome, <?php echo $_SESSION['user']; ?> | <a href="logout.php">Log out</a><br><br>

        <?php
        $fieldList = $PMS->getAdminFields();

        foreach ($fieldList as $key => $field) { ?>
          <form action="#" method="post">
            <label for="<?php echo $field['name']; ?>"><?php echo $field['name']; ?></label><br>
            <input type="hidden" id="fieldID" name="fieldID" value="<?php echo $field['id']; ?>" />
            <input type="text" id="fieldValue" name="fieldValue" value="<?php echo $field['value']; ?>" />
            <input type="submit" value="Update Value" name="updateField" /><input type="submit" value="Delete" name="deleteField" /><br><br>
          </form>
        <?php } ?>

        <form action="#" method="post">
          <label for="newField">Add New Field</label><br>
          <input type="text" id="newField" name="newField" />
          <input type="submit" value="Add New Field" name="addField" /><br><br>
        </form>

    <?php } ?>

  </body>
</html>
