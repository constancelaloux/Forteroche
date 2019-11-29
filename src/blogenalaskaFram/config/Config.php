<?php

/* 
 * On va mettre la configuration générale de notre projet
 */
return [

    /*blog\HTML\RendererInterface::class =>function ()
    {
        return new blog\HTML\Renderer(dirname(__DIR__.'/../views'));
    },*/
    'renderer' => function()
    {
        return new blog\HTML\Renderer(dirname(__DIR__).'/../views');
    },
    "myInstance"=>function(ContainerInterface $container) {
    return new MyInstance();
    }
];