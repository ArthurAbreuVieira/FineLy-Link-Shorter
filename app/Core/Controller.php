<?php

namespace App\Core;

abstract class Controller {
  public function load(string $viewName, array $params) {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__."/../view/");
    $twig = new \Twig\Environment($loader);
    $view = $twig->render($viewName, $params);
    echo $view;
  }
}