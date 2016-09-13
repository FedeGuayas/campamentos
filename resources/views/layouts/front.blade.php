<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Campamentos Deportivos</title>

    <!-- Font Awesome -->
    {!! Html::style('css/font-awesome.min.css') !!}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">--}}


    <!-- Bootstrap core CSS -->
    {!! Html::style('css/bootstrap.min.css') !!}
    {{--<link href="css/bootstrap.min.css" rel="stylesheet">--}}

    <!-- Material Design Bootstrap -->
    {!! Html::style('css/mdb.min.css') !!}
    {{--<link href="css/mdb.min.css" rel="stylesheet">--}}

    {!! Html::style('css/bootstrap-social.css') !!}

    <!-- Your custom styles (optional) -->
    {!! Html::style('css/style.css') !!}
    {{--<link href="css/style.css" rel="stylesheet">--}}




</head>

<body>


<!--Navbar-->
<nav class="navbar navbar-dark navbar-fixed-top scrolling-navbar">

    <!-- Collapse button-->
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx">
        <i class="fa fa-bars"></i>
    </button>

    <div class="container">

        <!--Collapse content-->
        <div class="collapse navbar-toggleable-xs" id="collapseEx">
            <!--Navbar Brand-->
            <a class="navbar-brand" href="http://mdbootstrap.com/material-design-for-bootstrap/" target="_blank">MDB</a>
            <!--Links-->
            <ul class="nav navbar-nav smooth-scroll">
                <li class="nav-item active">
                    <a class="nav-link" href="#home">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#best-features">Disciplinas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#examples-of-use">Ejemplos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#testimonials">Opiniones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pricing">Precios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contacto</a>
                </li>
            </ul>
        </div>
        <!--/.Collapse content-->

    </div>

</nav>
<!--/.Navbar-->

<!--Mask-->
<div class="view hm-black-strong">
    <div class="full-bg-img flex-center">
        <div class="container">
            <div class="row" id="home">

                <!--First column-->
                <div class="col-lg-6">
                    <div class="description">
                        <h2 class="h2-responsive wow fadeInLeft">Campamentos Deportivos</h2>
                        <hr class="hr-dark">
                        <p class="wow fadeInLeft" data-wow-delay="0.4s">En estos campamentos podrás conocer muchos deportes y aprender junto a los entrenadores que forman a nuestros campeones Nacionales, Sudamericanos, Bolivarianos, Panamericanos y Mundiales; ...</p>
                        <br>
                        <a class="btn btn-ptc wow fadeInLeft" data-wow-delay="0.7s">Leer más</a>
                    </div>
                </div>
                <!--/.First column-->

                <!--Second column-->
                <div class="col-lg-6">
                    <!--Form-->
                    <div class="card wow fadeInRight">
                        <div class="card-block">
                            <!--Header-->
                            <div class="text-xs-center">
                                <h3><i class="fa fa-user"></i> Registrarse con:</h3>

                                <a href="" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                                <a href="" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                                <a href="" class="btn btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
                                <hr>
                                <h3>O:</h3>
                            </div>

                            <!--Body-->
                            <div class="md-form">
                                <i class="fa fa-envelope prefix"></i>
                                <input type="text" id="form2" class="form-control">
                                <label for="form2">Su email</label>
                            </div>

                            <div class="md-form">
                                <i class="fa fa-lock prefix"></i>
                                <input type="password" id="form4" class="form-control">
                                <label for="form4">Password</label>
                            </div>

                            <div class="text-xs-center">
                                <button class="btn btn-ptc btn-lg">Entrar</button>
                                <hr>
                                <fieldset class="form-group">
                                    <input type="checkbox" id="checkbox1">
                                    <label for="checkbox1">Recordarme</label>
                                </fieldset>
                            </div>

                        </div>
                    </div>
                    <!--/.Form-->
                </div>
                <!--/Second column-->


            </div>
        </div>
    </div>
</div>
<!--/.Mask-->

