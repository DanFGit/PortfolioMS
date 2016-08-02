<?php require('db.class.php');

class PMS {

  private $DB;

  function __construct() {
    $this->DB = new DB();
  }

  //Checks if PMS has been setup correctly
  public function isSetup() {
    return $this->DB->isSetup();
  }

  //Gets the title to be shown on each webpage
  public function getHomeTitle() {
    //TODO: Make controlable through DB //return $this->DB->select("personal", "title")->fetch()['title'];
    return "Homepage - Portfolio";
  }

  //Get/Set theme
  public function getTheme() {
    return $this->DB->select("personal", "theme")->fetch()['theme'];
  }
  public function setTheme($name) {
    return $this->DB->update("personal", "theme='$name'", "true");
  }

  //Verify Password
  public function verifyPassword($email, $password) {
    $storedPW = $this->DB->select("personal", "*", "email='$email'")->fetch()['password'];
    return password_verify($password, $storedPW);
  }

  //Change Email - Returns 0 if fail, 1 if success
  public function changeEmail($currentEmail, $newEmail) {
    return $this->DB->updateSecure("personal", "email=?", [$newEmail], "email='$currentEmail'");
  }

  //Change Password
  public function changePassword($email, $pass) {
    $newPassword = password_hash($pass, PASSWORD_DEFAULT);
    return $this->DB->updateSecure("personal", "password=?", [$newPassword], "email='$email'");
  }

  //Alias function for 'getAdminField'
  public function get($fieldName) {
    return $this->getAdminField($fieldName);
  }

  //Checks the user login information is correct
  //Returns 0 if not
  public function login($email, $password) {
    $storedUser = $this->DB->select("personal", "*", "email='$email'")->fetch();
    return array ( password_verify($password, $storedUser['password']), $storedUser['email'] );
  }

  //Field Related CRUD Methods (Create, Read, Update, Delete)
  public function getAdminFields() {
    $query = $this->DB->select("fields");

    if($query->rowCount()) {
      return $query->fetchAll();
    } else {
      return [];
    }
  }
  public function getAdminField($fieldName) {
    $query = $this->DB->select("fields", "value", "name='$fieldName'");

    if($query->rowCount()) {
      return nl2br($query->fetch()['value']);
    }
  }
  public function createField($fieldName, $fieldValue, $fieldType) {
    if($fieldType == "array"){
      if(!is_array($fieldValue)) $fieldValue = array($fieldValue);
      $insertValue = json_encode($fieldValue);
    } else {
      $insertValue = $fieldValue;
    }
    return $this->DB->insert("fields", [NULL, $fieldName, $insertValue, $fieldType]);
  }
  public function updateField($fieldID, $fieldValue) {
    return $this->DB->update("fields", "value='$fieldValue'", "id='$fieldID'");
  }
  public function deleteField($fieldID) {
    return $this->DB->delete("fields", "id='$fieldID'");
  }

  //Project Related CRUD Methods (Create, Read, Update, Delete)
  public function getProject($id) {
    $query = $this->DB->select("projects", "*", "id='$id'");

    if($query->rowCount()) {
      return $query->fetch();
    } else {
      return [];
    }
  }
  public function getProjects() {
    $query = $this->DB->select("projects", "*", "1=1 ORDER BY id DESC");

    if($query->rowCount()) {
      return $query->fetchAll();
    } else {
      return [];
    }
  }
  public function getPublicProjects() {
    $query = $this->DB->select("projects", "*", "visible='1' ORDER BY id DESC");

    if($query->rowCount()) {
      return $query->fetchAll();
    } else {
      return [];
    }
  }
  public function createProject($title, $preview, $body, $visible) {
    return $this->DB->insertSecure("projects", [NULL, $title, $preview, $body, $visible]);
  }
  public function deleteProject($id) {
    return $this->DB->delete("projects", "id='$id'");
  }
  public function hideProject($id) {
    return $this->DB->update("projects", "visible=0", "id='$id'");
  }
  public function showProject($id) {
    return $this->DB->update("projects", "visible=1", "id='$id'");
  }
  public function editProject($id, $title, $preview, $body, $visible) {
    return $this->DB->updateSecure("projects", "title=?, preview=?, body=?, visible=?", [$title, $preview, $body, $visible], "id='$id'");
  }
}
