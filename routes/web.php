<?php 

$this->get("", "PageController@index");
$this->get("home", "PageController@index");
$this->post("short", "ShorterController@shortLink");
$this->get("signup", "PageController@signUp");
$this->post("signup-user", "UserController@signUp");
$this->get("login", "PageController@login");
$this->post("login-user", "UserController@login");
