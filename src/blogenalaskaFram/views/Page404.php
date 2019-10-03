<!--Include Footer et template -->
<?php $title = '404 page'; ?>
<?php //ob_start(); ?>

<div class="text-center text-secondary">

    <!--<h1 class="display-1">
    <i class="far fa-frown fa-2x"></i>
    </h1>-->
    <a class="404_icon" href="#">
        <img src="/blogenalaska/public/images/404img.png" alt="logo">
    </a>
    <h1 class="display-1 text-danger font-title font-weight-bold">404</h1>
    <!--<h3 class="display-4 font-title">Page non trouvée</h3>-->
    <h3 class="display-4  text-danger font-title">Ahhhhhh !</h3>
    <h2>Vous avez cassé internet!</h2>
    <!--La page que vous tentez d'afficher n'existe pas ou une autre erreur s'est produite.-->
    <div id='404text'>
        <p>Cependant il n'est pas absurde d'envisager l'idée ni sotte, ni saugrenue, que nous sommes de maniére 
        ni plus ou moins aléatoire tombés sur une erreur 404 et que la page que vous recherchez n'existe problablement pas, ou plus!</p>
    </div>
    Vous pouvez revenir à <a href="javascript:history.back()">la page précédente</a> ou aller à 
    <a href="/">la page d'accueil</a>.
</div>



<?php //$content = ob_get_clean(); ?>

<?php //require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');?>
