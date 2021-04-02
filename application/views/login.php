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
        <!-- Vendor CSS-->
        <link rel="stylesheet" href="<?= base_url() ?>static/admin/vendor/fontawesome/css/font-awesome.min.css">
        <style>
            

            @charset "UTF-8";
@import url("https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap");
* {
  box-sizing: border-box;
}

.sr-only {
  visibility: hidden;
}

.hidden {
  width: 0;
  height: 0;
  visibility: hidden;
  display: none;
  overflow: hidden;
}

html {
  font-size: 16px;
}

body {
  display: flex;
  padding: 0;
  margin: 0;
  align-items: center;
  flex-direction: column;
  min-height: 100vh;
  font-family: "Rubik", sans-serif;
  position: relative;
  background-color: #fbfcfc;
  background-image: url("<?= base_url('static/banner/banner-2.jpg') ?>");
  background-repeat: no-repeat;
  background-size: cover;
}

.challenge-title {
  text-align: center;
  padding: 0;
  margin: 1rem 0 0.5rem;
  color: #0d1117;
  font-size: 2rem;
  font-weight: bold;
}

.challenge-subtitle {
  text-align: center;
  margin: 0;
  font-size: 1.125rem;
  color: black;
  margin-bottom: 2rem;
}

.challenge-part-of {
  text-align: center;
  margin: 1rem 0 0;
  font-size: 0.875rem;
  color: #0d1117;
  position: fixed;
  bottom: 1rem;
  right: 1rem;
  background-color: rgba(255, 255, 255, 0.55);
  -webkit-backdrop-filter: blur(5px);
          backdrop-filter: blur(5px);
  border-radius: 0.5rem;
  font-weight: bold;
  padding: 0.5rem;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
  border: 1px solid rgba(255, 255, 255, 0.18);
}
.challenge-part-of a,
.challenge-part-of a:visited {
  color: #0d1117;
  -webkit-text-decoration-style: wavy;
          text-decoration-style: wavy;
}
.challenge-part-of a:hover, .challenge-part-of a:active,
.challenge-part-of a:visited:hover,
.challenge-part-of a:visited:active {
  color: #1f2938;
}

.login-card {
  margin: auto;
  width: 800px;
  min-height: 400px;
  display: flex;
  align-items: stretch;
  border-radius: 0.5rem;
  overflow: hidden;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 10px 15px -3px, rgba(0, 0, 0, 0.05) 0px 4px 6px -2px;
  border: 1px solid rgba(255, 255, 255, 0.18);
}

.login-glass {
  flex: 0 0 40%;
  background-color: rgba(255, 255, 255, 0.35);
  -webkit-backdrop-filter: blur(5px);
          backdrop-filter: blur(5px);
  display: flex;
  align-items: center;
  justify-content: center;
}
.login-glass svg {
  width: 30%;
  fill: white;
}

.login-form-container {
  flex: 0 0 60%;
  display: flex;
  flex-direction: column;
  padding: 2rem;
  background-color: white;
}
.login-form-container .login-title {
  font-size: 1.25rem;
  font-weight: bold;
  text-align: center;
  padding: 0 0 2rem;
}
.login-form-container .form-control {
  display: flex;
  align-items: center;
  position: relative;
  width: 100%;
}
.login-form-container .form-control:not(:last-of-type) {
  margin-bottom: 1.5rem;
}
.login-form-container .form-control > label {
  position: absolute;
  font-weight: bold;
  color: #4d555f;
  font-size: 0.875rem;
  top: 0;
  left: 0.75rem;
  transform: translateY(-50%);
  background-color: white;
  padding: 0 0.25rem;
}
.login-form-container .form-control > input {
  flex: 1 0 auto;
  padding: 0.875rem;
  border-radius: 0.5rem;
  border: 1px solid #d1d5da;
  transition: border-color 0.2s ease;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
}
.login-form-container .form-control > input:hover {
  border-color: #e56b6f;
}
.login-form-container .form-control > input:focus {
  outline: 0;
  border-color: #e56b6f;
}
.login-form-container .form-control .form-remember,
.login-form-container .form-control .form-forgot {
  flex: 1 0 50%;
  display: flex;
  align-items: center;
}
.login-form-container .form-control .form-remember label {
  cursor: pointer;
  color: #7c8896;
  transition: color 0.2s ease;
  padding-left: 0.5rem;
  position: relative;
}
.login-form-container .form-control .form-remember label:hover {
  color: #0d1117;
}
.login-form-container .form-control .form-remember label::before {
  content: "";
  position: absolute;
  font-family: "Font Awesome 5 Free";
  top: 50%;
  transform: translateY(-50%);
  left: -0.875rem;
  color: #7c8896;
}
.login-form-container .form-control .form-remember input:hover + label {
  color: #0d1117;
}
.login-form-container .form-control .form-remember input:checked + label::before {
  content: "";
}
.login-form-container .form-control .form-remember input {
  cursor: pointer;
  margin: 0;
  opacity: 0;
}
.login-form-container .form-control .form-forgot {
  justify-content: flex-end;
}
.login-form-container .form-control .form-forgot a,
.login-form-container .form-control .form-forgot a:focus {
  color: #e56b6f;
  font-size: 0.875rem;
  font-weight: bold;
  text-decoration: none;
}
.login-form-container .form-control .form-forgot a:hover, .login-form-container .form-control .form-forgot a:active,
.login-form-container .form-control .form-forgot a:focus:hover,
.login-form-container .form-control .form-forgot a:focus:active {
  text-decoration: underline;
}

