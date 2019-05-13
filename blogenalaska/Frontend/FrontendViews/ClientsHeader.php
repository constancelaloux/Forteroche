<!--Menu-->
<header class="nav">

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark col-lg-12 fixed-top" style="background-color: white;">
            
<!--icon-->
            <a class="navbar-brand" href="#">
                <img src="/blogenalaska/public/images/logoforteroche.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


<!--fin icon-->
            
<!--Le menu de navigation--> 
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/blogenalaska/index.php?action=goToFrontPageOfTheBlog"  style="color: rgba(0,0,0,.5);">ACCUEIL</a> <!-- style="color: rgba(70, 156, 214, 0.9);">Accueil</a>-->
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#ancre_articles" style="color: rgba(0,0,0,.5);">ARTICLES</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#ancre_contact" style="color: rgba(0,0,0,.5);">CONTACT</a>
                    </li>
                </ul>
                <div id="buttonSubmit">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            <?php 
                if(isset($_SESSION['clientUsername'])) 
                    {
            ?>
                        <div class="d-flex">
                            <div class="dropdown mr-1">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">                                     
                                        <?php
                                        //Session 
                                            echo 'Bonjour ' . $_SESSION['clientUsername'] . ' !<br />'
                                        ;?>
                                        <!--<img src="/blogenalaska/public/images/disconnect.png">-->
                                        <?php echo $_SESSION['imageComment']; ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                        <div>
                                            <a class="dropdown-item" href="/blogenalaska/index.php?action=disconnectTheClient">DECONNEXION</a>
                                        </div>
                                    </div>
                            </div> 
                        </div>

            <?php
                    }
                else 
                    {
            ?>
              <!--Click sur image pour se connecter au backend-->
                <div class="d-flex">
                    <div class="dropdown mr-1">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20"  style="background-color: white;">                                             
                                <img src="/blogenalaska/public/images/connect.png">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                <div>
                                    <a class="dropdown-item" href="/blogenalaska/index.php?action=getTheFormClientsConnexion">Connexion</a>
                                </div>
                            </div>
                    </div> 
                </div>  
            <?php                  
                    }
            ?>

            </div>

        </nav>
    </div>
    
</header> 


<!--script permettant le hover sur les dropdown-->
<script>
    $('ul.navbar-nav li.nav-item').hover(function() 
        {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
        }, function() 
        {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
        });
</script>