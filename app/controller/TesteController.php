<?php

namespace App\Controller;

class TesteController {
  public function __construct() {
    
  }

  public function index() {
    echo 'Olá, sou o index do TesteController!';
  }
  public function createShortedLink() {
    echo 'link shorter!';
  }
}