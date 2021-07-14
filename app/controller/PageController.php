<?php

namespace App\Controller;

use App\Core\Controller;

class PageController extends Controller{
  public function __construct() {

  }

  public function index() {
    $this->load('index.html',[]);
  }

}