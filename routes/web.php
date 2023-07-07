<?php

use Core\Application;

$app = new Application();

$app::get('/','HomeController','index');
$app::get('/switch_output/create','HomeController','create');
$app::post('/switch_output/store','HomeController','store');
$app::get('/switch_output/edit/{id}','HomeController','edit');
$app::post('/switch_output/update','HomeController','update');
$app::get('/switch_output/delete/{id}','HomeController','destroy');
$app::post('/switch_output/change_state','HomeController','change_state');
$app::get('/switch_list','HomeController','switch_list');

$app::get('/api/gpio_state','HomeController','get_gpio_state');

$app->run();