<?php $this->load->view('archivos/typehtml') ?>
<html lang="<?php $this->load->view('archivos/lang') ?>">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?= $title ?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css">
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
                                <h4 class="invoice-title">Venta</h4>
                                No. <b>#<?= str_pad($idventa_after, 8, "0", STR_PAD_LEFT) ?></b>
                                <div class="divider"></div>

                                <div class="invoice-date mrg20B">
                                    <?= $fecha ?>
                                </div>
                                <button class="btn btn-alt btn-info" id="guardar_venta">
                                    Guardar venta <i class="glyph-icon fa fa-save"></i>
                                </button>
                                <a href="<?= base_url('ventas') ?>" class="btn btn-alt btn-danger">
                                    <span>Cancelar</span>
                                    <i class="glyph-icon fa-refresh"></i>
                                </a>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="row">
                            <div class="col-md-3">
                                <h2 class="invoice-client mrg10T">Información del cliente:</h2>
                                <h5><label for=""><label for="" id="nombre">Seleccionar un cliente </label></label> 
                                <button  type="button" title="Seleccionar un proveedor" id="seleccionar_cliente" class="btn btn-success btn-xs" ><i class="fa fa-plus"></i></button></h5>
                                <address class="invoice-address">
                                    <p for="" id="ruc">----</p>
                                    <p for="" id="direccion">----</p>
                                    <p for="" id="telefono">----</p>
                                </address>
                                <input type="hidden" id="idcliente" value="0">
                            </div>
                            <div class="col-md-4">
                                <h2 class="invoice-client mrg10T">Información de la venta:</h2>
                                <ul class="reset-ul">
                                    <li style="display: flex;"><b>Fecha:</b> <span><input type="text" data-inputmask="'alias': 'datetime', 'inputFormat': 'yyyy-mm-dd'" id="fecha"
                                                class="form-control" value="<?= strftime("%Y-%m-%d") ?>"></span></li>
                                    <li><b>Estado:</b> <span class="bs-label label-warning">Venta no guardada</span>
                                    </li>
                                    <li><b>Id:</b> # <span id="idventa"><?= str_pad($idventa_after, 4, "0", STR_PAD_LEFT) ?></span></li>
                                </ul>
                            </div>
                            <div class="col-md-5">
                                <h2 class="invoice-client mrg10T">Seleccionar mercadería</h2>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="idinventario_mercaderia">Seleccionar Nombre Serie - Marca - Modelo </label>
                                        <select name="idinventario_mercaderia" class="form-control input-sm" id="idinventario_mercaderia"
                                            >
                                            <option value="0">Seleccionar Nombre, {Serie - Marca - Modelo}</option>
                                            <?php foreach ($idinventario_mercaderia as $key => $x) { ?>
                                                <option data-json='{"json":<?= json_encode($x) ?>}' value="<?= $x->idinventario_mercaderia ?>"><?= $x->nombre ?>, {<?= $x->serie ?> - <?= $x->marca ?> - <?= $x->modelo ?>}</option>
                                            <?php } ?>
                                              
                                        </select>
                                    </div>
                                    <div class="col-sm-12" style="margin-top:10px">
                                        <label for="idinventario_mercaderia">Agregar Venta</label>
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
                                    <th style="width: 20%;">Precio</th>
                                    <th colspan="2" style="width: 19%;">Total</th>
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
                                    <td id="sub_total">$0.00</td>
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
                                    <td class="font-red" id="tax_amount">$0.00</td>
                                </tr>
                                <tr class="font-bold font-black">
                                    <td colspan="6" class="text-right">TOTAL:</td>
                                    <td class="font-blue font-size-23" id="total_amount">$0.00</td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="modal_cliente" class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Seleccionar cliente</h4>
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
                                                <th>Cédula</th>
                                                <th>Dirección</th>
                                                <th>Teléfono</th>
                                                <th class="text-center">Seleccionar</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_cliente">
                                            <?php $i = 0; foreach ($idcliente as $key => $value) { $i++; ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td><?= strtoupper($value->nombres.' '.$value->apellidos) ?></td>
                                                    <td><?= $value->cedula ?></td>
                                                    <td><?= $value->direccion ?></td>
                                                    <td><?= $value->telefono ?></td>
                                                    <td class="text-center">
                                                        <button class="btn btn-success btn-sm" rel="seleccionar" data-json='{"idcliente":<?= $value->idcliente ?>, "json":<?= json_encode($value) ?>}'><i class="fa fa-plus-square"></i></button>
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
                                    <input type="text" data-inputmask="'alias': 'datetime', 'inputFormat': 'yyyy-mm-dd'" class="form-control" id="fechai" placeholder="Ingresar fecha">
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
                                <input type="hidden" id="idcuentabancaria" value="1">
                                <div class="col-md-12">
                                <br>
                                    <button class="btn btn-primary" id="guardarventa">
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
        <style type="text/css">
            #modal_metodo .modal-title {
                    font-size: 18px;
                    line-height: 23px;
                    font-weight: 700;
                    width: 250px;
                    margin-left: auto;
                    margin-right: auto;
                    color: black;
                }
        </style>
        <div id="modal_metodo" class="modal" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body"><button type="button" style="color: black;opacity: 0.6;font-size: 32px;position: absolute;left: 91%;top: -6px;" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align: center;">Antes de guardar una venta, debes elegir el método de pago</h4>
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
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script>
        <script>
        $(function() {
            
            var i_global = 1;
            var idglobal = 1;
            $('#table_proveedor').DataTable();
            $("#fecha").inputmask();
            $("#fechai").inputmask();

            $('#fecha').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#fecha, #fechai').val(moment().format('YYYY-MM-DD'));
            $('#fechai').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#fechai').data("DateTimePicker").minDate($('#fecha').val()   );
            $("#fecha").on("dp.change", function (e) {
                $('#fechai').data("DateTimePicker").minDate(e.date);
            });
            $('#seleccionar_cliente').click(function(){
                $('#modal_cliente').modal('show');
            });

            $('#idinventario_mercaderia').select2({
                placeholder: 'Buscar Mercadería',
                theme: "bootstrap"
            });
            $('#body_cliente').on('click', 'button[rel="seleccionar"]', function () {
                var data = $(this).data('json'),
                        json = data.json,
                        id = data.idcliente;
                $('#nombre').html(json.apellidos+' '+json.nombres);
                $('#ruc').html(json.cedula);
                $('#direccion').html(json.direccion);
                $('#telefono').html(json.telefono);
                $('#idcliente').val(id);
                $('#modal_cliente').modal('hide');
            });
            var tr_table = function(id, data){
                var html = '';
                //html += '<tr id="addr'+id+'">'
                html += '<td>0</td>'
                html += '<td class="serie">'+data.serie+'</td>'
                html += '<td>'+data.mercaderia.nombre+' - '+data.mercaderia.modelo+'</td>'
                html += '<td>'+data.garantia.text+' mes(es)</td>'
                html += '<td><input type="text"  id="precio_'+id+'" precio= "'+id+'" value="'+data.precio+'" placeholder="Precio al público" class="form-control price" ></td>'
                html += '<td class="" style="vertical-align:middle">'
                html += '<div class="input-group mb-2 mb-sm-0 " style="display:flex">'
                html += '$ <div class="total">0.00</div> '
                html += '</div>'
                html += '</td>'
                html += '<td>'
                html += '<input type="hidden" class="garantia" value="'+data.garantia.id+'">'
                html += '<input type="hidden" class="idinventario_mercaderia" value="'+data.mercaderia.idinventario_mercaderia+'">'
                html += "<button value='"+(id)+"' class='btn btn-default btn-xs deletes'><i class='fa fa-trash text-danger'></i></button>"
                html += '</td>'
                //html += '</tr>';
                return html;
            }

            $('#idinventario_mercaderia').change(function(){
                console.log($('#idinventario_mercaderia option:selected').data('json'))
            })
            
            $("#add_row").click(function() {
                if($('#idcliente').val()!='0'){
                    var idinventario_mercaderia = $('#idinventario_mercaderia').val();
                    var datosmercaderia = $('#idinventario_mercaderia option:selected').data('json');

                    if (typeof datosmercaderia != 'undefined') {
                        if(!existe_mercaderia(idinventario_mercaderia)){
                            var serie = datosmercaderia.json.serie;
                            var garantia = datosmercaderia.json.garantia_meses;
                            var idgarantia = datosmercaderia.json.garantia_meses;
                            if(!existe_serie(serie)){
                                agregar(garantia, idgarantia, serie, idinventario_mercaderia, datosmercaderia, datosmercaderia.json.precio_venta);
                                calc();
                            }else{
                                alert('La serie ya existe');
                            }
                        }else{
                            alert('La mercadería ya está ingresada')
                        }
                    }else{
                        alert('Elegir una mercadería')
                    }
                }else{
                    alert('Elegir un cliente');
                    $('#modal_cliente').modal('show')
                }
                

                




                /**$('#tab_logic tbody tr').each(function(i, element) {
                    var html = $(this).html();
                    if (html != '') {
                        alert($(this).find('.price').attr('idparam'))
                    }
                }); */
            });

            var agregar = function(garantia, idgarantia, serie, idinventario_mercaderia, datosmercaderia,precio){
                var dat = {
                    serie: serie,
                    precio: precio,
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
                $("#precio_"+i_global).on('input',function(){
                    this.value = this.value.replace(/[^0-9.]/g,'');
                });
                $("#precio_"+i_global).attr('maxlength', 8);
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

            var existe_mercaderia = function(ins){
                var existe = false;
                $('#tab_logic tbody tr').each(function(i, element) {
                    var html = $(this).html();
                    if (html != '') {
                        var idinventario_mercaderia = '';
                        var idinventario_mercaderia = $(this).find('.idinventario_mercaderia').val();
                        if(idinventario_mercaderia === ins){
                            existe = true;
                        }
                    }
                });
                return existe;
            }

            function calc() {
                var id = 1;
                $('#tab_logic tbody tr').each(function(i, element) {
                    var html = $(this).html();
                    if (html != '') {
                        //var qty = $(this).find('.qty').val();
                        var qty = 1;
                        var price = $(this).find('.price').val();
                        $(this).find('.total').html((qty * price).toFixed(2));

                        
                        $(this).find('td:first-child').html(id);
                        id++;
                        
                        calc_total();
                        
                    }
                });
            }


            function calc_total() {
                total = 0;
                $('.total').each(function() {
                    total += parseFloat($(this).html());
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
            var idcliente_g = '';
            var fecha_g = '';
            var detalle_g = [];
            var guardar_venta_= function(pago){
                var fechai = $('#fechai').val();
                var tipo = $('#tipo').val();
                var cuotas = $('#cuotas').val();
                var idcuentabancaria = $('#idcuentabancaria').val();
                if(fechai != ''){
                    if(idcuentabancaria != '0'){
                        $.ajax({
                            url: '<?= base_url() ?>venta/crearnew',
                            type: 'POST',
                            data: data_add_venta(fechai, tipo, cuotas, idcuentabancaria, pago),
                            dataType: 'JSON',
                            beforeSend: function() {
                                $('#contado').prop('disabled',true);
                                $('#credito').prop('disabled',true);
                                $('.row').find('input, textarea, button, select').prop('disabled',
                                    true);
                                $('#guardarventa').html(
                                    '<i class="fa fa-refresh fa-spin"></i> Espere..');
                            }
                        }).done(function(data) {
                            $('.row').find('input, textarea, button, select').prop('disabled', false);
                            $('#guardarventa').html('<i class="fa fa-check"></i> Tu venta fué guardada con éxito');
                            if(confirm('¿Imprimir factura?')){
                                window.location = '<?= base_url() ?>venta/print/'+data.idventa;
                            }else{
                                location.reload();
                            }
                            return;
                        }).fail(function() {
                            $('#contado').prop('disabled',false);
                            $('#credito').prop('disabled',false);
                            $('.row').find('input, textarea, button, select').prop('disabled', false);
                            $('#guardarventa').html(
                                '<i class="fa fa-warning"></i> Tus datos no fueron guardados');
                            setTimeout(function() {
                                $('#guardarventa').html(
                                    '<i class="fa fa-save"></i> Crear Registro');
                            }, 2000);
                        });;
                    }else{
                        alert('Seleccionar una fecha de inicio de pagos')
                    }
                }else{
                    alert('Seleccionar una fecha de inicio de pagos')
                }
            }
            $('#guardar_venta').click(function(){
                idcliente_g = $('#idcliente').val();
                fecha_g = $('#fecha').val();
                detalle_g = [];
                var existe = false;
                if(fecha_g ==''){
                    alert('Error, ingresar una fecha')
                    return false;
                
                }
                if(idcliente_g != '0'){
                    $('#tab_logic tbody tr').each(function(i, element) {
                        var html = $(this).html();
                        if (typeof ($(this).find('.serie').html()) != 'undefined') {//if (html != '') {
                            detalle_g.push({
                                serie: $(this).find('.serie').html(),
                                costo: 0,
                                precio_venta: $(this).find('.price').val(),
                                garantia_meses: $(this).find('.garantia').val(),
                                idinventario_mercaderia: $(this).find('.idinventario_mercaderia').val(),
                            });
                            existe = true;
                        }
                    });
                    if(!existe){
                        alert('Agregar por lo menos 1 producto')
                    }else{
                        $('#modal_metodo').modal('show');

                        /**if(confirm('Realizar el pago ¿a crédito?')){
                            
                        }else{
                            
                        } */
                    }
                    
                }else{
                    alert('Agregar cliente');
                }
            });

            $('#contado').click(function(){
                guardar_venta_('si');
            })
            $('#credito').click(function(){
                $('#modal_pagos').modal('show');
                $('#modal_metodo').modal('hide');
            })

            var data_add_venta = function(fechai, tipo, cuotas, idcuentabancaria, pago){
                var iva = $('#tax').val();
                var data = {
                    idcliente:idcliente_g,
                    fecha:fecha_g,
                    detalle: JSON.stringify(detalle_g),
                    fechai:fechai,
                    tipo:tipo,
                    cuotas:cuotas,
                    iva:iva,
                    idcuentabancaria:idcuentabancaria,
                    pago:pago
                }
                return data;
            }

            $('#guardarventa').click(function(){
                guardar_venta_('no');
            });
            
            $("#tax").attr('maxlength', 3);
            $("#tax").on('input',function(){
                this.value = this.value.replace(/[^0-9.]/g,'');
            });
        });
        </script>
    </div>
</body>

</html>