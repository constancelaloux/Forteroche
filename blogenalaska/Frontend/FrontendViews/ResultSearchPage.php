<?php  if(!isset($_SESSION))
        {
            session_start();
        }
?>
<!--Include Footer et template -->
<?php $title = 'Frontend main page'; ?>
<?php ob_start(); ?>
<?php 

    if(isset($_SESSION['username']))
        {
            include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/Header.php');

            $expireAfter = 30;

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
                            //User has been inactive for too long.
                            //Kill their session.
                            session_unset();
                            session_destroy();

                            //header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
                        }
                }
        }
    else
        {
            include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/ClientsHeader.php');           
        }
?>

<div class="listOfSearch">

                        <?php
                            if (empty($mySearchResult))
                                {
                        ?>
                                    <p>Rien a afficher pour l'instant</p>
                        <?php
                                }
                            else
                                {
                                    if (!empty ($mySearchResult))
                                        {
                                            foreach ($mySearchResult as $result) 
                                                {
                                                    $searchResult = $result->subject();
                                                    $idsearchresultArticle = $result->id();
                                                    //echo '<div id="mySearchResult">','<a href='.$searchResult.'', "\n", '</div>';
                                                    ?>
                                                    <p> <a href="/blogenalaska/index.php?action=getArticleFromId&id=<?php echo $idsearchresultArticle ?>,"> <?php echo htmlspecialchars($searchResult)?></a></p>
                                                <?php
                                                }

                                        }
                                    else
                                        {
                                            ?>
                                                    <p>pas d'articles trouvés</p>
                                            <?php
                                        }
                                    /*foreach ($mySearchResult as $searchResult) 
                                        {
                                            $searchResultToDisplay = $searchResult->mySearchWords(); 
                                            
                                    
                                            echo '<div id="mySearchResult">', '<h3>', $searchResult , '</h3>', "\n", '</div>';
                                        }*/
                                }
                        ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');

