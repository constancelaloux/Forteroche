<?php /*session_start();
print_r($_SESSION["status"]);
    // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
    if($_SESSION["status"] != 'client' || session_status() === PHP_SESSION_NONE)
    {
        //$this->addFlash()->error('Votre compte a bien été créé');
        return $this->redirect('/connectform');
    }*/
print_r($_SESSION);
print_r($posts);
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
            <div class="col-lg-4">
                <div class="services-item p-2">
                    <img class="card-img-top img-responsive w-100" src="/../../public/images/presentation.jpg" alt="">
                    <strong class="d-inline-block mb-2 text-danger">Derniers aricles</strong>
                    <h3>Shooting</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                        magna aliqua. Quis ipsum suspendisse ultrices gravida.<a href="/article" class="text-danger">Lire la suite</a></p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="services-item p-2">
                    <img class="card-img-top img-responsive w-100" src="/../../public/images/kayak.jpg" alt="">
                    <strong class="d-inline-block mb-2 text-danger">Derniers articles</strong>
                    <h3>Videos</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                        magna aliqua. Quis ipsum suspendisse ultrices gravida.<a href="/article" class="text-danger">Lire la suite</a></p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="services-item p-2">
                    <img class="card-img-top img-responsive w-100" src="/../../public/images/lacsalaska.jpg" alt="">
                    <strong class="d-inline-block mb-2 text-danger">Derniers articles</strong>
                    <h3>Editing</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                    magna aliqua. Quis ipsum suspendisse ultrices gravida.<a href="/article" class="text-danger">Lire la suite</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container pb-4 mb-4" id="allchapters">   
    <div class="row">
        <div class="col-lg-12">
            <div class="row mb-2"> <!--justify-content-center">-->
                <div class="col-lg-12">
                    <h2 class="display-4 font-italic">Tous les chapitres</h2>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <div class="overlay-image">
                            <img class="card-img-top img-responsive w-100" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="Card image cap">
                            <div class="overlay-item-caption smoothie"></div>
                            <div class="hover-item-caption smoothie">
                                <h3 class="text"><a href="/article" class="stretched-link" title="view article">View</a></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 1</strong>
                            <h3 class="card-title"><strong>Card title that wraps to a new line</strong></h3>
                            <div class="mb-1 text-muted">12 Novembre 2020 Posted by Coach</div>
                            <!--<p class="card-text mb-4">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>-->
                            <!--<a href="/article" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <div class="overlay-image">
                            <img class="card-img-top" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513095416/IMG_7240_q9dadh.jpg" alt="Card image cap" alt="Card image cap">
                            <div class="overlay-item-caption smoothie"></div>
                            <div class="hover-item-caption smoothie">
                                <h3 class="text"><a href="/article" class="stretched-link" title="view article">View</a></h3>
                                <!--<div class="texte">Hello World</div>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 2</strong>
                            <h3 class="card-title">Card title that wraps to a new line</h3>
                            <div class="mb-1 text-muted">12 Novembre 2020 Posted by Coach</div>
                            <!--<p class="card-text mb-4">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <a href="/article" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <div class="overlay-image">
                            <img class="card-img-top img-responsive w-100" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="Card image cap">
                            <div class="overlay-item-caption smoothie"></div>
                            <div class="hover-item-caption smoothie">
                                <h3 class="text"><a href="/article" class="stretched-link" title="view article">View</a></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 3</strong>
                            <h3 class="card-title">Card title that wraps to a new line</h3>
                            <div class="mb-1 text-muted">12 Novembre 2020 Posted by Coach</div>
                            <!--<p class="card-text mb-4">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <a href="/article" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <div class="overlay-image">
                            <img class="card-img-top img-responsive w-100" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="Card image cap">
                            <div class="overlay-item-caption smoothie"></div>
                            <div class="hover-item-caption smoothie">
                                <h3 class="text"><a href="/article" class="stretched-link" title="view article">View</a></h3>
                                <!--<div class="texte">Hello World</div>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 4</strong>
                            <h3 class="card-title"><strong>Card title that wraps to a new line</strong></h3>
                            <div class="mb-1 text-muted">12 Novembre 2020 Posted by Coach</div>
                            <!--<p class="card-text mb-4">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <a href="/article" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>  
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <div class="overlay-image">
                            <img class="card-img-top" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513095416/IMG_7240_q9dadh.jpg" alt="Card image cap" alt="Card image cap">
                            <div class="overlay-item-caption smoothie"></div>
                            <div class="hover-item-caption smoothie">
                                <h3 class="text"><a href="/article" class="stretched-link" title="view article">View</a></h3>
                                <!--<div class="texte">Hello World</div>-->
                            </div>
                        </div>
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 5</strong>
                            <h3 class="card-title">Card title that wraps to a new line</h3>
                            <div class="mb-1 text-muted">12 Novembre 2020 Posted by Coach</div>
                            <!--<p class="card-text mb-4">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <a href="/article" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <div class="overlay-image">
                            <img class="card-img-top img-responsive w-100" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="Card image cap">
                            <div class="overlay-item-caption smoothie"></div>
                            <div class="hover-item-caption smoothie">
                                <h3 class="text"><a href="/article" class="stretched-link" title="view article">View</a></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 6</strong>
                            <h3 class="card-title">Card title that wraps to a new line</h3>
                            <div class="mb-1 text-muted">12 Novembre 2020 Posted by Coach</div>
                            <!--<p class="card-text mb-4">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <a href="/article" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="Card image cap">
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 7</strong>
                            <h3 class="card-title">Card title that wraps to a new line</h3>
                            <div class="mb-1 text-muted">12 Novembre 2020 Posted by Coach</div>
                            <!--<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <a href="/article" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top" src="https://via.placeholder.com/350x250" alt="Card image cap">
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 8</strong>
                            <h3 class="card-title">Card title that wraps to a new line</h3>
                            <div class="mb-1 text-muted">12 Novembre 2020 Posted by Coach</div>
                            <!--<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <a href="#" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cards h-100">
                        <img class="card-img-top" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513095416/IMG_7240_q9dadh.jpg" alt="Card image cap">
                        <div class="card-body">
                            <strong class="d-inline-block mb-2 text-danger">Chapitre 9</strong>
                            <h3 class="card-title">Card title that wraps to a new line</h3>
                            <div class="mb-1 text-muted">Nov 12</div>
                            <!--<p class="card-text mb-4">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                            <a href="/article" class="stretched-link">Continue reading</a>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link text-danger" href="#">Prévious</a></li>
                        <li class="page-item"><a class="page-link text-danger" href="/articles&page=1">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <span class="page-link text-danger">
                                2
                                <span class="sr-only">(current)</span>
                            </span>
                        </li>
                        <li class="page-item"><a class="page-link text-danger" href="#">3</a></li>
                        <li class="page-item"><a class="page-link text-danger" href="#">Next</a></li>
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

