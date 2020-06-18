<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
/**
 * Description of SearchController
 *
 * @author constancelaloux
 */
class SearchController extends AbstractController
{
//JE RECHERCHE UN ARTICLE DANS LE BLOG            
    function search()
    {
        /*if (isset($_POST['whatImSearching']))
        {*/
            if(!is_null($this->request->postData('userSearch')))
            //if (!empty($_POST['whatImSearching']))
            {
                //print_r($this->request->postData('userSearch'));
                //$mySearchWords = $this->request->postData('userSearch');
                $post = new \blog\entity\Post();
                $model = new \blog\database\EntityManager($post);

                $mySearchResults = $model->get($this->request->postData('userSearch'));
                print_r($mySearchResults);
                die("je meurs ici");
                $this->getrender()->render('FrontendhomeView',['SearchResultView' => $mySearchResults]);
            }
            else 
            {
                $this->addFlash()->error('Vous n\'avez pas fait de recherche!');
            }
        /*}
        else
        {
            $this->addFlash()->error('Vous n\'avez pas fait de recherche!');
        }*/
    }
}
