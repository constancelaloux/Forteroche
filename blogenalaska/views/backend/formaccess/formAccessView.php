<?php $title = 'Les aventures de Jean Forteroche'; ?>

<p>Veuillez entrer votre mot de passe et votre identifiant</p>

    <form action="index.php?action=transferdatatocontroler" method="post">
        <p>
        <div>
            <label for="username">Identifiant</label>
            <input type="text" id="username" name="username" />
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="mot_de_passe" />
        </div>
        <p>
            <div>Jean_Forteroche</div>
            <div>jean38</div>
        </p>
        <div>
            <input type="submit" value="Valider" />
        </div>
        </p>
    </form>

<?php //$content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/template.php');



