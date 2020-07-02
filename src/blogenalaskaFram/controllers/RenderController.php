<?php

namespace blog\controllers;

use blog\controllers\AbstractController;

/**
 * Description of RenderController
 *
 * @author constancelaloux
 */
class RenderController extends AbstractController
{
    public function renderPage404()
    {
        $this->getRender()->render('Page404');
    }
}
