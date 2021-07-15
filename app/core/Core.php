<?php

namespace App\Core;

use App\Core\Database;

class Core {
  private $routesGet = [];
  private $conn;

  public function __construct() {
    $this->conn = new Database();

    $uri = $this->getUri();
    $uri = $this->sanitizeUri($uri);

    include_once 'D:\laragon\www\Likn\routes\web.php';
    
    if(!$this->checkRoute($uri) && !$this->pageExists($uri)) {
      echo 'route not found';
      die();
    }

    $this->execute($uri);
  }

  private function getUri() {
    if(!isset($_GET['uri']) || empty($_GET['uri'])) {
      $uri = '/';
    } else {
      $uri = $_GET['uri'];
    }
    return $uri;
  }

  private function sanitizeUri(string $uri) {
    $newUri = filter_var($uri, FILTER_SANITIZE_URL);
    $newUri = trim(rtrim($newUri, '/'));
    return $newUri;
  }
  
  private function explodeUri(string $uri) {
    $uriArray = explode('/', $uri);
    return $uriArray;
  }
  
  private function checkRoute(string $uri) {
    foreach($this->routesGet as $route) {
      if(in_array($uri, $route)) {
        return true;
      }
    }
    return false;
  }

  private function execute(string $uri) {
    $params = [];
    
    if($this->pageExists($uri)) {
      $data = $this->conn->selectOnly($uri);
      $controller = 'App\Controller\PageController';
      $method = 'redirect';
      $params = $data;
    } else {
      foreach($this->routesGet as $route) {
        if($uri === $route['route']) {
          $controller = $this->getController($route['call']);
          $method = $this->getMethod($route['call']);
          break;  
        }
      }
    }

    call_user_func_array([new $controller, $method], [$params]);
  }

  private function getController($route) {
    $controller = "App\Controller\\".explode("@", $route)[0];
    
    if(!class_exists($controller)){
      return "App\Controller\\PageController";
    }

    return $controller;
  }

  private function getMethod($route) {
    $controller = $this->getController($route);
    $method = explode('@', $route)[1];

    if(!method_exists($controller, $method)){
      return "index";
    }

    return $method;
  }

  public function pageExists(String $url) {
    $conn = $this->conn;
    $data = $conn->selectOnly($url);

    if(!empty($data)) {
      return true;      
    }

    return false;
  }

  private function get(string $routeName, string $method) {
    if(!in_array($routeName, $this->routesGet)) {
      array_push($this->routesGet, [
        "route" => $routeName,
        "call" => $method
      ]);
    }
  }

  private function post(string $routeName, string $method) {
    if(!in_array($routeName, $this->routesGet)) {
      array_push($this->routesGet, [
        "route" => $routeName,
        "call" => $method
      ]);
    }
  }
}