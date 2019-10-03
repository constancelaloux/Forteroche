<?php $title = 'new Client'; ?>
<?php ob_start(); ?>

<section class="newClient">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div id="textFormNewClient">
                    <a class="navbar-brand" href="#">
                        <img src="/public/images/logoforteroche.png" alt="logo">
                    </a>
                    <p>Entrez votre login et votre mot de passe.</p>
                </div>
                <form action="/public/index.php?action=createNewClientPasswordAndUsername" method="post">

                        <div class="surname">
                            <label for="surname">Nom</label>
                            <input type="text" name="surname"  maxlength="20" ><br />
                        </div>
                        <div class="firstname">
                            <label for="firstname">Prénom</label>
                            <input type="text" name="firstname"  maxlength="20" ><br />
                        </div>
                        <div class="username">
                            <label for="username">Identifiant</label>
                            <input type="text" name="login" pattern=".{6,}"   required title="6 caracteres minimum"><br />
                        </div>
                        <div class="password">
                            <label for="password">Mot de passe</label>
                            <input type="text" name="pass" pattern=".{6,}"   required title="6 caracteres minimum"><br />
                        </div>

                    <!--J'upload une image-->
                    <div id="newClientImageUpload">
                        <div  class="imageOfClient">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Télécharger une image</button>         
                        </div>

                        <div class="preview">                                           
                            <img id="image" src="/public/images/upload.png" /> 
                        </div>
                        <input type="hidden" class="valueHidden" name="image" value=""/>
                    </div>
                    
                    <!--Je soumet le formuaire-->
                    <div id="submitNewClient">
                        <input type="submit" value="Envoyer !">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


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

            $.ajax({
                url         : '/public/index.php?action=uploadImage',     // point to server-side PHP script 
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
    $('#upload').on('click', function(e){
        e.preventDefault();

        var form_data = $("#newFile").val();
        $.ajax({
            url         : '/public/index.php?action=iGetImageIntoFormFromUploadPath&data='+form_data,     // point to server-side PHP script 
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
<?php require('/Applications/MAMP/htdocs/Forteroche/blogenalaska/views/Template.php');