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
        // dés que l'on va faire un new session, le constructeur va etre appellé
        public function __construct() 
            {
                session_start();
            }
        //FONCTION REDIRECTION
        /*function redirect()
            {
            //print_r($setmessage);
            //exit("je sors");
                header("Location: /blogenalaska/test.php").die();
                //ob_end_flush();
            }*/
        //définir un msg de notification 
        //Permet de mettre en notification un msg affiché sur la prochaine page
        public function setFlash($message,$type='danger')
            {   //On met dans un index flash le message
                $_SESSION['flash'] = array(
                    'message' =>$message,
                    'type' =>$type
                );
                //print_r($_SESSION);
                            //die('je meurs');
            }
        //Afficher un msg si on a un msg en mémoire et de le supprimer 1x afficher
        public function flash()
            {
                if(isset($_SESSION['flash']))
                    {
                        ?>
                            <div id='#myAlert' class="alert alert-<?php echo $_SESSION['flash']['type'];?>">
                                 <a class="close">x</a>
                                <?php   echo $_SESSION['flash']['message'];?>
                            </div>
                        <?php
                        //header('Location: /blogenalaska/index.php?action=getTheFormClientsConnexion');
                        //header('Location: /blogenalaska/Frontend/FrontendViews/ClientFormAccess/FormClientAccessView.php'); 
                       // unset($_SESSION['flash']);
                    }
            }
    }

                              /*<script>
                              jQuery(function($))
                                {
                                    console.log('je passe ici');
                                    var alert = $('#alert');
                                    if(alert.length>0)
                                        {
                                            alert.hide().slideDown(500);
                                            alert.find('.close').on('click',(function(e))
                                            {
                                                e.preventDefault();
                                                alert.slideUp();
                                            });
                                        }
                                };

                            </script>*/