<!--Main container-->
<div class="container">

    <div class="divider-new">
        <h2 class="h2-responsive wow fadeInDown">Algunas Disciplinas</h2>
    </div>

    <!--Section: Best features-->
    <section id="best-features">
        <div class="row">
            <!--First columnn-->
            <div class="col-md-4">

                <!--Card-->
                <div class="card">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="img/camp/nadador-min.jpg" class="img-fluid" alt="">
                        <a href="#">
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <div class="card-block text-xs-center">
                        <!--Title-->
                        <h4 class="card-title">Natación</h4><hr>
                        <!--Text-->
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        {{--<a href="#" class="btn btn-primary">Button</a>--}}
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

            </div>
            <!--First columnn-->

            <!--Second columnn-->
            <div class="col-md-4">

                <!--Card-->
                <div class="card">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="img/camp/atletismo-min.jpg" class="img-fluid" alt="">
                        <a href="#">
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <div class="card-block text-xs-center">
                        <!--Title-->
                        <h4 class="card-title">Atletismo</h4><hr>
                        <!--Text-->
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        {{--<a href="#" class="btn btn-primary">Button</a>--}}
                    </div>
                    <!--/.Card content-->
                    <!--/.First columnn-->

                </div>
                <!--/.Card-->

            </div>
            <!--Second columnn-->

            <!--Third columnn-->
            <div class="col-md-4">
                <!--Card-->
                <div class="card">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="img/camp/gimnasia-min.jpg" class="img-fluid" alt="">
                        <a href="#">
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <div class="card-block text-xs-center">
                        <!--Title-->
                        <h4 class="card-title">Gimnasia</h4><hr>
                        <!--Text-->
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        {{--<a href="#" class="btn btn-primary">Button</a>--}}
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->
            </div>
            <!--Third columnn-->
        </div>
    </section>
    <!--/Section: Best features-->


    <div class="divider-new">
        <h2 class="h2-responsive wow fadeInDown">Otras Disciplinas</h2>
    </div>

    <!--Section: Additional features-->
    <section id="additional-features">
        <div class="row">
            <!--First columnn-->
            <div class="col-md-6">

                <!--Card-->
                <div class="card">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="http://mdbootstrap.com/images/reg/reg%20(2).jpg" class="img-fluid" alt="">
                        <a href="#">
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Cras justo odio
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Dapibus ac facilisis in
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Morbi leo risus
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Cras justo odio
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Dapibus ac facilisis in
                        </li>
                    </ul>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

            </div>
            <!--First columnn-->

            <!--Second column-->
            <div class="col-md-6">

                <!--Card-->
                <div class="card">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="http://mdbootstrap.com/images/reg/reg%20(2).jpg" class="img-fluid" alt="">
                        <a href="#">
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Cras justo odio
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Dapibus ac facilisis in
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Morbi leo risus
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Cras justo odio
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check pull-xs-right"></i> Dapibus ac facilisis in
                        </li>
                    </ul>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

            </div>
            <!--/Second column-->
        </div>
    </section>
    <!--/Section: Additional features-->


    <div class="divider-new">
        <h2 class="h2-responsive wow fadeInDown">Ejemplos de uso</h2>
    </div>

    <!--Section: Examples of use-->
    <section id="examples-of-use">
        <div class="row">
            <!--First column-->
            <div class="col-md-5 wow fadeIn">
                <h2 class="h2-responsive">Why is it so great?</h2>
                <hr>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus modi sint accusantium earum, quisquam dolore odit cumque magnam temporibus blanditiis, nostrum voluptas perferendis, iusto repellendus error corporis ex totam voluptatem.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus modi sint accusantium earum, quisquam dolore odit cumque magnam temporibus blanditiis, nostrum voluptas perferendis, iusto repellendus error corporis ex totam voluptatem.</p>
            </div>
            <!--/First column-->

            <!--Second column-->
            <div class="col-md-7">
                <!--Carousel Wrapper-->
                <div id="carousel-example-2" class="carousel slide carousel-fade wow fadeIn" data-wow-delay="0.3s" data-ride="carousel">
                    <!--Indicators-->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-2" data-slide-to="1"></li>
                        <li data-target="#carousel-example-2" data-slide-to="2"></li>
                    </ol>
                    <!--/.Indicators-->

                    <!--Slides-->
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img src="http://mdbootstrap.com/images/regular/city/img%20(3).jpg" alt="First slide">
                            <div class="carousel-caption">
                                <h3>Heading</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="http://mdbootstrap.com/images/regular/city/img%20(7).jpg" alt="Second slide">
                            <div class="carousel-caption">
                                <h3>Heading</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="http://mdbootstrap.com/images/regular/city/img%20(13).jpg" alt="Third slide">
                            <div class="carousel-caption">
                                <h3>Heading</h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                    <!--/.Slides-->

                    <!--Controls-->
                    <a class="left carousel-control" href="#carousel-example-2" role="button" data-slide="prev">
                        <span class="icon-prev" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-2" role="button" data-slide="next">
                        <span class="icon-next" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    <!--/.Controls-->
                </div>
                <!--/.Carousel Wrapper-->
            </div>
            <!--/Second column-->
        </div>
    </section>
    <!--/Section: Examples of use-->

    <div class="divider-new">
        <h2 class="h2-responsive wow fadeInDown">Opiniones</h2>
    </div>

    <!--Section: Testimonials-->
    <section id="testimonials">
        <div class="row">

            <!--Carousel Wrapper-->
            <div id="multi-item-example" class="carousel slide carousel-multi-item wow fadeIn" data-ride="carousel">

                <!--Controls-->
                <div class="controls-top">
                    <a class="btn-floating btn-small mdb-color" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                    <a class="btn-floating btn-small mdb-color" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </div>
                <!--/.Controls-->

                <!--Indicators-->
                <ol class="carousel-indicators">
                    <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
                    <li data-target="#multi-item-example" data-slide-to="1"></li>
                    <li data-target="#multi-item-example" data-slide-to="2"></li>
                </ol>
                <!--/.Indicators-->

                <!--Slides-->
                <div class="carousel-inner" role="listbox">

                    <!--First slide-->
                    <div class="carousel-item active">

                        <div class="col-md-4">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up green lighten-1">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/avatar-1.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                        <div class="col-md-4 hidden-sm-down">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up green darken-2">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/avatar-2.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                        <div class="col-md-4 hidden-sm-down">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up green darken-4">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/avatar-3.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                    </div>
                    <!--/.First slide-->

                    <!--Second slide-->
                    <div class="carousel-item">

                        <div class="col-md-4">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up blue lighten-1">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/team-avatar-1.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                        <div class="col-md-4 hidden-sm-down">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up blue darken-2">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/team-avatar-2.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                        <div class="col-md-4 hidden-sm-down">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up blue darken-4">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/team-avatar-3.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                    </div>
                    <!--/.Second slide-->

                    <!--Third slide-->
                    <div class="carousel-item">

                        <div class="col-md-4">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up indigo lighten-1">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/avatar-3.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                        <div class="col-md-4 hidden-sm-down">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up indigo darken-1">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/team-avatar-1.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                        <div class="col-md-4 hidden-sm-down">
                            <!--Card-->
                            <div class="card testimonial-card">

                                <!--Bacground color-->
                                <div class="card-up indigo darken-4">
                                </div>

                                <!--Avatar-->
                                <div class="avatar"><img src="http://mdbootstrap.com/wp-content/uploads/2015/10/team-avatar-2.jpg" class="img-circle img-responsive">
                                </div>

                                <div class="card-block">
                                    <!--Name-->
                                    <h4 class="card-title">Anna Doe</h4>
                                    <hr>
                                    <!--Quotation-->
                                    <p><i class="fa fa-quote-left"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eos, adipisci</p>
                                </div>

                            </div>
                            <!--/.Card-->
                        </div>

                    </div>
                    <!--/.Third slide-->

                </div>
                <!--/.Slides-->

            </div>
            <!--/.Carousel Wrapper-->

        </div>
    </section>
    <!--/Section: Testimonials-->

    <div class="divider-new">
        <h2 class="h2-responsive wow fadeInDown">Precios</h2>
    </div>

    <!--Section: Pricing v.1-->
    <section class="section">

        <!--Section heading-->
        <h1 class="section-heading">Our pricing plans v.1</h1>
        <!--Section description-->
        <p class="section-description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit, error amet numquam iure provident voluptate esse quasi, veritatis totam voluptas nostrum quisquam eum porro a pariatur accusamus veniam. Quia, minima?</p>

        <!--First row-->
        <div class="row">

            <!--First column-->
            <div class="col-lg-4 col-md-6 m-b-r">

                <!--Pricing card-->
                <div class="card pricing-card">
                    <!--Price-->
                    <div class="price header blue">
                        <h1>10</h1>
                        <div class="version">
                            <h5>Basic</h5>
                        </div>
                    </div>
                    <!--/.Price-->

                    <!--Features-->
                    <div class="card-block striped">
                        <ul>
                            <li>
                                <p><i class="fa fa-check"></i> 20 GB Of Storage</p>
                            </li>
                            <li>
                                <p><i class="fa fa-check"></i> 2 Email Accounts</p>
                            </li>
                            <li>
                                <p><i class="fa fa-times"></i> 24h Tech Support</p>
                            </li>
                            <li>
                                <p><i class="fa fa-times"></i> 300 GB Bandwidth</p>
                            </li>
                            <li>
                                <p><i class="fa fa-times"></i> User Management </p>
                            </li>
                        </ul>

                        <button class="btn btn-primary">Buy now</button>
                    </div>
                    <!--/.Features-->

                </div>
                <!--/.Pricing card-->

            </div>
            <!--/First column-->

            <!--Second column-->
            <div class="col-lg-4 col-md-6 m-b-r">

                <!--Pricing card-->
                <div class="card pricing-card">
                    <!--Price-->
                    <div class="price header indigo">
                        <h1>20</h1>
                        <div class="version">
                            <h5>Pro</h5>
                        </div>
                    </div>
                    <!--/.Price-->

                    <!--Features-->
                    <div class="card-block striped">
                        <ul>
                            <li>
                                <p><i class="fa fa-check"></i> 20 GB Of Storage</p>
                            </li>
                            <li>
                                <p><i class="fa fa-check"></i> 4 Email Accounts</p>
                            </li>
                            <li>
                                <p><i class="fa fa-check"></i> 24h Tech Support</p>
                            </li>
                            <li>
                                <p><i class="fa fa-times"></i> 300 GB Bandwidth</p>
                            </li>
                            <li>
                                <p><i class="fa fa-times"></i> User Management </p>
                            </li>
                        </ul>

                        <button class="btn btn-primary">Buy now</button>
                    </div>
                    <!--/.Features-->

                </div>
                <!--/.Pricing card-->

            </div>
            <!--/Second column-->

            <!--Third column-->
            <div class="col-lg-4 col-md-6 m-b-r">
                <!--Pricing card-->
                <div class="card pricing-card">
                    <!--Price-->
                    <div class="price header deep-purple">
                        <h1>30</h1>
                        <div class="version">
                            <h5>Enterprise</h5>
                        </div>
                    </div>
                    <!--/.Price-->

                    <!--Features-->
                    <div class="card-block striped">
                        <ul>
                            <li>
                                <p><i class="fa fa-check"></i> 30 GB Of Storage</p>
                            </li>
                            <li>
                                <p><i class="fa fa-check"></i> 5 Email Accounts</p>
                            </li>
                            <li>
                                <p><i class="fa fa-check"></i> 24h Tech Support</p>
                            </li>
                            <li>
                                <p><i class="fa fa-check"></i> 300 GB Bandwidth</p>
                            </li>
                            <li>
                                <p><i class="fa fa-check"></i> User Management </p>
                            </li>
                        </ul>

                        <button class="btn btn-primary">Buy now</button>
                    </div>
                    <!--/.Features-->

                </div>
                <!--/.Pricing card-->
            </div>
            <!--/Third column-->

        </div>
        <!--/First row-->

    </section>
    <!--/Section: Pricing v.1-->

    <div class="divider-new">
        <h2 class="h2-responsive">Contacto</h2>
    </div>

    <!--Section: Contact-->
    <section id="contact">
        <div class="row">
            <!--First column-->
            <div class="col-md-8">
                <div id="map-container" class="z-depth-1 wow fadeInUp" style="height: 300px"></div>
            </div>
            <!--/First column-->

            <!--Second column-->
            <div class="col-md-4">
                <ul class="text-xs-center">
                    <li class="wow fadeInUp" data-wow-delay="0.2s"><a class="btn-floating btn-small mdb-color"><i class="fa fa-map-marker"></i></a>
                        <p>New York, NY 10012, USA</p>
                    </li>

                    <li class="wow fadeInUp" data-wow-delay="0.3s"><a class="btn-floating btn-small mdb-color" data-toggle="modal" data-target="#contact-form"><i class="fa fa-phone"></i></a>
                        <p>+ 01 234 567 89</p>
                    </li>

                    <li class="wow fadeInUp" data-wow-delay="0.4s"><a class="btn-floating btn-small mdb-color" data-toggle="modal" data-target="#contact-form"><i class="fa fa-envelope"></i></a>
                        <p>contact@mdbootstrap.com</p>
                    </li>
                </ul>
            </div>
            <!--/Second column-->
        </div>
    </section>
    <!--Section: Contact-->

