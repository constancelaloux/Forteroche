<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Autoloader {
    
    static function register(){
        
spl_autoload_register(function($class_name) {
        // Define an array of directories in the order of their priority to iterate through.
        $dirs = array(
            'Models/BackendModels', // Project specific classes (+Core Overrides)
            'Controllers/BackendControllers'
            );

        // Looping through each directory to load all the class files. It will only require a file once.
        // If it finds the same class in a directory later on, IT WILL IGNORE IT! Because of that require once!
        foreach( $dirs as $dir ) {
            if (file_exists($dir.'/'. ($class_name).'.php')) {
                //print_r('file do not exist');
                require_once($dir.'/'. ($class_name).'.php');
                
                return;
            }
        }
    });
    }
}


/*class Autoloader {
    

    static function register()
    {
    //spl_autoload_register('chargerClasse'); 
    //On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on instanciera 
    //une classe non déclarée.
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }
    
    static function autoload($class_name){
        print_r('Class/' . 'Models/' . 'BackendModels/' . $class_name . '.php');
        require 'Class/' . 'Models/' . 'BackendModels/'  . $class_name . '.php';
    }
}*/