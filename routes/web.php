<?php 

$this->get("", "PageController@index");
$this->get("home", "PageController@index");
$this->get("create", "PageController@createShortedLink");
$this->get("teste", "TesteController@index");