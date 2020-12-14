<?php
if ($this->session->userdata('admin')) {
    redirect(base_url() . 'menu/');
}
?>
<!DOCTYPE html>
<html lang="<?php $this->load->view('archivos/lang') ?>">
<head>
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <title>Ingresar al sistema</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/jpg" href="<?= base_url() ?>static/imagen/almacen.png">
        <!-- Bootstrap CSS-->
        <link rel="stylesheet" href="<?= base_url() ?>static/bootstrap-3.3.7-dist/css/bootstrap.css">
        <!-- Vendor CSS-->
        <link rel="stylesheet" href="<?= base_url() ?>static/admin/vendor/fontawesome/css/font-awesome.min.css">
        <style>
            .login-form {
                width: 340px;
                margin: 50px auto;
            }
            .login-form form {
                margin-bottom: 15px;
                background: #f7f7f7;
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
                padding: 30px;
            }
            .login-form h2 {
                margin: 0 0 15px;
            }
            .form-control, .btn {
                min-height: 38px;
                border-radius: 2px;
            }
            .btn {        
                font-size: 15px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
    <div class="login-form">
        <form autocomplete="off" id="frmEntidad" name="frmEntidad" method="POST">
            <h2 class="text-center">Ingresar al sistema</h2>       
            <div class="form-group">
                <input type="email" class="form-control" placeholder="Ingresar correo" name="usuario" id="usuario" required="required">
            </div>
            <div class="form-group">
                <input type="password" id="pass" name="pass" class="form-control" placeholder="Ingresar su contraseña" required="required">
            </div>
            <div class="form-group">
            <button  type="submit" class="btn btn-success btn-block submit ingresar">Ingresar</button>
            <div class="form-group" style="margin: 20px">
                <div id="alerta" class="alert alert-danger alert-dismissible" style="display: none;" role="alert">
                    <!--<a href="#" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>-->
                    <div id="alerta_texto"></div>
                </div>
            </div>
            </div>
                 
        </form>
        
    </div>

    
    
    <!-- 
        <div class="clearfix">
                <a href="#" class="pull-right">¿Olvidó su contraseña?</a>
            </div>   
<p class="text-center"><a href="#">Crear una cuenta</a></p>

        Main vendor Scripts-->
    <script src="<?= base_url() ?>static/jquery-2.1.1.min.js"></script>
    <script src="<?= base_url() ?>static/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script>
        $(function () {
            var msj = {
                alert: function (mensaje) {
                    $('#alerta_texto').html('<span class="fa fa-warning"></span>  ' + mensaje);
                    if ($('#alerta').is(':hidden')) {
                        $('#alerta').toggle('slow');
                    }
                    setTimeout(function () {
                        $('#alerta').toggle('slow');
                    }, 2500);
                },
                alert_correo: function (mensaje) {
                    $('#alerta_texto_correo').html('<span class="fa fa-warning"></span>  ' + mensaje);
                    if ($('#alerta_correo').is(':hidden')) {
                        $('#alerta_correo').toggle('slow');
                    }
                    setTimeout(function () {
                        $('#alerta_correo').toggle('slow');
                        $('#form_recovery').find('input, textarea, button, select').prop('disabled', false);
                        $('.ingresar_correo').html('Enviar correo <i class="fa fa-envelope"></i>');
                    }, 3500);
                }
            }
            $('#frmEntidad').keypress(function (e) {
                if (e.which === 32) {
                    return false;
                }
            });
            $('#frmEntidad').submit(function () {
                $.ajax({
                    url: "<?= base_url() ?>login/iniciar",
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    timeout: 15000,
                    beforeSend: function () {
                        //M_error.Envio();
                        $('#frmEntidad').find('input, textarea, button, select').prop('disabled', true);
                        $('.ingresar').html('<i class="fa fa-refresh fa-pulse fa-fw"></i> Espere...');
                    },
                    success: function (data) {
                        if (data.resp) {
                            location.reload()
                            return;
                        } else {
                            msj.alert(data.msj);
                        }
                        $('#frmEntidad').find('input, textarea, button, select').prop('disabled', false);
                        $('.ingresar').html('<i class="fa fa-sign-in"></i>  Ingresar');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 0) {
                            msj.alert('No estás conectado, verifica tu conección.');
                        } else if (jqXHR.status == 404) {
                            msj.alert('Respuesta, página no existe [404].');
                        } else if (jqXHR.status == 500) {
                            msj.alert('Error interno del servidor [500].');
                        } else if (textStatus === 'parsererror') {
                            msj.alert('Respuesta JSON erróneo.');
                        } else if (textStatus === 'timeout') {
                            msj.alert('Error, tiempo de respuesta.');
                        } else if (textStatus === 'abort') {
                            msj.alert('Respuesta ajax abortada.');
                        } else {
                            msj.alert('Uncaught Error: ' + jqXHR.responseText);
                        }
                    }
                });
                return false;
            });
            $('#form_recovery').submit(function () {
                $.ajax({
                    url: "<?= base_url() ?>login/sendpass",
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    timeout: 15000,
                    beforeSend: function () {
                        //M_error.Envio();
                        $('#form_recovery').find('input, textarea, button, select').prop('disabled', true);
                        $('.ingresar_correo').html('<i class="fa fa-refresh fa-pulse fa-fw"></i> Espere...');
                    },
                    success: function (data) {
                        if (data.resp) {
                            $('.ingresar_correo').html('Correo enviado <i class="fa fa-check"></i>');
                            msj.alert_correo('Por favor, ingresar a su correo revisar en su bandeja de entrada o correo no deseado, su código dura 1 día.');
                            setTimeout(function () {
                                $('.ingresar_correo').html('Enviar correo <i class="fa fa-envelope"></i>');
                                $('#form_recovery').find('input, textarea, button, select').prop('disabled', false);
                            }, 2500);
                            setTimeout(function () {
                                $('#panel_form').slideDown('slow');
                                $('#panel_form_recuperar').slideUp('slow');
                            }, 4500);
                            return;
                        } else {
                            msj.alert_correo(data.msj);
                        }
                        $('#form_recovery').find('input, textarea, button, select').prop('disabled', false);
                        $('.ingresar_correo').html('Enviar correo <i class="fa fa-envelope"></i>');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 0) {
                            msj.alert_correo('No estás conectado, verifica tu conección.');
                        } else if (jqXHR.status == 404) {
                            msj.alert_correo('Respuesta, página no existe [404].');
                        } else if (jqXHR.status == 500) {
                            msj.alert_correo('Error interno del servidor [500].');
                        } else if (textStatus === 'parsererror') {
                            msj.alert_correo('Respuesta JSON erróneo.');
                        } else if (textStatus === 'timeout') {
                            msj.alert_correo('Error, tiempo de respuesta.');
                        } else if (textStatus === 'abort') {
                            msj.alert_correo('Respuesta ajax abortada.');
                        } else {
                            msj.alert_correo('Uncaught Error: ' + jqXHR.responseText);
                        }
                    }
                });
                return false;
            });
            $('#pass_olvide').click(function(){
                $('#panel_form').slideUp('slow');
                $('#panel_form_recuperar').slideDown('slow');
            })
            $('#regresar_olvide').click(function(){
                $('#panel_form').slideDown('slow');
                $('#panel_form_recuperar').slideUp('slow');
            })
        });
    </script>
</body>
</html>
