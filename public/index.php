<?php

/**
 * Le role de index.php se limite à un point d'entrée avec le reste de l'application.
 * En aucun cas, il comporte de la logique
 */

/**
 * Repporter les erreurs php
 */
error_reporting(E_ALL);
ini_set('display_errors', 'on');

/**
 * Time to load the page
 */
define('DEBUG_TIME', microtime(TRUE));
sleep(2);

/**
 * Autoload
 */
require(__DIR__ . '/../src/blogenalaskaFram/Autoload.php');


//je récupére l'application à charger
/**
 * instance class
 * use, permet d'importer une class d'un autre "dossier"
 */

use blog\App;
$app =(new App());
//Je passe la requéte à mon application et cette application va me retourner une réponse
$app->run();