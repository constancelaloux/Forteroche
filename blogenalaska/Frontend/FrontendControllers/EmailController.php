<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of emailController
 *
 * @author constancelaloux
 */
class EmailController
    {
        //put your code here
        function sendEmail()
            {
                //Connexion à la base de données et création des identifiants du client
                if (isset($_POST['origine']) AND isset($_POST['title']) AND isset($_POST['content']) AND isset($_POST['email']))
                    {
                        if (!empty($_POST['origine']) && !empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['email']))
                            {
                                // check if the username and the password has been set
                                $content = ($_POST['content']);

                                $title = ($_POST['title']);

                                $origine = ($_POST['origine']);
                                
                                $email = ($_POST['email']);
                            }
                    }
                $to = "constancelaloux@gmail.com";

                // Send
                $sent = mail($to, $title, $email, $origine, $content);

                if ($sent)
                    {
                        header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');
                        //echo 'Email sent correctly';
                    }
                else
                    {
                        header('Location: /blogenalaska/index.php?action=goToFrontPageOfTheBlog');
                        //echo 'Error in sending the email';
                    }
            }
    }
