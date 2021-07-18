<?php

namespace App\Controller;

use App\Core\Controller;
use App\Model\ShorterModel;

class ShorterController extends Controller{
  
  private $model;

  public function __construct() {
    $this->model = new ShorterModel();
  }

  public function index() {
    if(!isset($_POST['url']) || empty($_POST['url'])){
      $this->load('linkResult.html',["error" => 'empty_url']);
      die(); 
    }

    $url = $_POST['url'];
    $pageId = $this->short($url);
    $shortedUrl = "http://localhost/likn/".$pageId;
    $data = [
      'id' => $pageId,
      'original_url' => $url,
      'shorted_url' => $shortedUrl,
    ];

    $this->model->insertUrlInDatabase($data);

    $this->load('linkResult.html',$data);
  }

  public function short(String $url) {
    $part1 = substr(uniqid(uniqid(substr(uniqid(uniqid()), 10))), 0, 2);
    $part2 = substr(md5($part1.substr(sha1(uniqid()), -4)), -2);
    $part3 = substr(sha1($part1.$part2), -3);

    $pageId = substr(password_hash(sha1($part1.$part2.$part3), PASSWORD_DEFAULT), -7);
    $pageId = str_replace(['/','.'], 'A', $pageId);

    return $pageId;
  }
}