<?php 
namespace Models;
require_once(__ROOT__.'/html/models/relay.php'); 

class Model {
  private $db;
  private $db_object;

  public function __construct($id = '') {
    global $mysqli;

    if ($mysqli->connect_errno) {
      printf("Connect failed: %s\n", $mysqli->connect_error);
    }

    $this->db = $mysqli;
  }

  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    } else {
      throw new \Exception("Property $property not defined.");
    }
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    } else {
      throw new \Exception("Property $property not defined.");
    }
    return $this;
  }
}