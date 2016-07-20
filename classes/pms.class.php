<?php require('db.class.php');

class PMS {

  private $DB;

  function __construct() {
    $this->DB = new DB();
  }

  //TODO: Tables may be created but PMS setup fails - better to check if
  //      table is populated rather than exists
  public function isSetup() {
    return $this->DB->isSetup();
  }

  //TODO: Make controlable through DB
  public function getHomeTitle() {
    return "Homepage - Portfolio";
  }

  //TODO: Grab selected theme name from DB
  public function getTheme() {
    return "default";
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
    return $this->DB->select("fields")->fetchAll();
  }
  public function addAdminField($fieldName, $fieldType) {
    return $this->DB->insert("fields", [NULL, $fieldName, NULL, $fieldType]);
  }
  public function getAdminField($fieldName) {
    return nl2br($this->DB->select("fields", "value", "name='$fieldName'")->fetch()['value']);
  }
  public function updateAdminField($fieldID, $fieldValue) {
    return $this->DB->update("fields", "value='$fieldValue'", "id='$fieldID'");
  }
  public function removeAdminField($fieldID) {
    return $this->DB->delete("fields", "id='$fieldID'");
  }

  //Project Related CRUD Methods (Create, Read, Update, Delete)
  public function getProjects() {
    return $this->DB->select("projects", "*", "1=1 ORDER BY id DESC")->fetchAll();
  }
  public function createProject($title, $preview, $body) {
    return $this->DB->insert("projects", [NULL, $title, $preview, $body]);
  }
  public function getProject($id) {
    return $this->DB->select("projects", "*", "id='$id'")->fetch();
  }
  public function deleteProject($id) {
    return $this->DB->delete("projects", "id='$id'");
  }
}
