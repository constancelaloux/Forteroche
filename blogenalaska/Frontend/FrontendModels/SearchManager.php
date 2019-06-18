<?php
//namespace Forteroche\blogenalaska\Frontend\FrontendModels;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchManager
 *
 * @author constancelaloux
 */
class SearchManager 
    {
            //Cette gestion sera le rôle d'une autre classe, communément appelée manager. Dans notre cas, notre gestionnaire de personnage sera tout simplement nomméePersonnagesManager.
        private $_db; //instance de PDO
        
        //  n'oubliez pas d'ajouter un setter pour notre manager afin de pouvoir modifier l'attribut$_db. 
        //La création d'un constructeur sera aussi indispensable si nous voulons assigner à cet attribut un objet PDO dès l'instanciation du manager.
        //Initialisation de la connection a la base de données
        public function __construct($db)
            { 
                $this->setDb($db);      
            }
                    //Je récupére un commentaire en fonction de l'id pour ensuite aller le modifier
        public function get($mySearchWords)
            {
                $data = array();
                $getSearchDatasFromId = $this->_db->prepare("SELECT subject, id FROM articles WHERE subject LIKE '%$mySearchWords%' OR content LIKE '%$mySearchWords%'");
                //$getSearchDatasFromId = $this->_db->prepare("SELECT id FROM articles WHERE CONCAT_WS(subject, content) LIKE '%:mySearchWords%'ORDER BY id DESC");
                //$getSearchDatasFromId->bindValue(':mySearchWords', $words->mySearchWords(), \PDO::PARAM_STR );

                $getSearchDatasFromId->execute();
                //print_r($getSearchDatasFromId->execute());
                //die("sors de la");
                while ($datasFromSearch = $getSearchDatasFromId->fetch())
                    {
                        //print_r($datasFromSearch);

                        $tmpWords =  new Search($datasFromSearch);
                        //print_r("jepasse encore ici");
                        //print_r($tmpWords);
                    //die("je sors");      
                        $words[] = $tmpWords;
                        //print_r($words);
                    }
                
                $data = $words;
                //print_r($data);
                //die("meurs un autre jour");
                return $data;

                //return new Search($getSearchDatasFromId->fetch(\PDO::FETCH_ASSOC));     
            }
            
        public function setDb(\PDO $db)
            {
                $this->_db = $db;
            }
        //put your code here
    }
