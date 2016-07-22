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
      $isSetup = 0;

      if($this->conn->query("SHOW TABLES LIKE 'fields'")->rowCount() > 0){
        if($this->conn->query("SELECT * FROM fields")->rowCount() > 0){
          $isSetup = 1;
        }
      }

      return $isSetup;
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
      return 0;
    }
  }

  //Sanitises inputs as opposed to insert()
  //TODO: Move all INSERT queries to this function
  public function insertSecure($tableName, $values) {
    try {
      $sql = "INSERT INTO $tableName VALUES (";
      foreach($values as $i => $value) {
        if($i > 0) $sql = $sql . ", ";
        $sql = $sql . "?";
      }
      $sql = $sql . ")";

      $stmt = $this->conn->prepare($sql);
      foreach($values as $i => $value){
        $stmt->bindValue($i + 1, $value);
      }
      return $stmt->execute();
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

  //Sanitises inputs as opposed to update()
  //TODO: Move all UPDATE queries to this function
  public function updateSecure($tableName, $set, $values, $criteria = "true") {
    try {
      $sql = "UPDATE $tableName SET $set WHERE $criteria";
      $stmt = $this->conn->prepare($sql);
      foreach($values as $i => $value){
        $stmt->bindValue($i + 1, $value);
      }
      return $stmt->execute();
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
