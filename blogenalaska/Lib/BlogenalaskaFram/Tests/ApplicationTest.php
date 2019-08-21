<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApplicationTest
 *
 * @author constancelaloux
 */
use PHPUnit\Framework\TestCase;
class ApplicationTest  extends TestCase
    {
        //put your code here
        public function testrun()
            {
                $app = new \blogenalaska\Lib\BlogenalaskaFram\Application();
                //$result = 'Bonjour je suis dans la  class application et je fonctionne grace à l\'autoloader';
                $this->assertNull($app->run());
                //$app->run();
            }
    }
