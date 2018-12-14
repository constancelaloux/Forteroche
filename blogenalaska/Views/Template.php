<?php //ob_start(); ?>
<?php //include("/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Backend/Header.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="public/css/style.css" rel="stylesheet" />

    </head>
    
    <body>

    <!--Menu-->
    <?php if (isset($_SESSION['username'])) { print_r("im authentificated"); ?>
        <p>Je suis le header du backend</p>
        <header class="col-sm-12 col-lg-12 table-responsive">
             <div class="container">
               <nav class="navbar navbar-inverse">
                <div class="navbar-header">
                  <!--   <a class="navbar-brand" href="#">$_SESSION['userName']</a>-->
                </div>
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
                        <li class="active"> <a href="http://localhost:8888/blogenalaska/Views/Frontend/Accueil.php">Site web</a> </li>
                        <li class="active"> <a href="BackendView.php">Accueil</a> </li>
                        <li class="dropbtn"> <a href="#" class="dropbtn">Articles</a>
                        <div class="dropdown-content">
                            <a href="WriteArticlesView.php">Rédiger un article</a>
                        </div>
                        </li>
                        <li class="active"> <a href="ManageCommentsView.php">Commentaires</a> </li>
                    </ul>
                </div>
               </nav>
             </div>
        </header>
            
        <!--Contenu-->
            

        
        <!--Footer-->
        <p>Je suis le footer</p>
    <?php }
    else {
    ?>        
        <?= $content ?>
    <?php
    }?>
    <!--Contenu-->
         <?= $backend ?>

    <!--Footer-->
    <!--<p>Je suis le footer</p>-->
    </body>

</html>
<?php //include("/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Backend/Footer.php"); ?>
<?php //$content = ob_get_clean(); ?>

