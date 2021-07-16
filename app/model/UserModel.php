<?php

namespace App\Model;

use App\Core\Database;

class UserModel extends Database {
  public function signUpUser($values) {
    $this->insert('users', $values);
  }
  
  public function loginUser($values) {
    $userEmail = $this->selectOnly('users', 'email', $values['email'], 'email')['email'];
    $userPassword = $this->selectOnly('users', 'email', $values['email'], 'password')['password'];
    
    if($userEmail === $values['email'] && password_verify($values['password'], $userPassword))  {
      header('Location: home');
      die();
    } else {
      echo 'dados invalidos.';
    }
  }
}