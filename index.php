<?php

session_start();

require "./vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv -> load();

use App\Core\Core;


$core = new Core();