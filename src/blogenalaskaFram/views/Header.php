    <nav class="navbar fixed-top navbar-expand-lg navbar-light" id="navbar">
        <!--bg-transparent-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#">
            <img src="/../../public/images/logo.png" width="30" height="30" class="d-inline-block align-top" alt="logo">
            Jean Forteroche
        </a>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <!--<li>
                    <a class="nav-link" href="/createpost">Ecrire un article</a>
                </li>
                <li>
                    <a class="nav-link" href="/rendercommentspage">Commentaires</a>
                </li>-->
                <?php 
                if (isset($_SESSION['authorId'])|| (isset($_SESSION['client'])))
                { ?>
                <div class="navbar-test">Connecté en tant que <?php echo $_SESSION['authorUsername'] ?></div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Profil</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/updateuser">Modifier son profil</a>
                        <a class="dropdown-item" href="/deleteuser">Supprimer son profil</a>
                        <form class="nav-item active pr-1" method="post" action = "/logout">
                            <button class="btn btn-outline-success my-2 my-sm-0">Se déconnecter</button>
                        </form>
                    </div>
                </li>
                <?php 
                }
            else
            { ?>
                <li>
                    <a class="nav-link" href="/connectform">Connexion</a>
                </li>
            <?php 
            } ?>
            </ul>
            <form  action="/searchPosts" method="post" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" name="userSearch" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
<!--</header>-->

<?php
//print_r($_SESSION['ClientId']);
?>
<!--Menu-->
<!--<header class="nav">

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark col-lg-12 fixed-top" style="background-color: white;">
            
<!--icon-->
            <!--<a class="navbar-brand" href="#">
                <img src="/blogenalaska/public/images/logoforteroche.png" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>-->


<!--fin icon-->
            
<!--Le menu de navigation--> 
            <!--<div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/blogenalaska/index.php?action=goToFrontPageOfTheBlog"  style="color: rgba(0,0,0,.5);">ACCUEIL</a> <!-- style="color: rgba(70, 156, 214, 0.9);">Accueil</a>-->
                    <!--</li>

                    <li class="nav-item">
                        <a class="nav-link" href="#ancre_articles" style="color: rgba(0,0,0,.5);">ARTICLES</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#ancre_contact" style="color: rgba(0,0,0,.5);">CONTACT</a>
                    </li>
                </ul>-->
                <!--<div id="buttonSubmit">-->
                <!--<form action="/blogenalaska/index.php?action=search" method="post">
                    <div class="input-group md-form form-sm form-2 pl-0">
                        <input class="form-control my-0 py-1 red-border" type="text" name="whatImSearching" placeholder="Rechercher" aria-label="Search">
                            <div class="input-group-append">
                                <button type="submit" id="#userSearch" name="userSearch"><span class="input-group-text red lighten-3" id="basic-text1"><i class="fas fa-search text-grey" aria-hidden="true"></i></span></button>
                            </div>
                    </div>
                </form>-->

                    <!--<button type="submit" name="userSearch"><i class="fas fa-search"></i>chercher</button>-->
            <?php 
                //if(isset($_SESSION['clientUsername'])) 
                //    {
                    
            ?>
                        <!--<div class="d-flex">
                            <div class="dropdown mr-1">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,20">     -->                                
                                        <?php
                                        //Session 
                                            //echo 'Bonjour ' . $_SESSION['clientUsername'] . ' !<br />'
                                        ;?>
                                        <!--<img src="/blogenalaska/public/images/disconnect.png">-->
                                        <?php //echo $_SESSION['imageComment']; ?>
                                    <!--</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                        <div>
                                            <a class="dropdown-item" href="/blogenalaska/index.php?action=disconnectTheClient">Déconnexion</a>
                                            
                                            <!--<button  type="button" class="dropdown-item" data-toggle="modal" data-target="#getModal">Supprimer mon compte</button>-->
                                            <!--href="/blogenalaska/index.php?action=removeClient"-->
                                            <!--<button type="button" class="dropdown-item" data-toggle="modal" data-target="#getModal">Supprimer mon compte</button>
                                            <a class="dropdown-item" href="/blogenalaska/index.php?action=updateClientForm&id=<?php echo $_SESSION['ClientId']?>">Réinitialiser mon compte</a>
                                        </div>
                                    </div>
                            </div> 
                        </div>-->

            <?php
                    //}
                //else 
                    //{
            ?>
              <!--Click sur image pour se connecter au backend-->
                <!--<div class="d-flex">
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
                </div>  -->
            <?php                  
                   // }
            ?>

            <!--</div>

        </nav>
    </div>
    
</header> -->

                
<!-- Modal -->
<!--<div id="getModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <!--<div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">File upload form</h4>
            </div>
            <div class="modal-body">
                <!-- Form -->
                <!--<form>
                    <p>Voulez vous vraiment supprimer votre compte ?</p>
                    <br>
                    <input type="hidden" id="newFile" name="newFile" value="<?php echo $_SESSION['ClientId'] ?>"/>
                    <button id="validateDeleteClient"  data-dismiss="modal" name="validateRemoveClient">Valider</button>
                </form>
            </div>

        </div>

    </div>
</div>-->

<!--script permettant le hover sur les dropdown-->
<!--<script>
    $('ul.navbar-nav li.nav-item').hover(function() 
        {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
        }, function() 
        {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
        });
</script>-->

<!--<script>
    $('#validateDeleteClient').on('click', function(e)
        {
            e.preventDefault();

            var form_data = $("#newFile").val();
            $.ajax(
                {
                    url         : '/blogenalaska/index.php?action=removeClient',     // point to server-side PHP script 
                    method      :"POST",
                    dataType: 'html',
                    data        : {'data' : form_data},
                    success     : function(response)
                        {
                            var url = "/blogenalaska/index.php?action=disconnectTheClient"; 
                            window.location.href = url; 
                        },
                    error: function(xhr, ajaxOptions, thrownError) 
                        {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }      
                });
        });    
</script>-->