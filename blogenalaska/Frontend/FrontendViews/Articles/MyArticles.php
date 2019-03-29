<!--Include Footer et template -->
<?php $title = 'Frontend main page'; ?>
<?php ob_start(); ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/Header.php'); ?>

<?php

    echo $titleToDisplay;
    
    echo $imageToDisplay;
    
    echo $articlesToDisplay;
?>

<form action="/blogenalaska/index.php?action=sendCommentsFromId&id=<?php $commentId ?>" method="post">
        <p>Envoyer ici votre commentaire</p>
        <?php
            $commentId = $_GET['id'];
        ?>
        <div>
            <label for="comments">Commentaire</label>
            <textarea id="comments" name="comments"></textarea>
        </div>

        <div>
            <input type="submit" value="Envoyer" />
        </div>
    </form>

<section id="listOfComments">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="listOfComments">
                    <?php
                        foreach ($listOfCommentsFromManager as $comments) 
                            {

                                $commentsToDisplay = $comments->content();

                                //$idComments = $comments->id();

                                $dateCreate = $comments->createdate();
                                $commentsDateCreate = $dateCreate->format('Y-m-d');

                                echo '<p>', $commentsDateCreate , '</p>' , "\n",
                                '<p>', $commentsToDisplay, '</p>';

                            }

                        //Pagination
                        /*for ($i=1;$i<=$numberOfPages;$i++)
                            {
                                echo "<a href=\"/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=",$i,"\"> $i </a>/ ";
                            } */
                    ?>

                </div>
  
                <div id="navComments">
                    <nav aria-label="...">

                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetCommentsToshowInTheBlogPage&p=<?php echo $prevpage?>">Previous</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetCommentsToshowInTheBlogPage&p=1">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetCommentsToshowInTheBlogPage&p=2">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetCommentsToshowInTheBlogPage&p=3">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetCommentsToshowInTheBlogPage&p=<?php echo $nextpage?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>


<?php $content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>

