<?php

namespace blog\controllers;

use blog\controllers\AbstractController;
use blog\database\Query;
/**
 * Description of SearchController
 *
 * @author constancelaloux
 */
class SearchController extends AbstractController
{
    /**
     * JE RECHERCHE UN ARTICLE DANS LE BLOG            
     */
    function search()
    {
            if(!is_null($this->request->postData('userSearch')))
            {
                $post = new \blog\entity\Post();
                $mySearchResults = (new Query($post))
                        ->from('post')
                        ->select('*')
                        ->where('subject LIKE :subject OR content LIKE :content')
                        ->setParams(array('subject' => '%'.$this->request->postData('userSearch').'%', 'content' => '%'.$this->request->postData('userSearch').'%'))
                        ->fetchAll();
                if($this->userSession()->requireRole('admin','client'))
                {
                    $this->getrender()->render('SearchResultView',['mySearchResults' => $mySearchResults]);
                }
                else 
                {
                    $this->addFlash()->error('Vous n\avez pas acces à cette page!');
                    return $this->redirect('/connectform');
                }
            }
            else 
            {
                $this->addFlash()->error('Vous n\'avez pas fait de recherche!');
            }
    }
}
