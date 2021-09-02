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
    
    if(empty($name) || empty($email) || empty($password)) {
      $this->load('signUp.html',[
        "error" => [
          "type" => "Invalid data",
          "msg" => "Preencha todos os campos!"
        ]
      ]);
      die;
    }

    $user = $this->model->selectOnly('users', 'email', $email);
    if($user != false) {
      $this->load('signUp.html',[
        "error" => [
          "type" => "Invalid data",
          "msg" => "Usuário já cadastrado!"
        ]
      ]);
      die;
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
      $this->load('login.html',[
        "error" => [
          "type" => "Invalid data",
          "msg" => "Preencha todos os campos!"
        ]
      ]);
    }

    $values = [
      "email" => $email,
      "password" => $password
    ];

    if($this->model->loginUser($values)) {
      $userData = $this->model->selectOnly('users', 'email', $email);
      $_SESSION['user'] = [
        "id" => $userData['id'],
        "name" => $userData['name'],
        "email" => $userData['email']
      ];
      header('Location: home');
    } else {
      $this->load('login.html',[
        "error" => [
          "type" => "Invalid data",
          "msg" => "Dados invalidos!"
        ]
      ]);
    }
  }

  public function logout()  {
    unset($_SESSION['user']);
    session_destroy();
    header("Location: ./home");
    die();
  }

  static public function userIsLoggedIn() {
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      return true;
    }
    return false;
  }

  public function updateUserData() {
    if(empty($_POST['data'])){  
      echo json_encode([
        'status' => 'error',
        'msg' => "Não foi possivel alterar os dados."
      ]);
      die;
    }
    $json = json_decode($_POST['data'], true);
    if(empty($json['type'] || empty($json['value']))) {
      echo json_encode([
        'status' => 'error',
        'msg' => "Não foi possivel alterar os dados."
      ]);
      die;
    }
    if($json['type'] === "password") {
      $json['value'] = password_hash($json['value'], PASSWORD_BCRYPT);
    }
    if($this->model->updateUser($json)) {
      if($json['type'] === 'name') {
        $_SESSION['user']['name'] = $json['value'];
      } else if ($json['type'] === 'email') {
        $_SESSION['user']['email'] = $json['value'];
      }
      echo json_encode([
        'status' => 'success',
        'msg' => "Dados alterados com sucesso"
      ]);
      die;
    }else {
      echo json_encode([
        'status' => 'error',
        'msg' => "Não foi possivel alterar os dados."
      ]);
      die;
    }
  }
}