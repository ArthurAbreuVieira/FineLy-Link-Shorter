<?php 

namespace App\Model;

use App\Core\Database;

class ShorterModel extends Database {
  public function insertUrlInDatabase($values) {
    $this->insert('links', $values);
  }
}