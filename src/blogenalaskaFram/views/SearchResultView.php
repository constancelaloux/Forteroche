<div class="listOfSearch">
    <p>Le résultat de la racherche donne les articles suivants: </p>
    <?php if (!empty($mySearchResults)): ?>
            <?php foreach ($mySearchResults as $mySearchResult): ?>    
                        <p> <a href="/article&id=<?php echo $mySearchResult->id()?>,"> <?php echo htmlspecialchars($mySearchResult->subject())?></a></p>
                        <?php echo htmlspecialchars($mySearchResult->createdate()->format('Y-m-d'))?>
                        <?php echo $mySearchResult->id()?>
            <?php endforeach; ?>
        <?php else: ?>
                <p>pas d'articles trouvés</p>
        <?php endif; ?>
</div>

