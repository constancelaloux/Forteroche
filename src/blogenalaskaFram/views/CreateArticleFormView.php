<?php
print_r($_SESSION);
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
                    <?php if(isset($form))
                            {
                                echo $form;
                            } ?>
                    <div id="preview">
                        <?php if(isset($image))
                                {
                                    echo $image;
                                }
                    ?>
                    </div><br>
                    <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="validate" value="Valider"/>
                    <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="save" value="Sauvegarder"/>
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