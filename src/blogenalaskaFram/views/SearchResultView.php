<div class="listOfSearch">
    <?php
        if (empty($mySearchResults))
        {
    ?>
            <p>Rien a afficher pour l'instant</p>
    <?php
        }
        else
        {
            if (!empty ($mySearchResults))
            {
                foreach ($mySearchResults as $results) 
                {
                    //$searchResult = $result->subject();
                    //$idsearchresultArticle = $result->id();
                    //echo '<div id="mySearchResult">','<a href='.$searchResult.'', "\n", '</div>';
                    ?>
                    <p> <a href="/article&id=<?php echo $results->id() ?>,"> <?php echo htmlspecialchars($results->subject())?></a></p>
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

