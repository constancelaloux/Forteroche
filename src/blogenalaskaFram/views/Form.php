    <section class="createAuthorForm">
        <div class="container">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="FormImg">
                    <img src="/../../public/images/logo.png" alt="photo de montagne" />
                    </div>
                    <div class="formTitle">
                        <h1><?php echo $title ?></h1>
                    </div>
                    <form action="" method="post">
                    <!--<p>-->
                        <?php echo $form ?>
 
                    <!--<input type="submit" value="Ajouter" />-->
                    <button type= "submit" class="btn btn-primary btn-round btn-lg btn-block">Valider</button>
                    <!--</p>-->
                    </form>


                    <a class="connectForm" href="<?php echo $url ?>"><?php echo $p ?></a>
                    <a class="BackToBlog" href="/">Retour vers le blog</a>
                    <p>username = Jean_Forteroche
                    password = @jeanF38</p>
            </div>
        </div>
    </section>
