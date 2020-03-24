<?php

namespace blog\session;

//use blog\session\SessionInterface;
use blog\session\PHPSession;

//use blog\session\PHPSession;

class FlashService 
{
    /**
    * @var SessionInterface
    */
    private $session;
    
    private $messages;
    
    private $sessionKey = 'flash';
    
    public function __construct()
    {
        //$this->session = new ArraySession();
        $this->session = new PHPSession();
    }
    
    /**
    * Je stocke les informations en session
    */
    public function success(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
        //print_r($this->session->set($this->sessionKey, $flash));
    }
    
    public function error(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['error'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }
    
    /**
    * Récupére une information en session
    * @param string $key
    * @param $default
    * @return mixed
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
        //$type correspond à success ou error
        /*if(is_null($this->messages))
        {
            //print_r("je ne passe pas la et pourtant je devrais");
            $this->messages = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }
        //$flash = $this->session->get($this->sessionKey, []);
        if(array_key_exists($type, $this->messages))
        {
            //print_r("je passe pas la et pourtant je devrais pas");
            return $this->messages[$type];
        }
        return null;*/
    }
}
