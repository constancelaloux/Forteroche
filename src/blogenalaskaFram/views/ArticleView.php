<?php /*session_start();
    // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
    if(!$_SESSION["status"] === 'client' || session_status() === PHP_SESSION_NONE)
    {
        $this->addFlash()->error('Votre compte a bien été créé');
        return $this->redirect('/connectform');
    }*/
//print_r($_SESSION);
?>
<div class="section-article">
    <div class="container">
        <div class="row">
            <div class="blog-post col-lg-9">
                <h2 class="blog-post-title"><?=$post->subject ?></h2>
                <p class="blog-post-meta"><?= $post->createdate->format('Y-m-d') ?> by <a href="#">Mark</a></p>
                <!--<p class="blog-post-meta">January 1, 2014 by <a href="#">Mark</a></p>-->
                <img class="card-img" src="<?=$post->image ?>" alt="image article">
                <p><?=$post->content ?><!--This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>
                <hr>
                <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
                <blockquote>
                    <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong> ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                </blockquote>
                <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
                <h2>Heading</h2>
                <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                <h3>Sub-heading</h3>
                <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                <pre><code>Example code block</code></pre>
                <p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
                <h3>Sub-heading</h3>
                <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
                <ul>
                    <li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
                    <li>Donec id elit non mi porta gravida at eget metus.</li>
                    <li>Nulla vitae elit libero, a pharetra augue.</li>
                </ul>
                <p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.</p>
                <ol>
                    <li>Vestibulum id ligula porta felis euismod semper.</li>
                    <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
                    <li>Maecenas sed diam eget risus varius blandit sit amet non magna.</li>
                </ol>
                <p>Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.--></p>
                
                <nav class="blog-pagination text-center">
                    <a class="btn btn-outline-primary" href="<?php echo $previouslink?>">Précédent</a>
                    <a class="btn btn-outline-secondary" href="<?php echo $nextlink?>" tabindex="-1" aria-disabled="true">Suivant</a>
                </nav>
                
                <div class="comments">
                    <h2>Commentaires</h2>
         
                    <?php
                    foreach ($comments as $comment) 
                    {
                        //print_r($comment);
                        //print_r($comment->image);
                        //print_r($comment->image);
                        //die('meurs');
                    ?>
                    <div class="media mt-3">
                        <img src="<?php echo $comment->image?>" class="align-self-start mr-3 img-thumbnail" alt="image 1" width="100" height="50">
                        <div class="media-body">
                            <h5 class="mt-0"><?php echo $comment->subject?></h5>
                            <p><?php echo $comment->content?></p>
                            <!--<p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            <p>Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>-->
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <!--<div class="media mt-3">
                        <img src="/../../public/images/personne.png" class="align-self-start mr-3 img-thumbnail" alt=".image 2" width="100" height="50">
                        <div class="media-body">
                            <h5 class="mt-0">Top-aligned media</h5>
                            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            <p>Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                        </div>
                    </div>
                    <div class="media mt-3">
                        <img src="/../../public/images/personne.png" class="align-self-start mr-3 img-thumbnail" alt="image 3" width="100" height="50">
                        <div class="media-body">
                            <h5 class="mt-0">Top-aligned media</h5>
                            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            <p>Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                        </div>
                    </div>
                    <div class="media mt-3">
                        <img src="/../../public/images/personne.png" class="align-self-start mr-3 img-thumbnail" alt="image 4" width="100" height="50">
                        <div class="media-body">
                            <h5 class="mt-0">Top-aligned media</h5>
                            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            <p>Donec sed odio dui. Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                        </div>
                    </div>-->
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
                                    <!--<input type="text" class="form-control" id="name" name="name" placeholder="Your name">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Your email">
                                    <textarea class="form-control mt-3" rows="3" placeholder="Write a response.."></textarea>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">Upload file</button>
                                <div class="preview">
                                    <img class="mb-1" id="image" src="/../../public/images/upload.png"  alt="photo de montagne"> 
                                </div>-->
                                <input type="hidden" id="newFile" name="idpost" value="<?php echo $post->id?>"/>
                                <input type = "submit" class="btn btn-primary btn-round btn-lg btn-block" name="validate" value="Valider"/>
                                <!--<button type= "submit" class="btn btn-primary btn-round btn-lg btn-block">Valider</button>-->
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
                        <img src="<?= $post->image ?>" class="card-img-top" alt="image 1">
                        <div class="card-body">
                            <h5 class="card-title"><?= $post->subject ?></h5>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <!--<div class="card mb-4">
                        <img src="/../../public/images/presentation.jpg" class="card-img-top" alt="image 2">
                        <div class="card-body">
                            <h5 class="card-title">Chapitre 2</h5>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <img src="/../../public/images/lacsalaska.jpg" class="card-img-top" alt="image 3">
                        <div class="card-body">
                            <h5 class="card-title">Chapitre 3</h5>
                        </div>
                    </div>-->
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

