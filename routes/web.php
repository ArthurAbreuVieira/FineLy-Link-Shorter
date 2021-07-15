<?php 

$this->get("", "PageController@index");
$this->get("home", "PageController@index");
$this->post("short", "ShorterController@shortLink");
$this->get("signup", "PageController@signUp");
$this->post("create-user", "UserController@signUp");
