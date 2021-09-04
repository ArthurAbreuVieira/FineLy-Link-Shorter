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
    $params["BASE"] = $_ENV['BASE'];
    $this->load('index.html',$params);
  }

  public function signUp() {
    if(UserController::userIsLoggedIn()) {
      header('location:'.$_ENV['BASE'].'/home');
      die();
    }
    $params = [];
    $params["BASE"] = $_ENV['BASE'];
    $this->load('signUp.html',$params);    
  }
  
  public function login() {
    if(UserController::userIsLoggedIn()) {
      header('location:'.$_ENV['BASE'].'/home');
      die();
    }
    $params = [];
    $params["BASE"] = $_ENV['BASE'];
    $this->load('login.html',$params);
  }
  
  public function profile() {
    if(!UserController::userIsLoggedIn()) {
      header('location:'.$_ENV['BASE'].'/home');
      die();
    }
    $params = [];
    $params = ["user" => $_SESSION['user']];
    $params["BASE"] = $_ENV['BASE'];
    $this->load('profile.html',$params);
  }
}