</div>
<!--/Main container-->

<!--Footer-->
<footer class="page-footer center-on-small-only">

    <!--Footer Links-->
    <div class="container-fluid">
        <div class="row">

            <!--First column-->
            <div class="col-md-3 offset-md-1">
                <h5 class="title">ABOUT MATERIAL DESIGN</h5>
                <p>Material Design (codenamed Quantum Paper) is a design language developed by Google. </p>

                <p>Material Design for Bootstrap (MDB) is a powerful Material Design UI KIT for most popular HTML, CSS, and JS framework - Bootstrap.</p>
            </div>
            <!--/.First column-->

            <hr class="hidden-md-up">

            <!--Second column-->
            <div class="col-md-2 offset-md-1">
                <h5 class="title">First column</h5>
                <ul>
                    <li><a href="#!">Link 1</a></li>
                    <li><a href="#!">Link 2</a></li>
                    <li><a href="#!">Link 3</a></li>
                    <li><a href="#!">Link 4</a></li>
                </ul>
            </div>
            <!--/.Second column-->

            <hr class="hidden-md-up">

            <!--Third column-->
            <div class="col-md-2">
                <h5 class="title">Second column</h5>
                <ul>
                    <li><a href="#!">Link 1</a></li>
                    <li><a href="#!">Link 2</a></li>
                    <li><a href="#!">Link 3</a></li>
                    <li><a href="#!">Link 4</a></li>
                </ul>
            </div>
            <!--/.Third column-->

            <hr class="hidden-md-up">

            <!--Fourth column-->
            <div class="col-md-2">
                <h5 class="title">Third column</h5>
                <ul>
                    <li><a href="#!">Link 1</a></li>
                    <li><a href="#!">Link 2</a></li>
                    <li><a href="#!">Link 3</a></li>
                    <li><a href="#!">Link 4</a></li>
                </ul>
            </div>
            <!--/.Fourth column-->

        </div>
    </div>
    <!--/.Footer Links-->

    <hr>

    <!--Call to action-->
    <div class="call-to-action">
        <h4>Material Design for Bootstrap</h4>
        <ul>
            <li>
                <h5>Get our UI KIT for free</h5></li>
            <li><a target="_blank" href="http://mdbootstrap.com/getting-started/" class="btn btn-danger">Sign up!</a></li>
            <li><a target="_blank" href="http://mdbootstrap.com/material-design-for-bootstrap/" class="btn btn-default">Learn more</a></li>
        </ul>
    </div>
    <!--/.Call to action-->

    <!--Copyright-->
    <div class="footer-copyright">
        <div class="container-fluid">
            © 2015 Copyright: <a href="http://www.MDBootstrap.com"> MDBootstrap.com </a>

        </div>
    </div>
    <!--/.Copyright-->

