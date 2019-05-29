<?php $title = 'new Client'; ?>
<?php ob_start(); ?>

<section class="newClient">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div id="textFormNewClient">
                    <a class="navbar-brand" href="#">
                        <img src="/blogenalaska/public/images/logoforteroche.png" alt="logo">
                    </a>
                    <p>Entrez votre login et votre mot de passe.</p>
                </div>
                <form action="/blogenalaska/index.php?action=createNewClientPasswordAndUsername" method="post">
                    <p>
                        Prenom: <input type="text" name="firstname"><br />
                        Nom : <input type="text" name="surname"><br />
                        Identifiant : <input type="text" name="login"><br />
                        Mot de passe : <input type="text" name="pass"><br /><br />
                    </p>
                    
                    <!--J'upload une image-->
                    <div id="newClientImageUpload">
                        <div  class="imageOfClient">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#uploadModal">Télécharger une image</button>         
                        </div>

                        <div class="preview">                                           
                            <img id="image" src="/blogenalaska/public/images/upload.png" /> 
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
    $('#upload').on('click', function(e){
        e.preventDefault();

        var form_data = $("#newFile").val();
        $.ajax({
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