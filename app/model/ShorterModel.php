<?php 

namespace App\Model;

use App\Core\Database;

class ShorterModel extends Database {
  public function insertUrlInDatabase($values) {
    $sql = "INSERT INTO links VALUES('".$values['id']."','".$values['shorted_url']."','".$values['original_url']."')";
    $this->insert($sql);
  }
}