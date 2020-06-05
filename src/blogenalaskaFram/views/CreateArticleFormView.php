<?php /*session_start();
    // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
    if(!$_SESSION["status"] === 'admin' || !$_SESSION["status"] === 'auth' || session_status() === PHP_SESSION_NONE)
    {
        $this->addFlash()->success('Votre compte a bien été créé');
        return $this->redirect('/connectform');
    }*/
//print_r($_SESSION);
?>
<section class="createAuthorForm">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <!--<p>-->
                    <div class="text-center mb-4">
                        <h1 class="h2 mb-3 font-weight-normal border-left border-info text-warning"><?php echo $title ?></h1>
                    </div>
                    <?php echo $form ?>
                    <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">Upload file</button>-->
                    <!--<div class="preview">
                        <img class="mb-1" id="image" src="/../../public/images/upload.png"  alt="photo de montagne"> 
                    </div>-->
                    <!--<input type="hidden" class="valueHidden" name="image" value=""/>
                    <input type="hidden" id="newFile" name="newFile" value=""/>-->
                    <!--<div class="preview"><img class="image" src="/../../../public/images/upload.png" /> </div>-->
                     <!--<div class="preview"><img id="image" src="/blogenalaska/public/images/upload.png" /> </div>-->
                    <?php /*if(isset($image))
                    {
                        print_r($image);
                        foreach ($image as $imageValue) 
                        {
                    ?>
                            <img class="card-img" src="<?=$imageValue->image() ?>" alt="image article">
                    <?php
                        }
                    }*/
                    ?>
                    <!--<input type="hidden" class="valueHidden" name="image2" value=""/>-->
                    <!--<div id="preview"><img src="/../../../public/images/86716189_2996327917095311_6384907101017210880_o_copy_copy_copy.jpg" /> </div><br>-->
                    <!--<div id="preview"><img src="/../../../public/images/upload.png" /></div><br>-->
                   <!--<div id="preview"><img src="/../../../public/images/upload/posts/<?php //echo $image ?>"/></div><br>-->
                    <div id="preview"><?php echo $image ?></div><br>
                    <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="validate" value="Valider"/>
                    <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="save" value="Sauvegarder"/>
                    <!--<div class="form-group">
                        <label for="exampleFormControlFile1">Example file input</label>
                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                    </div>-->
                    <!--<button type= "submit" class="btn btn-primary btn-round btn-lg btn-block" name="validate" value="valider">Valider</button>
                    <button type= "submit" class="btn btn-primary btn-round btn-lg btn-block" name="save" value="sauvegarder">Sauvegarder</button>-->
                    <!--</p>-->
                </form>
            </div>
        </div>
    </div>
</section>


<!-- The Modal -->
<div class="modal" id="uploadModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Choisir une image</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <!-- Form -->
        <form>
            Select file : <input type='file' name='file' id='file' class='form-control' onchange="fileSelected(this)" ><br>
            <input type="hidden" id="newFile" name="newFile" value=""/>
            <button id="upload"  data-dismiss="modal">Upload</button>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>