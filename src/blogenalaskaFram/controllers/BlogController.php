<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
/**
 * Description of BlogController
 *
 * @author constancelaloux
 */
class BlogController extends AbstractController
{
    public function renderBlog()
    {
        $this->getrender()->render('BlogView');
    }
    
    public function renderArticle()
    {
        $this->getrender()->render('ArticleView');
    }
}
