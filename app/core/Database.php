<?php

namespace App\Core;

class Database {
  private $conn;
  public function __construct() {
    $this->conn = new \PDO('mysql:host=localhost;dbname=FineLy', 'root', '');
  }

  public function selectOnly($id) {
    $sql = "SELECT * FROM links WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    if($stmt->execute()) {
      $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $data;
    }
    return null;
  }

  public function insert($query) {
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
  }
}