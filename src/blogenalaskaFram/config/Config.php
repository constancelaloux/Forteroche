<?php

/* 
 * On va mettre la configuration générale de notre projet
 */
return [
    \blog\HTML\Render::class => [
        'class' => \blog\HTML\Render::class,
        ],
    \blog\HTTPResponse::class => [
        'class' => \blog\HTTPResponse::class,
        ],
    \blog\session\FlashService::class => [
        'class' => \blog\session\FlashService::class,
        ],
    'renderer' => function()
    {
        return new blog\HTML\Renderer(dirname(__DIR__).'/../views');
    },
    "myInstance"=>function(ContainerInterface $container) {
    return new MyInstance();
    },
];