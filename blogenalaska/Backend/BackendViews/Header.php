<!--Menu-->

<header class="navbarAuthor">

    <div class="container">
        <div class="navAuthor">
        <nav class="navbar navbar-expand-lg navbar-dark col-lg-12 fixed-top">
            
<!--icon-->
            <a class="navbar-brand" href="#">
                <img src="/blogenalaska/public/images/logoBackend.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
<!--fin icon-->
            
<!--Le menu de navigation--> 
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/blogenalaska/index.php?action=goToFrontPageOfTheBlog">Site web <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/blogenalaska/index.php?action=mainBackendPage">Accueil</a>
                    </li>

<!--dropdown-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Articles</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/blogenalaska/index.php?action=writeAnArticle">Rédiger un article</a>
                            </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >Commentaires<b class="caret"></b></a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/blogenalaska/index.php?action=getCommentsViewDatatables">Commentaires</a>
                            </div>
                    </li> 
                </ul>

<!--Click sur image pour déconnecter-->
                <div class="d-flex">
                    <div class="dropdown mr-1">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20"  style="background-color: #23282d;">                                     
                                <?php
                                //Session
                                try
                                    {
                                        if (!empty($_SESSION['username']))
                                            {
                                                echo 'Bonjour ' . $_SESSION['username'] . ' !<br />';
                                            }
                                        else 
                                            {
                                                throw new Exception('Votre identifiant n\'existe plus');
                                            }
                                    }
                                catch (Exception $e)
                                    {
                                        echo 'Erreur : ' . $e->getMessage();
                                    }
                                ;?>
                                <img src="/blogenalaska/public/images/disconnect.png">
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                <div>
                                    <a class="dropdown-item" href="/blogenalaska/index.php?action=disconnectTheAdmin">Déconnexion</a>
                                </div>
                            </div>
                    </div> 
                </div>
                <!--message d'erreur si pas déconnecté-->
                <div id="errorMessageDisplay">
                    <p>
                        <?php if (isset($error))
                                {
                                    echo $error;
                                }
                        ?>
                    </p>
                </div>
            </div>
        </nav>
        </div>
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


