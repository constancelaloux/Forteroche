<?php                                     
//session timeout
// Is the admin logged in? 
class DoLogout
    {
        function logout()
            {
                /*if (isset($_SESSION['username']))
                    {*/
                        //Expire the session if user is inactive for 30
                        //minutes or more.
                        $expireAfter = 1;

                        //Check to see if our "last action" session
                        //variable has been set.
                        if(isset($_SESSION['last_action']))
                            {

                                //Figure out how many seconds have passed
                                //since the user was last active.
                                $secondsInactive = time() - $_SESSION['last_action'];

                                //Convert our minutes into seconds.
                                $expireAfterSeconds = $expireAfter * 60;

                                //Check to see if they have been inactive for too long.
                                if($secondsInactive >= $expireAfterSeconds)
                                    {
                                    //print_r("ma session est inactive");
                                        //User has been inactive for too long.
                                        //Kill their session.
                                        session_unset();
                                        session_destroy();

                                    header('Location: /public/index.php?action=getTheFormAdminConnexionBackend');
                                    }
                            }

                        //Assign the current timestamp as the user's
                        //latest activity
                        $_SESSION['last_action'] = time();

                    /*}

                 else 
                    {
                        header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
                    }*/
            }
    }


?>