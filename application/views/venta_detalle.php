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
                                <a href="<?= base_url('ventas') ?>" class="btn btn-alt btn-danger">
                                    <span>Cancelar</span>
                                    <i class="glyph-icon fa-refresh"></i>
                                </a>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="invoice-client mrg10T">Información del cliente:</h2>
                                <h5><label for=""><label for="" id="nombre"><?= $idcliente->nombres ?> </label></label> </h5>
                                <address class="invoice-address">
                                    <p for="" id="ruc"><?= $idcliente->cedula ?></p>
                                    <p for="" id="direccion"><?= $idcliente->direccion ?></p>
                                    <p for="" id="telefono"><?= $idcliente->telefono ?></p>
                                </address>
                                <input type="hidden" id="idproveedor" value="<?= $idcliente->idcliente ?>">
                            </div>
                            <div class="col-md-4">
                                <h2 class="invoice-client mrg10T">Información de la venta:</h2>
                                <ul class="reset-ul">
                                    <li style="display: flex;"><b>Fecha:</b> <span><?= $idcliente->fecha ?></span></li>
                                    <li>
                                    <?php if($idcliente->estado_v == '1'){ ?>
                                        <b>Estado:</b> <span class="bs-label label-success">Venta guardada</span>
                                    <?php }else{ ?>
                                        <b>Estado:</b> <span class="bs-label label-warning">Venta no guardada</span> <button id="guardar_venta" title="Guardar venta" class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i></button>
                                    <?php } ?>
                                    </li>
                                    <li><b>Id:</b> # <span id="idcompra"><?= str_pad($idcompra_after, 4, "0", STR_PAD_LEFT) ?></span></li>
                                </ul>
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
                                <tr class="font-bold font-black" style="display:none">
                                    <td colspan="6" class="text-right">Subtotal:</td>
                                    <td colspan="3" id="sub_total">$0.00</td>
                                    <input type="hidden" class="form-control" id="tax" value="0" placeholder="0">
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
                                    <input type="text" class="form-control" id="fechai" placeholder="Ingresar fecha">
                                </div>
                                <div class="col-md-4"><br>
                                    <label for="">Tipo de intervalo</label>
                                    <select name="" id="tipo" class="form-control">
                                        <option value="1">Mes</option>
                                        <option value="2">Semana</option>
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
                                        Guardar venta
                                    </button>
                                <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        <script src="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script><!-- bootstrap time picker -->
        <script src="<?= base_url() ?>static/moment/moment.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/moment/locale/es.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js"></script>
        
        <script>
        $(function() {
            var i_global = 1;
            var idglobal = 1;
            $('#fechai').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#fechai').data("DateTimePicker").minDate("<?= $idcliente->fecha ?>");

            $('#seleccionar_proveedor').click(function(){
                $('#modal_proveedor').modal('show');
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
                html += '<td>'+data.mercaderia.nombre+' - '+data.mercaderia.modelo+'</td>'
                html += '<td>'+data.garantia.text+'</td>'
                html += '<td class="text-center">$ '+data.costo;
                html += '<input type="hidden" id="costo_'+id+'" costo="'+id+'" value="'+data.costo+'" placeholder="Ingresar el costo" class="form-control qty">'
                html += '</td>'
                html += '<td>$ '+data.precio_venta+'<input type="hidden" readonly id="precio_'+id+'" precio= "'+id+'" value="'+data.precio_venta+'" placeholder="Precio al público" class="form-control price"></td>'
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
            
            


            var agregar = function(idventa_mercaderia, garantia, idgarantia, serie, idmercaderia, datosmercaderia, costo, precio_venta){
                var dat = {
                    serie: serie,
                    garantia: {
                        text:garantia,
                        id:idgarantia
                    },
                    mercaderia: datosmercaderia,
                    costo: costo,
                    precio_venta: precio_venta
                }
                b = i_global - 1;
                $("#addr0").html('');
                $('#addr' + i_global).html(tr_table(idventa_mercaderia, dat));
                $('#tab_logic').append('<tr id="addr' + (i_global + 1) + '"></tr>');

                
                i_global++;
            }

            var inventarios = <?= json_encode($idinventario) ?>;
            for (let i = 0; i < inventarios.length; i++) {
                var ins = inventarios[i];
                agregar(ins.idventa_mercaderia, (ins.garantia_meses+ ' mes(es) de garantía'), ins.garantia_meses, ins.serie, ins.idmercaderia, {
                    idmercaderia: ins.idmercaderia,
                    nombre:ins.nombre,
                    modelo:ins.modelo
                }, 
                ins.costo, ins.precio);
                
            }
            calc();
            

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
                        var idmercaderia = '';
                        var idmercaderia = $(this).find('.idmercaderia').val();
                        if(idmercaderia === ins){
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
                        var costo = $(this).find('.qty').val();
                        $(this).find('.total').html((qty * price).toFixed(2));

                        
                        $(this).find('td:first-child').html(id);
                        id++;
                        
                        calc_total();
                        
                    }
                });
            }

            var total_g = 0;
            function calc_total() {
                total_g = 0;
                total = 0;
                $('.total').each(function() {
                    total += parseInt($(this).html());
                    total_g += parseInt($(this).html());
                });
                $('#sub_total').html('$ '+total.toFixed(2));
                tax_sum = total / 100 * $('#tax').val();
                $('#tax_amount').html('$'+tax_sum.toFixed(2));
                $('#total_amount').html('$'+(tax_sum + total).toFixed(2));
            }

            $('#tab_logic tbody').on('click', 'button.deletes', function() {
                var id = $(this).val();
                var btn = $(this);
                $.ajax({
                    url: '<?= base_url() ?>venta/eliminar',
                    type: 'POST',
                    data: {
                        idventa_mercaderia: id 
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.prop('disabled', true);
                        btn.html('<i class="fa fa-refresh fa-spin"></i>');
                    }
                }).done(function(data) {
                    location.reload();
                    return;
                }).fail(function() {
                    btn.html('<i class="fa fa-warning"></i>');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                });;
            });
            var idproveedor_g = '';
            var fecha_g = '';
            var detalle_g = [];
            
            $('#guardarventa').click(function(){
                var idventa = <?= $idcompra_after ?>;
                var fechai = $('#fechai').val();
                var tipo = $('#tipo').val();
                var cuotas = $('#cuotas').val();
                var idcuentabancaria = $('#idcuentabancaria').val();

                $.ajax({
                    url: '<?= base_url() ?>venta/editarventa',
                    type: 'POST',
                    data: {
                        idventa:idventa,
                        total:total_g,
                        fechai:fechai,
                        idcliente:<?= $idcliente->idcliente ?>,
                        tipo:tipo,
                        cuotas:cuotas,
                        idcuentabancaria:idcuentabancaria,
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.row').find('input, textarea, button, select').prop('disabled',
                            true);
                        $('#guardarventa').html(
                            '<i class="fa fa-refresh fa-spin"></i> Espere..');
                    }
                }).done(function(data) {
                    $('.row').find('input, textarea, button, select').prop('disabled', false);
                    $('#guardarventa').html('<i class="fa fa-check"></i> Tu venta fué guardada con éxito');
                    alert('Venta guardada');
                    location.reload();
                    return;
                }).fail(function() {
                    $('.row').find('input, textarea, button, select').prop('disabled', false);
                    $('#guardarventa').html(
                        '<i class="fa fa-warning"></i> Tus datos no fueron guardados');
                    setTimeout(function() {
                        $('#guardarventa').html(
                            '<i class="fa fa-save"></i> Crear Registro');
                    }, 2000);
                });
            });
            $('#guardar_venta').click(function(){
                calc_total();
                $('#modal_pagos').modal('show');
                

            });
            
        });
        </script>
    </div>
</body>

</html>