<?php

use Core\Application;

$app = new Application();

$app::get('/','HomeController','test');

$app->run();