<?php

namespace App\Core;

use App\Core\Database;

class Core {
  private $routesGet = [];
  private $conn;
  private $currentRoute;

  public function __construct() {
    $this->conn = new Database();

    $uri = $this->getUri();
    $uri = $this->sanitizeUri($uri);

    
    
    include_once 'D:\laragon\www\Likn\routes\web.php';
    
    if(!$this->checkRoute($uri) && !$this->pageExists($uri)) {
      echo 'route not found';
      die();
    }

    if($this->pageExists($uri)) {
      $this->execute([$this->pageExists($uri)]);
    } else {
      $this->execute($this->checkRoute($uri));
    }
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
        $this->currentRoute = $route;
        return [$uri, $route];
      }
      
      if(preg_match('/{.*}/', $route['route'], $match)) {
        $match = $match[0];
        $match = substr($route['route'], 0, strpos($route['route'], $match));
        $match = substr($match, 0, -1);
        if(str_starts_with($uri, $match)) {
          $uri = $match;
          $route['route'] = $match;
        }
      }

      if(in_array($uri, $route)) {
        $this->currentRoute = $route;
        return [$uri, $route];
      }
      
    }
    return false;
  }

  private function execute(array $route) {
    $params = [];
    
    if($this->pageExists($route[0])) {
      $data = $this->conn->selectOnly("links", "id", $route[0]);
      $controller = 'App\Controller\PageController';
      $method = 'redirect';
      $params = $data;
    } else {
      $controller = $this->getController($route[1]['call']);
      $method = $this->getMethod($route[1]['call']);
    }

    $params["base"] = "http://localhost/likn";

    // echo '<pre>';
    // print_r($params);
    // die();

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

  public function pageExists(String $uri) {
    if(empty($uri)) {
      return false;
    }

    $conn = $this->conn;
    $data = $conn->selectOnly("links", "id", $uri);

    if(!empty($data)) {
      return $uri;      
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