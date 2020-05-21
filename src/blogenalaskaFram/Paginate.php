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
        
        $pages = $this->getPages();
        
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
     * Lien suivant
     * @param string $link
     * @return string
     */
    public function nextlink()//string $link)
    {
        $nextPage = $this->getCurrentPage() + 1;
        
        //Si la page suivante est supérieure au nombre de pages possibles
        if($nextPage > $this->getPages())
        {
            //On revient à la page numéro 1
            return $nextPage = 1;
        }
        return $nextPage;
        /*$currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if($currentPage >= $pages)
        {
            return NULL;
        }
        $link .= "&page=" . ($currentPage + 1);
        return
        '<a href="'.$link.'" class="btn btn-primary">&laquo; Page précédente </a>';*/
    }
    
    /**
     * Lien précédent
     * @param string $link
     * @return string
     */
    public function previouslink()//string $link) //: string
    {
        $prevPage = $this->getCurrentPage() - 1;
        //print_r($prevPage);
        //print_r($this->getPages());
        //die("meurs");
        if($prevPage < 1)
        {
            return $prevPage = $this->getPages();
            //return null;
        }
        return $prevPage;
        
        /*if($prevPage >= 1)
        {
            return $prevPage = $this->getPages();
        }*/
        /*$currentPage = $this->getCurrentPage();
        if($currentPage <= 1)
        {
            return null;
        }
        if($currentPage > 2)
        {
            $link.= "&page=" . ($currentPage -1);
        }
        return
        '<a href="'.$link.'" class="btn btn-primary">&laquo; Page suivante </a>';*/
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
     * On souhaite obtenir un nombre de pages à avoir
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
