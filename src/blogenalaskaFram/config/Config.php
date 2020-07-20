<?php

/* 
 * We will put the general configuration of our project
 */
return [
    \blog\HTML\Render::class => [
        'class' => \blog\HTML\Render::class,
        ],
    \blog\HTTPResponse::class => [
        'class' => \blog\HTTPResponse::class,
        ],
    \blog\HTTPRequest::class => [
        'class' => \blog\HTTPRequest::class,
        ],
    \blog\error\FlashService::class => [
        'class' => \blog\error\FlashService::class,
        ],
    \blog\user\UserSession::class => [
        'class' => \blog\user\UserSession::class,
        ],
    /*\blog\form\Form::class => [
        'class' => \blog\form\Form::class,*/
        //'parameter' =>\blog\database\Model::class,
        //\blog\database\Model::class,
       // ], 
    \blog\entity\Author::class => [
        'class' => \blog\entity\Author::class,
        ],
    \blog\file\PostUpload::class => [
        'class' => \blog\file\PostUpload::class,
        ],
    \blog\database\EntityManager::class => [
        'class' => \blog\database\EntityManager::class,
        ],
    \blog\entity\Comment::class => [
        'class' => \blog\entity\Comment::class,
    ],
    \blog\entity\Post::class => [
        'class' => \blog\entity\Post::class,
    ],
    \blog\form\ArticlesForm::class => [
        'class' => \blog\form\ArticlesForm::class,
    ],
    \blog\form\StringField::class => [
        'class' => \blog\form\StringField::class,
    ],
    \blog\form\TextField::class => [
        'class' => \blog\form\TextField::class,
    ],
    \blog\DotEnv::class => [
        'class' => \blog\DotEnv::class,
    ],
    \blog\session\PHPSession::class => [
        'class' => \blog\session\PHPSession::class, 
    ],
    \blog\file\AuthorUpload::class => [
        'class' => \blog\file\AuthorUpload::class, 
    ],
    /*'renderer' => function()
    {
        return new blog\HTML\Renderer(dirname(__DIR__).'/../views');
    },
    "myInstance"=>function(ContainerInterface $container) {
    return new MyInstance();
    },*/
];