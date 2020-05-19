<?php

namespace blog\error;

use blog\session\PHPSession;

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
    
    /**
     * Je fais une connexion à la session
     */
    public function __construct()
    {
        //$this->session = new ArraySession();
        $this->session = new PHPSession();
    }
    
    /**
     * Je stocke les informations en session
     * set un message de success
     * @param string $message
     */
    public function success(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }
    
    /**
     * set un message d'erreur
     * @param string $message
     */
    public function error(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['error'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }
    
    /**
     * Récupére une information en session
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
