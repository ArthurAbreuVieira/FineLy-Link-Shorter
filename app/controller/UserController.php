<?php 

namespace App\Controller;

use App\Core\Controller;
use App\Model\UserModel;

class UserController extends Controller {
  private $model;

  public function __construct() {
    $this->model = new UserModel();
  }

  public function signUp() {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if($this->model->selectOnly('users', 'email', $email)) {
      echo "USUARIO JÀ CASDASTRADO";
      die();
    }
    
    if(empty($name) || empty($email) || empty($password)) {
      echo "Preencha todos os campos!";
      die();
    }

    $values = [
      "name" => $name,
      "email" => $email,
      "password" => $password
    ];

    $this->model->createUser($values);
    header('Location: home');
  }
}