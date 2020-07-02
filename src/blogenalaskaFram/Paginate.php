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
    
    /**
     * 
     * @return int
     */
    public function getItems(): int
    {
        $currentPage = $this->getCurrentPage();
        
        $offset = $this->perPage * ($currentPage - 1);
        
        return $offset;
    }
    
    /**
     * Lien suivant
     * @param string $link
     * @return string
     */
    public function nextlink()
    {
        $nextPage = $this->getCurrentPage() + 1;
        
        /**
         * Si la page suivante est supérieure au nombre de pages possibles
         */
        if($nextPage > $this->getPages())
        {
            /**
             * On revient à la page numéro 1
             */
            return $nextPage = 1;
        }
        return $nextPage;
    }
    
    /**
     * Lien précédent
     * @param string $link
     * @return string
     */
    public function previouslink()
    {
        $prevPage = $this->getCurrentPage() - 1;
        if($prevPage < 1)
        {
            return $prevPage = $this->getPages();
        }
        return $prevPage;
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
            
        /**
         * Les numéros de pages en paramétre dans l'url
         */
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

        /**
         * On obtient le nombre de pages que l'on va avoir
         */
        return $pages = ceil($this->count / $this->perPage);
        
    }
}
