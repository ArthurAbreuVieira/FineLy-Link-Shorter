<?php 

$this->get("", "PageController@index");
$this->get("home", "PageController@index");
$this->post("short", "LinkController@shortLink");
$this->get("signup", "PageController@signUp");
$this->post("signup-user", "UserController@signUp");
$this->get("login", "PageController@login");
$this->get("logout", "UserController@logout");
$this->post("login-user", "UserController@login");
$this->get("mylinks", "LinkController@myLinksPage");
$this->get("details/{link_id}", "LinkController@linkDetailsPage");
$this->post("edit", "LinkController@editLink");
$this->post("delete", "LinkController@deleteLink");
$this->get("profile", "PageController@profile");
$this->post("update", "UserController@updateUserData");

