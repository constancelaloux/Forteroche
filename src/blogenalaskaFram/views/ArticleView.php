<div class="section-article">
    <div class="container">
        <div class="row">
            <div class="blog-post col-lg-9">
                <?=print_r($post->id()); ?>
                <h2 class="blog-post-title"><?=$post->subject()?></h2>
                <p class="blog-post-meta"><?= $post->createdate()->format('Y-m-d') ?> par Jean Forteroche</p>
                <img class="card-img" src="<?=$post->image() ?>" alt="image article">
                <p><?=$post->content() ?></p>
                
                <nav class="blog-pagination text-center">
                    <a class="btn btn-outline-primary" href="<?php echo $previouslink?>">Précédent</a>
                    <a class="btn btn-outline-secondary" href="<?php echo $nextlink?>" tabindex="-1" aria-disabled="true">Suivant</a>
                </nav>
                
                <div class="comments">
                    <h2>Commentaires</h2>
         
                    <?php
                    if (isset($comments))
                    {
                        foreach ($comments as $comment) 
                        {
                        ?>
                        <div class="media mt-3">
                            <img src="<?php echo $comment->originalData->image?>" class="align-self-start mr-3 img-thumbnail" alt="image 1" width="100" height="50">
                            <div class="media-body">
                                <button class="reportComment" id=<?php echo $comment->id() ?>>Signaler à l'administrateur</button>
                                <h5 class="mt-0"><?php echo $comment->subject()?></h5>
                                <p><?php echo $comment->createdate()->format('Y-m-d')?></p>
                                <p><?php echo $comment->content()?></p>

                                <?php 
                                    if($comment->idclient() == $_SESSION['authorId'])
                                    {
                                ?>
                                    <form action="/article&id=<?php echo $post->id() ?>&idcomment=<?php echo $comment->id ?>" method="post">
                                        <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="modify" value="Modifier"/>
                                    </form>
                                    <form action="/deletecomment&id=<?php echo $post->id() ?>&idcomment=<?php echo $comment->id ?>" method="post">
                                        <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="delete" value="Supprimer"/>
                                    </form>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <?php
                        }
                    }
                    else 
                    {
                    ?>
                    <p>Il n'y a aucun commentaire pour cet article</p>
                    <?php
                    }
                        ?>

                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="/article&id=<?=$post->id?>&page=<?php echo $previouslink?>" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="/article&id=<?=$post->id?>&page=1">1</a></li>
                            <li class="page-item active">
                                <a class="page-link" href="/article&id=<?=$post->id?>&page=2">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="/article&id=<?=$post->id?>&page=3">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="/article&id=<?=$post->id?>&page=<?php echo $nextlink?>">Next</a>
                            </li>
                        </ul>
                    </nav>

                </div>
                <div class="form mb-4">
                    <h5>Laissez votre commentaire</h5>
                        <?php if (isset($form))
                        {
                        ?>
                            <form action="" method="post">
                                <!--<p>-->
                                <div class="text-center mb-4">
                                    <h1 class="h2 mb-3 font-weight-normal border-left border-info text-warning"><?php //echo $title ?></h1>
                                </div>
                                    <?php echo $form ?>
                                <input type="hidden" id="newFile" name="idpost" value="<?php echo $post->id?>"/>
                                <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="validate" value="Valider"/>
                                <!--</p>-->
                            </form>
                        <?php    
                        }
                        else
                        {
                        ?>
                            <p>Vous devez vous inscrire pour écrire un commentaire</p>
                        <?php
                        }
                        ?>
                </div><!-- /.blog-post --> 
            </div>
            
            <div class="col-lg-3 ml-auto">
                <aside class="sidebar">
                    <h4>Les derniers chapitres</h4>
                    <?php
                    foreach ($lastsposts as $post) 
                    {
                    ?>
                    <div class="card mb-4">
                        <div class="overlay-image">
                            <img src="<?= $post->image()?>" class="card-img-top" alt="image 1">
                            <div class="overlay-item-caption smoothie"></div>
                            <div class="hover-item-caption smoothie">
                                <h3 class="text"><a href="/article&id=<?=$post->id?>" class="stretched-link" title="view article">View</a></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->subject() ?></h5>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    
                </aside>
                <aside class="sidebar">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Suivez moi</h4>
                            <!--Facebook-->
                            <a class="fb-ic ml-0">
                                <i class="fab fa-facebook white-text mr-4"> </i>
                            </a>
                            <!--Twitter-->
                            <a class="tw-ic">
                                <i class="fab fa-twitter white-text mr-4"> </i>
                            </a>
                            <!--Google +-->
                            <a class="vkon-ic">
                                <i class="fab fa-vk white-text mr-4"> </i>
                            </a>
                            <!--Linkedin-->
                            <a class="li-ic">
                                <i class="fab fa-linkedin white-text mr-4"> </i>
                            </a>
                            <!--Instagram-->
                            <a class="ins-ic">
                                <i class="fab fa-instagram white-text mr-lg-4"> </i>
                            </a>
                        </div>
                    </div><!-- /.card -->
                </aside>
                <aside class="sidebar">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Les nouveautés</h4>
                        </div>
                        <img src="/../../public/images/livre.png" class="card-img-bottom" alt="image 3">
                    </div><!-- /.card -->
                </aside>
            </div>
        </div>
    </div>
</div>
