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
            include('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/Header.php');

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
            include('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/ClientsHeader.php');           
        }
?>

<!--Le carousel-->
<section id="caroussel">
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/public/images/alaska1.png" style="width:100%" alt="image1"> <!--class="d-block w-100"-->
            </div>
            <div class="carousel-item">
                <img src="/public/images/alaska2.jpg" style="width:100%" alt="image2">
            </div>
            <div class="carousel-item">
                <img src="/public/images/alaska3.jpg" style="width:100%" alt="image3">
            </div>
        </div>

        <div id="title">
            <h2>BILLET SIMPLE POUR L' ALASKA</h2>
        </div>
    </div>   
</section>



<!--Affichage des articles-->
<section id="articles">
    <div id="ancre_articles"></div>   
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8">
                    <div class="listOfArticles">
                        <?php
                            if (empty($articlesFromManager))
                                {
                        ?>
                                    <p>Pas d'épisodes pour l'instant</p>
                        <?php
                                }
                            else
                                {
                                    foreach ($articlesFromManager as $articles) 
                                        {
                                            if (strlen($articles->content()) <= 400)
                                                {
                                                    $articlesToDisplay = $articles->content();
                                                }
                                            else
                                                {
                                                //Returns the portion of string specified by the start and length parameters.
                                                    $debut = substr($articles->content(), 0, 400);
                                                    $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                                                    $articlesToDisplay = $debut;
                                                }

                                            $titlesToDisplay = $articles->subject();
                                            $idArticles = $articles->id();

                                            $dateCreate = $articles->createdate();
                                            
                                            //$articleDateCreate = $dateCreate;//->format('l jS F Y');

                                            $image = $articles->image();
                                            
                                    
                                            echo '<div id="myarticles">', '<h3>',htmlspecialchars($titlesToDisplay) , '</h3>', "\n", '<p>', htmlspecialchars($dateCreate) , '</p>' , "\n",'<div id="textAndImage">',"\n", '<div id="imageFromListing">','<p>', $image , '</p>',  '</div>',"\n",
                                            '<p>', $articlesToDisplay, '</p>', "\n", '<div id="next">', '<p><a href="/public/index.php?action=getArticleFromId&id=', $idArticles, '">lire la suite', '</a></p>',  '</div>', '</div>' , '</div>';
                                        }
                                }
                        ?>

                    </div>

                    <div id="navArticles">
                        <nav aria-label="...">

                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="/public/index.php?action=iGetArticlesToshowInTheBlogPage&p=<?php echo $prevpage?>">Previous</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="/public/index.php?action=iGetArticlesToshowInTheBlogPage&p=1">1</a>
                                </li>
                                <li class="page-item" aria-current="page">
                                    <a class="page-link" href="/public/index.php?action=iGetArticlesToshowInTheBlogPage&p=2>">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="/public/index.php?action=iGetArticlesToshowInTheBlogPage&p=3">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="/public/index.php?action=iGetArticlesToshowInTheBlogPage&p=<?php echo $nextpage?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            
            <!--Affichage du dernier article-->

                <div class="col-lg-4  col-md-4 col-sm-4">
                    <aside id="whyThisBlog">
                        <div id="logoAndExplanation">
                            <!--icon-->
                            <div id="logo">
                                <!--<p>-->
                                    <img src="/public/images/jeanforteroche.jpeg" alt="logo">
                                <!--</p>-->
                            </div>
                            
                            <div id="titleOfBlogExplanation">
                                <h3>
                                    Bienvenu sur Billet Simple Pour l'Alaska
                                </h3>
                            </div>
                            <p>
                                Je partage sur ce blog mes coups de coeur et découvertes ainsi que mes carnets de voyages.
                            </p>
                            <!--<div id="textHomePage">
                                <p>
                                   Il y a un pays où les montagnes sont sans nom,
                                   Et toutes les rivières s’y écoulent
                                   Dieu sait où ;
                                   Il y a des vies errantes et sans but,
                                   Et la mort qui tient juste à un fil ;
                                   Il y a des épreuves indicibles ;
                                   Il y a des vallées désertes et figées ;
                                   C’est le Pays – oh ! il m’appelle et m’appelle,
                                   Je veux y retourner – et je le ferai.
                               </p>
                            </div>-->
                           
                        </div>
                        <div id="logoFollowME">

                            <p>FOLLOW ME</p>
                            <!--Twitter-->
                            <!--<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>-->
                            <a class="logoTwitter" href="#">
                                <img src="/public/images/twitter.png" alt="logo">
                            </a>
                            <!--Facebook-->
                            <a class="logoFacebook" href="#">
                                <img src="/public/images/facebook.png" alt="logo">
                            </a>
                           <!-- <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width="" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                            <div id="fb-root"></div>
                            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.2"></script>-->
                            
                            <!--Instagram-->
                            <a class="logoInstagram" href="#">
                                <img src="/public/images/instagram.png" alt="logo">
                            </a>
                        </div>
                    </aside>

                    <aside id="LastArticle">
                        <h3>
                            DERNIERS ARTICLES
                        </h3>

                        <?php 
                            if (empty($articlesFromManager))
                                {
                        ?>
                                    <p>Pas de dernier épisode pour l'instant</p>
                        <?php
                                }
                            else
                                {
                                    foreach ($lastArticle as $articles)
                                        {
                                            $titleLastArticle = $articles->subject();

                                            $idLastArticle = $articles->id();

                                            $contentLastArticle = $articles->content();

                                            if (strlen($contentLastArticle) <= 90)
                                                {
                                                    $contentArticleToDisplay = $contentLastArticle;
                                                }
                                            else
                                                {
                                                    //Returns the portion of string specified by the start and length parameters.
                                                    $debut = substr($contentLastArticle, 0, 100);
                                                    $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                                                    $contentArticleToDisplay = $debut;
                                                }

                                            $imageLastArticle = $articles->image(); 
                        ?> 
                                        
                                        
                                        <div id="imageAndTitlefromLastArticles">
                                            <div class="imageFromLastArticle">
                                                <div class="col-lg-12  col-md-12 col-sm-12">
                                                    <?php echo $imageLastArticle; ?>
                                                </div>
                                            </div>

                                            <div class="titleFromLastArticle">
                                                    <p> <a href="/public/index.php?action=getArticleFromId&id=<?php echo $idLastArticle ?>,"> <?php echo htmlspecialchars($titleLastArticle)?></a></p>
                                            </div>
                                        </div>
                        <?php
                                        }
                                }
                        ?>
                    </aside>
                </div>
            </div>
        </div>
