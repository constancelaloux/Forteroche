<?php

namespace blog;

use blog\RendererInterface;
/**
 * Description of Renderer
 *
 * @author constancelaloux
 */
class Renderer implements RendererInterface
{
    const DEFAULT_NAMESPACE = 'blog';
    
    private $path = [];
    
    //variables accessibles sur toutes les vues
    private $globals = [];
    
    /*
    * Permet de rajouter un chemin pour charger les vues
     * @param string $namespace
     * @param null/string $path
    */
    public function addPath(string $namespace, string $path = null)
    {
        if(is_null($path))
        //Si le nom de chemin et le chemin ne sont pas définis alors il utilise un namespace
        //comme chemin et cette constante comme namespace par default
        {
            //print_r($namespace);
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
            //print_r( $this->paths[self::DEFAULT_NAMESPACE]);
        }
        else
        //si je défini un nom de chemin et un chemin
        {
            $this->paths[$namespace] = $path;      
        }
    }
    
    /*
    * Permet de rendre une vue
     * Le chemin peut etre précisé avec des namespaces rajoutés via le addPath()
     * $this->render('@blog/view')
     * $this->render('view')
    */
    //Elle retourne une chaine de caractéres
    public function render(string $view)
    {
        //print_r($view);
        if($this->hasNamespace($view))
        {
            $path = $this->replaceNamespace($view).'.php';
            //print_r($path);
        }
        else
        {
            //print_r($this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR);
            $path = $this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR.$view.'.php';
            //print_r($path);
        }
        //print_r($path);

        //Ob_start = tout ce qui sera affiché maintenant, tu le stockes dans une variable
        ob_start();
        //$renderer = $this;;
        //extract($this->globals);
        //extract($params);
        //print_r($path);
        require $path;
        $content = ob_get_clean();
        require __DIR__.'/views/layout.php';
        //echo $content;
        //print_r($content);
    }
    
    /*
    * Permet de rajouter des variables globales à toutes les vues
     * 
     * @param string $key
     * @param mixed $value
    */
    public function addGlobal(string $key, $value):void
    {
        $this->globals[$key] = $value;
    }
    //Est ce que j'ai un namespace
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
       //substr($view, 1, strpos($view, '/')-1);
    }
    
    private function getNamespace(string $view):string
    {
        return substr($view, 1, strpos($view, '/')-1);
    }
    
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
