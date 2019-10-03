<?php //print_r($_SESSION);die('je meurs'); ?>
<?php $title = 'test blog page';
ob_start();
/*require_once '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Autoloader.php';
\Forteroche\blogenalaska\Autoloader::register();*/
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//$session = new SessionClass();
$session->flash();

$content = ob_get_clean();
require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');