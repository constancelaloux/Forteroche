<?php
print_r($_SESSION);
?>
<header class="head" id="head">
    <div class="container-fluid">   
        <div class="row">
            <img src="/../../public/images/jean.jpg" class="img-fluid w-100" alt="Responsive image">
        </div>
    </div>
</header>

<section class="services-section pb-4" id="lastnews">
    <div class="container">
        <div class="row mb-4">
            <?php
            foreach ($lastsposts as $post) 
            {
            ?>
            <div class="col-lg-4">
                <div class="services-item p-2">
                    <img class="card-img-top img-responsive w-100" src="<?= $post->image() ?>" alt="Card image cap">
                    <strong class="d-inline-block mb-2 text-danger">Derniers chapitres</strong>
                    <h3><?= $post->subject() ?></h3>
                    <p><?php if (strlen($post->content()) <= 400)
                        {
                            echo $post->content();
                        }
                    else
                        {
                            //Returns the portion of string specified by the start and length parameters.
                            $debut = substr($post->content(), 0, 400);
                            $debut = substr($debut, 0, strrpos($debut, ' ')) . '...';

                            echo $debut;
                        }?>
                        
                    <a href="/article&id=<?=$post->id()?>" class="text-danger">Lire la suite</a></p>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<section class="container pb-4 mb-4" id="allchapters">   
    <div class="row">
        <div class="col-lg-12">
            <div class="row mb-2">
                <div class="col-lg-12">
                    <h2 class="display-4 font-italic">Tous les chapitres</h2>
                </div>
            </div>

            <div class="row mb-4">
                <?php          
                if(empty($posts))
                {
                ?>
                    <p>Aucun article n'a encore été posté. Soyez le premier à en laisser un !</p>
                <?php
                }
                else 
                {
                ?>           
                    <?php
                    foreach($posts as $post) 
                    {
                     ?>
                    <div class="col-lg-4">
                        <div class="cards h-100">
                            <div class="overlay-image">
                                <img class="card-img-top img-responsive w-100" src="<?= $post->image() ?>" alt="Card image cap">
                                <div class="overlay-item-caption smoothie"></div>
                                <div class="hover-item-caption smoothie">
                                    <h3 class="text"><a href="/article&id=<?=$post->id()?>" class="stretched-link" title="view article">View</a></h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <strong class="d-inline-block mb-2 text-danger"><?= $post->subject() ?></strong>
                                <h3 class="card-title"><strong>Card title that wraps to a new line</strong></h3>
                                <div class="mb-1 text-muted"><?=$post->createdate()->format('Y-m-d')?> Posté par Jean Forteroche</div>
                            </div>
                        </div>  
                    </div>
                    <?php
                    }
                }
                ?>
            </div>
            <div class="row justify-content-center">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=<?php echo $previouslink ?>">Prévious</a></li>
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=1">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link text-danger" href="/articles&page=2">
                                2
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=3">3</a></li>
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=<?php echo $nextlink ?>">Next</a></li>
                    </ul>
                </nav>
            </div>
        </div>    
    </div>
</section>

<section class="librairie pb-4">
    <div class="jumbotron jumbotron-fluid mb-4 " id="jumbotron">
        <div class="container">
            <div class="row mb-4"> <!-- justify-content-center">-->
                <div class="col-lg-12">
                    <h2 class="display-4 font-italic text-white bg-danger">Vous aimerez aussi</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top img-responsive" src="/../../public/images/livre.png" alt="Card image fluid" >
                        <div class="card-body bg-white">
                            <div class="mb-1 text-muted">Tourisme littéraire</div>
                            <h3 class="card-title"><strong>Conseils camping pour la montagne</strong></h3>
                            <a href="/article" class="stretched-link">Acheter</a>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top img-responsive w-100" src="/../../public/images/livre2.jpg" alt="Card image cap">
                        <div class="card-body bg-white">
                            <div class="mb-1 text-muted">Tourisme littéraire</div>
                            <h3 class="card-title"><strong>Voyage au coeur de la montagne</strong></h3>
                            <a href="/article" class="stretched-link">Acheter</a>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top img-responsive w-100" src="/../../public/images/livre3.jpg" alt="Card image cap">
                        <div class="card-body bg-white">
                            <div class="mb-1 text-muted">Tourisme littéraire</div>
                            <h3 class="card-title"><strong>Conseils photo pour les voyageurs</strong></h3>
                            <a href="/article" class="stretched-link">Acheter</a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact pb-4" id="contact">
    <div class="container rounded mb-4 ">
        <div class="row justify-content-center">
            <div class="col-lg-6 pb-4">
                <form>
                    <h2 class="display-4 font-italic">Contactez nous</h2>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <aside class="col-lg-6 col-md-12 col-sm-12 blog-sidebar">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <p>Du lundi au vendredi</p>
                    </div>
                    <div class="col-lg-4">
                        <p>9h00 - 18h00</p>
                    </div>
                    <div class="col-lg-4">
                        <p>+41 23 40 19</p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16282291.90687623!2d-176.5259279963209!3d60.121384562730476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5400df9cc0aec01b%3A0xbcdb5e27a98adb35!2sAlaska%2C%20%C3%89tats-Unis!5e0!3m2!1sfr!2sfr!4v1588862030775!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </aside>
        </div>
    </div>
</section>

<script>
$('#spy').scrollspy({ target: '#navbar' });
</script>