<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\LinkModel;

class LinkController extends Controller {
  
  private $model;

  public function __construct() {
    $this->model = new LinkModel();
  }

  public function getMyLinksPage() {
    if(!UserController::userIsLoggedIn()) {
      header('location: home');
      die();
    }
    $user = $_SESSION['user'];
    $links = $this->model->getLinksFromUser();
    $this->load('my_links.html', [
      "links" => $links,
      "user" => $user
    ]);
  }

  public function linkDetailsPage() {
    if(false) {
      echo "<pre>";
      echo "ESTOU NA ROTA DETAILS".PHP_EOL;
      $uri = $_SERVER['REQUEST_URI'];
      $uri = array_filter(explode('/', $uri));
      $uri = array_values($uri);
      var_dump($uri);
    }
    
    $this->load('details.html', []);
  }

  public function shortLink() {
    if(!isset($_POST['url']) || empty($_POST['url'])){
      $this->load('linkResult.html',["error" => 'empty_url']);
      die(); 
    }

    $url = $_POST['url'];
    $pageId = $this->generatePageId($url);
    $shortedUrl = "http://localhost/likn/".$pageId;
    $data = [
      'id' => $pageId,
      'owner' => NULL,
      'original_url' => $url,
      'shorted_url' => $shortedUrl,
    ];

    $this->model->insertUrlInDatabase($data);

    $this->load('linkResult.html',$data);
  }

  private function generatePageId(String $url) {
    $part1 = substr(uniqid(uniqid(substr(uniqid(uniqid()), 10))), 0, 2);
    $part2 = substr(md5($part1.substr(sha1(uniqid()), -4)), -2);
    $part3 = substr(sha1($part1.$part2), -3);

    $pageId = substr(password_hash(sha1($part1.$part2.$part3), PASSWORD_DEFAULT), -7);
    $pageId = str_replace(['/','.'], 'A', $pageId);

    return $pageId;
  }
}