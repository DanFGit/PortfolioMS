<?php
  session_start();

  require('classes/pms.class.php');

  //Populate variables
  $PMS = new PMS();

  $me = "current users's information";
  $posts = ["array", "of", "posts"];
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $PMS->getHomeTitle(); ?></title>
  </head>
  <body>
    
  </body>
</html>
