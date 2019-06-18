<?php
//namespace Forteroche\blogenalaska\Session;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sessionClass
 *
 * @author constancelaloux
 */

class SessionClass 
    {
        //put your code here
        public function __construct() 
            {
                session_start();
            }
        //définir un msg de notification    
        public function setFlash($message,$type='error')
            {   //On met dans un index flash le message
                $_SESSION['flash'] = array(
                    'message' =>$message,
                    'type' =>$type
                );
            }

        public function flash()
            {
                if(isset($_SESSION['flash']))
                    {
                        ?>
                            <div class="alert-alert-error"><?php echo $_SESSION['flash']['type'];?>
                                 <a class="close">x</a>
                                <?php   echo $_SESSION['flash']['message'];?>
                            </div>
                        <?php
                        unset($_SESSION['flash']);
                    }
            }
    }
