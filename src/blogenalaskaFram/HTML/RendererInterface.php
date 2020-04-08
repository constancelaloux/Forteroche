<?php

namespace blog\HTML;

interface RendererInterface 
{
    
    /**
     *@Permet de rajouter un chemin pour charger les vues
     * @param string $namespace
     * @param null/string $path
     */
    public function addPath(string $namespace, string $path = null);
    
    
    /**
     *
     * @Permet de rendre une vue
     * Le chemin peut etre précisé par des namespaces rajoutés via addPath()
     * $this->render('@blog/view');
     * $this->render('view');
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view);
    
    
    /*
    * Permet de rajouter des variables globales à toutes les vues
     * 
     * @param string $key
     * @param mixed $value
    */
    public function addGlobal(string $key, $value):void;
}
