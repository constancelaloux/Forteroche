<?php $title = 'create new Author form'; ?>
<?php ob_start(); ?>
<?php
    //Session flash message
    if (!empty($session))
        {
            $session->flash(); 
        }
?>

<section class="connectAuthor">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="formTitle">
                    <p>Veuillez entrez votre login et votre mot de passe.</p>
                </div>
                <form action="/public/index.php?action=createPasswordAndUsername" method="post">
                    <p>
                        <div class="surname">
                            <label for="surname">Nom</label>
                            <input type="text" name="surname"  maxlength="20" ><br />
                        </div>
                        <div class="firstname">
                            <label for="firstname">Prénom</label>
                            <input type="text" name="firstname"  maxlength="20" ><br />
                        </div>
                        <div class="username">
                            <label for="username">Identifiant</label>
                            <input type="text" name="login" pattern=".{6,}"   required title="6 caracteres minimum"><br />
                        </div>
                        <div class="password">
                            <label for="password">Mot de passe</label>
                            <input type="text" name="pass" pattern=".{6,}"   required title="6 caracteres minimum"><br />
                        </div>
                        <div id="submitNewAuthorForm">
                            <input type="submit" value="Envoyer !">
                        </div>
                    </p>
                </form>
                <a class="connectAuthorForm" href="/public/index.php?action=getTheFormAdminConnexionBackend">Revenir au formulaire de connexion</a>
            </div>
        </div>
     </div>
</section>



<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/Template.php');