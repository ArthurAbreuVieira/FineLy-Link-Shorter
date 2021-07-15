<?php 

$this->get("", "PageController@index");
$this->get("home", "PageController@index");
$this->post("short", "ShorterController@shortLink");
