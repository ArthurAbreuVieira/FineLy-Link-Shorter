<?php

namespace App\Core;

class Database {
  private $conn;
  public function __construct() {
    $driver   = $_ENV['DATABASE_DRIVER'];
    $host     = $_ENV['DATABASE_HOST'];
    $dbname   = $_ENV['DATABASE_DBNAME'];
    $user     = $_ENV['DATABASE_USER'];
    $password = $_ENV['DATABASE_PASSWORD'];
    $this->conn = new \PDO("$driver:host=$host;dbname=$dbname", $user, $password);
  }

  public function selectOnly($table, $column, $value, $select = '*') {
    $sql = "SELECT $select FROM $table WHERE $column = :value";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':value', $value);
    if($stmt->execute()) {
      $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $data;
    }
    return false;
  }
  
  public function selectMany($table, $column, $value, $select = '*') {
    $sql = "SELECT $select FROM $table WHERE $column = :value";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':value', $value);
    if($stmt->execute()) {
      $data = [];
      while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $data[] = $row;
      }
      return $data;
    }
  }

  public function insert($table, $values) {
    $sql = "INSERT INTO $table({{columns}}) VALUES({{values}})";

    $columns = '';
    $str_values = '';
    foreach($values as $key => $value) {
      $columns .= "$key,";
      $str_values .= "'$value',";
    }
    $columns = substr($columns, 0, -1);
    $str_values = substr($str_values, 0, -1);

    $sql = str_replace("{{columns}}", $columns, $sql);
    $sql = str_replace("{{values}}", $str_values, $sql);

    if(str_contains($sql,"'NOW()'")) {
      $sql = str_replace("'NOW()'", "NOW()", $sql);
    }

    $stmt = $this->conn->prepare($sql);
    if ($stmt->execute()) 
      return true;
    else 
      return false;
  }

  public function update($table, $column, $value, $where, $whereValue) {
    $sql = "UPDATE $table SET $column = :newValue WHERE $where = :whereValue";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":newValue", $value);
    $stmt->bindValue(":whereValue", $whereValue);
    if ($stmt->execute()) 
      return true;
    else 
      return false;
  }

  public function delete($table, $column, $value) {
    $sql = "DELETE FROM $table WHERE $column = :value";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":value", $value);
    if ($stmt->execute()) 
      return true;
    else 
      return false;
  }
}