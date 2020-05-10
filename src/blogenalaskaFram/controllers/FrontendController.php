<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
/**
 * Description of BlogController
 *
 * @author constancelaloux
 */
class FrontendController extends AbstractController
{
    /*
     * Fonction qui permet de rendre la page d'accueil
     */
    public function renderhomepage()
    {
        $this->getrender()->render('FrontendhomeView');
    }
    
    /*
     * Fonction qui permet de rendre la page de l'article
     */
    public function renderArticle()
    {
        $this->getrender()->render('ArticleView');
    }
    
    /*
     * Fonction qui me permet de créer un commentaire
     */
    public function createComment()
    {
        
    }
    
    /*
     * Fonction qui me permet de modifier un commentaire
     */
    public function updateComment()
    {
        
    }
    
    /*
     * Fonction qui me permet de supprimer un commentaire
     */
    public function deleteComment()
    {
        
    }
}
