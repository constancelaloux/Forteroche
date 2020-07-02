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
    }
    
    /**
     * Pick up the user into database
     * @return type
     */
    public function user()
    {
        if(session_status() === PHP_SESSION_NONE)
            {
                session_start();
            }
            
        $id = $_SESSION['authorId'] ?? NULL;
        if($id === null)
        {
            /**
             * ca signifie que l'utilisateur n'est pas connecté
             */
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
    
    /**
     * void signifie on ne récupére rien
     * ...$roles signifie que l'on accepte plusieurs paramétres
     */
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
    }
    
    public function expiredSession()
    {
        $expireAfter = 60;
        if(isset($_SESSION['last_action']))
        {
            /**
             * Figure out how many seconds have passed
             * since the user was last active.
             */
            $secondsInactive = time() - $_SESSION['last_action'];

            /**
             * Convert our minutes into seconds.
             */
            $expireAfterSeconds = $expireAfter * 60;

            /**
             * Check to see if they have been inactive for too long.
             */
            if($secondsInactive >= $expireAfterSeconds)
            {
                /**
                 * User has been inactive for too long.
                 * Kill their session.
                 */
                session_unset();
                session_destroy();
                require __DIR__.'/../views/AdminHeader.php';
            }
        }
    }
    public function timeoutSession()
    {
        $timeout = $_SERVER['REQUEST_TIME'];
        /**
         * for a 1 minute timeout, specified in seconds
        */
        $timeout_duration = 60;
        $_SESSION['LAST_ACTIVITY'] = $timeout;

        if (isset($_SESSION['LAST_ACTIVITY']) && ($timeout - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) 
        {
            session_unset();
            session_destroy();
            session_start();
        }
    }
}
