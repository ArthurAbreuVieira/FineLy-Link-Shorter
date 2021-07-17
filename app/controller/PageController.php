<?php

namespace App\Controller;

use App\Core\Controller;
use App\Controller\UserController;

class PageController extends Controller{
  public function __construct() {

  }

  public function index() {
    $this->load('index.html',[]);
  }

  public function signUp() {
    if(UserController::userIsLoggedIn()) {
      header('location: home');
      die();
    }

    $this->load('signUp.html',[]);    
  }
  
  public function login() {
    if(UserController::userIsLoggedIn()) {
      header("Location: home");
      die();
    }

    $this->load('login.html',[]);    
  }

  public function redirect($data) {
    $url = str_starts_with($data['original_url'], 'http') ? $data['original_url'] : 'https://'.$data['original_url']; //NECESSITA DE MELHORIA!!!!!!!!!!!!!
    header('location:'.$url);
  }
}