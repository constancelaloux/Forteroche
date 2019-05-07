<?php session_start(); ?>
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

                            header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
                        }
                }
        }
    else 
        {
            include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/ClientsHeader.php');       
        }
?>

<!--J'affiche le contenu de mon article en fonction de l'id -->
<section class="myArticleById">
    <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <p>
                    <?php
                        echo $titleToDisplay;
                    ?>
                    </p>
                    <?php
                        echo $imageToDisplay;
                    ?>
                    <p>
                    <?php
                        echo $articlesToDisplay;
                    ?>
                    </p>   
                </div>
            </div>
    </div>
</section>

<!--L'id de l'article, devient l'id des commentaires-->
        <?php
            $commentId = $_GET['id'];
        ?>

<!--J'affiche les commentaires-->
<section id="listOfComments">

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="numberOfComments">
                    <p><?php echo $numberOfComments ?>commentaires</p>
                </div>
                
                <div class="listOfComments">
                    <?php
                        if (empty($myComment))
                            {
                    ?>
                                <p>Aucun commentaire n'a encore été posté. Soyez le premier à en laisser un !</p>
                    <?php
                            }
                         else
                            {
                                foreach ($myComment as $comments) 
                                    {
                                        $titleToDisplay = $comments->title();
                                        $commentsToDisplay = $comments->content();
                                        $commentsDate = $comments->createdate();
                                        $commentsDateToDisplay=$commentsDate->format('Y-m-d');
                                        echo '<div id="myComments">','<p>' , $titleToDisplay , '</p>' , "\n",'<p>', $commentsToDisplay, '</p>', "\n", '<p>' ,$commentsDateToDisplay, '</p>', '</div>';
                                    }
                            } 
                    ?>
                </div>           

                <div id="navComments">
                    <nav aria-label="...">

                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=getArticleFromId&p=<?php echo $prevpage ?>&id=<?php echo $commentId ?>">Previous</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=getArticleFromId&p=1&id=<?php echo $commentId ?>">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=getArticleFromId&p=2&id=<?php echo $commentId ?>">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=getArticleFromId&p=3&id=<?php echo $commentId ?>">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetCommentsToshowInTheBlogPage&p=<?php echo $nextpage ?>&id=<?php echo $commentId ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                
                <?php
                    if(isset($_SESSION['clientUsername']))
                        {
                ?>
                            <div class="formComment">
                                <!--Formulaire pour envoyer des commentaires-->
                                <form action="/blogenalaska/index.php?action=sendCommentsFromId&id=<?php echo $commentId ?>" method="post">
                                    <p>Envoyer ici votre commentaire</p>
                                    <div class="titleOfComment">
                                        <label for="titleComment">Titre</label>
                                        <input type="text" id="titleComment" name="title" />
                                    </div>
                                    <div>
                                        <label for="comments">Commentaire</label>
                                        <textarea id="comments" name="comments"></textarea>
                                    </div>

                                    <div>
                                        <input type="submit" value="Envoyer" />
                                    </div>
                                </form>

                                <!--Bouton modifier 1 commentaire-->
                                <button id="modifyComment" > Modifier Commentaire</button>

                                <!--Bouton signaler 1 commentaire-->
                                <button id="reportComment">Signaler</button>
                    <?php
                        }
                    ?>
                            </div>
  
            </div>
        </div>
    </div>
</section>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/Footer.php'); ?>
<?php $content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>

