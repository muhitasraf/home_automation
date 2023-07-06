<?php

use Core\Application;

$app = new Application();

$app::get('/','HomeController','index');
$app::get('/create','HomeController','create');
$app::post('/store','HomeController','store');

$app->run();