<!--<div class="background" style="background-image:url(/../../public/images/librairie.jpg);"></div>-->
<!--<img src="/../../public/images/librairie.jpg" class="img-fluid w-100" alt="Responsive image">-->
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
                    <!--<div class="p-4 mb-3 rounded">-->
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
<!--</div>-->

<script>
$('#spy').scrollspy({ target: '#navbar' });
</script>
  <!--<div class="jumbotron p-4 p-md-5 text-white rounded">
    <div class="card col-lg-8 bg-dark">
        <div class="row no-gutters align-items-center">
            <div class="col-lg-5">
                <img class="card-img" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="Card image cap">
            </div>
            <div class="col-lg-7">
                <div class="card-body">
                    <h1 class="card-title font-italic">A la une</h1>
                    <h5 class="card-title">Qui suis-je ?</h5>
                    <p class="card-text">Je m'appelle Jean Forteroche et je suis partie faire une traversée de l'Alaska pendant un an et demi...</p>
                    <p class="card-text"><small class="text-white">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>
    </div>
</div>-->
  
  

<!--<div class="container-fluid">
    <div class="row mb-2 justify-content-center">
        <h2 class="display-4 font-italic">Les derniers avis de nos lecteurs</h2>
    </div>
    <div class="row mb-4">
        <div class="col-lg-4 col-sm-12 col-md-12">
            <div class="card mb-3 shadow-sm">
              <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/../../public/images/personne.png" class="img-thumbnail rounded-circle" alt="photo1">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content...</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12 col-md-12">
            <div class="card mb-3 shadow-sm">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/../../public/images/personne.png" class="img-thumbnail rounded-circle" alt="photo2">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content...</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="col-lg-4 col-sm-12 col-md-12">
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="/../../public/images/personne.png" class="img-thumbnail mr-3 rounded-circle" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content...</p>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>-->


