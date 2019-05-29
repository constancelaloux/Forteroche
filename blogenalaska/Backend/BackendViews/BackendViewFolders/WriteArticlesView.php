<?php  if(!isset($_SESSION))
        {
            session_start();
        }

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
<?php $title = 'backend creation articles'; ?>
<?php include('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Backend/BackendViews/Header.php'); ?>
<?php ob_start(); ?>
        
    <script type="text/javascript">
        tinymce.init
            ({ 
                    selector:'#mytextarea',
                    // langue
                    language_url: '/blogenalaska/Public/js/fr_FR.js',
                    font_formats: 'Arial=arial',
                    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
                    height : 300,
                    max_height: 300,
                    min_height: 300
            });
    </script>

    <!--message d'erreur si l'article n'a pas été complété-->      
    <?php

        if (!empty($session))
            {
                $session->flash(); 
            }
    ?>

    <form action="/blogenalaska/index.php?action=saveNewArticle" id="formArticle" method="post">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1>Ajouter un nouvel article</h1>
                    <div class="titleOfArticle">
                        <label for="titleArticle">Titre de l'article</label>
                        <input type="text" id="titleArticle" name="title" />
                    </div>
                    <div class="contentOfArticle">
                        <label for="contentArticle">Contenu de l'article</label>
                        <textarea id="mytextarea" name="content"> <p></textarea>
                    </div>

                    <div  class="imageOfArticle">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Upload file</button>
                    </div>
                    <div class="preview"><img id="image" src="/blogenalaska/public/images/upload.png" /> </div>
                    <input type="hidden" class="valueHidden" name="image" value=""/>
                    <div id="validArticlesButton">         
                        <input type = "submit" name="validate" value="Valider"/>
                    </div>
                    <div id="saveArticlesButton">
                        <input type = "submit" name="save" value="Sauvegarder" formaction="/blogenalaska/index.php?action=saveArticleBeforeToValidate"/>
                    </div>
                </div>
            </div>
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
                    <form>
                        Select file : <input type='file' name='file' id='file' class='form-control' onchange="fileSelected(this)" ><br>
                        <input type="hidden" id="newFile" name="newFile" value=""/>
                        <button id="upload"  data-dismiss="modal">Upload</button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script>
          function fileSelected(input)
            {
                var file_data = $('#file').prop('files')[0];
                var form_data = new FormData();
                form_data.append('file', file_data);
                $.ajax(
                    {
                        url         : '/blogenalaska/index.php?action=uploadImage',     // point to server-side PHP script 
                        dataType    : 'text',           // what to expect back from the PHP script, if anything
                        cache       : false,
                        contentType : false,
                        processData : false,
                        data        : form_data,                         
                        type        : 'post',
                        success     : function(output)
                            {
                                var message;
                                message = $("#newFile").attr("value",output);
                            },
                        error: function(xhr, ajaxOptions, thrownError) 
                            {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                    });
            }
    </script>

    <script>
        $('#upload').on('click', function(e)
            {
                e.preventDefault();

                var form_data = $("#newFile").val();
                $.ajax(
                    {
                        url         : '/blogenalaska/index.php?action=iGetImageIntoFormFromUploadPath&data='+form_data,     // point to server-side PHP script 
                        method      :"GET",
                        dataType: 'html',
                        data        : form_data,
                        success     : function(response)
                            {
                                $('.preview').html(response);
                                $('.valueHidden').attr("value",response);
                            },
                        error: function(xhr, ajaxOptions, thrownError) 
                            {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }      
                    });
            });    
    </script>
        
<?php $content = ob_get_clean(); ?>
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/Template.php');