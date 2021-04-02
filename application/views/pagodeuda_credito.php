<?php $this->load->view('archivos/typehtml') ?>
<html lang="<?php $this->load->view('archivos/lang') ?>">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?= $title ?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/grocery_crud/themes/bootstrap/css/bootstrap/bootstrap.min.css" />
    <?php $this->load->view('archivos/css') ?>
    <link href="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url() ?>static/bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css">
</head>

<body>
    <div id="sb-site">
        <?php $this->load->view('web/loading') ?>


        <div id="page-wrapper">
            <?php $this->load->view('web/sidebar') ?>
            <div id="page-content-wrapper">
                <div id="page-content">
                    <?php $this->load->view('web/nav') ?>
                    <div id="page-title">
                        <h2><?= $nombre ?></h2>

                        <p><?= $subtitle ?></p>

                    </div>

                    <div class="content-box pad25A">
                        <div class="row">
                            <div class="col-sm-3">
                                
                                <address class="invoice-address">
                                    <?= $this->session->userdata('idimportadora')->nombre ?>
                                    <br />
                                    <?= $this->session->userdata('idimportadora')->correo ?>
                                    <br />
                                    <?= $this->session->userdata('idimportadora')->direccion ?>
                                </address>
                            </div>
                            <div class="col-sm-6 float-right text-right">
                                <h4 class="invoice-title">Venta</h4>
                                No. <b>#<?= str_pad($idcredito_pagar->idventa, 8, "0", STR_PAD_LEFT) ?></b>
                                <div class="divider"></div>
                                <a href="<?= base_url('credito') ?>" class="btn btn-alt btn-danger">
                                    <span>Cancelar</span>
                                    <i class="glyph-icon fa-refresh"></i>
                                </a>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="invoice-client mrg10T">Información del cliente y su deuda:</h2>
                                <h5><label for=""><label for="" id="nombre"><?= $idcredito_pagar->apellidos ?> <?= $idcredito_pagar->nombres ?> </label></label> </h5>
                                <address class="invoice-address">
                                <div for="" id=""><strong>Cédula: </strong> <?= $idcredito_pagar->cedula==''?'<a class="text-danger" href="'.base_url('cliente/index/edit/').$idcredito_pagar->idcliente.'">Necesita actualizar los datos</a>':$idcredito_pagar->cedula ?></div>
                                    <div for="" id=""><strong>Deuda: </strong> $ <?= $idcredito_pagar->deudainicial ?></div>
                                    <div for="" id="telefono"><strong>Saldo: </strong> <?= $idcredito_pagar->saldo=='0'?'<label class="label label-success">Pagado</label>': '$ '.(round($idcredito_pagar->saldo, 2)) ?></div>
                                </address>
                            </div>
                            
                        </div>

                        <table class="table mrg20T table-hover table-bordered" id="tab_logic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha de pago</th>
                                    <th>Fecha pagado</th>
                                    <th>Valor a pagar</th>
                                    <th>Valor pagado</th>
                                    <th>Valor pendiente</th>
                                    <th>Estado</th>
                                    <td class="text-center" style="width: 19%;"><strong>Anticipo</strong></td>
                                    <td class="text-center"><strong>Acción</strong></td>
                                </tr>
                            </thead>
                            <tbody id="body_pago">
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" class="h3">
                                        Debe
                                    </td>
                                    <td class="text-right h3" id="debe">
                                        $ 0
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="h3">
                                        Pagado
                                    </td>
                                    <td class="text-right h3" id="pagado">
                                        $ 0
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" class="h3">
                                        Total
                                    </td>
                                    <td class="text-right h3" id="total">
                                        $ 0
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        
        <script>
        $(function() {
            var pagar = function(btn, dat){
                var icon = btn.html();
                var estado = (dat.estado == '1' ? 0 : 1);
                var loading = '<i class="fa fa-circle-o-notch fa-spin"></i>';
                var warning = '<i class="fa fa-warning"></i>';
                $.ajax({
                    url: '<?= base_url() ?>ctaporpagar/pago',
                    type: 'POST',
                    data: {
                        idamortizacion_cuotas:dat.idamortizacion_cuotas,
                        estado: estado,
                        numcheque:dat.numcheque
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.prop('disabled', true);
                        btn.html(loading);
                    }
                }).done(function(data) {
                    location.reload();
                    return;
                }).fail(function() {
                    alert('Error al realizar el pago, intente nuevamente');
                    location.reload();
                });
            };
            var debe_g = 0;
            var deber_v = 0;
            var saldo_update = function(saldo) {
                $.ajax({
                    url: '<?= base_url() ?>credito/saldo',
                    type: 'POST',
                    data: {
                        'saldo': saldo,
                        'idcredito': <?= $idcredito_pagar->idcredito ?>
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        
                    }
                }).done(function(data) {
                    $('#telefono').html('<strong>Saldo: </strong>$ '+(parseFloat(saldo).toFixed(3)));
                    return;
                }).fail(function() {
                    location.reload();
                });
            }
            var detalle = function(idcredito){
                $.ajax({
                    url: '<?= base_url() ?>credito/detalle',
                    type: 'POST',
                    data: {
                        'idcredito': idcredito
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        //$(".input-pago").trigger('touchspin.destroy');
                        $('#body_pago').html('<tr> <td colspan="8" class="text-center"><i class="fa fa-refresh fa-spin"></i> Buscando registros..</td> </tr>');
                    }
                }).done(function(data) {
                    $('#body_pago tr').remove();
                    var total_ = 0;
                    var debe = 0;
                    var pagado = 0;
                    var idcredito = 0;
                    for (var i in data) {
                        var ins = data[i];
                        var html = '';
                        html += '<tr>';
                        html += '<td align="left">' + (parseInt(i) + 1) + '</td>';
                        
                        idcredito = ins.idcredito;
                        html += '<td align="center">' + ins.fechapagar + '</td>';
                        html += '<td align="center">' + (ins.fechapagado==null?'No pagado':ins.fechapagado) + '</td>';
                        html += '<td align="center">$' + parseFloat(ins.valorcuota).toFixed(2) + '</td>';
                        html += '<td align="center">$' + parseFloat(ins.saldo).toFixed(2) + '</td>';
                        if((ins.valorcuota - ins.saldo) == '0'){
                            html += '<td align="center">$' + (ins.valorcuota - ins.saldo).toFixed(2) + '</td>';
                        }else{
                            html += '<td align="center"><strong> $' + (ins.valorcuota - ins.saldo).toFixed(2) + ' </strong></td>';
                        }
                        html += '<td align="center">' + (ins.estado=='1'?'<label class="label label-success">Pagado</label>':(ins.estado == '0'?'<label class="label label-danger">Debe</label>':'<label title="Falta completar el pago" class="label label-warning">Falta</label>')) + '</td>';
                        var botones = '';
                        if((ins.estado=='0') || (ins.estado=='2')){
                            debe = debe + parseFloat(ins.valorcuota); 
                            botones += '<button title="Pagar el valor" class="btn btn-default btn-xs btn-ocultar-'+ins.idamortizacion_cuotas+'" rel="pago" data-json=\'{"id":"'+ins.idamortizacion_cuotas+'","action":"pagar","idcredito":'+ins.idcredito+', "estado":"'+ins.estado+'", "fechapagar":"'+ins.fechapagar+'", "valorcuota":' + ins.valorcuota + '}\'>Pagar</button> ';
                        }else{
                            pagado = pagado + parseFloat(ins.valorcuota);
                            if(ins.estado=='1'){
                                botones += '<button title="Quitar el pago" class="btn btn-danger btn-xs btn-ocultar-'+ins.idamortizacion_cuotas+'" rel="pago" data-json=\'{"id":"'+ins.idamortizacion_cuotas+'","action":"pagar","idcredito":'+ins.idcredito+', "estado":"'+ins.estado+'", "fechapagar":"'+ins.fechapagar+'", "valorcuota":' + ins.valorcuota + '}\'>Pago <i class="fa fa-remove"></i></button> ';

                            }
                        }
                        
                        
                        botones += '';
                        botones += '';
                        botones += '';
                        

                        var btns = '';
                        if(ins.estado == '0'){
                            btns += '<input class="form-control form-xs input-pago input-id-'+ins.idamortizacion_cuotas+'" style="" value="'+ins.valorabonado+'" placeholder="Ingresar un valor 0.0" rel="pago" data-json=\'{"idamortizacion_cuotas":"'+ins.idamortizacion_cuotas+'","action":"valorabonado","idcredito":'+ins.idcredito+', "estado":"'+ins.estado+'", "valorcuota":"'+ins.valorcuota+'", "fechapagar":"'+ins.fechapagar+'"}\'>';
                        }else{
                            if(ins.estado == '1'){
                                btns += '<input class="form-control form-xs input-pago input-id-'+ins.idamortizacion_cuotas+'" readonly style="" value="'+parseFloat(ins.saldo).toFixed(2)+'" placeholder="Ingresar un valor 0.0">';
                            }
                            if(ins.estado == '2'){
                                btns += '<input class="form-control form-xs input-pago input-id-'+ins.idamortizacion_cuotas+'" readonly style="" value="'+parseFloat(ins.saldo).toFixed(2)+'" placeholder="Ingresar un valor 0.0">';
                            }
                            
                        }
                        html += '<td class="text-center" align="center">'+ btns +'</td>';

                        html += '<td class="text-center" align="center">'+ botones +'</td>';
                        html += '</tr>';
                        
                        
                        $('#body_pago').append(html);
                    }
                    $('#debe').html('$ <b>' + (debe).toFixed(2) + '</b>');
                    $('#pagado').html('$ <b>' + (pagado).toFixed(2) + '</b>');
                    $('#total').html('$ <b>' + (debe+pagado).toFixed(2) + '</b>');
                    if (data.length > 0) {
                        $('#guardar').prop('disabled', false)
                    } else {
                        $('#body_pago').append(
                            '<tr><td colspan="8" class="text-center">Ningún dato en la tabla</td></tr>')
                    }
                    debe_g = parseFloat(debe+pagado);
                    deber_v = (debe).toFixed(2);

                    //actualizarprecio(idcredito, deber_v);

                    saldo_update(debe);
                    return;
                }).fail(function() {
                    alert('Error al cargar')
                });
            }
            detalle(<?= $idcredito_pagar->idcredito ?>);

            $('#body_pago').on('change', '.input-pago', function () {
                var btn =  $(this);
                var data = $(this).data('json'),
                        action = data.action,
                        id = data.id;
                var json = data;
                if(parseFloat(btn.val()) <= debe_g){
                    $.ajax({
                        url: '<?= base_url() ?>credito/anticipo',
                        type: 'POST',
                        data: {
                            'idamortizacion_cuotas': json.idamortizacion_cuotas,
                            'idcredito': json.idcredito,
                            'estado': json.estado,
                            'fechapago': json.fechapagar,
                            'valorcuota': json.valorcuota,
                            'valorabonado': btn.val()
                        },
                        dataType: 'JSON',
                        beforeSend: function() {
                            btn.prop('disabled', true);
                        }
                    }).done(function(data) {
                        btn.prop('disabled', false);
                        detalle(json.idcredito);
                        return;
                    }).fail(function() {
                        alert('Error al cargar');
                    });
                }else{
                    btn.val('0');
                    alert('El valor ingresado no debe pasar de: $'+ debe_g);
                }
                
            });
            
            function filterFloat(evt,input){
                // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
                var key = window.Event ? evt.which : evt.keyCode;    
                var chark = String.fromCharCode(key);
                var tempValue = input.value+chark;
                if(key >= 48 && key <= 57){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
                }else{
                        if(key == 8 || key == 13 || key == 0) {     
                            return true;              
                        }else if(key == 46){
                            if(filter(tempValue)=== false){
                                return false;
                            }else{       
                                return true;
                            }
                        }else{
                            return false;
                        }
                }
            }
            function filter(__val__){
                var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
                if(preg.test(__val__) === true){
                    return true;
                }else{
                    return false;
                }
                
            }
            $('#body_pago').on('keypress', '.input-pago', function (e) {
                return filterFloat(e,this);
            });
            var pagar_cred = function(btn, idpago, idcredito, estado_pago, fechapago, valorcuota) {
                var html_a = btn.html();
                $.ajax({
                    url: '<?= base_url() ?>credito/pagar',
                    type: 'POST',
                    data: {
                        'idamortizacion_cuotas': idpago,
                        'idcredito': idcredito,
                        'estado_pago': estado_pago,
                        'fechapago': fechapago,
                        'valorcuota': valorcuota
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.prop('disabled', true);
                        btn.html('<i class="fa fa-refresh fa-spin"></i>' );
                    }
                }).done(function(data) {
                    btn.prop('disabled', false);
                    btn.html(html_a);
                    detalle(idcredito);
                    return;
                }).fail(function() {
                    alert('Error al cargar');
                });
            }

            

            $('#body_pago').on('click', 'button[rel="pago"]', function () {
                var btn =  $(this);
                var data = $(this).data('json'),
                        action = data.action,
                        id = data.id;
                switch (action) {
                    case 'pagar':
                        var json = data;
                        pagar_cred(btn, id, json.idcredito, (json.estado=='1'?0:1), json.fechapagar, json.valorcuota);
                        break;
                    case 'anticipo':
                        var json = data;
                        $('.btn-ocultar-'+id+'').css('display','none');
                        $('.input-id-'+id+'').css('display','block');
                        break;
                }
            });
        });
        </script>
    </div>
</body>

</html>