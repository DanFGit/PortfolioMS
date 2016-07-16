<?php
  require('classes/db.class.php');
  $DB = new DB();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>PortfolioMS Setup</title>
    <style media="screen">
      *{box-sizing:border-box;}
      body{font:1rem monospace;max-width: 555px;}
      p,form{padding:5px;border-left:4px #fff solid;}
      #error{border-color:#f88;}
      #success{border-color:#7f8;}
      #info{border-color:#ff8;}
      li{list-style-position:inside;}
      #adminInput{margin-top:4px;font:.8rem monospace;background:#ff8;border:1px solid #bb5;padding:2px;}
      input[type="submit"]{background:#7f8;border:1px solid #495;font:.8rem monospace;padding:2px 4px;cursor:pointer;}
    </style>
  </head>
  <body>

    <h1>Welcome to PortfolioMS</h1>

    <?php if($DB->isSetup()) {
      echo "<p id=error><b>Error</b> - PortfolioMS is already setup on this server! Please delete this file for security reasons.<br>";
      echo "If you would like to re-setup PortfolioMS, please delete the PortfolioMS database and refresh the page.<br>";
      echo "If you would like to setup multiple instances of PortfolioMS on one server, please provide them with unique database names in their '<i>classes/db.class.php</i>' file.</p>";
      exit;
    } ?>

    <?php

    //Create Personal table
    //Create Projects table

    ?>

    <p id=success>Database tables have been created successfully.</p>

    <form id=info autocomplete=off>
      <label for=adminInput>Please enter your desired directory for the Admin Dashboard. It is
      recommended that this is not easy to guess, like '<i>admin</i>', as
      despite best efforts to secure login forms it is always safer to have
      fewer people that know where the login form is in the first place.</label><br>
      <input type=text required name=admin id=adminInput placeholder="Example: <?php echo substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10); ?>"/>
      <input type=submit value="Create Admin Directory" />
    </form>



  </body>
</html>
