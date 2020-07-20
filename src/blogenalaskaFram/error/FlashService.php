<?php

namespace blog\error;

use blog\session\PHPSession;
use blog\config\Container;

/**
 * Description of FlashService  
 *
 * @author constancelaloux
 */
class FlashService 
{
    /**
    * @var SessionInterface
    */
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
    private $sessionKey = 'flash';
    
    protected $container;
    
    /**
     * I make a connexion to the session
     */
    public function __construct()
    {
        $this->session = new PHPSession();
        /*$services   = include __DIR__.'/../config/Config.php';
        $this->container = new Container($services);
        $this->session = $this->container->get(blog\session\PHPSession::class);*/
    }
    
    /**
     * I store the information in session
     * set a success message
     * @param string $message
     */
    public function success(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    /**
     * Set an error message
     * @param string $message
     */
    public function error(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['error'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }
    
    /**
     * Retrieve information in session
     * @param string $type
     * @return type
     */
    public function get(string $type)
    {
        if(is_null($this->messages))
        {
            $this->messages = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }
        
        if(array_key_exists($type, $this->messages))
        {
            return $this->messages[$type];
        }
        return null;
    }
}
