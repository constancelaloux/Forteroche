<?php $title = 'reinitiate client blog page'; ?>
<?php ob_start(); ?>
<section class="connectClient">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                
                <div id="logoAndTextClientForm">
                    <a class="navbar-brand" href="#">
                        <img src="/public/images/logoforteroche.png" alt="logo">
                    </a>

                    <p>Veuillez entrer votre nouveau mot de passe</p>
                </div>
                
                <form action="/public/index.php?action=updateClient" method="post">

                    <div id="passwordFormClient">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" />
                    </div>
                    
                    <div id="hideId">
                        <input type="hidden" id="id" name="id" value="<?php echo $clientId?>" />
                    </div>

                    <div id="submitClientForm">
                        <input type="submit" value="valider" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/Template.php');

