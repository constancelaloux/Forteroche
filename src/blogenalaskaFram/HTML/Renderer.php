<?php

namespace blog\HTML;

use blog\HTML\RendererInterface;
/**
 * Description of Renderer
 *
 * @author constancelaloux
 */
class Renderer implements RendererInterface
{
    private $stack = array();
    const DEFAULT_NAMESPACE = 'blog';
    
    private $tpl;
    private $paths = array();
    
    private $viewpath;
    //variables accessibles sur toutes les vues
    private $globals = [];
    
    private $assignedValues = array();
    
    /*
    * Permet de rajouter un chemin pour charger les vues
     * @param string $namespace
     * @param null/string $path
    */
    public function addPath(string $namespace, string $path = null)
    {
        //print_r($namespace);
        if(is_null($path))
        //Si le nom de chemin et le chemin ne sont pas définis alors il utilise un namespace
        //comme chemin et cette constante comme namespace par default
        {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        }
        else
        //si je défini un nom de chemin et un chemin
        {
            $this->paths[$namespace] = $path;      
        }
    }

    /*
    * Permet de rendre une vue et ses variables
     * Le chemin peut etre précisé avec des namespaces rajoutés via le addPath()
     * $this->render('@blog/view')
     * $this->render('view')
    */
    //Elle retourne une chaine de caractéres
    public function render(string $view, array $params = [])
    {
        //print_r($params);
        //$this->view = $view;
        
        if($this->hasNamespace($view))
        {
            $this->viewpath = $this->replaceNamespace($view).'.html';
        }
        else
        {
            $this->viewpath = $this->paths[self::DEFAULT_NAMESPACE].DIRECTORY_SEPARATOR.$view.'.html';
        }
        
        //Ob_start = tout ce qui sera affiché maintenant, tu le stockes dans une variable
        ob_start();
        
        if(!empty($this->viewpath))
        {
            if(file_exists($this->viewpath))
            {
                $this->tpl = file_get_contents($this->viewpath);
            }
            else
            {
                echo"page 404";
            }
        }

        //print_r(extract($params));
        foreach ($params as $searchString => $replaceString) 
        {
            if(!empty($searchString))
            {
                $this->assignedValues[$searchString] = $replaceString;   
            }  
        }
        
        if(count($this->assignedValues) > 0)
        {
            //print_r($this->assignedValues); //signifie array 0, 1 et 2
            foreach ($this->assignedValues as $firstkey => $value)
            {
                //print_r($firstkey); // signifie test et stuff
                //print_r($this->assignedValues); //signifie array 0, 1 et 2
                if(is_array($value))
                {
                    //print_r($value[1]);//titre, pays 
                    // Parsage des FOR  
                    foreach ($value as $key => $valu) 
                    {
                        //print_r($key); // 0, 1, 2
                        //print_r($key); //array
                            //print_r($valu);
                            //print_r($key);
                                // process your loop here, probably with new foreach,
                                // to populate $processedValue by content of your array in $value
                                $this->tpl = preg_replace('#\{\%FOR:(\w+)\%\}#', '<?php foreach('.$valu['stuff'].' as \$$1s){ echo $$1s ?>', $this->tpl);
                                $this->tpl = preg_replace('#\{\%ENDFOR\%\}#', '<?php } ?>', $this->tpl);
                    //print_r($value);//titre, pays 
                    /*foreach ($value as $key => $value) 
                    {
                        //print_r($value);
                        //exit("je sors");
                        $this->tpl = str_replace('{{'.$firstkey.'.'.$key.'}}', $value, $this->tpl);
                        // Parsage des FOR      
                        $this->tpl = preg_replace('#\{\%FOR:(\w+)\%\}#', '<?foreach ($value[\'$1\'] as \$_$1_vars): $this->_stack(\$_$1_vars); ?>', $this->tpl);
                        //ENDFOR
                        $this->tpl = preg_replace('#\{\%ENDFOR\%\}#', '<?php $this->_unstack(); endforeach; ?>', $this->tpl);
                    }*/

                    }
                }
                else if(is_object($value))
                {
                    //print_r(get_object_vars($value));
                    foreach ($value as $key => $value) 
                    {
                        $this->tpl = str_replace('{{'.$firstkey.'.'.$key.'}}', htmlspecialchars($value), $this->tpl);
                        
                    }
                }
                else
                {
                    $this->tpl = str_replace('{{'.$firstkey.'}}', htmlspecialchars($value), $this->tpl);
                }
            }
        }

        echo $this->tpl;

        $content = ob_get_clean();
        require __DIR__.'/../views/layout.php';

        /*if(file_exists($this->tpl))
        {
            require $this->tpl; 
            //echo $this->viewpath;
        }
        else
        {
            //die("meurs");
            echo"page 404";
        }*/
    }
    
    private function stack($elem)
    {
        foreach($elem as $key => $value)
        {
          print_r($key)  ;
          $this->data[$key] = $value;
        }
        /*$this->stack[] = $this->data;
        foreach ($elem as $key => $value)
        {
            $this->data[$key] = $value;
        }*/
    }
    
    private function unstack()
    {
        $this->data = array_pop($this->stack);
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
