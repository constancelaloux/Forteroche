<?php $title = 'connect client blog page'; ?>
<?php ob_start(); ?>
<section class="connectClient">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p>Veuillez entrer votre mot de passe et votre identifiant</p>

                    <form action="/blogenalaska/index.php?action=checkThePassAndUsernameOfClient" method="post">

                        <div id="usernameFormClient">
                            <label for="username">Identifiant</label>
                            <input type="text" id="username" name="username" />
                        </div>

                        <div id="passwordFormClient">
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
            </div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');