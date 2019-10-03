<?php //session_start();?>
<?php $title = 'connect client blog page'; ?>
<?php ob_start(); ?>
<?php
//print_r($_SESSION);
//Session flash message
    /*if(isset($session))
        {
            $session->flash();  
            print_r($_SESSION);
        }
    else
    {
            print_r('rien');
    }*/
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
                        <img src="/public/images/logoforteroche.png" alt="logo">
                    </a>

                    <p>Veuillez entrer votre mot de passe et votre identifiant</p>
                </div>
                <form action="/public/index.php?action=checkThePassAndUsernameOfClient" method="post">

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
                <a class="dropdown-item" href="/public/index.php?action=createNewClientForm">Créer un compte</a>
            </div>
        </div>
    </div>
</section>
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/src/blogenalaskaFram/views/Template.php');