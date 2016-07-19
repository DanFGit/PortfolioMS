<?php
  require('../classes/db.class.php');
  $DB = new DB();

  function ThrowError($message) {
    header("HTTP/1.1 400 Bad Request");
    echo $message;
    exit;
  }

  //--- DATABASE TABLE SETUP ---//
  $createPersonalTable = $DB->createTable("Personal", ["email", "password"], ["VARCHAR(255)", "VARCHAR(255)"]);
  if($createPersonalTable != 1) ThrowError("Could not create the 'Personal' table");

  $createProjectsTable = $DB->createTable("Projects", ["id", "title", "preview", "body"], ["INT PRIMARY KEY AUTO_INCREMENT", "VARCHAR(255)", "TEXT", "MEDIUMTEXT"]);
  if($createProjectsTable != 1) ThrowError("Could not create the 'Projects' table");

  $createFieldsTable = $DB->createTable("Fields", ["id", "name", "value"], ["INT PRIMARY KEY AUTO_INCREMENT", "VARCHAR(255) UNIQUE", "TEXT"]);
  if($createFieldsTable != 1) ThrowError("Could not create the 'Fields' table");

  //--- ADMIN DIRECTORY SETUP ---//
  //TODO: Instead of breaking when using an illegal directory name, use a
  //      default name for admin dir and tell the user to rename it manually
  //TODO: Instead of making a new directory, rename '/setup/admin' directory
  $adminDir = $_POST['adminDirectory'];

  //Stop admin dashboard overwriting setup or classes folders
  if($adminDir == "setup" || $adminDir == "classes") ThrowError("Illegal name used for Admin directory");

  //Stop admin directory overwriting an existing directory
  if (file_exists('../' . $adminDir) || is_dir('../' . $adminDir)) ThrowError("Admin directory already exists");

  //Make the admin directory
  mkdir('../' . $_POST['adminDirectory']);


  //--- USER ACCOUNT SETUP ---//
  //TODO: Don't store the password in plain text
  $userEmail = $_POST['email'];
  $userPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $insertPersonal = $DB->insert("Personal", [$userEmail, $userPassword]);
  if($insertPersonal != 1) ThrowError("Error: Could not insert data to the 'Personal' table");

  $insertField = $DB->insert("Fields", [NULL, "E-mail", $userEmail]);
  if($insertField != 1) ThrowError("Error: Could not insert data to the 'Fields' table");

  //Send a successful response
  header("HTTP/1.1 201 Created");
