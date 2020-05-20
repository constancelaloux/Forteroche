<?php

namespace blog;

use blog\database\EntityManager;

/**
 * Description of Paginate
 *
 * @author constancelaloux
 */
class Paginate 
{
    private $perPage;
    
    private $count;
    
    public function __construct($entity, int $perPage)
    {
        $this->perPage = $perPage;
        $this->model = new EntityManager($entity);
    }
    
    public function getItems():array
    {
        /*$page = $_GET['page'] ?? 1;
        if(!filter_var($page, FILTER_VALIDATE_INT))
        {
            throw new Exception("Numéro de page invalide");
        }
            
        //Les numéros de pages en paramétre dans l'url
        $currentPage = (int)$page;*/
        $currentPage = $this->getCurrentPage();
        
       // $pages = $this->getPages();
        
        //Si le numéro de page dans l'url est supérieur au nombre de pages que l'on devrait avoir on met une exception
        /*if($currentPage > $pages)
        {
            throw new Exception("Cette page n'existe pas");
        }*/
        
        $offset = $this->perPage * ($currentPage - 1);
        $posts = $this->model->findBy($filters = NULL, [$orderBy = 'create_date'], $limit = $this->perPage, $offset = $offset);
        return $posts;
    }
    
    /**
     * 
     * @param string $link
     * @return string
     */
    public function nextlink(string $link): string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if($currentPage >= $pages)
        {
            return NULL;
        }
        $link .= "&page=" . ($currentPage + 1);
        return
        '<a href="'.$link.'" class="btn btn-primary">&laquo; Page précédente </a>';
                /*if($currentPage <= 1)
        {
            print_r("je passse la");
            return NULL;
        }*/
    }
    
    /**
     * 
     * @param string $link
     * @return string
     */
    public function previouslink(string $link): string
    {
        $currentPage = $this->getCurrentPage();
        if($currentPage <= 1)
        {
            return null;
            //print_r($currentPage);
            //print_r($link);
        }
        if($currentPage > 2)
        {
            $link .= "&page=" . ($currentPage -1);
            //print_r("je passse la");
        }
        return
        '<a href="'.$link.'" class="btn btn-primary">&laquo; Page suivante </a>';
    }
    
    
    /**
     * On retourne la page courante
     * @return int
     * @throws Exception
     */
    private function getCurrentPage(): int
    {
        $page = $_GET['page'] ?? 1;
        if(!filter_var($page, FILTER_VALIDATE_INT))
        {
            throw new Exception("Numéro de page invalide");
        }
            
        //Les numéros de pages en paramétre dans l'url
        return $currentPage = (int)$page; 
    }
    
    /**
     * 
     * @return int
     */
    private function getPages(): int
    {
        if ($this->count === NULL)
        {
            $this->count = $this->model->exist();
        }

        //On obtient le nombre de pages que l'on va avoir
        return $pages = ceil($this->count / $this->perPage);
        
    }
}
