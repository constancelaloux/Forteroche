<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\database\EntityManager;
use blog\entity\Articles;
use blog\form\ArticlesForm;

/**
 * Description of BacOfficeController
 * @author constancelaloux
 */
class BackOfficeController extends AbstractController
{
    /**
     * Afficher le tableau d'articles
     */
    public function renderBackoffice()
    {
        $this->getrender()->render('BackofficeView');
    }
    
    /**
     * Récupérer des articles pour les afficher au sein de datatables
     */
    public function getListOfArticles()
    {
        $post = new Articles();
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
            $this->getrender()->render('BackofficeView');
        }
    }
    
    /**
     * Créer un article
     */
    public function createArticle()
    {
        $articles = new Articles(); 
        $formBuilder = new ArticlesForm($articles);
        $form = $formBuilder->buildform($formBuilder->form());
        $title = "création d'un article";
        $this->getrender()->render('CreateArticleFormView',['title' => $title,'form' => $form->createView()]);
    }
}
