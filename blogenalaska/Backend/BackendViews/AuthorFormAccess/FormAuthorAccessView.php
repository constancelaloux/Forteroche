<?php $title = 'connect blog page'; ?>
<?php ob_start(); ?>

<p>Veuillez entrer votre mot de passe et votre identifiant</p>

    <form action="/blogenalaska/index.php?action=checkThePassAndUsername" method="post">

        <div>
            <label for="username">Identifiant</label>
            <input type="text" id="username" name="username" />
        </div>
        
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" />
        </div>

        <div>Jean_Forteroche</div>
        
        <div>passFromUser</div>

        <div>
            <input type="submit" value="Se connecter" />
        </div>
    </form>

<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');



