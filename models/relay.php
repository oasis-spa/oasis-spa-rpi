<?php
namespace Models;

class Relay {
  private $db;
  private $id;
  private $db_object;
  private $name;

  public function __construct($id = '') {
    global $mysqli;

    if ($mysqli->connect_errno) {
      printf("Connect failed: %s\n", $mysqli->connect_error);
    }

    $this->db = $mysqli;
    $this->id = $id;
    $result = $this->db->query("SELECT id, name FROM relays WHERE id = $id");
    $row = $result->fetch_assoc();
    $this->db_object = $row;
    $this->load_from_row($row);
    return $row;
  }

  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    }

    return $this;
  }

  private function load_from_row($row) {
    $this->name = $row['name'];
  }

  public function delete($id): self {
      $query = $this->db->prepare('DELETE FROM relays WHERE id = :id');
      $query->execute(['id' => $id]);
      return $this;
  }
}