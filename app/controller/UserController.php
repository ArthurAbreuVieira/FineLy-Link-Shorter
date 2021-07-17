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
    if(self::userIsLoggedIn()) {
      header('location: home');
      die();
    }

    if(!isset($_POST['name']) && !isset($_POST['email']) && !isset($_POST['password'])) {
      header('location: signup');
      die();
    }

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

    $this->model->signUpUser($values);
    header('Location: home');
  }

  public function login() {
    if(self::userIsLoggedIn()) {
      header("Location: home");
      die();
    }

    if(!isset($_POST['email']) && !isset($_POST['password'])) {
      header('location: login');
      die();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)) {
      echo "Preencha todos os campos!";
      die();
    }

    $values = [
      "email" => $email,
      "password" => $password
    ];

    if($this->model->loginUser($values)) {
      $userData = $this->model->selectOnly('users', 'email', $email);
      $_SESSION['user'] = [
        "user_id" => $userData['id'],
        "user_name" => $userData['name'],
        "user_email" => $userData['email']
      ];
      header('Location: home');
    } else {
      echo 'dados invalidos.';
    }
  }

  static public function userIsLoggedIn() {
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      return true;
    }
    return false;
  }
}