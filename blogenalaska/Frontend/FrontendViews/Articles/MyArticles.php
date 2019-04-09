<!--Include Footer et template -->
<?php $title = 'Frontend main page'; ?>
<?php ob_start(); ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Frontend/frontendViews/Header.php'); ?>

<?php

    echo $titleToDisplay;
    
    echo $imageToDisplay;
    
    echo $articlesToDisplay;
    
    //echo $myComment;
?>
        <?php
            $commentId = $_GET['id'];
            //print_r($commentId);
        ?>

<!--Formulaire pour envoyer des commentaires-->
<form action="/blogenalaska/index.php?action=sendCommentsFromId&id=<?php echo $commentId ?>" method="post">
        <p>Envoyer ici votre commentaire</p>

        <div>
            <label for="comments">Commentaire</label>
            <textarea id="comments" name="comments"></textarea>
        </div>

        <div>
            <input type="submit" value="Envoyer" />
        </div>
</form>

<!--J'affiche les commentaires-->
<section id="listOfComments">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
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
                                //print_r($listOfComments);

                                    //echo '<p>', $contentSubjectToDisplay , '</p>';
                                foreach ($myComment as $comments) 
                                    {
                                    //print_r("j y suis");
                                        $commentsToDisplay = $comments->content();
                                        echo '<p>', $commentsToDisplay, '</p>';
                                    }

                                /*foreach ($listOfCommentsFromManager as $comments) 
                                    {

                                        $commentsToDisplay = $comments->content();

                                        //$idComments = $comments->id();

                                        $dateCreate = $comments->createdate();
                                        $commentsDateCreate = $dateCreate->format('Y-m-d');

                                        echo '<p>', $commentsDateCreate , '</p>' , "\n",
                                        '<p>', $commentsToDisplay, '</p>';

                                    }*/

                                //Pagination
                                /*for ($i=1;$i<=$numberOfPages;$i++)
                                    {
                                        echo "<a href=\"/blogenalaska/index.php?action=iGetArticlesToshowInTheBlogPage&p=",$i,"\"> $i </a>/ ";
                                    } */
                            } 
                    ?>

                </div>
  
                <!--<div id="navComments">
                    <nav aria-label="...">

                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=getArticleFromId&p=<?php echo $prevpage?>">Previous</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=getArticleFromId&p=1">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=getArticleFromId&p=2">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=getArticleFromId&p=3">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="/blogenalaska/index.php?action=iGetCommentsToshowInTheBlogPage&p=<?php echo $nextpage?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>-->
            </div>


<?php $content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>

