<!--Include Footer et template -->
<?php $title = 'Frontend main page'; ?>
<?php ob_start(); ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/Header.php'); ?>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/blogenalaska/public/images/alaska3.jpg" class="d-block w-100" alt="image1">
        </div>
        <div class="carousel-item">
            <img src="/blogenalaska/public/images/alaska.jpg" class="d-block w-100" alt="image2">
        </div>
        <div class="carousel-item">
            <img src="/blogenalaska/public/images/alaskaf.jpg" class="d-block w-100" alt="image3">
        </div>
    </div>
</div>

<section id="articles">
    <div class="listArticlesContainer">


            <?php
                foreach ($articlesFromManager as $articles) 
                    {
                        if (strlen($articles->content()) <= 200)
                            {
                            //print_r("j y suis");
                                $articlesToDisplay = $articles->content();
                                //print_r($articlesToDisplay);
                            }
                        else
                            {
                            //print_r("ou la");
                            //Returns the portion of string specified by the start and length parameters.
                                $debut = substr($articles->content(), 0, 200);
                                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                                $articlesToDisplay = $debut;
                            }
                            
                        $titlesToDisplay = $articles->subject();
                        //$articlesToDisplay = $articles->content();
                        
                        echo '<h2>', $titlesToDisplay , '</h2>', "\n",
                        '<p>', $articlesToDisplay, '</p>', "\n", '<p>lire la suite </p>' ;
                        //$row = array();
                        
                        //$row[] = $articles->content();
                        //$row[] = $articles->id();
                       /* if ($articles->content())
                            {
                            //print_r($articles->content());
                                $row[] = $articles->content();
                                //exit();
                            }*/
                    }
            ?>
            <?php
                /*foreach ($titlesToDisplay as $valueTitleArticles) 
                    {
                        echo '<h2>', $valueTitleArticles ,'</h2>';
                    }*/
            ?>
                                
            <?php
                /*foreach ($articlesToDisplay as $valueArticles) 
                    {
                        echo $valueArticles;
                    }*/
            ?>
            <div id="navArticles">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item" aria-current="page">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        
            <aside id="whyThisBlog">
                <h2>
                    Bienvenu sur Billet Simple Pour l'Alaska
                </h2>
                <p>
                    Je partage sur ce blog mes coups de coeur et découvertes ainsi que mes carnets de voyages. 
                </p>
            </aside>
            <aside id="LastArticle">
                <p>
                    Derniers articles
                </p>
            </aside>
    </div> 
</section>

<section id="contact">
    <div class="contactForm">
        
    </div>
</section>

<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>