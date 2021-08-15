<?php 

$this->get("", "PageController@index");
$this->get("home", "PageController@index");
$this->post("short", "LinkController@shortLink");
$this->get("signup", "PageController@signUp");
$this->post("signup-user", "UserController@signUp");
$this->get("login", "PageController@login");
$this->get("logout", "UserController@logout");
$this->post("login-user", "UserController@login");
$this->get("mylinks", "LinkController@getMyLinksPage");
$this->get("details", "LinkController@linkDetailsPage");

