<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\database\EntityManager;
use blog\entity\Articles;

/**
 * Description of BacOfficeController
 *
 * @author constancelaloux
 */
class BackOfficeController extends AbstractController
{
    public function renderBackoffice()
    {
        $this->getrender()->render('Backoffice');
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
                //print_r($articles);
                //print_r($article = $articles->id());
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
            //$this->getrender()->render('Backoffice',['title' => json_encode($json_data)]);
            //require_once (__DIR__.'/../views/Backoffice.php');
        }
        else
        {
            //require_once (__DIR__.'/../views/Backoffice.php');
            $this->getrender()->render('Backoffice');
        }
    }
}
