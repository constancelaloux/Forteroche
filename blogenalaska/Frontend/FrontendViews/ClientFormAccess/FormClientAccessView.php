<?php //session_start();?>
<?php $title = 'connect client blog page'; ?>
<?php ob_start(); ?>
<?php
if(isset($error))
    { 
?>
        <div  id='#myAlert' class="alert alert-danger"> <a class="close">x</a><?= $error?></div>
<?php
    }

//print_r($_SESSION);
//Session flash message
 /*if(isset($session))
        {
            $session->flash();  
        }*//*$session->flash();*/
?>

<!--le message flash se ferme lorsque je clique sur la croix-->
<script>
    var alert = $('.alert');
    if(alert.length>0)
      {
          alert.hide().slideDown(500);
          $('.close').on('click', function(e) 
            {
              // do something…
              e.preventDefault();
              alert.slideUp();
            });
      };
</script>
                            
<section class="connectClient">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div id="logoAndTextClientForm">
                    <a class="navbar-brand" href="#">
                        <img src="/blogenalaska/public/images/logoforteroche.png" alt="logo">
                    </a>

                    <p>Veuillez entrer votre mot de passe et votre identifiant</p>
                </div>
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

                    <div id="submitClientForm">
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