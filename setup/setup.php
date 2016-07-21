<?php
  require('../classes/db.class.php');
  $DB = new DB();

  function ThrowError($message) {
    header("HTTP/1.1 400 Bad Request");
    echo $message;
    exit;
  }

  if(!isset($_POST['adminDirectory'])) ThrowError("You shouldn't be here!");

  //--- DATABASE TABLE SETUP ---//
  $createPersonalTable = $DB->createTable("Personal", ["email", "password", "theme"], ["VARCHAR(255)", "VARCHAR(255)", "VARCHAR(255)"]);
  if($createPersonalTable != 1) ThrowError("Could not create the 'Personal' table");

  $createProjectsTable = $DB->createTable("Projects", ["id", "title", "preview", "body", "visible"], ["INT PRIMARY KEY AUTO_INCREMENT", "VARCHAR(255)", "TEXT", "MEDIUMTEXT", "BOOLEAN"]);
  if($createProjectsTable != 1) ThrowError("Could not create the 'Projects' table");

  $createFieldsTable = $DB->createTable("Fields", ["id", "name", "value", "type"], ["INT PRIMARY KEY AUTO_INCREMENT", "VARCHAR(255) UNIQUE", "TEXT", "ENUM('text','textarea')"]);
  if($createFieldsTable != 1) ThrowError("Could not create the 'Fields' table");

  //--- ADMIN DIRECTORY SETUP ---//
  //TODO: Instead of making a new directory, rename '/setup/admin' directory
  $adminDir = $_POST['adminDirectory'];
  $restrictedDirs = ["setup", "classes", "css", "img", "js"];

  //Stop admin dashboard overwriting setup or classes folders
  if(in_array(strtolower($adminDir), $restrictedDirs)) ThrowError("Illegal name used for Admin directory");

  //Stop admin directory overwriting an existing directory
  if (file_exists('../' . $adminDir) || is_dir('../' . $adminDir)) ThrowError("Admin directory already exists");

  //Make the admin directory
  rename('admin', '../' . $_POST['adminDirectory']);

  //--- USER ACCOUNT SETUP ---//
  //TODO: Don't store the password in plain text
  $userEmail = $_POST['email'];
  $userPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $insertPersonal = $DB->insert("Personal", [$userEmail, $userPassword, NULL]);
  if($insertPersonal != 1) ThrowError("Error: Could not insert data to the 'Personal' table");

  $insertField = $DB->insert("Fields", [NULL, "E-mail", $userEmail, "text"]);
  if($insertField != 1) ThrowError("Error: Could not insert data to the 'Fields' table");

  $insertField = $DB->insert("Fields", [NULL, "Name", "Your Name Here", "text"]);
  if($insertField != 1) ThrowError("Error: Could not insert data to the 'Fields' table");

  $insertField = $DB->insert("Fields", [NULL, "About Me", "Use the Admin Dashboard to enter a little bit about you.", "textarea"]);
  if($insertField != 1) ThrowError("Error: Could not insert data to the 'Fields' table");

  //Send a successful response
  header("HTTP/1.1 201 Created");
