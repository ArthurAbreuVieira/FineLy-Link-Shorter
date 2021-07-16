<?php

namespace App\Model;

use App\Core\Database;

class UserModel extends Database {
  public function createUser($values) {
    $this->insert('users', $values);
  }
}