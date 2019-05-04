<?php
namespace Models;

class Relay extends Model {
  private $id;
  private $name;

  public function __construct($id) {
    parent::__construct($id);
    $this->id = $id;
    $result = $this->db->query("SELECT id, name FROM relays WHERE id = $id");
    $row = $result->fetch_assoc();
    $this->db_object = $row;
    $this->load_from_row($row);
    return $row;
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