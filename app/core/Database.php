<?php

namespace App\Core;

class Database {
  private $conn;
  public function __construct() {
    $this->conn = new \PDO('mysql:host=localhost;dbname=FineLy', 'root', '');
  }

  public function selectOnly($table, $collumn, $value) {
    $sql = "SELECT * FROM $table WHERE $collumn = :value";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':value', $value);
    if($stmt->execute()) {
      $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $data;
    }
  }

  public function insert($table, $values) {
    $sql = "INSERT INTO $table({{collumns}}) VALUES({{values}})";

    $collumns = '';
    $str_values = '';
    foreach($values as $key => $value) {
      $collumns .= "$key,";
      $str_values .= "'$value',";
    }
    $collumns = substr($collumns, 0, -1);
    $str_values = substr($str_values, 0, -1);

    $sql = str_replace("{{collumns}}", $collumns, $sql);
    $sql = str_replace("{{values}}", $str_values, $sql);

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
  }
}