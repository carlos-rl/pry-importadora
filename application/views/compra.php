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
<!-- select2 -->
<link href="<?= base_url() ?>static/lib/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="<?= base_url() ?>static/lib/select2-bootstrap-theme-master/dist/select2-bootstrap.min.css" rel="stylesheet" media="screen">
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
                                <div class="dummy-logo">
                                    <img src="<?= base_url('static/imagen/importadora.png') ?>" width="75" alt="">
                                </div>
                                <address class="invoice-address">
                                    <?= $this->session->userdata('idimportadora')->nombre ?>
                                    <br />
                                    <?= $this->session->userdata('idimportadora')->correo ?>
                                    <br />
                                    <?= $this->session->userdata('idimportadora')->direccion ?>
                                </address>
                            </div>
                            <div class="col-sm-6 float-right text-right">
                                <h4 class="invoice-title">Compra</h4>
                                No. <b>#<?= str_pad($idcompra_after, 8, "0", STR_PAD_LEFT) ?></b>
                                <div class="divider"></div>

                                <div class="invoice-date mrg20B">
                                    <?= $fecha ?>
                                </div>
                                <button class="btn btn-alt btn-info" id="guardar_compra">
                                    Guardar compra <i class="glyph-icon fa fa-save"></i>
                                </button>
                                <a href="<?= base_url('compras') ?>" class="btn btn-alt btn-danger">
                                    <span>Cancelar</span>
                                    <i class="glyph-icon fa-refresh"></i>
                                </a>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="invoice-client mrg10T">Información del proveedor:</h2>
                                <h5><label for=""><label for="" id="nombre">Seleccionar un proveedor </label></label> 
                                <button  type="button" title="Seleccionar un proveedor" id="seleccionar_proveedor" class="btn btn-success btn-xs" ><i class="fa fa-plus"></i></button></h5>
                                <address class="invoice-address">
                                    <p for="" id="ruc">----</p>
                                    <p for="" id="direccion">----</p>
                                    <p for="" id="telefono">----</p>
                                </address>
                                <input type="hidden" id="idproveedor" autocomplete="off" value="0">
                            </div>
                            <div class="col-md-4">
                                <h2 class="invoice-client mrg10T">Información de la compra:</h2>
                                <ul class="reset-ul">
                                    <li style="display: flex;"><b>Fecha:</b> <span>
                                    <input data-inputmask="'alias': 'datetime', 'inputFormat': 'yyyy-mm-dd'" type="text" id="fecha"
                                                class="form-control" value="<?= strftime("%Y-%m-%d") ?>"></span></li>
                                    <li><b>Estado:</b> <span class="bs-label label-warning">Compra no guardada</span>
                                    </li>
                                    <li><b>Id:</b> # <span id="idcompra"><?= str_pad($idcompra_after, 4, "0", STR_PAD_LEFT) ?></span></li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <h2 class="invoice-client mrg10T">Añadir mercadería</h2>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="idmercaderia">Seleccionar una mercadería</label>
                                        <select name="idmercaderia" class="form-control input-sm" id="idmercaderia">
                                            <option value="0">Seleccionar Nombre, {Marca - Modelo}</option>
                                            <?php foreach ($idmercaderia as $key => $x) { ?>
                                                <option data-json='{"json":<?= json_encode($x) ?>}' value="<?= $x->idmercaderia ?>"><?= $x->mercaderia==''?'Sin nombre':$x->mercaderia ?> {<?= $x->nombre ?> - <?= $x->modelo ?>}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12" style="margin-top:10px">
                                        <label for="serie">Ingresar una serie</label>
                                        <input type="text" maxlength="20" id="serie" class="form-control input-sm" placeholder="Serie"
                                            value="">
                                    </div>
                                    <div class="col-sm-12" style="margin-top:10px">
                                        <label for="idmercaderia">Garantia #</label>
                                        <select name="garantia" class="form-control input-sm" id="garantia"
                                            style="margin-top:10px">
                                            <option value="1">1 mes de garantía</option>
                                            <option value="2">2 meses de garantía</option>
                                            <option value="3">3 meses de garantía</option>
                                            <option value="4">4 meses de garantía</option>
                                            <option value="5">5 meses de garantía</option>
                                            <option value="10">10 meses de garantía</option>
                                            <option value="12">12 meses de garantía</option>
                                            <option value="14">14 meses de garantía</option>
                                            <option value="18">18 meses de garantía</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12" style="margin-top:10px">
                                        <label for="idmercaderia">Agregar compra</label>
                                        <button class="btn btn-block btn-info btn-sm" id="add_row" style="margin-top:10px">
                                            Agregar <i class="glyph-icon fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table mrg20T table-hover" id="tab_logic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Serie</th>
                                    <th>Mercadería</th>
                                    <th>Meses de Garantía</th>
                                    <th class="text-center">Costo</th>
                                    <th>Precio al público</th>
                                    <th colspan="2">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id='addr0'>
                                    <td colspan="7" class="text-center">Ningún dato en la tabla</td>
                                </tr>
                                <tr id='addr1'></tr>
                            </tbody>
                            <tfoot>
                                <tr class="font-bold font-black">
                                    <td colspan="6" class="text-right">Subtotal:</td>
                                    <td colspan="3" id="sub_total">$0.00</td>
                                </tr>
                                <tr class="font-bold font-black">
                                    <td colspan="5"></td>
                                    <td class="text-right">
                                        <div class="input-group">
                                            <select name="tax" id="tax" class="form-control">
                                                <?php for ($i=0; $i < 31 ; $i++) {  ?>
                                                    <option <?= $i==12?'selected':'' ?> value="<?= $i ?>"><?= $i ?></option>
                                                    <?php $i++; ?>
                                                <?php } ?>
                                            </select>
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </td>
                                    <td colspan="3" class="font-red" id="tax_amount">$0.00</td>
                                </tr>
                                <tr class="font-bold font-black">
                                    <td colspan="6" class="text-right">TOTAL:</td>
                                    <td colspan="3" class="font-blue font-size-23" id="total_amount">$0.00</td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="modal_proveedor" class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Seleccionar proveedor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table mrg20T table-hover" id="table_proveedor">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombres</th>
                                                <th>RUC</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th class="text-center">Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_proveedor">
                                            <?php $i = 0; foreach ($idproveedor as $key => $value) { $i++; ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= $value->nombres ?></td>
                                                    <td><?= $value->ruc ?></td>
                                                    <td><?= $value->direccion ?></td>
                                                    <td><?= $value->telefono ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-sm" rel="seleccionar" data-json='{"idproveedor":<?= $value->idproveedor ?>, "json":<?= json_encode($value) ?>}'><i class="fa fa-plus-square"></i></button>
                                                    </td>
                                                </tr>
                                            <?php }  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="modal_pagos" class="modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Seleccionar fecha y N° Cuotas</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12"><br>
                                    <label for="">Fecha de inicio de cuotas</label>
                                    <input type="text"  data-inputmask="'alias': 'datetime', 'inputFormat': 'yyyy-mm-dd'"  class="form-control" id="fechai" placeholder="Ingresar fecha">
                                </div>
                                <div class="col-md-4"><br>
                                    <label for="">Tipo de intervalo</label>
                                    <select name="" id="tipo" class="form-control">
                                        <option value="1">Mes</option>
                                        <option value="2">Semana</option>
                                        <option value="3">Cada 15 días</option>
                                    </select>
                                </div>
                                <div class="col-md-4"><br>
                                    <label for="">N°  de cuotas</label>
                                    <select name="" id="cuotas" class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="12">12</option>
                                        <option value="18">18</option>
                                        <option value="24">24</option>
                                        <option value="48">45</option>
                                    </select>
                                </div>
                                <div class="col-md-4"><br>
                                    <label for="">Cuenta Bancaria</label>
                                    <select name="" id="idcuentabancaria" class="form-control">
                                        <?php foreach ($idcuentabancaria as $key => $value) { ?>
                                            <option value="<?= $value->idcuentabancaria ?>"><?= $value->nombre ?> - <?= $value->numero ?>, <?= ($value->tipo=='2'?'Corriente':'Ahorros') ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                <br>
                                    <button class="btn btn-primary" id="guardarcompra">
                                        Crear Registro
                                    </button>
                                <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div id="modal_metodo" class="modal" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Seleccionar el método de pago</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid"><br>
                            <div class="row">
                                <div class="col-md-12" align="center">
                                    <button class="btn btn-primary btn-block" id="contado">
                                       <i class="fa fa-dollar"></i> Pagar al contado
                                    </button><br>
                                </div>
                                <div class="col-md-12" align="center">
                                    <button class="btn btn-primary btn-block" id="credito">
                                        <i class="fa fa-money"></i> Pagar a crédito
                                    </button>
                                </div>
                            </div><br><br>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- JS Demo -->
        <script src="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>static/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        <script src="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script><!-- bootstrap time picker -->
        <script src="<?= base_url() ?>static/moment/moment.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/moment/locale/es.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js"></script>
        
        <script type="text/javascript" src="<?= base_url() ?>static/Inputmask/dist/jquery.inputmask.js"></script>
        
		<!-- select2 -->
        <script src="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/lib/select2/select2.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
        <script>
        $(function() {
            
            $("#fecha").inputmask();
            $("#fechai").inputmask();

            var i_global = 1;
            var idglobal = 1;
            $('#fecha').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#fechai').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#fecha, #fechai').val(moment().format('YYYY-MM-DD'));
            $('#fechai').data("DateTimePicker").minDate($('#fecha').val()   );
            $("#fecha").on("dp.change", function (e) {
                $('#fechai').data("DateTimePicker").minDate(e.date);
            });
            $('#seleccionar_proveedor').click(function(){
                $('#modal_proveedor').modal('show');
            });

            $('#idmercaderia').select2({
                placeholder: 'Buscar Mercadería',
                theme: "bootstrap"
            });
            $('#body_proveedor').on('click', 'button[rel="seleccionar"]', function () {
                var data = $(this).data('json'),
                        json = data.json,
                        id = data.idproveedor;
                $('#nombre').html(json.nombres);
                $('#ruc').html(json.ruc);
                $('#direccion').html(json.direccion);
                $('#telefono').html(json.telefono);
                $('#idproveedor').val(id);
                $('#modal_proveedor').modal('hide');
            });
            var tr_table = function(id, data){
                var html = '';
                //html += '<tr id="addr'+id+'">'
                html += '<td>0</td>'
                html += '<td class="serie">'+data.serie+'</td>'
                html += '<td class="nombre_artc"> '+data.mercaderia.nombre+' - '+data.mercaderia.modelo+'</td>'
                html += '<td>'+data.garantia.text+'</td>'
                html += '<td class="text-center">'
                html += '<input type="text" id="costo_'+id+'" costo="'+id+'" value="0" placeholder="Ingresar el costo" class="form-control qty">'
                html += '</td>'
                html += '<td><input type="text"  id="precio_'+id+'" precio= "'+id+'" value="0" placeholder="Precio al público" class="form-control price"></td>'
                html += '<td class="" style="vertical-align:middle">'
                html += '<div class="input-group mb-2 mb-sm-0 " style="display:flex">'
                html += '$ <div class="total">0.00</div> '
                html += '</div>'
                html += '</td>'
                html += '<td>'
                html += '<input type="hidden" class="garantia" value="'+data.garantia.id+'">'
                html += '<input type="hidden" class="idmercaderia" value="'+data.mercaderia.idmercaderia+'">'
                html += "<button value='"+(id)+"' class='btn btn-default btn-xs deletes'><i class='fa fa-trash text-danger'></i></button>"
                html += '</td>'
                //html += '</tr>';
                return html;
            }
            
            $("#add_row").click(function() {
                if($('#idproveedor').val()!='0'){
                    var garantia = $('#garantia option:selected').text();
                    var idgarantia = $('#garantia').val();
                    var serie = $('#serie').val();
                    var idmercaderia = $('#idmercaderia').val();
                    var datosmercaderia = $('#idmercaderia option:selected').data('json');

                    if (typeof datosmercaderia != 'undefined') {
                        if(!existe_mercaderia(idmercaderia, serie)){
                            if(serie != ''){
                                if(!existe_serie(serie)){
                                    buscarajaxserie(garantia, idgarantia, serie, idmercaderia, datosmercaderia)
                                }else{
                                    alert('La serie ya existe');
                                }
                                
                            }else{
                                alert('Ingresar una serie')
                            }
                        }else{
                            alert('La mercadería ya está ingresada')
                        }
                    }else{
                        alert('Elegir una mercadería')
                    }
                }else{
                    alert('Elegir un proveedor');
                    $('#modal_proveedor').modal('show')
                }
                

                




                /**$('#tab_logic tbody tr').each(function(i, element) {
                    var html = $(this).html();
                    if (html != '') {
                        alert($(this).find('.price').attr('idparam'))
                    }
                }); */
            });

            var agregar = function(garantia, idgarantia, serie, idmercaderia, datosmercaderia){
                var dat = {
                    serie: serie,
                    garantia: {
                        text:garantia,
                        id:idgarantia
                    },
                    mercaderia: datosmercaderia.json
                }
                b = i_global - 1;
                $("#addr0").html('');
                $('#addr' + i_global).html(tr_table(i_global, dat));
                $('#tab_logic').append('<tr id="addr' + (i_global + 1) + '"></tr>');

                $("#costo_"+i_global).TouchSpin({
                    buttondown_class: 'btn btn-white',
                    buttonup_class: 'btn btn-white',
                    min: 0.01,
                    max: 99999999,
                    step: 0.01,
                    decimals: 2,
                    boostat: 1,
                    maxboostedstep: 1,
                    postfix: '$',
                    verticalbuttons: false
                });
                $("#precio_"+i_global).TouchSpin({
                    buttondown_class: 'btn btn-white',
                    buttonup_class: 'btn btn-white',
                    min: 0.01,
                    max: 99999999,
                    step: 0.01,
                    decimals: 2,
                    boostat: 1,
                    maxboostedstep: 1,
                    postfix: '$',
                    verticalbuttons: false
                });
                $("#costo_"+i_global).on('input',function(){
                    
                    this.value = this.value.replace(/[^0-9.]/g,'');
                });
                $("#precio_"+i_global).on('input',function(){
                    this.value = this.value.replace(/[^0-9.]/g,'');
                });
                $("#precio_"+i_global).attr('maxlength', 8);
                $("#costo_"+i_global).attr('maxlength', 8);
                i_global++;
            }

            $('#tab_logic tbody').on('keyup change', function() {
                calc();
            });
            $('#tax').on('keyup change', function() {
                calc_total();
            });

            var existe_serie = function(ins){
                var existe = false;
                $('#tab_logic tbody tr').each(function(i, element) {
                    var html = $(this).html();
                    if (html != '') {
                        var serie = '';
                        var serie = $(this).find('.serie').html();
                        if(serie === ins){
                            existe = true;
                        }
                    }
                });
                return existe;
            }

            var existe_mercaderia = function(idmercaderia, serie){
                var existe = false;
                $('#tab_logic tbody tr').each(function(i, element) {
                    var html = $(this).html();
                    if (html != '') {
                        var idmercaderia_local = '';
                        var idmercaderia_local = $(this).find('.idmercaderia').val();
                        var serie_local = $(this).find('.serie').html();
                        if((idmercaderia_local === idmercaderia) && (serie_local === serie)){
                            existe = true;
                        }
                    }
                });
                return existe;
            }

            var buscarajaxserie = function(garantia, idgarantia, serie, idmercaderia, datosmercaderia){
                var textbtn = 'Agregar<i class="glyph-icon fa fa-plus"></i>';
                $.ajax({
                    'url': '<?= base_url() ?>compra/buscarserie',
                    'type': 'POST',
                    'data': {serie: serie},
                    'dataType': 'json',
                    'timeout': 15000,
                    beforeSend: function () {
                        $('#add_row, #serie').prop('disabled',true);
                        $('#add_row').html('Validando <i class="fa fa-refresh fa-spin"></i>');
                    },
                    success: function (data) {
                        $('#add_row, #serie').prop('disabled',false);
                        $('#add_row').html(textbtn);
                        if(data.resp){
                            alert('La serie ya existe en la bd')
                        }else{
                            agregar(garantia, idgarantia, serie, idmercaderia, datosmercaderia);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 0) {
                            alert('No estás conectado, verifica tu conección.');
                        } else if (jqXHR.status == 404) {
                            alert('Respuesta, página no existe [504].');
                        } else if (jqXHR.status == 500) {
                            alert('Error interno del servidor [500].');
                        } else if (textStatus === 'parsererror') {
                            alert('Respuesta JSON erróneo.');
                        } else if (textStatus === 'timeout') {
                            alert('Error, tiempo de respuesta.');
                        } else if (textStatus === 'abort') {
                            alert('Respuesta ajax abortada.');
                        } else {
                            alert('Uncaught Error: ' + jqXHR.responseText);
                        }
                    }
                });
            }

            function calc() {
                var id = 1;
                $('#tab_logic tbody tr').each(function(i, element) {
                    var html = $(this).html();
                    if (html != '') {
                        //var qty = $(this).find('.qty').val();
                        var qty = 1;
                        var price = $(this).find('.price').val();
                        var costo = $(this).find('.qty').val();
                        $(this).find('.total').html((qty * costo).toFixed(2));

                        if(parseFloat(costo) > parseFloat(price)){
                            $(this).find('.price').val(parseFloat(costo)+0.01);
                        }
                        $(this).find('td:first-child').html(id);
                        id++;
                        
                        calc_total();
                        
                    }
                });
            }


            function calc_total() {
                total = 0;
                $('.total').each(function() {
                    total += parseInt($(this).html());
                });
                $('#sub_total').html('$ '+total.toFixed(2));
                tax_sum = total / 100 * $('#tax').val();
                $('#tax_amount').html('$'+tax_sum.toFixed(2));
                $('#total_amount').html('$'+(tax_sum + total).toFixed(2));
            }

            $('#tab_logic tbody').on('click', 'button.deletes', function() {
                
                var id = $(this).val();
                var btn = $(this);
                $('#addr'+id).remove();

                calc();
            });
            var idproveedor_g = '';
            var fecha_g = '';
            var detalle_g = [];
            $('#guardar_compra').click(function(){
                idproveedor_g = $('#idproveedor').val();
                fecha_g = $('#fecha').val();
                detalle_g = [];
                var existe = false;
                if(fecha_g ==''){
                    alert('Error, ingresar una fecha')
                    return false;
                
                }
                if(idproveedor_g != '0'){
                    $('#tab_logic tbody tr').each(function(i, element) {
                        if(parseFloat($(this).find('.qty').val())<1){
                            alert('Debe ingresar un precio al producto '+$(this).find('.nombre_artc').html())
                            return false;
                        }
                        var html = $(this).html();
                        if (typeof ($(this).find('.serie').html()) != 'undefined') {//if (html != '') {
                            detalle_g.push({
                                serie: $(this).find('.serie').html(),
                                costo: $(this).find('.qty').val(),
                                precio_venta: $(this).find('.price').val(),
                                garantia_meses: $(this).find('.garantia').val(),
                                idmercaderia: $(this).find('.idmercaderia').val(),
                            });
                            existe = true;
                        }
                    });
                    if(!existe){
                        alert('Agregar por lo menos 1 producto con el precio')
                    }else{
                        /**if(confirm('Realizar el pago ¿a crédito?')){
                            $('#modal_pagos').modal('show');
                        }else{
                            guardar_compra('si');
                        } */
                        $('#modal_metodo').modal('show');
                    }
                    
                }else{
                    alert('Agregar proveedor');
                }
            });

            $('#contado').click(function(){
                guardar_compra('si');
            })
            $('#credito').click(function(){
                $('#modal_pagos').modal('show');
                $('#modal_metodo').modal('hide');
            });

            var data_add_compra = function(fechai, tipo, cuotas, idcuentabancaria,  pagado){
                var iva = $('#tax').val();
                var data = {
                    idproveedor:idproveedor_g,
                    fecha:fecha_g,
                    detalle: JSON.stringify(detalle_g),
                    fechai:fechai,
                    tipo:tipo,
                    iva:iva,
                    cuotas:cuotas,
                    idcuentabancaria:idcuentabancaria,
                    pagado:pagado
                }
                return data;
            }

            var guardar_compra = function(pagado){
                var fechai = $('#fechai').val();
                var tipo = $('#tipo').val();
                var cuotas = $('#cuotas').val();
                var idcuentabancaria = $('#idcuentabancaria').val() || 0;
                if(fechai != ''){
                    if(idcuentabancaria != '0'){
                        $.ajax({
                            url: '<?= base_url() ?>compra/crearcompra',
                            type: 'POST',
                            data: data_add_compra(fechai, tipo, cuotas, idcuentabancaria, pagado),
                            dataType: 'JSON',
                            beforeSend: function() {
                                $('.row').find('input, textarea, button, select').prop('disabled',
                                    true);
                                $('#guardarcompra').html(
                                    '<i class="fa fa-refresh fa-spin"></i> Espere..');
                            }
                        }).done(function(data) {
                            $('.row').find('input, textarea, button, select').prop('disabled', false);
                            $('#guardarcompra').html('<i class="fa fa-check"></i> Tu compra fué guardada con éxito');
                            alert('Compra guardada');
                            location.reload();
                            return;
                        }).fail(function() {
                            $('.row').find('input, textarea, button, select').prop('disabled', false);
                            $('#guardarcompra').html(
                                '<i class="fa fa-warning"></i> Tus datos no fueron guardados');
                            setTimeout(function() {
                                $('#guardarcompra').html(
                                    '<i class="fa fa-save"></i> Crear Registro');
                            }, 2000);
                        });;
                    }else{
                        alert('Seleccionar una cuenta bancaria')
                    }
                }else{
                    alert('Seleccionar una fecha de inicio de pagos')
                }
            }

            $('#guardarcompra').click(function(){
                guardar_compra('no');
            });
            $('#serie').on('input',function(){ 
                this.value = this.value.replace(/[^a-zA-Z0-9-]/g,'');
            });
        });
        </script>
    </div>
</body>

</html>