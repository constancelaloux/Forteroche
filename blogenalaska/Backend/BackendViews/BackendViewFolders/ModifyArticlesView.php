<?php  session_start();
if (isset($_SESSION['username']))
    {
        $expireAfter = 30;

        //Check to see if our "last action" session
        //variable has been set.
        if(isset($_SESSION['last_action']))
            {

                //Figure out how many seconds have passed
                //since the user was last active.
                $secondsInactive = time() - $_SESSION['last_action'];

                //Convert our minutes into seconds.
                $expireAfterSeconds = $expireAfter * 60;

                //Check to see if they have been inactive for too long.
                if($secondsInactive >= $expireAfterSeconds)
                    {
                        //print_r("ma session est inactive");
                        //User has been inactive for too long.
                        //Kill their session.
                        session_unset();
                        session_destroy();

                        header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
                    }
            }

        //Assign the current timestamp as the user's
        //latest activity
        $_SESSION['last_action'] = time();
    }
else 
    {
        header('Location: /blogenalaska/index.php?action=getTheFormAdminConnexionBackend');
    }
    
?>
<?php $title = 'ManageCommentsView'; ?>
<?php ob_start(); ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/Header.php'); ?> ?>


    <h1>Modifier votre article</h1>

    <script type="text/javascript">
        tinymce.init
            ({
                selector: '#mytitle',
                //language: 'fr_FR',
                font_formats: 'Arial=arial',
                toolbar: 'fontsizeselect',
                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                height : 30,
                max_height: 30
            });
    </script>

    <script type="text/javascript">
        tinymce.init
            ({ 
                selector:'#mytextarea',
                convert_urls : false,
                //language: 'fr_FR',
                font_formats: 'Arial=arial',
                toolbar: ['fontsizeselect', 'image'],
                plugins: "image imagetools",
                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                height : 300,
                max_height: 300,
                min_height: 300
            });

    </script>


    <form action="/blogenalaska/index.php?action=articleUpdated" method="post">

        <textarea id="mytitle" name="title"><h1><?php echo $articleSubject?></h1></textarea>
        <textarea id="mytextarea" name="content"><?php echo $articleContent?></textarea>
        
        <input type="hidden" name="id" value="<?= $id ?>" />
        <input type = "submit" value="Valider"/>
    </form>
       
  <!-- <div id="resultat">-->
        <!-- Nous allons afficher un retour en jQuery au visiteur -->
    <!--</div>-->
    
   <!-- <script>
            $("#submit").click(function()
            {
                e.preventDefault();
                console.log("je passe la");
                $.post(
                    'index.php', // Un script PHP que l'on va créer juste après
                    {
                        myeditable : $("#myeditable").val(),  // Nous récupérons la valeur de nos inputs que l'on fait passer à connexion.php
                        mytextarea : $("#mytextarea").val()
                    },

                    function(data)
                    { // Cette fonction ne fait rien encore, nous la mettrons à jour plus tard
                        
                        if(data == 'Success')
                        {
                        // Le membre est connecté. Ajoutons lui un message dans la page HTML.

                            $("#resultat").html("<p>Vous avez été connecté avec succès !</p>");
                            console.log("reussi");
                        }
                       else
                        {
                            // Le membre n'a pas été connecté. (data vaut ici "failed")

                            $("#resultat").html("<p>Erreur lors de la connexion...</p>");
                            console.log("nope raté");
                        }
                    }
                        
                    //'text'  //Nous souhaitons recevoir "Success" ou "Failed", donc on indique text !
                );

            });

    </script>  -->     
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');