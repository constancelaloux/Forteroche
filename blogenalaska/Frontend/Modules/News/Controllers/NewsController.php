<?php
namespace \blogenalaska\Frontend\Modules\News\Controllers\NewsController;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use \blogenalaska\Lib\BlogenalaskaFram\BackController;
use blogenalaska\Lib\BlogenalaskaFram\HTTPRequest;

class NewsController extends BackController
    {
        public function executeIndex(HTTPRequest $request)
            {
                //exit("cool j y suis dans la fonction executeIndex");
                // On récupère le manager des news.
                $manager = $this->managers;
            }
    }