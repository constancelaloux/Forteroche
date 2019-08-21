<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of Bootstrapp
 *
 * @author constancelaloux
 */
//exit("cool j y suis dans Bootstrap.php");
const DEFAULT_APP = 'Frontend';



//print_r(__DIR__.'/../blogenalaska/'.$_GET['app']);

// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404
if (!isset($_GET['app']) || !file_exists(__DIR__.'/../blogenalaska/'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;

// On commence par inclure la classe nous permettant d'enregistrer nos autoload
//require __DIR__.'/../lib/OCFram/SplClassLoader.php';
require(__DIR__ . '/../Lib/BlogenalaskaFram/vendor/autoload.php');
// On va ensuite enregistrer les autoloads correspondant à chaque vendor (OCFram, App, Model, etc.)
//$OCFramLoader = new Forteroche\blogenalaska\Lib\BlogenalaskaFram();
//$OCFramLoader->register();
//exit("cool j y suis dans Bootstrap.php");
//$appLoader = new blogenalaska();
//$appLoader->register();

//$modelLoader = new blogenalaska\Lib\Vendors\Model();

//$entityLoader = new \blogenalaska\Lib\BlogenalaskaFram\Entity();
//$entityLoader->register();

// Il ne nous suffit plus qu'à déduire le nom de la classe et à l'instancier
$appClass = '\\'.'blogenalaska\\'.$_GET['app'].'\\'.$_GET['app'].'Application';
//print_r($appClass);
$app = new $appClass;
$app->run();
