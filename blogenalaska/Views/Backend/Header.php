<!--Menu-->

<header class="navbar">

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark col-lg-12 fixed-top" style="background-color: rgba(70, 156, 214, 0.9);">
            
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
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?action=goToTheBlog">Site web <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=mainBackendPage">Accueil</a>
                    </li>

<!--dropdown-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Articles</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="index.php?action=writeAnArticle">Rédiger un article</a>
                            </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Commentaires<b class="caret"></b></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="index.php?action=seeArticleView">Commentaires</a>
                            </div>
                    </li> 
                </ul>

<!--Click sur image pour déconnecter-->
                <div class="d-flex">
                    <div class="dropdown mr-1">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20"  style="background-color: rgba(70, 156, 214, 0.9);">                                     
                                <?php
                                //Session 
                                    echo 'Bonjour ' . $_SESSION['username'] . ' !<br />'
                                ;?>
                                <img src="/blogenalaska/public/images/disconnect.png">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                <div>
                                    <a class="dropdown-item" href="#">Déconnexion</a>
                                </div>
                            </div>
                    </div> 
                </div>
            </div>
<!
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