</footer>
<!--/.Footer-->









<!-- SCRIPTS -->

<!-- JQuery -->
{!! Html::script('js/jquery-3.1.0.min.js') !!}
{{--<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>--}}

<!-- Bootstrap tooltips -->
{!! Html::script('js/tether.min.js') !!}
{{--<script type="text/javascript" src="js/tether.min.js"></script>--}}

<!-- Bootstrap core JavaScript -->
{!! Html::script('js/bootstrap.min.js') !!}
{{--<script type="text/javascript" src="js/bootstrap.min.js"></script>--}}

<!-- MDB core JavaScript -->
{!! Html::script('js/mdb.min.js') !!}
{{--<script type="text/javascript" src="js/mdb.min.js"></script>--}}


        <!--Google Maps-->
<script src="http://maps.google.com/maps/api/js"></script>

<script>
    function init_map() {

        var var_location = new google.maps.LatLng(40.725118, -73.997699);

        var var_mapoptions = {
            center: var_location,

            zoom: 14
        };

        var var_marker = new google.maps.Marker({
            position: var_location,
            map: var_map,
            title: "New York"
        });

        var var_map = new google.maps.Map(document.getElementById("map-container"),
                var_mapoptions);

        var_marker.setMap(var_map);

    }

    google.maps.event.addDomListener(window, 'load', init_map);
</script>


<script>
    // SideNav init
    $(".button-collapse").sideNav();

    // Custom scrollbar init
    var el = document.querySelector('.custom-scrollbar');
    Ps.initialize(el);
</script>

</body>

</html>