<!--Aside-->
<!--<aside class="col-lg-3 col-md-12 col-sm-12 blog-sidebar">
    <div class="p-4 mb-3 rounded">
        <h4 class="mb-3 font-italic">Les derniers articles</h4>
        <div class="media">
            <div class="pull-left">
                <img class="img-thumbnail mr-3" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="" width="80" height="80">
            </div>
            <div class="media-body">
                <span class="media-heading"><a href="#">Panic In London</a></span>
                <small class="muted">Posted 14 April 2019</small>
            </div>
        </div>
        <div class="media">
            <div class="pull-left">
                <img class="img-thumbnail mr-3" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="" width="80" height="80">
            </div>
            <div class="media-body">
                <span class="media-heading"><a href="#">Panic In London</a></span>
                <small class="muted">Posted 14 April 2019</small>
            </div>
        </div>
        <div class="media">
            <div class="pull-left">
                <img class="img-thumbnail mr-3" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="" width="80" height="80">
            </div>
            <div class="media-body">
                <span class="media-heading"><a href="#">Panic In London</a></span>
                <small class="muted">Posted 14 April 2019</small>
            </div>
        </div>
        <div class="media">
            <div class="pull-left">
                <img class="img-thumbnail mr-3" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="" width="80" height="80">
            </div>
            <div class="media-body">
                <span class="media-heading"><a href="#">Panic In London</a></span>
                <small class="muted">Posted 14 April 2019</small>
            </div>
        </div>
        <div class="media">
            <div class="pull-left">
                <img class="img-thumbnail mr-3" src="https://res.cloudinary.com/sepuckett86/image/upload/v1513176680/IMG_5837_xicdt5.jpg" alt="" width="80" height="80">
            </div>
            <div class="media-body">
                <span class="media-heading"><a href="#">Panic In London</a></span>
                <small class="muted">Posted 14 April 2019</small>
            </div>
        </div>
        <div class="p-4">
            <h4 class="font-italic">Archives</h4>
            <ol class="list-unstyled mb-0">
                <li><a href="#">March 2014</a></li>
                <li><a href="#">February 2014</a></li>
                <li><a href="#">January 2014</a></li>
                <li><a href="#">December 2013</a></li>
                <li><a href="#">November 2013</a></li>
                <li><a href="#">October 2013</a></li>
                <li><a href="#">September 2013</a></li>
                <li><a href="#">August 2013</a></li>
                <li><a href="#">July 2013</a></li>
                <li><a href="#">June 2013</a></li>
                <li><a href="#">May 2013</a></li>
                <li><a href="#">April 2013</a></li>
            </ol>
        </div>

        <div class="p-4">
            <h4 class="font-italic">Suivez moi</h4>
            <ol class="list-unstyled">
                <li><a href="#">GitHub</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Facebook</a></li>
            </ol>
        </div>
    </div>         
</aside><!-- /.blog-sidebar -->  


                        <!--<h4 class="font-italic">Suivez moi</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">GitHub</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                        </ol>-->
                    <!--</div>-->