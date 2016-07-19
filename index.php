<?php
  require('classes/pms.class.php');
  $PMS = new PMS();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $PMS->getHomeTitle(); ?></title>
  </head>
  <body>

    <?php if(!$PMS->isSetup()) { ?>
      <p>PortfoliMS has not been setup yet. Please go to <a href="setup/">Setup</a> and follow the instructions.</p>
    <?php exit; } ?>


    <?php print_r($PMS->get("E-mail")); ?>
    <?php print_r($PMS->get("test")); ?>
  </body>
</html>
