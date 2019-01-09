<?php $title = 'new Author blog page'; ?>
<?php ob_start(); ?>

<p>Entrez votre login et votre mot de passe.</p>

<form action="/blogenalaska/index.php?action=createPasswordAndUsername" method="post">
    <p>
        Prenom: <input type="text" name="firstname"><br />
        Nom : <input type="text" name="surname"><br />
        Identifiant : <input type="text" name="login"><br />
        Mot de passe : <input type="text" name="pass"><br /><br />
    
        <input type="submit" value="Envoyer !">
    </p>
</form>


<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');