<?php

namespace blog\HTML;

use blog\HTML\RendererInterface;
use blog\error\FlashService;
use blog\user\UserSession;

/**
 * Description of Render
 *
 * @author constancelaloux
 */
class Render  implements RendererInterface 
{
    private $stack = array();
    const DEFAULT_NAMESPACE = 'blog';
    
    private $tpl;
    private $paths = array();
    
    private $viewpath;
    
    //variables accessibles sur toutes les vues
    private $globals = [];
    
    private $assignedValues = array();
    private $renderer;
    
    /**
     * I give the view path into the construct
     */
    public function __construct()
    {
        $this->addPath('blog',__DIR__.'/../views');
    }
    
    /*
     * Permet de rajouter un chemin pour charger les vues
     * @param string $namespace
     * @param null/string $path
    */
    public function addPath(string $namespace, string $path = null)
    {
        if(is_null($path))
        /**
         *Si le nom de chemin et le chemin ne sont pas définis alors il utilise un namespace
         * comme chemin et cette constante comme namespace par default
         */
        {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        }
        else
        /**
         * si je défini un nom de chemin et un chemin
         */
        {
            $this->paths[$namespace] = $path;      
        }
    }

    /**
     * Permet de rendre une vue et ses variables
     * Le chemin peut etre précisé avec des namespaces rajoutés via le addPath()
     * $this->render('@blog/view')
     * $this->render('view')
    */
    /**
     * Elle retourne une chaine de caractéres
     */
    public function render(string $view, array $params = [])
    {
        $this->view = $view;
        
        if($this->hasNamespace($view))
        {
            //print_r("je passe dans la fonction render");
            $this->viewpath = $this->replaceNamespace($view).'.php';
        }
        else
        {
            $this->viewpath = $this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR.$view.'.php';
        }
        
        if(!empty($this->viewpath))
        {
            if(file_exists($this->viewpath))
            {
                $session = new FlashService();
                
                if (session_status() === PHP_SESSION_NONE)
                {
                    session_start();
                }   
                else if ($_SESSION['status'] === 'admin')
                {
                    $usersession = new UserSession();
                    $usersession->timeoutSession();
                }
                /**
                 * Ob_start = tout ce qui sera affiché maintenant, tu le stockes dans une variable
                 */
                ob_start();
                extract($this->globals);
                extract($params);
                require($this->viewpath);
            }
            else
            {
                echo"page 404";
            }
        }
        $content = ob_get_clean();
        ob_start();
        require __DIR__.'/../views/layout.php';
    }

    /**
     * Permet de rajouter des variables globales à toutes les vues
     * @param string $key
     * @param mixed $value
    */
    public function addGlobal(string $key, $value):void
    {
        $this->globals[$key] = $value;
    }
    
    /**
     * Est ce que j'ai un namespace
     */
    private function hasNamespace(string $view): bool
    {
        return $view[0] === '@';
    }
    
    /**
     * 
     * @param string $view
     * @return string
     */
    private function getNamespace(string $view):string
    {
        return substr($view, 1, strpos($view, '/')-1);
    }
    
    /**
     * 
     * @param string $view
     * @return string
     */
    private function replaceNamespace(string $view): string
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}
