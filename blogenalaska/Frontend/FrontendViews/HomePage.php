<!--Include Footer et template -->
<?php $title = 'Frontend main page'; ?>
<?php ob_start(); ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/Header.php'); ?>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/blogenalaska/public/images/alaska1.jpeg" class="d-block w-100" alt="image1">
        </div>
        <div class="carousel-item">
            <img src="/blogenalaska/public/images/alaska2.jpg" class="d-block w-100" alt="image2">
        </div>
        <div class="carousel-item">
            <img src="/blogenalaska/public/images/alaska3.jpg" class="d-block w-100" alt="image3">
        </div>
    </div>
    
    <div id="title">
        <h2>Billet simple pour l'Alaska</h2>
    </div>
</div>



<section id="articles">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="listOfArticles">
                    <?php
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

                                echo '<h2>', $titlesToDisplay , '</h2>', "\n", '<p>', $articleDateCreate , '</p>' , "\n", '<p>', $image, '</p>', "\n",
                                '<p>', $articlesToDisplay, '</p>', "\n", '<p><a href="/blogenalaska/index.php?action=getArticleFromId&id=', $idArticles, '">lire la suite', '</a></p>';

                            }

                        //Pagination
                        /*for ($i=1;$i<=$numberOfPages;$i++)
                            {
                                echo "<a href=\"/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=",$i,"\"> $i </a>/ ";
                            } */
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
            
            <div class="col-lg-4">
                <aside id="whyThisBlog">
                    <!--icon-->
                    <p>
                        <img src="/blogenalaska/public/images/logo.png" alt="logo">
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
                            echo $imageLastArticle;
                        ?>
                    </p>
                </aside>    
            </div>
        </div> 
    </div>
</section>

<section id="contact">
    <div class="contactForm">
        
    </div>
</section>

<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/Footer.php'); ?>
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>