<?php

require('db.class.php');

class PMS {

  private $DB;

  function __construct() {
    $this->DB = new DB();
  }

  public function getHomeTitle() {
    return "Homepage - Portfolio";
  }

  public function get($fieldName) {
    return $this->DB->select("fields", "value", "name='$fieldName'")->fetch()['value'];
  }

  public function update($fieldName, $value) {
    return $this->DB->update("fields", "value='$value'", "name='$fieldName'");
  }

  public function isSetup() {
    return $this->DB->isSetup();
  }

  public function login($email, $password) {
    $storedUser = $this->DB->select("personal", "*", "email='$email'")->fetch();

    return array ( password_verify($password, $storedUser['password']), $storedUser['email'] );
  }

  //Field Related Methods
  public function getAdminFields() {
    return $this->DB->select("fields")->fetchAll();
  }
  public function addAdminField($fieldName) {
    return $this->DB->insert("fields", [NULL, $fieldName, NULL]);
  }
  public function removeAdminField($fieldName) {
    return $this->DB->delete("fields", "name='$fieldName'");
  }

}

 ?>
