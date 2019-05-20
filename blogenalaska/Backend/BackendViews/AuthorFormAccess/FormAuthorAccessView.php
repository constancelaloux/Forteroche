<?php $title = 'connect blog page'; ?>
<?php ob_start(); ?>

<section class="connectAuthor">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="formTitle">
                    <p>Veuillez entrer votre mot de passe et votre identifiant</p>
                </div>
                <form action="/blogenalaska/index.php?action=checkThePassAndUsername" method="post">

                    <div class="username">
                        <label for="username">Identifiant</label>
                        <input type="text" id="username" name="username" />
                    </div>

                    <div class="password">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" />
                    </div>

                    <div>Jean_Forteroche</div>

                    <div>passFromUser</div>

                    <div id="submitAuthorFormConnection">
                        <input type="submit" value="Se connecter" />
                    </div>
                </form>    
            </div>
        </div>
     </div>


<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');



