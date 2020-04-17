<?php

/* 
 * On va mettre la configuration générale de notre projet
 */
return [
    /*\blog\HTML\Renderer::class => [
        'class' => \blog\HTML\Renderer::class,
        /**/
            //],
    \blog\HTML\Render::class => [
        'class' => \blog\HTML\Render::class,
        /**/
        ],
    //print_r("je suis dans config.php"),
    \blog\HTTPResponse::class => [
        'class' => \blog\HTTPResponse::class,
    /**/
        ],
    \blog\session\FlashService::class => [
        'class' => \blog\session\FlashService::class,
    /**/
        ],
    /*blog\HTML\RendererInterface::class =>function ()
    {
        return new blog\HTML\Renderer(dirname(__DIR__.'/../views'));
    },*/
    'renderer' => function()
    {
        print_r("je passe par la");
        return new blog\HTML\Renderer(dirname(__DIR__).'/../views');
    },
    "myInstance"=>function(ContainerInterface $container) {
    return new MyInstance();
    },
    //\SessionIdInterface::class => \DI\object(\blog\session\PHPSession::class)
];