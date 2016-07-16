<?php

require('db.class.php');

class PMS {

  private $DB;

  function __construct() {
    $DB = new DB();
  }

  public function getHomeTitle() {
    return "Homepage - Portfolio";
  }

}

 ?>
