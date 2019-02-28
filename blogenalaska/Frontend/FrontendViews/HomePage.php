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
        <div class="listOfArticles">
            <?php
                foreach ($articlesFromManager as $articles) 
                    {
                        if (strlen($articles->content()) <= 200)
                            {
                                $articlesToDisplay = $articles->content();
                            }
                        else
                            {
                            //Returns the portion of string specified by the start and length parameters.
                                $debut = substr($articles->content(), 0, 200);
                                $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                                $articlesToDisplay = $debut;
                            }
                            
                        $titlesToDisplay = $articles->subject();
                        $idArticles = $articles->id();
                        
                        echo '<h2>', $titlesToDisplay , '</h2>', "\n",
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
                        <!--<a class="page-link" href="/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=2">2</a>-->
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
        
        <!--Code javascript pour la pagination -->
        <script> 

            var show_per_page = 3; 
            var current_page = 0;

            function set_display(first, last)
                {
                    $('#content').children().css('display', 'none');
                    $('#content').children().slice(first, last).css('display', 'block');
                }

            function previous()
                {
                    if($('.active').prev('.page_link').length) go_to_page(current_page - 1);
                }

            function next()
                {
                    if($('.active').next('.page_link').length) go_to_page(current_page + 1);
                }

            function go_to_page(page_num)
                {
                    current_page = page_num;
                    start_from = current_page * show_per_page;
                    end_on = start_from + show_per_page;
                    set_display(start_from, end_on);
                    $('.active').removeClass('active');
                    $('#id' + page_num).addClass('active');
                }  

            $(document).ready(function() 
                {
                    var number_of_pages = Math.ceil($('#content').children().length / show_per_page);
      
                    var nav = '<ul class="pagination"><li><a href="javascript:previous();">&laquo;</a>';

                    var i = -1;
                    while(number_of_pages > ++i)
                        {
                            nav += '<li class="page_link'
                            if(!i) nav += ' active';
                            nav += '" id="id' + i +'">';
                            nav += '<a href="javascript:go_to_page(' + i +')">'+ (i + 1) +'</a>';
                        }
                    nav += '<li><a href="javascript:next();">&raquo;</a></ul>';

                    $('#page_navigation').html(nav);
                    set_display(0, show_per_page);
                });

        </script>
        
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
                <?php    
                    echo $titleLastArticle;
                    echo $contentLastArticle;
                ?>
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