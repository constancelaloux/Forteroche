<?php
namespace blog\user;

use blog\entity\Author;
use blog\database\EntityManager;
use blog\session\PHPSession;

/**
 * @author constancelaloux
 */
class UserSession
{
    private $loginPath;
    
    private $session;
    
    /**
     *
     * @var type 
     */
    private $messages;
    
    /**
     *
     * @var type 
     */
    private $sessionKey = 'user';
    
    /**
     * Je fais une connexion à la session
     * @param string $loginPath
     */
    public function __construct()//(string $loginPath)
    {
        $this->session = new PHPSession();
        //$this->loginPath = $loginPath;
    }
    
    /**
     * Pick up the user into database
     * @return type
     */
    public function user()
    {
        /*$flash = $this->session->get($this->sessionKey, []);
        $flash[$message] = $message;
        $this->session->set($this->sessionKey, $flash);*/
        if(session_status() === PHP_SESSION_NONE)
            {
                session_start();
            }
            
        $id = $_SESSION['authorId'] ?? NULL;
        if($id === null)
        {
            //ca signifie que l'utilisateur n'est pas connecté
            return NULL;
        }
        
        $author = new Author(
            [
                'id' =>  $id,
            ]);
        $model = new EntityManager($author);
        $auth = $model->findById($author->id());
        return $auth ?: NULL;
    }
    
    //void signifie on ne récupére rien
    //...$roles signifie que l'on accepte plusieurs paramétres
    /**
     * Vérfie si le ou les roles utilisateur en paramétre existent
     * @param type $roles
     * @return string
     */
    public function requireRole(string ...$roles)
    {
        $user = $this->user();
        
        if($user === NULL || !in_array($user->status, $roles))
        {
            return NULL;
        }
        else
        {
            return $user->status();
        }
    }
    
    /**
     * Function to log out the user
     */
    public function logOut()
    {
        session_start();
        session_unset();
        $_SESSION = array();
        session_destroy();
        
        // Suppression des variables de session et de la session
        // Réinitialisation du tableau de session
        // On le vide intégralement
        //$this->session->delete();
        //on détruit les variables de notre session
   
        //session_unset();
        //$_SESSION = array();
        //$this->session->delete('authorPassword');
        //$this->session = new PHPSession();
        //$this->session->delete('authorId');
        //$this->session->delete('authorUsername');
        //$this->session->delete('status');
        //session_destroy();
        /*if(session_id() === NULL)
        {
            return TRUE;
        }*/    
    }

    /*public function user(): Author
    {
        //if(session_status() === PHP_SESSION_NONE){
        //session_start();}
        //$id = $_SESSION['auth'] ?? null;
        //if ($id === null) { return null;}
        //$query = select * from users where id = ?
        //$query->execute ([$id]);
        //$user = $query->fetchObject(User::class)
        //return $user ?: null;
    }
    
    public function login(string $username, string $password): Author
    {
        //trouve l'utilisateur correspondant au username
        //$query = select * from users where username = username
        //$query->execute username
        //A enlever //$query->setFetchMode(\PDO::FETCH_CLASS, User::class);
        //$user = $query->fetchObject(User::class)
        //if($user === false) {return null;}
        
        //On vérify avec password verify que l'utilisateur correspon
        //Si correspond on renvoi sinon on renvoi null
        //if(password_verify($password, $user->password, ))
        //{
        //if (session_status() === PHP_SESSION_NONE
        //{
        //session_start();
        //$_SESSION['auth'] = $user->id;
            //return $user;
        //}
        //return null;
    }
    
    //void signifie on ne récupére rien
    //...$roles signifie que l'on accepte plusieurs paramétres
    public function requireRole(string ...$roles): void
    {
        $user = $auth->user();
        if($user === NULL || !in_array($user->roles, $roles))
        {
            //redirige vers la page de connexion
            header('location: {$this->loginPath}?forbid=1');
            exit();
        }
        
    }*/
}
