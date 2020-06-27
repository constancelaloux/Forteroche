<?php

print_r($_SESSION);
?>
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
        ?>
        <p>Le résultat de la racherche donne les articles suivants: </p>
        <?php
            if (!empty ($mySearchResults))
            {
                foreach ($mySearchResults as $mySearchResult) 
                {
                //print_r($mySearchResults);
                /*foreach ($mySearchResults as $results) 
                {*/
                    //$searchResult = $result->subject();
                    //$idsearchresultArticle = $result->id();
                    //echo '<div id="mySearchResult">','<a href='.$searchResult.'', "\n", '</div>';
                    ?>
                    
                    <p> <a href="/article&id=<?php echo $mySearchResult->id() ?>,"> <?php echo htmlspecialchars($mySearchResult->subject())?></a></p>
                    <?php echo $mySearchResult->createdate()->format('Y-m-d')?>
                    <?php echo $mySearchResult->id() ?>
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

