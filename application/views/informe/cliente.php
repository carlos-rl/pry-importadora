<?php $this->load->view('archivos/typehtml') ?>
<html lang="<?php $this->load->view('archivos/lang') ?>">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?= $title ?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link type="text/css" rel="stylesheet"
        href="<?= base_url() ?>assets/grocery_crud/themes/bootstrap/css/bootstrap/bootstrap.min.css" />

    <?php $this->load->view('archivos/css') ?>
    <style>
    .gc-container .header-tools {
        padding: 5px 5px 10px 5px;
        border-left: 0px solid #DDD;
        border-right: 0px solid #DDD;
    }

    a,
    a:hover {
        text-decoration: none;
    }

    .gc-container .footer-tools {
        border: 1px solid rgba(158, 173, 195, .16);
    }

    .btn:hover {
        box-shadow: 0 0px 0px rgba(0, 0, 0, .23), 0 0px 0px rgba(0, 0, 0, .19);
    }

    .t3 {
        margin-top: 10px;
    }

    .report-div {
        padding: 10px 15px 15px 15px;
        margin: 0px 4px;
        font-weight: bold;
    }

    .btn-cr {
        margin: 5px;
    }

    .daterangepicker .applyBtn {
        float: right;
        width: 80px;
    }
    </style>

    <link rel="stylesheet" href="<?= base_url() ?>static/bootstrap-daterangepicker/daterangepicker.css" />
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel">
                                <div class="panel-body">
                                    <h3 class="title-hero">
                                        Informe de registros de clientes
                                    </h3>
                                    <div class="example-box-wrapper">
                                        <ul class="nav nav-pills">
                                            <li class="active"><a href="#" data-toggle="modal"
                                                    data-target="#modal_buscar"><i class="fa fa-filter"></i> Cambiar filtros</a></li>
                                            <li>
                                                <a href="#" id="exportar"><i class="fa fa-file-pdf-o"></i> Exportar como PDF</a>
                                            </li>
                                        </ul>
                                        <table class="table table-bordered table-hover" id="tab_logic">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Fecha de registro</th>
                                                    <th>Nombres</th>
                                                    <th>Cédula</th>
                                                    <th>Teléfono</th>
                                                    <th>Correo</th>
                                                    <th>Dirección</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_">
                                                <tr id='addr0'>
                                                    <td colspan="7" class="text-center">Seleccione un filtro de clientes</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal_buscar" class="modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Seleccionar filtros de búsquedas</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-horizontal bordered-row">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Por clientes</label>
                                        <div class="col-sm-9">
                                            <select name="idcliente" id="idcliente" class="form-control">
                                                <option value="0">Todos los clientes</option>
                                                <?php foreach ($ventas as $key => $x) { ?>
                                                    <option value="<?= $x->idcliente ?>">CI- <?= $x->cedula ?>, <?= $x->nombres ?> <?= $x->apellidos ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-3  control-label">
                                            <button class="btn btn-success" id="buscar">Aplicar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/skycons/skycons.js"></script>
        <!-- JS Demo -->

        <script type="text/javascript" src="<?= base_url() ?>static/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <!-- bootstrap time picker -->
        <script src="<?= base_url() ?>static/moment/moment.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/moment/locale/es.js" type="text/javascript"></script>

        <script src="<?= base_url() ?>static/bootstrap-daterangepicker/es.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/bootstrap-daterangepicker/daterangepicker.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo-2.js"></script>
        <script>
        $(function() {
            //$('#modal_buscar').modal('show')
            var idcompra = 0;
            var fechai = '';
            var fechaf = '';
            var tablaDatos = function(btn){
                $.ajax({
                    url: '<?= base_url() ?>cliente/listarreporte',
                    type: 'POST',
                    data: {
                        //'fechaf': fechaf,
                        'idcliente':fechai
                        },
                    dataType: 'JSON',
                    beforeSend: function () {
                        btn.html('Buscando...');
                        btn.prop('disabled',true);
                        $('#tbody_').html('<tr> <td colspan="7">Buscando datos <i class="fa fa-refresh fa-spin"></i></td>');
                    }
                }).done(function (data) {
                    btn.html('Aplicar');
                    btn.prop('disabled',false);

                    data = data.lista;
                    $('#tbody_ tr').remove();
                    var total = 0;
                    for(var i in data){
                        var d = data[i];
                        var html = '<tr>';
                        html +='<th scope="row">'+ (i*1+1) +'</th>';
                        html +='<td class="">'+(d.fecha).toUpperCase()+' </td>';
                        html +='<td class="">'+(d.nombres+' '+d.apellidos).toUpperCase()+'</td>';
                        html +='<td class="">'+(d.cedula==null?'':d.cedula).toUpperCase()+' </td>';
                        html +='<td class="">'+(d.telefono==null?'':d.telefono).toUpperCase()+'</td>';
                        html +='<td class="">'+(d.correo==null?'':d.correo).toUpperCase()+'</td>';
                        html +='<td class="">'+(d.direccion==null?'':d.direccion).toUpperCase()+'</td>';
                        html +='</tr>';
                        $("#tbody_").append(html);
                    }
                    if(data.length < 1){
                        $('#tbody_').html('<tr> <td colspan="7">Ningún dato en la tabla</td>');
                    }
                    $('#modal_buscar').modal('hide');
                }).fail(function () {
                    $('#tbody_').html('<tr> <td colspan="7">Error,  intente nuevamente</td>');
                });
            }
            $('input[id=fecha]').daterangepicker({
                'autoUpdateInput':false,
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Los últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'Este año': [moment().startOf('year'), moment().endOf('year')],
                    'El mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(
                        1, 'month').endOf('month')]
                },
                locale: {
                    format: 'YYYY/MM/DD',
                    cancelLabel: 'Limpiar',
                    applyLabel: 'Aceptar',
                    customRangeLabel: "Abrir Calendario"
                },
                "autoApply": false,
                startDate: moment(),
                endDate: moment(),
                "opens": "right",
                "cancelClass": "btn-danger btn-xs btn-cr",
                "applyClass": "btn-success btn-xs btn-cr"
            });
            $('#buscar').click(function(){
                fechai = $('#idcliente').val();
                tablaDatos($(this));
            });
            /***$('input[name="fecha"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                fechai = picker.startDate.format('YYYY-MM-DD');
                fechaf = picker.endDate.format('YYYY-MM-DD');
            }); */

            $('input[name="fecha"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#exportar').click(function(){
                window.location= '<?= base_url() ?>cliente/pdf?fechai='+fechai+'&fechaf='+fechaf;
            });
            $('input[name="fecha"]').on('input',function(){ 
                this.value = this.value.replace(/[^0-9/-\s]/g,'');
            });
            $('input[name="fecha"]').attr('readonly', true);
            $('input[name="fecha"]').attr('maxlength', 23);
        })
        </script>
    </div>
</body>

</html>