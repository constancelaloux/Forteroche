<?php $title = 'connect client blog page'; ?>
<?php ob_start(); ?>

<p>Veuillez entrer votre mot de passe et votre identifiant</p>

    <form action="/blogenalaska/index.php?action=checkThePassAndUsernameOfClient" method="post">
        
        <div>
            <label for="username">Identifiant</label>
            <input type="text" id="username" name="username" />
        </div>
        
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" />
        </div>

        <div>Pascal</div>
        
        <div>lemotdepasseduclient</div>

        <div>
            <input type="submit" value="Se connecter" />
        </div>
    </form>
    <a class="dropdown-item" href="/blogenalaska/index.php?action=createNewClientForm">Créer un compte</a>

<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');