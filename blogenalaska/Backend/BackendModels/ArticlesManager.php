<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//namespace Forteroche\blogenalaska\Models\BackendModels; 

class ArticlesManager
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
        
        //J'ajoute un article en bdd
        public function add(Article $articles)
            {
                $sendArticlesDatas = $this->_db->prepare('INSERT INTO articles (content, subject, create_date, image, status) '
                        . 'VALUES(:content, :subject, NOW(), :image, :status)');

                $sendArticlesDatas->bindValue(':content', $articles->content(), \PDO::PARAM_STR);
                $sendArticlesDatas->bindValue(':subject', $articles->subject(), \PDO::PARAM_STR);
                $sendArticlesDatas->bindValue(':image', $articles->image(), \PDO::PARAM_STR);
                $sendArticlesDatas->bindValue(':status', $articles->status(), \PDO::PARAM_STR);

                $sendArticlesDatas->execute();
            }
        
        //Je sauvegarde un article en base de données mais celui ci doit etre valider pour etre afficher sur le blog
        public function save(Article $articles)
            {
                $saveArticlesDatas = $this->_db->prepare('INSERT INTO articles (content, subject, create_date, image, status) '
                . 'VALUES(:content, :subject, NOW(), :image, :status)');

                $saveArticlesDatas->bindValue(':content', $articles->content(), \PDO::PARAM_STR);
                $saveArticlesDatas->bindValue(':subject', $articles->subject(), \PDO::PARAM_STR);
                $saveArticlesDatas->bindValue(':image', $articles->image(), \PDO::PARAM_STR);
                $saveArticlesDatas->bindValue(':status', $articles->status(), \PDO::PARAM_STR);
                $saveArticlesDatas->execute();
                /*if ($articles->isValid())
                    {
                        $articles->isNew() ? $this->add($articles) : $this->modify($articles);
                    }
                else
                    {
                        throw new \RuntimeException('La news doit être validée pour être enregistrée');
                    }*/
            }
        
        //Je compte mes articles
        public function count()
            {
                return $this->_db->query('SELECT COUNT(*) as nbArt FROM articles')->fetchColumn();
            }
            
        //Je compte mes articles publiés
        public function countPublishedArticles()
            {
                return $this->_db->query('SELECT COUNT(*) as nbArt FROM articles WHERE status = "Valider"')->fetchColumn();
            }
            
        //Je supprime un article 
        public function delete(Article $articles)
            {
                //Executer une requéte de type delete.
                $this->_db->exec('DELETE FROM articles WHERE id = '.$articles->id());
            }
        
        //Je récupére mon article en fonction de l'id
        public function get(Article $articles)
            {
                //Je récupére mes articles en fonction de l'id
                //execute une requéte de type select avec une clause Where, et retourne un objet ArticlesManager. 

                $getArticlesDatasFromId = $this->_db->prepare("SELECT * FROM articles WHERE id = :id");

                $getArticlesDatasFromId->bindValue(':id', $articles->id(), \PDO::PARAM_STR );
                $getArticlesDatasFromId->execute();

                return new Article($getArticlesDatasFromId->fetch(\PDO::FETCH_ASSOC));
            }

        //Je récupére la liste compléte de mes articles   
        public function getList()
            {
                //execute une requéte de type select avec une clause Where, et retourne un objet ArticlesManager. 

                //$articles = [];
                
                $getArticlesDatas = $this->_db->prepare("SELECT id, create_date, update_date, subject, content FROM articles");
                $getArticlesDatas->execute();

                while ($donnees = $getArticlesDatas->fetch())
                    {
                        $tmpArticle =  new Article($donnees);

        
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        setlocale(LC_TIME, "fr_FR");
                        $articleDate = strftime("%H %B %Y", $date->getTimestamp());
                        $tmpArticle->setCreatedate($articleDate);
                        
                        //Je vérifie si j'ai Null ou une date d'enregistré en bdd
                        if (is_null($donnees['update_date']))
                            {
                                //echo '<td>0000-00-00 00:00:00 </td>';

                                //print_r($articleUpdateDate); 
                            }
                        else
                            {
                                $date =  DateTime::createFromFormat('Y-m-d H:i:s', $donnees['update_date']);
                                setlocale(LC_TIME, "fr_FR");
                                $articleUpdateDate = strftime("%H %B %Y", $date->getTimestamp());
                                $tmpArticle->setUpdatedate($articleUpdateDate);
                            }
                        
                        $articles[] = $tmpArticle;
                    }
                $data = $articles;
                return $data;
            }
        
        //Je met a jour les articles dans la base de données
        public function update(Article $articles)
            {
                // Prépare une requête de type UPDATE.
                // Assignation des valeurs à la requête.
                // Exécution de la requête.
                $dbRequestModifyArticle = $this->_db->prepare('UPDATE articles SET subject = :subject, content = :content, image = :image,  update_date = NOW(), status = :status WHERE id = :id');
    
                $dbRequestModifyArticle->bindValue(':subject', $articles->subject());
                $dbRequestModifyArticle->bindValue(':content', $articles->content());
                $dbRequestModifyArticle->bindValue(':image', $articles->image());
                $dbRequestModifyArticle->bindValue(':id', $articles->id(), \PDO::PARAM_INT);
                $dbRequestModifyArticle->bindValue(':status', $articles->status(), \PDO::PARAM_INT);
                $dbRequestModifyArticle->execute();
            }
            
        //Je met a jour les articles dans la base de données et je sauvegarde, je ne valide pas
        public function updateAndSave(Article $articles)
            {
                // Prépare une requête de type UPDATE.
                // Assignation des valeurs à la requête.
                // Exécution de la requête.
                $dbRequestModifyArticle = $this->_db->prepare('UPDATE articles SET subject = :subject, content = :content, image = :image,  update_date = NOW(), status = :status WHERE id = :id');
    
                $dbRequestModifyArticle->bindValue(':subject', $articles->subject());
                $dbRequestModifyArticle->bindValue(':content', $articles->content());
                $dbRequestModifyArticle->bindValue(':image', $articles->image());
                $dbRequestModifyArticle->bindValue(':id', $articles->id(), \PDO::PARAM_INT);
                $dbRequestModifyArticle->bindValue(':status', $articles->status(), \PDO::PARAM_INT);
                $dbRequestModifyArticle->execute();
            }
        
        //Je récupére le dernier article
        public function getUnique()
            {
                $data = array();
                $getLastArticle = $this->_db->prepare("SELECT * FROM articles  WHERE status = 'Valider' ORDER BY ID DESC LIMIT 0, 2");
                $getLastArticle->execute();
                 while ($donnees = $getLastArticle->fetch())
                    {
                       $article =  new Article($donnees);
                       $data[] = $article;
                    }
                 
                return $data;
            }
        
        //Je récupére 5 articles
        public function getListOfFiveArticles($page,$nbrArticlesPerPage)
            {
                $data = array();
                $getLastArticle = $this->_db->prepare("SELECT * FROM articles WHERE status = 'Valider' ORDER BY ID DESC LIMIT ".(($page-1)*$nbrArticlesPerPage).", $nbrArticlesPerPage"); 
                $getLastArticle->execute(); 
                while ($donnees = $getLastArticle->fetch())
                    {
                        $article =  new Article($donnees);
                        setlocale(LC_TIME, "fr_FR");
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $donnees['create_date']);
                        $articleDate = strftime("%d %B %Y", $date->getTimestamp());
                        $article->setCreatedate($articleDate);

                        $data[] = $article;
                    } 

                return $data;
            }
            
        public function setDb(\PDO $db)
            {
                $this->_db = $db;
            }
    }
