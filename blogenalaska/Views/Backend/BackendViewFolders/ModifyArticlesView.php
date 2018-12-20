<?php  session_start(); ?>

<?php $title = 'modification des articles'; ?>
<?php ob_start(); ?>

<?php echo"je suis dans ma vue de modif articles"?>
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
        <textarea id="mytextarea" name="content"><?php echo $articleSubject?></textarea>
        
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
<?php $backend = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');