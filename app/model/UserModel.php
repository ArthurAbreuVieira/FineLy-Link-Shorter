<?php

namespace App\Model;

use App\Core\Database;

class UserModel extends Database {
  public function signUpUser($values) {
    $this->insert('users', $values);
  }
  
  public function loginUser($values) {
    $userEmail = $this->selectOnly('users', 'email', $values['email'], 'email');
    if(!$userEmail) {
      return false;
    }
    $userEmail = $userEmail['email'];
    $userPassword = $this->selectOnly('users', 'email', $values['email'], 'password')['password'];
    var_dump($userEmail);
    
    if($userEmail === $values['email'] && password_verify($values['password'], $userPassword))  {
      return true;
    }
    return false;
  }
}