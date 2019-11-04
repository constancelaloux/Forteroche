<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require(__DIR__ . '/Autoloader.php');
//$loader = blog\Autoloader::register();
$loader = new blog\Autoloader();
$loader->register();

$loader->addNamespace('blog', __DIR__ . '/../../src/blogenalaskaFram');
$loader->addNamespace('blog\provider', __DIR__ . '../../src/blogenalaskaFram/provider');
$loader->addNamespace('blog\controllers', __DIR__ . '../../src/blogenalaskaFram/controllers');
$loader->addNamespace('blog\database', __DIR__ . '../../src/blogenalaskaFram/provider');
$loader->addNamespace('blog\HTML', __DIR__ . '../../src/blogenalaskaFram/HTML');