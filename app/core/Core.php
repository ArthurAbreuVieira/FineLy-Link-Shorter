<?php

namespace App\Core;

class Core {
  private $routesGet = [];
  
  public function __construct() {
    $uri = $this->getUri();

    $uri = $this->sanitizeUri($uri);
    include_once 'D:\laragon\www\Likn\routes\web.php';
    
    if(!$this->checkRoute($uri)) {
      echo 'error';
      // $this->execute($uri);
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
    foreach($this->routesGet as $route) {
      if($uri === $route['route']) {
        $controller = $this->getController($route['call']);
        $method = $this->getMethod($route['call']);
        break;  
      }
    }

    // $controller = "App\Controller\\".$controller;
    call_user_func_array([new $controller, $method], []);
  }

  private function getController($route) {
    $controller = "App\Controller\\".explode($route, '@')[0];

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

  private function get(string $routeName, string $method) {
    if(!in_array($routeName, $this->routesGet)) {
      array_push($this->routesGet, [
        "route" => $routeName,
        "call" => $method
      ]);
    }
  }


}