<?php

class DB {

  private $servername = "localhost";
  private $username   = "root";
  private $password   = "";
  private $database   = "portfolioms";

  private $conn;

  function __construct() {
    //Connect to MySQL and Database
    try {
      $this->conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->database, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }

  //Check if database has been setup
  public function isSetup() {
    try {
      return ($this->conn->query("SHOW TABLES LIKE 'personal'")->rowCount()) > 0;
    } catch(PDOException $e) {
      echo $e->getMessage();
    }
  }

  // public function query($sql) {
  //   return json_encode ( $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC) );
  // }
  //
  // public function insert($sql, $arguments) {
  //
  // }
}

// if(isset($_GET['maps'])) {
//   echo $db->query("SELECT * FROM maps");
// } else if(isset($_GET['mapVariant'])) {
//   try {
//     $stmt = $db->conn->prepare("REPLACE INTO mapvariants VALUES (:id)");
//     $stmt->bindParam(":id", $_GET['id']);
//     $stmt->execute();
//   } catch (PDOException $e) {
//     echo $e->getMessage();
//   }
// }
