<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\database\EntityManager;
use blog\entity\Post;
use blog\form\ArticlesForm;

/**
 * Description of BacOfficeController
 * @author constancelaloux
 */
class BackendController extends AbstractController
{
    /**
     * Show posts board
     */
    public function renderHomepage()
    {
        $this->getrender()->render('BackendhomeView');
    }
    
    /**
     * get Post to show in datatables
     */
    public function getListOfArticles()
    {
        $post = new Post();
        $model = new EntityManager($post);
        $posts = $model->findAll();

        if (!empty ($posts))
        {
            foreach ($posts as $articles) 
            {
                $row = array();
                $row[] = $articles->id();
                $row[] = $articles->subject();
                $row[] = $articles->createdate();
                $updateArticleDate = $articles->updatedate();

                if (is_null($updateArticleDate))
                {
                    $row[] = "Vous n'avez pas fait de modifications sur cet article pour l'instant";
                }
                else 
                {
                    $row[] = $updateArticleDate;
                }

                $row[] = $articles->status();
                $data[] = $row;
            }
                            
            // Structure des données à retourner
            $json_data = array
            (
                "data" => $data
            );
            echo json_encode($json_data);
        }
        else
        {
            $this->getrender()->render('BackendhomeView');
        }
    }
    
    /**
     * Delete post
     */
    public function deletePost()
    {
        if ($this->request->method() == 'POST')
        {  
            $post = new Post(
            [
                'id' =>  $this->request->postData('id'),
            ]);
            $model = new EntityManager($post);
            $model->remove($post);
        }
    }
    
    /**
     * redirect if post as been well deleted
     * @return type
     */
    public function confirmDeletedPost()
    {
        $this->addFlash()->success('La news a bien été supprimée !');
        return $this->redirect('/backoffice'); 
    }
    
    /**
     * Create post
     */
    public function createPost()
    {
        $title = "Ecrire un article";
        $this->processForm($title);
    }
    
    /**
     * Save post
     */
    public function savePost()
    {

    }
    
    /**
     * Update post
     */
    public function updatePost()
    {
        $title = "Ecrire un article";
        $this->processForm($title);
            // On récupère l'annonce $id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if (null === $advert) 
        {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
    }

    
    /**
     * Show the form and check if the form is valid
     * @param type $title
     * @return type
     */
    public function processForm($title)
    {
        if ($this->request->method() == 'POST')
        {  
            $post = new Post(
            [
                'subject' =>  $this->request->postData('subject'),
                'content' =>  $this->request->postData('content'),
                'image' =>  $this->request->postData('image'),
                'status' =>  $this->request->postData('validate'),
                'create_date' => "NOW()",
                'update_date' => 'NULL',
            ]);
        }
        else
        {
            $post = new Post();
        }
        
        $formBuilder = new ArticlesForm($post);
        $form = $formBuilder->buildform($formBuilder->form());
        
        if ($this->request->method() == 'POST' && $form->isValid())
        {
            $model = new EntityManager($post);
            if($model->persist($post))
            {
                $this->addFlash()->success('La news a bien été ajoutée !');
                return $this->redirect('/createpost');
            }
        }
        
        $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);
    }
    
    
}
