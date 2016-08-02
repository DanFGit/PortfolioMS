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
  $createPersonalTable = $DB->createTable("personal", ["email", "password", "theme"], ["VARCHAR(255)", "VARCHAR(255)", "VARCHAR(255)"]);
  if($createPersonalTable != 1) ThrowError("Could not create the 'personal' table");

  $createProjectsTable = $DB->createTable("projects", ["id", "title", "preview", "body", "visible", "sort"], ["INT PRIMARY KEY AUTO_INCREMENT", "VARCHAR(255)", "TEXT", "MEDIUMTEXT", "BOOLEAN", "INT"]);
  if($createProjectsTable != 1) ThrowError("Could not create the 'projects' table");

  $createFieldsTable = $DB->createTable("fields", ["id", "name", "value", "type"], ["INT PRIMARY KEY AUTO_INCREMENT", "VARCHAR(255) UNIQUE", "TEXT", "ENUM('text','textarea','array')"]);
  if($createFieldsTable != 1) ThrowError("Could not create the 'fields' table");

  //--- ADMIN DIRECTORY SETUP ---//
  $adminDir = $_POST['adminDirectory'];
  $restrictedDirs = ["setup", "classes", "css", "img", "js"];

  //Stop admin dashboard overwriting setup or classes folders
  if(in_array(strtolower($adminDir), $restrictedDirs)) ThrowError("Illegal name used for Admin directory");

  //Stop admin directory overwriting an existing directory
  if (file_exists('../' . $adminDir) || is_dir('../' . $adminDir)) ThrowError("Admin directory already exists");

  //Make the admin directory
  rename('admin', '../' . $_POST['adminDirectory']);

  //--- USER ACCOUNT SETUP ---//
  $userEmail = $_POST['email'];
  $userPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $insertPersonal = $DB->insert("personal", [$userEmail, $userPassword, NULL]);
  if($insertPersonal != 1) ThrowError("Error: Could not insert data to the 'personal' table");

  $insertField = $DB->insert("fields", [NULL, "E-mail", $userEmail, "text"]);
  if($insertField != 1) ThrowError("Error: Could not insert data to the 'fields' table");

  $insertField = $DB->insert("fields", [NULL, "Name", "Your Name Here", "text"]);
  if($insertField != 1) ThrowError("Error: Could not insert data to the 'fields' table");

  $insertField = $DB->insert("fields", [NULL, "About Me", "Use the Admin Dashboard to enter a little bit about you.", "textarea"]);
  if($insertField != 1) ThrowError("Error: Could not insert data to the 'fields' table");

  //Send a successful response
  header("HTTP/1.1 201 Created");
