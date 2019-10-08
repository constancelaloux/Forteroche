<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog;

/**
 * Description of Env
 *
 * @author constancelaloux
 */

class DotEnv
{
    
    public $db_host;
    
    public function load($dbUser)
    {
        $this->db_host = $dbUser;
        print_r($this->db_host);
        $this->db_host = getenv('DB_USER');
        //$dbUser = $_ENV['DB_USER'];
        print_r(getenv('DB_USER'));
    } 
}

