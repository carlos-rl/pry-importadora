<?php $this->load->view('archivos/typehtml') ?>
<html lang="<?php $this->load->view('archivos/lang') ?>">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?= $idimportadora->nombre ?> </title>
    <!-- Bootstrap core CSS -->
    <link href="<?= base_url() ?>static/css_inicio/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" type="image/jpg" href="<?= base_url() ?>static/imagen/almacen.png">
    <!-- Custom styles for this template -->
    <link href="<?= base_url() ?>static/css_inicio/css/shop-homepage.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>static/font-awesome/css/font-awesome.css">

    <style>
        .container{
            max-width: 940px;
        }
    </style>

</head>

<body class="bg-light">

    <div class="container">
        <div class="py-2 text-center">
            <a href="<?= base_url() ?>">
                <img class="d-block mx-auto mb-4" src="<?= base_url('static/css_inicio/carrito-de-compras.png') ?>"
                    alt="" width="72" height="72">
            </a>
            <h2>Ordenar tu compra</h2>
            <p class="lead">Cuando reserves tu compra, te la vamos a tener por un periodo de 48 horas, deberás acercarte a nuestro local, <code><?= $idimportadora->direccion ?></code>.</p>
            <br>
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Tu lista de pedido</span>
                    <span class="badge badge-secondary badge-pill"><?= count($this->session->userdata('carrito')) ?></span>
                </h4>
                <ul class="list-group mb-3">
                    <?php $total = 0; ?>
                    <?php if($this->session->userdata('carrito')!=null){ ?>
                        <?php foreach ($this->session->userdata('carrito') as $key => $value) { ?>
                            <?php $total = $total + $value['data']->precio_venta; ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="my-0"><?= $value['data']->modelo ?></h6>
                                    <small class="text-muted"><?= $value['data']->serie ?></small>
                                </div>
                                <span class="text-muted">$<?= round($value['data']->precio_venta, 2) ?></span>
                            </li>
                            <?php } ?>
                        <?php } ?>
                    
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>$<?= round($total, 2) ?></strong>
                    </li>
                </ul>

            </div>
            <div class="col-md-8 order-md-1 mb-4" >
            <?php 
        $error = '';
        if(isset($_GET['resp'])){
            if($_GET['resp']=='error'){
                $error = 'Intente nuevamente a ocurrido un error';
                ?>
                <div class="alert alert-danger" role="alert">
                    <strong>Error al guardar: </strong><?= $error ?>
                </div>
                <?php
            }
            
        ?>
          
        

        <?php } ?>
        <?php 
        $error = '';
        if(isset($_GET['resp'])){
            if($_GET['resp']=='true'){
                $error = 'Tu compra fué reservada con éxito, no olvides que tienes hasta 48 horas para ir a retirar tu pedido <a href="'.base_url().'">Regresar a la tienda</a>';
            }else {
                $error = 'Error al guardar, intente de nuevo';
            }
            
        ?>
        <div class="alert alert-success" role="alert">
            <strong>Mensaje: </strong><?= $error ?>
        </div>

        <?php } ?>
                <h4 class="mb-3">Datos del cliente</h4>
                <form class="needs-validation"  method="POST" action="<?= base_url('menu/ordenar') ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName">Nombre completo</label>
                            <input type="text" class="form-control" required id="nombres" name="nombres" placeholder="" value="" required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email">Correo <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="form-control"  value="" id="email" name="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>
                        <div class="col-md-12 mb-12 mb-3">
                            <label for="email">Cédula <span class="text-muted"></span></label>
                            <input type="text" maxlength="10" required class="form-control"  value="" id="cedula" name="cedula" placeholder="00000000">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email">Teléfono <span class="text-muted">(Optional)</span></label>
                        <input type="number" maxlength="10" class="form-control" name="telefono" id="telefono" value="" placeholder="+593 844556669">
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="" placeholder="Dirección de casa" required>
                        <div class="invalid-feedback">
                            Please enter your shipping address.
                        </div>
                    </div>

                    
                    <hr class="mb-4">
                    <?php if(count($this->session->userdata('carrito'))>0){ ?>.
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Reservar compra</button>
                    <?php } ?>
                    
                </form>
            </div>
        </div>

        <footer class="py-5">
            <div class="container">
                <p class="m-0 text-center">Copyright &copy; <?= $idimportadora->nombre ?> 2020</p>
            </div>
            <!-- /.container -->
        </footer>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="<?= base_url() ?>static/css_inicio/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>static/css_inicio/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function(){
            var nummax = '';
            $('#telefono').on('input',function(){ 
                this.value = this.value.replace(/[^0-9]/g,'');
                nombre = this.value;
                if (nombre.length<11){
                    nummax = nombre;
                }
                else {
                    this.value = nummax;
                }
            });
            $('#nombres').on('input',function(){ 
                this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g,'');
            });
            $('#direccion').on('input',function(){ 
                this.value = this.value.replace(/[^0-9a-zA-ZñÑáéíóúÁÉÍÓÚ@._-\s]/g,'');
            });
            $('#cedula').on('input',function(){ 
                this.value = this.value.replace(/[^0-9]/g,'');
            });
        })
    </script>
</body>

</html>