<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\LinkModel;

class LinkController extends Controller {
  
  private $model;

  public function __construct() {
    $this->model = new LinkModel();
  }

  public function myLinksPage() {
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
    if(!UserController::userIsLoggedIn()) {
      header('location: http://localhost/likn/home');
      die();
    }

    $uri = $_GET['uri'];
    $uri = array_filter(explode('/', $uri));
    $uri = array_values($uri);

    $data = [];

    if(isset($uri[1]) && !empty($uri[1])) {
      $data["code"] = $uri[1];
      $linkData = $this->model->getLinkData($data['code']);
      if(empty($linkData)) {
        header('location: http://localhost/likn/home');
        die();
      }
      $date = str_replace(['-', ' '], ['/', ' - '], $linkData['created_at']);
      $linkData['created_at'] = $date;
      $data["link"] = $linkData;
    }

    $this->load('details.html', $data);
  }

  public function shortLink() {
    if(!isset($_POST['url']) || empty($_POST['url'])){
      $this->load('linkResult.html',["error" => 'empty_url']);
      die(); 
    }

    $url = $_POST['url'];
    $pageId = $this->generatePageId($url);
    $shortedUrl = "http://localhost/likn/".$pageId;
    
    $date = new \DateTime();
    $timestamp = $date->getTimestamp();

    $data = [
      'id' => $pageId,
      'owner' => NULL,
      'redirect' => $url,
      'shorted' => $shortedUrl,
      'initial_redirect' => $url,
      'created_at' => "NOW()"
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