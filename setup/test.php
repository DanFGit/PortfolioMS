<?php
  session_start();
  require('../classes/db.class.php');
  $DB = new DB();

  $DB->insert("personal", ["dan", "dan"]);