.btn {
  display: flex;
  align-items: center;
  background-color: #e56b6f;
  border: 0;
  color: white;
  padding: 0.875rem 1rem;
  font-size: 1rem;
  border-radius: 0.25rem;
  border: 1px solid #e56b6f;
  transition: background-color 0.1s ease-in;
  cursor: pointer;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
}
.btn:hover {
  background-color: #e98184;
}
.btn:active {
  background-color: #e1555a;
}
.btn:focus {
  outline: 1px dotted #c72328;
}
.btn.btn-full {
  flex: 1 0 auto;
  font-weight: bold;
  font-size: 0.875rem;
  justify-content: center;
}
.btn.btn-default {
  background-color: white;
  color: #98a1ad;
  border-color: #d1d5da;
}
.btn.btn-default:hover {
  background-color: #f1f2f4;
}
.btn.btn-default:active {
  background-color: #e3e5e8;
}

.divider {
  padding: 2rem 1rem;
  margin: 0 auto;
  font-size: 0.875rem;
  color: #b5bbc3;
  position: relative;
}
.divider::before, .divider::after {
  content: "";
  position: absolute;
  top: 50%;
  width: 140px;
  height: 1px;
  background-color: #d1d5da;
}
.divider::before {
  left: 0;
  transform: translateX(-100%);
}
.divider::after {
  right: 0;
  transform: translateX(100%);
}

.social-list {
  display: flex;
  align-items: center;
  margin: 0 -0.5rem;
}
.social-list li {
  flex: 0 0 33.3333333333%;
  padding: 0 0.5rem;
}
.social-list li .btn {
  width: 100%;
  justify-content: center;
}
.login-form-container .form-control > label {
    z-index: 999;
    background-color: #fff0;
}
        </style>
    </head>
    <body>
    <h1 class="challenge-title"><?= $idimportadora->nombre ?></h1>
<h2 class="challenge-subtitle">Bienvenido</h2>

<div class="login-card">
	<div class="login-glass">
		<img width="280" src="<?= base_url('static/banner/logojhael.png') ?>" alt="">
	</div>
	<div class="login-form-container">
		<h3 class="login-title">
			Ingresar al sistema
		</h3>
		<form autocomplete="off" id="frmEntidad" name="frmEntidad" method="POST">
			<div class="form-control">
				<label for="email">Ingresar correo</label>
				<input id="usuario" name="usuario" type="email" autocomplete="off" required />
			</div>
			<div class="form-control">
				<label for="password">Ingresar contraseña</label>
				<input id="pass" name="pass" type="password" required />
			</div>
			
			<div class="form-control">
				<button class="btn btn-full submit ingresar">
					Ingresar
				</button>

                
			</div>
            <div class="form-group" style="margin: 20px">
                <div id="alerta" class="alert alert-danger alert-dismissible" style="display: none;" role="alert">
                    <!--<a href="#" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></a>-->
                    <div id="alerta_texto"></div>
                </div>
            </div>
		</form>
		
	</div>
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
