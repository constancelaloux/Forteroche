<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\entity\Comment;
use blog\database\EntityManager;
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
        if ($this->request->method() == 'POST')
        {
            $comment = new Comment(
            [
                'subject' =>  $this->request->postData('subject'),
                'content' =>  $this->request->postData('content'),
                'image' =>  $this->request->postData('image'),
                'status' =>  $this->request->postData('validate'),
                'create_date' => date("Y-m-d H:i:s"),
                'update_date' => null,
                'id_author' => 1
            ]);
        }
        else
        {
            $post = new Comment();
        }
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {  
            $model = new EntityManager($comment);
            $model->persist($comment);
            $this->addFlash()->success('La news a bien été ajoutée !');
            return $this->redirect('/backoffice');
        }
        
        //$this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);
        
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
        if ($this->request->method() == 'POST')
        {  
            $comment = new Comment(
            [
                'id' =>  $this->request->postData('id'),
            ]);
            $model = new EntityManager($comment);
            $model->remove($comment);
        }  
    }
}
