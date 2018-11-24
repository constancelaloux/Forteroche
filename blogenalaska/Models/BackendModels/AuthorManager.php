<?php

//namespace Forteroche\blogenalaska\models\backendModels;
//require("blogenalaska\backendModels\PdoConnection");
//include_once('Author.php');
//namespace Forteroche\blogenalaska;
//use PDO;
//$db = \Forteroche\blogenalaska\models\backendModels\setDb();
//require("PdoConnection.php");
namespace Forteroche\blogenalaska\Models\BackendModels; 
use Author;

//require '/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/Author.php';

/**
 * Description of Manager
 *
 * @author constancelaloux
 */
class AuthorManager //extends PdoConnection
{
    

    //Cette gestion sera le rôle d'une autre classe, communément appelée manager. Dans notre cas, notre gestionnaire de personnage sera tout simplement nomméePersonnagesManager.
    private $_db; //instance de PDO
    //private $db;
   
    //  n'oubliez pas d'ajouter un setter pour notre manager afin de pouvoir modifier l'attribut$_db. 
    //La création d'un constructeur sera aussi indispensable si nous voulons assigner à cet attribut un objet PDO dès l'instanciation du manager.
    //Initialisation de la connection a la base de données
    public function __construct($db)
    { 
        $this->setDb($db);
        //exit("fin");
        
    }
    
    public function add(Author $author)
    {
        print_r("je rentre dans la fonction add");
           // print_r("authormanager");
        //Preparation de la requéte d'insertion.
        //Assignation des valeurs pour le password, surname, username et firstname.
        //Execution de la requéte`
        // Préparation de la requête d'insertion.
        $sendAdminDatas = $this->_db->prepare('INSERT INTO articles_author (surname, firstname, username, password) '
                . 'VALUES(:surname, :firstname, :username, :password)');
        // Assignation des valeurs pour le nom du personnage.
        $sendAdminDatas->bindValue(':surname', $author->surname(), PDO::PARAM_STR);
        $sendAdminDatas->bindValue(':firstname', $author->firstname(), PDO::PARAM_STR);
        $sendAdminDatas->bindValue(':username', $author->username(), PDO::PARAM_STR );
        $sendAdminDatas->bindValue(':password', $author->password(), PDO::PARAM_STR);
        // Exécution de la requête.
        $sendAdminDatas->execute();
        
        // Hydratation du personnage passé en paramètre
       // $author->hydrate([
          //  'id' => $this->_db->lastInsertId(),, PDO::PARAM_STR, PDO::PARAM_STR
        //]);
        
        print_r("data has been sent");
   
        //echo $password . "admin user had been created";
        //return $sendAdminDatas;
        
    }
    
    public function delete(Author $author)
    {
        //Execeute une requéte de type delete.
    }
    
    public function verify(Author $author)
    {

       //execute une requéte de type select avec une clause Where, et retourne un objet AdminManager. 

        $getAuthorLogin = $this->_db->prepare("SELECT * FROM articles_author WHERE username = :username");
        $getAuthorLogin->bindValue(':username', $author->username(), PDO::PARAM_STR );
        print_r("je recupere mes donnees");
        $getAuthorLogin->execute();

       // $donneesAuthor = $getAuthorLogin->fetch(PDO::FETCH_ASSOC);

        return new Author($getAuthorLogin->fetch(PDO::FETCH_ASSOC));
    }
    
    public function getList()
    {
        //retourne la liste de tous les AdminManager
    }
    
    public function update(\Forteroche\blogenalaska\models\backendmodels\Author $author)
    {
            // Prépare une requête de type UPDATE.
    // Assignation des valeurs à la requête.
    // Exécution de la requête.
    }
    
   public function setDb(\PDO $db)
    {
        $this->_db = $db;
    }
}
    
    

    /*   protected function dbConnect()
    {
        try
        {
            $bdd = new \PDO('mysql:host=localhost;dbname=blogalaska;charset=utf8','root','root');
            return $bdd; 
        }

        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }*/


  /*   $password = "";
        $username = "";
        $surname = "";
        $firstname = "";
        $password_hash = "";
        
        var_dump($author->_db);
        echo '<br>'; echo '<br>';
      */
        
      /*  for ($i = 0; $i < 5; $i++) // array(5) 
        {
            //print_r($i);
            $value = array_pop($author->_db);
            //print_r($value[]);
            if (isset($value) && !empty($value))
            {
                print_r($i);
                print_r($value);
                echo '<br>';
                
                if ($i == 0) {
                   $firstname =  $value;
                }
                if ($i == 1) {
                   $surname =  $value;
                }
                if ($i == 2) {
                   $username =  $value;
                }
                if ($i == 3) {
                   $password_hash =  $value;
                }
                if ($i == 4) {
                   $password =  $value;
                }
            }
            
        }
        echo '<br>'; echo '<br>';*/
        

        
       /* $sendAdminDatas->bindValue(':surname', $surname);
        $sendAdminDatas->bindValue(':firstname', $firstname);
        $sendAdminDatas->bindValue(':username', $username);
        $sendAdminDatas->bindValue(':password', $password);*/
        
       // $datas = $sendAdminDatas->fetchAll(\PDO::FETCH_CLASS, $class_name);
        
       /* print_r("prenom : " +$firstname());
        echo '<br>';
        print_r("nom : " +$username());
        echo '<br>';
        print_r("author : " +$username());
        echo '<br>';
        print_r("psword : " +$password());
        echo '<br>';
        //print_r($author);
        echo 'Le jeu a bien été ajouté !';*/
        //return $sendAdminDatas;
