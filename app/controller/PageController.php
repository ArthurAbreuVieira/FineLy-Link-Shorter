<?php

namespace App\Controller;

use App\Core\Controller;
use App\Controller\UserController;
use App\Controller\LinkController;

// This controller only redirects to non-complex pages;

class PageController extends Controller{
  public function __construct() {

  }

  public function index() {
    $params = [];
    if(UserController::userIsLoggedIn()) {
      $params = ["user" => $_SESSION['user']];
    }

    $this->load('index.html',$params);
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
  
  public function profile() {
    if(UserController::userIsLoggedIn()) {
      header("Location: home");
      die();
    }

    $this->load('profile.html',[]);
  }
}