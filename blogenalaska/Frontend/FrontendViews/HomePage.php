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

                            //header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
                        }
                }
        }
    else 
        {
            include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/ClientsHeader.php');       
        }
?>

<!--Le carousel-->
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/blogenalaska/public/images/alaska1.png" class="d-block w-100" alt="image1" width="100%">
        </div>
        <div class="carousel-item">
            <img src="/blogenalaska/public/images/alaska2.jpg" class="d-block w-100" alt="image2" width="100%">
        </div>
        <div class="carousel-item">
            <img src="/blogenalaska/public/images/alaska3.jpg" class="d-block w-100" alt="image3" width="100%">
        </div>
    </div>
    
    <div id="title">
        <h2>Billet simple pour l'Alaska</h2>
    </div>
</div>


<!--Affichage des articles-->
<section id="articles">
    <div id="ancre_articles"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="listOfArticles">
                    <?php
                        if (empty($articlesFromManager))
                            {
                    ?>
                                <p>pas d'articles encore de créés</p>
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
                                        $articleDateCreate = $dateCreate->format('Y-m-d');

                                        $image = $articles->image();

                                        echo '<div id="myarticles">', '<h2>', $titlesToDisplay , '</h2>', "\n", '<p>', $articleDateCreate , '</p>' , "\n", '<div id="imageFromListing">','<p>', $image, '</p>',  '</div',"\n",
                                        '<p>', $articlesToDisplay, '</p>', "\n", '<p><a href="/blogenalaska/index.php?action=getArticleFromId&id=', $idArticles, '">lire la suite', '</a></p>' , '</div>';

                                    }
                            }
                    ?>

                </div>
  
                <div id="navArticles">
                    <nav aria-label="...">

                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=<?php echo $prevpage?>">Previous</a>
                            </li
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=1">1</a>
                            </li>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=2>">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=3">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=<?php echo $nextpage?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <!--Affichage du dernier article-->
            <div class="col-lg-4">
                <aside id="whyThisBlog">
                    <!--icon-->
                    <p>
                        <img src="/blogenalaska/public/images/jeanforteroche.jpeg" alt="logo">
                    </p>
                    <h3>
                        Bienvenu sur Billet Simple Pour l'Alaska
                    </h3>
                    <p>
                        Je partage sur ce blog mes coups de coeur et découvertes ainsi que mes carnets de voyages. 
                    </p>
                </aside>
                
                <aside id="LastArticle">
                    <h3>
                        DERNIERS ARTICLES
                    </h3>
                    <p>
                        <?php    
                            echo $titleLastArticle;
                            echo $contentLastArticle;
                        ?>
                            <div class="imageFromLastArticle">
                                    <?php echo $imageLastArticle ; ?>
                            </div>
                    </p>
                </aside>    
            </div>
        </div> 
    </div>
</section>

<!--Frmulaire de contact-->
<section id="contact">
    <div id="ancre_contact"></div>
    <div class="contactForm">
        <div class="row">
        <section class="col-sm-8">
          <form class="well">
            <legend>Si vous voulez me laisser un message</legend>
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
              <label for="textarea">Votre message :</label>
                <textarea id="textarea" class="form-control" rows="4"></textarea>
                <p class="help-block">Vous pouvez agrandir la fenêtre</p>
                <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Envoyer</button>
            </fieldset>
          </form>
        </section>
        <section class="col-sm-4">
            <address>
                <p>Vous pouvez également me contacter à cette adresse :</p>
                <strong>Jean Forteroche</strong><br>
                    Allée des pingouins<br>
                    Alaska<br>
            </address>
        </section>
      </div>
        
    </div>
</section>

<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/Footer.php'); ?>
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>