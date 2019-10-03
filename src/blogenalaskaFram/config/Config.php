<?php

/* 
 * On va mettre la configuration générale de notre projet
 */

return [
    blog\RendererInterface::class =>function ()
    {
        return new blog\Renderer(dirname(__DIR__.'/../views'));
    }
];