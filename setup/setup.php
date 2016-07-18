<?php
  session_start();
  require('../classes/db.class.php');
  $DB = new DB();

  $DB->createTable("Personal", ["email", "password"], ["VARCHAR(255)", "VARCHAR(255)"]);
  $DB->createTable("Projects", ["title", "preview", "body"], ["VARCHAR(255)", "TEXT", "MEDIUMTEXT"]);

  mkdir('../' . $_POST['adminDirectory']);
  //TODO: Instead of mkdir, rename 'admin' dir

  $DB->insert("Personal", [$_POST['email'], $_POST['password']]);

  header("HTTP/1.1 201 Created");
