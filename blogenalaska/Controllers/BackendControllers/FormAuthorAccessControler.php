<?php

//Contrôleur : cette partie gère la logique du code qui prend des décisions.
// C'est en quelque sorte l'intermédiaire entre le modèle et la vue : 
// le contrôleur va demander au modèle les données, les analyser, prendre des décisions et renvoyer le texte 
// à afficher à la vue. Le contrôleur contient exclusivement du PHP. C'est notamment lui qui détermine 
// si le visiteur a le droit de voir la page ou non (gestion des droits d'accès).

// Le controleur implémentera une seule méthode: executeIndex(). Cette méthode devra,
// si le formulaire a été envoyé, vérifier si le pseudo et le mdp entrés sont corrects.
// Si c'est le cas, l'utilisateur est authentifié, sinon un msg erreur s'affiche.
// Chargement des classes

//$OCFramLoader = new SplClassLoader('models', '/lib');
//$OCFramLoader->register();


require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/Author.php';

require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Controllers/PdoConnection.php';

require'/Applications/MAMP/htdocs/Forteroche/blogenalaska/Models/BackendModels/AuthorManager.php';

//test
function sendDataToDatabase()
{
        //Connexion à la base de données et création des identifiants de Jean Forteroche
    $newAuthor = new Author([
            //'passFromUser' =>'jean38', // password
            //'password' =>crypt('laloux38'),
            'password' => password_hash('passFromUser', PASSWORD_DEFAULT),
            'username' =>'Jean_Forteroche',
            'surname' => 'Forteroche',
            'firstname' => 'Jean'
        ]);
        print_r("j'insére des donnéees");
        $sendToTheManager = new Forteroche\blogenalaska\Models\BackendModels\AuthorManager($db);
        $sendToTheManager->add($newAuthor);
}
//require_once("Forteroche/blogenalaska/PdoConnection.php");
//require("controllers/PdoConnection.php");
//on vérifie que les variables sont bien instanciés pour le formulaire d'entrée du back office
function transferDatatoModel($usernameVar,$passwordVar)
{
    
    print_r("je suis dans le controler");

    //$db = \Forteroche\blogenalaska\Controllers\PdoConnection\connect();

    $author = new Author(
            [
            'password' => $passwordVar,
            'username' => $usernameVar
            ]); //Création d'un objet

    //$db = \PdoConnection\connect();
    $db = \Forteroche\blogenalaska\Controllers\PdoConnection::connect();
    //$db = Forteroche\blogenalaska\Controllers\PdoConnection\connect();
    
    // exit("je m'arréte la");
    $manager = new Forteroche\blogenalaska\Models\BackendModels\AuthorManager($db);
    $passwordFromManager = $manager->verify($author); // Appel d'une fonction de cet objet
    $passwordFromDb = $passwordFromManager->password();
    //$passwordFromDb = '$2y$10$cv1.O6M6orolbJd97uWCTepyFAzYowNQZX7pV54GpGfUYgIcxpZ3y';
    
    
    echo '<br>';echo '<br>';
    //print_r($passwordFromDb);
 
    //print_r(var_dump($test->password()));



     //exit("je m'arréte la");
    //On vérifie que les données insérées dans le formulaire sont bien équivalentes aux données de la BDD
    //$AuthorLogin = password_verify($passwordVar, $test2);
    if (password_verify($passwordVar, $passwordFromDb))
        {
            echo 'Le mot de passe est valide !';
        } else {
            echo 'Le mot de passe est invalide.';
            echo '<br>';echo '<br>';
            print_r($passwordFromDb);
            print_r($passwordVar);
        }
   
    //print_r($passwordVar);
    exit("je m'arréte la");

    if ($AuthorLogin)
     {  
        
        // Start the session
        // session_start();
        // $_SESSION['userName'] = $usernameVar;
         //$_SESSION['firstName'] = $usernameVar;
        // $_SESSION['surName'] = $usernameVar;
        // redirectionVueAdmin();
         
     }
  else 
     {
         echo "Vos identifiants sont incorrects";

     }

            

   // $response = $author->get($usernameVar);

}

// Fonction qui permet d'ajouter un Administrateur ou Rédacteur du blog
/*function addAdmin()
{
    $adminManager = new \Forteroche\blogenalaska\models\backendmodels\AuthorManager(); //Création d'un objet
    $sendAdminDatas = $adminManager->add();
    if($sendAdminDatas === false) {
        throw new Exception('Impossible d\'ajouter les données administrateurs !');
    }
} */

