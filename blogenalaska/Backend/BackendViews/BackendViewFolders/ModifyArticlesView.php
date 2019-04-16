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
                        selector:'#mytextarea',

                        // langue
                        //language : "fr_FR",
                        //language: 'fr_FR',
                        language_url: '/blogenalaska/Public/js/fr_FR.js',
                        font_formats: 'Arial=arial',
                        //toolbar: ['fontsizeselect', 'image'],
                        //plugins: "image imagetools",
                        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                        height : 300,
                        max_height: 300,
                        min_height: 300
                });

        </script>

   
    <form action="/blogenalaska/index.php?action=articleUpdated" id="formArticle" method="post">
        <h1>Ajouter un nouvel article</h1>
        <div class="titleOfArticle">
            <label for="titleArticle">Titre de l'article</label>
            <input type="text" id="titleArticle" name="title" value ='<?php echo $articleSubject?>' />
        </div>
        
        <div class="contentOfArticle">
            <label for="contentArticle">Contenu de l'article</label>
            <textarea id="mytextarea" name="content"> <?php echo $articleContent?></textarea>
        </div>
        
        
        <div  class="imageOfArticle">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Upload file</button>
            <!--<div class="preview"><img name="image" id="image" src="/blogenalaska/public/images/upload.png" /> </div>-->       
        </div>
        <!--<input type="image" class="preview">-->

        <div class="preview"><img id="image" src="<?php echo $articleImage; ?>"/> </div>

            <input type="hidden" class="valueHidden" name="image" value="<?php echo $articleImage ?>"/>
        <div>
        <input type="hidden" name="id" value="<?= $id ?>" />
        <div>
            <input type = "submit" value="Valider"/>
        </div>
    </form>
    
                <!-- Modal -->
        <div id="uploadModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">File upload form</h4>
                    </div>
                    <div class="modal-body">
                        <!-- Form -->
                        <!--<form action='/blogenalaska/index.php?action=iGetImageIntoFormFromUploadPath' method='post'>-->
                        <form>
                            Select file : <input type='file' name='file' id='file' class='form-control' onchange="fileSelected(this)" ><br>
                            <!--<input type="text" id="newFile" name="newFile" value="">-->
                            <input type="hidden" id="newFile" name="newFile" value=""/>
                            <!--<input type='submit' class='btn btn-info' value='Envoyer !' id='upload'>-->
                             <button id="upload"  data-dismiss="modal">Upload</button>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    

        
        
        
        <script>
              function fileSelected(input)
                {
                    //console.log("yeahhhh");
                    var file_data = $('#file').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    //e.preventDefault();
                    //var dataString = $('.btn').serialize();
                    $.ajax({
                        url         : '/blogenalaska/index.php?action=uploadImage',     // point to server-side PHP script 
                        dataType    : 'text',           // what to expect back from the PHP script, if anything
                        cache       : false,
                        contentType : false,
                        processData : false,
                        data        : form_data,                         
                        type        : 'post',

                        //dataType    : 'json', // what type of data do we expect back from the server
                        success     : function(output){
                            //$("#formArticle")[0].reset();
                            var message;
                            //$("#custId").val(output);
                            //message = $("#newFile").show();
                            message = $("#newFile").attr("value",output);
                            
                            //$("p").html($("p").html() + "<br>" + message);
                            //$('#custId').html(output).fadeIn();
                            //$("#preview").html(output).fadeIn();
 

                            //console.log('upload successful!\n' + output);
                                 //alert(output);
                                 //$('#pic').find("img").attr(output);
                                 //alert(output);
                                      // view uploaded file.

                                 //console.log(output);
                                     // display response from the PHP script, if any
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }

                    });
                               //$('#pic').val("");

                }
        </script>
        
        <script>
            $('#upload').on('click', function(e){
                e.preventDefault();

                console.log("test");
                var form_data = $("#newFile").val();
                //console.log(form_data);
                //var file_data = $('#newFile').prop('files')[0];
                //var form_data = new FormData();
                //form_data.append('newFile', file_data);

                //var dataString = $('.btn').serialize();
                $.ajax({
                url         : '/blogenalaska/index.php?action=iGetImageIntoFormFromUploadPath&data='+form_data,     // point to server-side PHP script 
                //dataType    : 'text',           // what to expect back from the PHP script, if anything
                method      :"GET",
                dataType: 'html',
                //cache       : false,
                //contentType : false,
                //processData : false,
                data        : form_data,

                //type        : 'post',
    
                //dataType    : 'json', // what type of data do we expect back from the server
                success     : function(response){
                    //var message;
                    //$('#file').html(output).fadeIn();
                    //$("#preview").html(output).fadeIn();
                    //$("#formArticle")[0].reset(); 
                    
                    //console.log('upload successful!\n' + output);
                    //alert(response);
                    //message = $("#image").attr("value",output);
                    $('.preview').html(response);
                    $('.valueHidden').attr("value",response);
                    //$('.preview').find("img").attr(output);
                    //$('#preview').find("img").attr(output);
                    //alert(output);
                         // view uploaded file.

                    //console.log(output);
                        // display response from the PHP script, if any
                },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
                
         });
                
            });    
        </script>
        
    <!--<form action="/blogenalaska/index.php?action=articleUpdated" method="post">

        <textarea id="mytitle" name="title"><h1><?php //echo $articleSubject?></h1></textarea>
        <textarea id="mytextarea" name="content"><?php //echo $articleContent?></textarea>
        
        <input type="hidden" name="id" value="" />
        <input type = "submit" value="Valider"/>
    </form>-->
       
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