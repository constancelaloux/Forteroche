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
                    <h2>
                        <?php
                            echo $titleToDisplay;
                        ?>
                    </h2>
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
                                        $idComments = $comments->id();
                                        $imageClientToDisplay = $comments->imageComment();
                                        $nameToDisplay = $comments->firstname();
                                        $commentsToDisplay = $comments->content();
                                        $commentsDate = $comments->createdate();
                                        $commentsDateToDisplay=$commentsDate;//->format('Y-m-d');
                                        $unwantedCommments = "unwanted";
                                        echo '<div id="myComments">',"\n",'<div class="image">',$imageClientToDisplay, "\n",'</div>', "\n",'<div class="contentOfComment">', "\n",'<div id="Name">', "\n",'<p> De ', $nameToDisplay, '</p>',"\n",
                                                '<button class="reportComment" id="'.$idComments.'">Signaler à l\'administrateur</button>'
                                                ,"\n",'</div>', "\n",'<div id="Date">', "\n", '<p>Créé le ' ,$commentsDateToDisplay, '</p>','</div>', "\n",'<p>', $commentsToDisplay, '</p>',"\n", '<button id="modifyComment"> Modifier</button>',"\n", '</div>',"\n", '</div>';                
                                    }
                            } 
                    ?>
                </div>   
                <script>
                    count=1;
                    $('.reportComment').click(function() 
                        { 
                            event.preventDefault();
                            var id = $(this).attr('id');
                            var number = count;

                            $.ajax
                                ({
                                    url: "/blogenalaska/index.php?action=unwantedComments&p=<?php echo $unwantedCommments ?>&idarticle=<?php echo $commentId ?>",
                                    type: 'POST',
                                    data: {number:number, id: id}, // An object with the key 'submit' and value 'true;
                                    success: function (result) 
                                        {
                                            console.log("test");
                                        }
                                });  
                        });
                </script>

                <!--Navigation des commentaires-->
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
                
                <!--Formulaire commentaires-->
                <?php
                    if(isset($_SESSION['clientUsername']))
                        {
                ?>
                            <div class="formComment">
                                <!--Formulaire pour envoyer des commentaires-->
                                <form action="/blogenalaska/index.php?action=sendCommentsFromId&id=<?php echo $commentId ?>&idClient=<?php echo $_SESSION['ClientId'] ?>" method="post">
                                    <p>Laissez votre commentaire</p>
                                    
                                    <div  class="contentOfComment">
                                        <label for="comments">Commentaire</label>
                                        <textarea id="comments" name="comments"></textarea>
                                    </div>
                                    
                                    <div class="buttonComments">
                                        <input type="submit" value="Poster le commentaire" />
                                    </div>
                                </form>

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

