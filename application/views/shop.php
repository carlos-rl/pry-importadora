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
                                    class="icon-shopping-cart icon-white"></i> [ <?= ($this->session->userdata('carrito')==null?0:count($this->session->userdata('carrito'))) ?> ] Producto(s) añadido </span> </a>
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
    <!-- Header End====================================================================== -->
    <div id="carouselBlk">
        <div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <img style="width:100%"
                            src="<?= base_url() ?>static/shop/themes/images/carousel/carrousel-2.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta
                                gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="container">
                        <img style="width:100%"
                            src="<?= base_url() ?>static/shop/themes/images/carousel/carrousel-3.jpg" alt="" />
                        <div class="carousel-caption">
                            <h4>Second Thumbnail label</h4>
                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta
                                gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
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
                                <img src="<?= base_url() ?>static/shop/themes/images/ico-cart.png" alt="producto(s) añadidos"><?= count($this->session->userdata('carrito')) ?> Item(s)  
                                <a href="<?= base_url('menu/checkout') ?>" class="btn btn-warning pull-right">Comprar <i class="icon-shopping-cart"></i></a>
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

                </div>
                <!-- Sidebar end=============================================== -->
                <div class="span9">
                    <h4>Mercadería
                        <?= isset($marca_2->nombre)==false?'':(' - '.$marca_2->nombre.' <a class="label label-danger" href="'.base_url('menu/shop').'">Quitar filtro</a> ') ?>
                    </h4>
                    <ul class="thumbnails">
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
                                            <a class="btn btn-success disabled">Añadido al
                                            carrito <i class="icon-shopping-cart"></i></a>
                                            <a href="<?= base_url('menu/delete/'.$x->idinventario_mercaderia) ?>" class="btn btn-danger"><i class="fa fa-remove"></i></a>
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
                                        
                                    </h4>
                                </div>
                            </div>
                        </li>
                        <?php } ?>

                    </ul>

                </div>
            </div>
        </div>
    </div>
    <!-- Footer ================================================================== -->
    <div id="footerSection">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <h5>Dirección</h5>
                    <label for=""><?= $idimportadora->direccion ?></label>
                </div>
                <div class="span3">
                    <h5>Teléfono</h5>
                    <label for=""><?= $idimportadora->telefono ?></label>
                </div>
                <div class="span3">
                    <h5>Correo</h5>
                    <label for=""><?= $idimportadora->correo ?></label>
                </div>
                <div id="socialMedia" class="span3 pull-right">
                    <h5>Redes sociales </h5>
                    <a href="#"><i class="fa fa-facebook-f fa-2x"></i></a>
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

</body>

</html>