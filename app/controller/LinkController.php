<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\LinkModel;
use App\Model\ClickModel;

class LinkController extends Controller {
  
  private $model;
  private $clickModel;

  public function __construct() {
    $this->model = new LinkModel();
    $this->clickModel = new ClickModel();
  }

  public function myLinksPage() {
    if(!UserController::userIsLoggedIn()) {
      header('location:'.$_ENV['BASE'].'/home');
      die();
    }
    $params = [];
    if(!empty($_SESSION['flash']))  {
      $params["flash"] = $_SESSION['flash'];
      unset($_SESSION['flash']);
    }
    $user = $_SESSION['user'];
    $links = $this->model->getLinksFromUser();
    $params['user'] = $user;
    $params['links'] = $links;
    $this->load('my_links.html', $params);
  }

  public function linkDetailsPage() {    
    if(!UserController::userIsLoggedIn()) {
      header('location: '.$_ENV['BASE'].'/home');
      die();
    }

    if(isset($_POST['link'])) {
      $linkCode = $_POST['link'];
    } else {
      $uri = $_GET['uri'];
      $uri = array_filter(explode('/', $uri));
      $uri = array_values($uri);
      if(isset($uri[1])) $linkCode = $uri[1];
    }
    
    $data = [];

    if(isset($linkCode) && !empty($linkCode)) {
      $linkData = $this->model->getLinkData($linkCode);
      if(!empty($linkData)) {
        $date = str_replace(['-', ' '], ['/', ' - '], $linkData['created_at']);
        $linkData['created_at'] = $date;
        $data["link"] = $linkData;
  
        $clickData = $this->clickModel->getClickData($linkData['id']);
        $data['clicks'] = $clickData;
      } else {
        $data["error"] = [
          "type" => "Link não pertence ao usuário",
          "msg" => "Esse link não existe ou não pertence a você!"
        ];
      }
    }
    $data['user'] = $_SESSION['user'];
    $this->load('details.html', $data);
  }

  public function shortLink() {
    if(!isset($_POST['url']) || empty($_POST['url'])){
      $this->load('short.html',[
        "error" => 'empty_url',
        "user" => UserController::userIsLoggedIn()?$_SESSION['user']:NULL
      ]);
      die(); 
    }

    $url = $_POST['url'];
    $pageId = $this->generatePageId($url);
    $shortedUrl = $_ENV['BASE']."/$pageId";
    
    $date = new \DateTime();
    $timestamp = $date->getTimestamp();

    $data = [
      'id' => $pageId,
      'owner' => NULL,
      'redirect' => $url,
      'initial_redirect' => $url,
      'created_at' => "NOW()",
      'click_count' => 0
    ];

    $this->model->insertUrlInDatabase($data);

    $data['shorted'] = $shortedUrl;
    if(UserController::userIsLoggedIn()) {
      $data["user"] = $_SESSION['user'];
    }
    $this->load('short.html',$data);
  }

  private function generatePageId(String $url) {
    $part1 = substr(uniqid(uniqid(substr(uniqid(uniqid()), 10))), 0, 2);
    $part2 = substr(md5($part1.substr(sha1(uniqid()), -4)), -2);
    $part3 = substr(sha1($part1.$part2), -3);

    $pageId = substr(password_hash(sha1($part1.$part2.$part3), PASSWORD_DEFAULT), -7);
    $pageId = str_replace(['/','.'], 'A', $pageId);

    return $pageId;
  }

  public function editLink($data) {
    if((isset($_SERVER['CONTENT_TYPE'], $_POST['data']) && $_SERVER['CONTENT_TYPE']==="application/x-www-form-urlencoded")) {
      
      $data = json_decode($_POST['data'], true);
      if(!is_array($data) || empty($data['id']) || empty($data['redirect'])) {
        $response = [
          "status" => "error",
          "msg" => "Não foi possivel editar o link!"
        ];
        $json = json_encode($response);
        echo $json;
        // var_dump($json);
        die;
      }
  
      if($this->model->updateLink($data)) {
        $response = [
          "status" => "success",
          "msg" => "Link editado com sucesso!"
        ];
        $json = json_encode($response);
        echo $json;
        die;
      } else {
        $response = [
          "status" => "error",
          "msg" => "Não foi possivel editar o link!"
        ];
        $json = json_encode($response);
        echo $json;
        die;
      }

    } else {
      header("Location:".$_ENV['BASE']."/home");die;
    }
  }

  public function deleteLink($data) {
    if((isset($_SERVER['CONTENT_TYPE'], $_POST['data']) && $_SERVER['CONTENT_TYPE']==="application/x-www-form-urlencoded")) {
      
      $data = json_decode($_POST['data'], true);
      if(!is_array($data) || empty($data['id'])) {
        $response = [
          "status" => "error",
          "msg" => "Não foi possivel deletar o link!"
        ];
        $json = json_encode($response);
        echo $json;
        die;
      }
  
      $response = [];

      if($this->model->deleteLink($data)) {
        $response = [
          "status" => "success",
          "msg" => "Link deletado com sucesso!"
        ];
        $json = json_encode($response);
        echo $json;

        $_SESSION['flash'] = [
          "type" => $response["status"],
          "msg" =>  $response["msg"]
        ];
        die;
      } else {
        $response = [
          "status" => "error",
          "msg" => "Não foi possivel deletar o link!"
        ];
        $json = json_encode($response);
        echo $json;
        die;
      }
    }
  }

  public function redirect($data) {
    
    $this->clickModel->trackClick($data['id']);

    $url = str_starts_with($data['redirect'], 'http') ? $data['redirect'] : 'https://'.$data['redirect']; //NECESSITA DE MELHORIA!!!!!!!!!!!!!
    header('location:'.$url);
  }
}