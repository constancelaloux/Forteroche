<!--Vue : cette partie se concentre sur l'affichage. 
Elle ne fait presque aucun calcul et se contente de récupérer des variables 
pour savoir ce qu'elle doit afficher. On y trouve essentiellement du code HTML mais aussi quelques boucles 
et conditions PHP très simples, pour afficher par exemple une liste de messages.-->
<?php $title = 'Les aventures de Jean Forteroche'; ?>

<p>Veuillez entrer votre mot de passe et votre identifiant</p>

    <form action="index.php?action=transferDatatoControler" method="post">
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
            <div>passFromUser</div>
        </p>
        <div>
            <input type="submit" value="Valider" />
        </div>
        </p>
    </form>

<?php $content = ob_get_clean(); ?>

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');



