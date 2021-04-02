<?php $this->load->view('archivos/typehtml') ?>
<html lang="<?php $this->load->view('archivos/lang') ?>">

<head>
    <meta charset="utf-8">
    <title><?= $idimportadora->nombre ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap style -->
    <link id="callCss" rel="stylesheet" href="<?= base_url() ?>static/shop/themes/bootshop/bootstrap.min.css"
        media="screen" />
    <link href="<?= base_url() ?>static/shop/themes/css/base.css" rel="stylesheet" media="screen" />
    <!-- Bootstrap style responsive -->
    <link href="<?= base_url() ?>static/shop/themes/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>static/shop/themes/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url() ?>static/font-awesome/css/font-awesome.css">
    <!-- Google-code-prettify -->
    <link href="<?= base_url() ?>static/shop/themes/js/google-code-prettify/prettify.css" rel="stylesheet" />
    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="<?= base_url() ?>static/imagen/importadora.png">
    <style>
    #header {
        background: #f8f8f8 !important;
    }

    #carouselBlk {
        background: white !important;
        padding-top: 40px;
        padding-bottom: 40px;
    }

    #mainBody {
        border-top: 0px solid #dedede;
    }

    .modal-body {
        text-align: center;
    }
    </style>
</head>

<body>
    <div id="header">
        <div class="container">
            <div id="welcomeLine" class="row">
                <div class="span6"></div>
                <div class="span6">
                    <div class="pull-right">
                        <a href="<?= base_url('menu/checkout') ?>"><span class="btn btn-mini btn-primary"><i
                                    class="icon-shopping-cart icon-white"></i> [
                                <?= ($this->session->userdata('carrito')==null?0:count($this->session->userdata('carrito'))) ?>
                                ] Producto(s) añadido </span> </a>
                    </div>
                </div>
            </div>
            <!-- Navbar ================================================== -->
            <div id="logoArea" class="navbar">
                <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-inner">
                    <a class="brand" href="<?= base_url() ?>" style="color:white"><?= $idimportadora->nombre ?></a>

                    <ul id="topMenu" class="nav pull-right">
                        <li class=""><a href="<?= base_url() ?>">Productos</a></li>
                        <li class="">
                            <a href="<?= base_url('login') ?>" style="padding-right:0"><span
                                    class="btn btn-large btn-success">Iniciar sesión</span></a>

                            <!--
                            <a href="#login" role="button" data-toggle="modal" style="padding-right:0"><span class="btn btn-large btn-success">Iniciar sesión</span></a>


                        -->
                            <div id="login" class="modal hide fade in" tabindex="-1" role="dialog"
                                aria-labelledby="login" aria-hidden="false">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">×</button>
                                    <h3>Iniciar sesión</h3>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal loginFrm">
                                        <div class="control-group">
                                            <input type="text" id="inputEmail" placeholder="Email">
                                        </div>
                                        <div class="control-group">
                                            <input type="password" id="inputPassword" placeholder="Password">
                                        </div>
                                    </form>
                                    <button type="submit" class="btn btn-success">Ingresar</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <style>
        #logo-home div div div {
            text-align:center
        }
    </style>
    <section id="logo-home">
        <div class="container">
            <div class="row">
                <div class=" text-center">
                <img style="width:20%" src="<?= base_url() ?>static/banner/logojhael.png" alt="" />
                </div>
            </div>
        </div>
    </section>
    <!-- Header End====================================================================== -->
    <div id="carouselBlk">
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <img style="width:100%" src="<?= base_url() ?>static/banner/carrousel-3-new.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <img style="width:100%" src="<?= base_url() ?>static/banner/carrousel-5-new.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <img style="width:100%" src="<?= base_url() ?>static/banner/carrousel-7-new.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <img style="width:100%" src="<?= base_url() ?>static/banner/carrousel-10-new.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <img style="width:100%" src="<?= base_url() ?>static/banner/carrousel-19-new.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <img style="width:100%" src="<?= base_url() ?>static/banner/carrousel-20-new.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <img style="width:100%" src="<?= base_url() ?>static/banner/carrousel-21-new.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <img style="width:100%" src="<?= base_url() ?>static/banner/kitton-img-5.png" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>
    </div>
    <div id="mainBody">
        <div class="container">
            <div class="row">
                <!-- Sidebar ================================================== -->
                <div id="sidebar" class="span3">
                    <?php if($this->session->userdata('carrito')!=null){ ?>
                    <div class="well well-small">
                        <img src="<?= base_url() ?>static/shop/themes/images/ico-cart.png"
                            alt="producto(s) añadidos"><?= count($this->session->userdata('carrito')) ?> Item(s)
                        <a href="<?= base_url('menu/checkout') ?>" class="btn btn-warning pull-right">Comprar <i
                                class="icon-shopping-cart"></i></a>
                    </div>
                    <?php } ?>

                    <ul id="sideManu" class="nav nav-tabs nav-stacked">
                        <li class="subMenu open"><a> Filtrado por marcas</a>
                            <ul>
                                <?php foreach ($marca as $key => $x) { ?>
                                <li><a href="<?= base_url('menu/shop/'.$x->idmarca) ?>"><i
                                            class="icon-chevron-right"></i><?= $x->nommarca ?> (<?= $x->num ?>)</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                    <br />
                    <div id="myCarousel_2" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-4-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-1-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-2-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-6-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-8-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-9-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-11-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-12-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-13-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-14-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-15-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-16-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-17-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="item">
                                <div class="">
                                    <img style="width:100%" src="<?= base_url() ?>static/banner/slider/carrousel-18-new.jpg"
                                        alt="" />
                                </div>
                            </div>
                            
                        </div>
                        <a class="left carousel-control" href="#myCarousel_2" data-slide="prev">&lsaquo;</a>
                        <a class="right carousel-control" href="#myCarousel_2" data-slide="next">&rsaquo;</a>
                    </div>
                </div>
                <!-- Sidebar end=============================================== -->
                <div class="span9">
                    <h4>Mercadería
                        <?= isset($marca_2->nombre)==false?'':(' - '.$marca_2->nombre.' <a class="label label-danger" href="'.base_url('menu/shop').'">Quitar filtro</a> ') ?>
                    </h4>
                    <ul class="thumbnails" id="tbody_">
                        <?php foreach ($inventario as $key => $x) { ?>
                        <li class="span3">
                            <div class="thumbnail">
                                <img src="<?= base_url(($x->imagen==''?'static/imagen/img_not.png':$x->imagen)) ?>"
                                    alt="" />
                                <div class="caption" style="text-align:center">
                                    <h5><?= $x->modelo ?> </h5>
                                    <p>
                                        <?= $x->nommarca ?> -
                                        <strong style="text-align:center" class="text-center">
                                            $<?= $x->precio_venta ?>
                                        </strong>
                                    </p>
                                    <h4 style="text-align:center">

                                        <?php if($this->session->userdata('carrito')!=null){ ?>
                                        <?php if (existeCarrito($x->idinventario_mercaderia)=='1') { ?>
                                        <a class="btn btn-success disabled">Añadido <i class="icon-shopping-cart"></i></a>
                                        <a href="<?= base_url('menu/delete/'.$x->idinventario_mercaderia) ?>"
                                            class="btn btn-danger"><i class="fa fa-remove"></i></a>
                                        <?php }else{ ?>
                                        <a class="btn btn-primary"
                                            href="<?= base_url('menu/add/'.$x->idinventario_mercaderia) ?>">Agregar al
                                            carrito <i class="icon-shopping-cart"></i></a>
                                        <?php } ?>
                                        <?php } else{ ?>
                                        <a class="btn btn-primary"
                                            href="<?= base_url('menu/add/'.$x->idinventario_mercaderia) ?>">Agregar al
                                            carrito <i class="icon-shopping-cart"></i></a>
                                        <?php } ?>
                                        <button type="button" rel="action" class="btn btn-info btn-lg" data-json='<?= json_encode($x) ?>' ><i class="icon-list"></i></button>
                                    </h4>
                                </div>
                            </div>
                        </li>
                        <?php } ?>

                    </ul>

                </div>
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" id="titulo_shop">Modal Header</h4>
                        </div>
                        <div class="modal-body">
                        <div class="">
                    <div class="col-md-6 product_img">
                        <img width="190" id="imagen_shop" src="http://img.bbystatic.com/BestBuy_US/images/products/5613/5613060_sd.jpg" class="img-responsive">
                    </div>
                    <div class="col-md-6 product_content">
                        <h4 id="nombre_shop"></h4>
                        
                        <p id="descripcion_shop">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                        <h3 class="cost" id="precio_shop"></h3>
                        
                    </div>
                </div>
                        </div>
                        </div>

                    </div>
                </div>
                <style>
                #services {
                    margin-left: auto;
                    margin-right: auto;
                    text-align: center;
                    background-color: #f4f4f4;
                }

                #contacto,
                #services .container {
                    padding-bottom: 60px;
                    padding-top: 40px;

                }

                #footerSection {
                    margin-top: 0px;
                }
                .text-center{
                    text-align: center;
                }
                </style>

            </div>
        </div>
        <section id="services">
            <div class="container">
                <div class="row">
                    <div class=" text-center">
                        <h2 class="section-heading text-uppercase">Principios</h2>
                        <!--<h3 class="section-subheading text-muted">Nuestros principios</h3>-->
                    </div>
                </div>
                <div class="row text-center">
                    <div class="span4">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-free-code-camp fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="service-heading">VISIÓN </h4>
                        <p class="text-muted">Somos una empresa que brinda excelentes servicios a la comunidad
                            ofreciendo para ello comodidad al cliente con los mejores precios accesibles del mercado,
                            buscando satisfacer su necesidad con productos de calidad y útil a las familias, amigos y
                            personas en general.</p>
                    </div>
                    <div class="span4">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-american-sign-language-interpreting fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="service-heading">MISIÓN</h4>
                        <p class="text-muted">Ser reconocidos al nivel Nacional en la comercialización de
                            electrodomésticos, muebles, electrónicos y productos para la agricultura, para emprender
                            pequeños negocios comerciales como para pequeñas industrias, con productos de excelente
                            calidad con un alto nivel de servicio, comodidad y sobre todo el buen trato a los
                            trabajadores como a nuestros clientes.</p>
                    </div>
                    <div class="span4">
                        <span class="fa-stack fa-4x">
                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                            <i class="fa fa-certificate fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="service-heading">NUESTROS VALORES</h4>
                        <p class="text-muted">
                        <ul class="list-group">
                            <li class="list-group-item"> Somos una empresa responsabilidad</li>
                            <li class="list-group-item"> Mostramos honestidad e integridad</li>
                            <li class="list-group-item"> Trabajamos en equipó</li>
                            <li class="list-group-item"> Damos cumplimiento a las leyes</li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <section id="contacto">
            <div class="container">
                <div class="row">
                    <div class=" text-center">
                        <h2 class="section-heading text-uppercase">Contacto</h2>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="span12">
                        <p class="text-muted">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d996.6196093314122!2d-79.3053427!3d-2.3445365!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d2abf07f2921d7%3A0x52976eb412a4fbf5!2sCreditos%20Jha-el!5e0!3m2!1ses-419!2sec!4v1611598302976!5m2!1ses-419!2sec"
                                width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                                aria-hidden="false" tabindex="0"></iframe>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Footer ================================================================== -->
    <div id="footerSection">
        <div class="container">
            <div class="row">
                <div class="span6">
                    <h5>Contacto</h5>
                    Dirección: <i class="fa fa-map-marker"></i> <?= $idimportadora->direccion ?><br>
                    Correo: <i class="fa fa-envelope"></i> <?= $idimportadora->correo ?><br>
                    Whatsapp: <i class="fa fa-whatsapp"></i> 0991043411<br>
                </div>
                <div id="socialMedia" class="span3 pull-right">
                    <h5>Redes sociales </h5>
                    <a href="https://www.facebook.com/comercialjhael/"><i class="fa fa-facebook-f fa-2x"></i></a>
                </div>
            </div>
        </div><!-- Container End -->
    </div>
    <!-- Placed at the end of the document so the pages load faster ============================================= -->
    <script src="<?= base_url() ?>static/shop/themes/js/jquery.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>static/shop/themes/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>static/shop/themes/js/google-code-prettify/prettify.js"></script>

    <script src="<?= base_url() ?>static/shop/themes/js/bootshop.js"></script>
    <script src="<?= base_url() ?>static/shop/themes/js/jquery.lightbox-0.5.js"></script>
    <script>
    $(function(){
        $('#tbody_').on('click', 'button[rel="action"]', function () {
            var data = $(this).data('json');
            $('#imagen_shop').attr('src','<?= base_url() ?>'+(data.imagen==null?'static/imagen/img_not.png':data.imagen));
            $('#nombre_shop').html(data.modelo+' - '+data.nommarca);
            $('#titulo_shop').html('Descripción del artículo');
            $('#precio_shop').html('$ '+data.precio_venta);
            $('#descripcion_shop').html(data.descripcion);
            
            $('#myModal').modal('show')
        })
    })
    </script>
</body>

</html>