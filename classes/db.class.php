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
      return $e->getMessage();
    }
  }

  //Check if database has been setup
  //TODO: Change from query() to exec() as exec() returns rowCount();
  public function isSetup() {
    try {
      return ($this->conn->query("SHOW TABLES LIKE 'personal'")->rowCount()) > 0;
    } catch(PDOException $e) {
      return $e->getMessage();
    }
  }

  public function createTable($tableName, $fields, $fieldMetaData) {
    try {
      $sql = "CREATE TABLE IF NOT EXISTS " . $tableName . " (";
      foreach ($fields as $i => $field){
        if($i > 0) $sql = $sql . ", ";
        $sql = $sql . $field . " " . $fieldMetaData[$i];
      }
      $sql = $sql . ")";

      $this->conn->exec($sql);
      return 1;
    } catch(PDOException $e) {
      return $e->getMessage();
    }
  }

  public function insert($tableName, $values) {
    try {
      $sql = "INSERT INTO " . $tableName . " VALUES (";
      foreach ($values as $i => $value){
        if($i > 0) $sql = $sql . ", ";
        $sql = $sql . "'" . $value . "'";
      }
      $sql = $sql . ")";

      $this->conn->exec($sql);
      return 1;
    } catch(PDOException $e) {
      return $e->getMessage();
    }
  }

  public function select($tableName, $values = "*", $criteria = "true") {
    try {
      $sql = "SELECT " . $values . " FROM " . $tableName . " WHERE " . $criteria;
      
      return $this->conn->query($sql, PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
      return $e->getMessage();
    }
  }

  public function update($tableName, $setValues, $criteria) {
    try {
      $sql = "UPDATE " . $tableName . " SET " . $setValues . " WHERE " . $criteria;

      return $this->conn->exec($sql);
    } catch(PDOException $e) {
      return $e->getMessage();
    }
  }

  public function delete($tableName, $criteria) {
    try {
      $sql = "DELETE FROM $tableName WHERE $criteria";

      return $this->conn->exec($sql);
    } catch(PDOException $e) {
      return $e->getMessage();
    }
  }
}
