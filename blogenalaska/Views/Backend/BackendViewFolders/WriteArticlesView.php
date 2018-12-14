
<!--Jquery-->    
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>-->
<?php $title = 'backend creation articles'; ?>
<?php ob_start(); ?>
    <h1>Heyhey you are arrived in the building articles page</h1>


    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <!--<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=your_API_key"></script> -->

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


    <form action="/blogenalaska/index.php?action=transferArticlesToController" method="post"> 
        <textarea id="mytitle" name="title"><h1></h1></textarea>
        <textarea id="mytextarea" name="content"></textarea>
        
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
<?php //include("/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Backend/Footer.php"); ?> 

<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Views/Template.php');

  