</section>

<!--Mes derniers ouvrages-->
<section id="myLastBooks">
    <p>MES DERNIERS OUVRAGES</p>

    <!--<div id="books">-->
      <div class="container">
        <section class="row">
            <div class="col-xs-2 col-sm-2 col-md-2">
                    <img src="/public/images/livre1.png" alt="logo" style="width:100%">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                    <img src="/public/images/livre2.jpg" alt="logo" style="width:100%">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                    <img src="/public/images/livre3.png" alt="logo" style="width:100%">  
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                    <img src="/public/images/livre1.png" alt="logo" style="width:100%">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                    <img src="/public/images/livre2.jpg" alt="logo" style="width:100%">
            </div>
            <div class="col-xs-2 col-sm-2 col-md-2">
                    <img src="/public/images/livre3.png" alt="logo" style="width:100%">  
            </div>
        </section>
      </div>
    <!--</div>-->
</section>

<!--Formulaire de contact-->
<section id="contact">
    <div id="ancre_contact"></div>
    <div class="contactForm">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <legend>CONTACTEZ NOUS</legend>                   
                </div>

                <div class="col-sm-8 col-md-8 col-lg-8">
                    <form class="well" action="/public/index.php?action=sendEmail" method="post">

                        <h4>Comment m'avez-vous trouvé ?</h4>
                        <fieldset>
                            <div class="radio">
                                <label for="ami" class="radio">
                                    <input type="radio" name="origine" value="ami" id="ami">
                                    Par un ami 
                                </label>
                            </div>
                            <div class="radio">
                                <label for="web" class="radio">
                                    <input type="radio" name="origine" value="web" id="web">
                                    Sur le web 
                                </label>
                            </div>
                            <div class="radio">
                                <label for="hasard" class="radio">
                                    <input type="radio" name="origine" value="hasard" id="hasard">
                                    Par hasard 
                                </label>
                            </div>
                            <div class="radio">
                                <label for="autre" class="radio">
                                    <input type="radio" name="origine" value="autre" id="autre">
                                    Autre... 
                                </label>
                            </div>
                            <label for="email">Votre email</label>
                            <input type="email" id="email" name="email" />
                            
                            <label for="titleMessage">Titre du Message</label>
                            <input type="text" id="titleMessage" name="title" />
                            
                            <label for="textarea">Votre message ici:</label>
                            <textarea id="textarea" name="content" class="form-control" rows="8" cols="45"></textarea>
                            <p class="help-block">Vous pouvez agrandir la fenêtre</p>
                            <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Envoyer</button>
                        </fieldset>
                    </form>
                </div>

                <div class="col-sm-4 col-md-4 col-lg-4">
                    <address>
                        <p>Vous pouvez également me contacter à cette adresse :</p>
                        <strong>Jean Forteroche</strong><br>
                            Allée des pingouins<br>
                            Alaska<br>
                    </address>
                </div>
</section>

<?php include('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/Footer.php'); ?>
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/Template.php');?>