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
        }
                ?>
</div>

