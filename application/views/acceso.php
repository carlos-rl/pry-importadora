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
                            <div class="col-md-12">
                                <a style="z-index:900" href="<?= base_url('roles') ?>" class="btn btn-alt btn-primary pull-right" id="">
                                    Regresar
                                </a>
                                <h2 class="invoice-client mrg10T">Información del rol:</h2>
                                <h5><label for=""><label for="" id="nombre"><?= $grupo->nombre ?> </label></label> </h5>
                                <address class="invoice-address">
                                    <b>Estado:</b> <span class="bs-label label-success">Rol activo</span>
                                </address>
                            </div>
                        </div>

                        <table class="table mrg20T table-hover table-bordered" id="tab_logic">
                            <thead>
                                <tr>
                                    <tr>
										<th>Nombre de la página</th>
										<th class="cw text-center">Exportar</th>
										<th class="cw text-center">Listar</th>
										<th class="cw text-center">Leer</th>
										<th class="cw text-center">Crear</th>
										<th class="cw text-center">Eliminar</th>
										<th class="cw text-center">Editar</th>
									</tr>
                                </tr>
                            </thead>
                            <tbody id="tbody_detalle_list">
                                <tr>
                                    <td class="text-center" colspan="7" id="loading_detalle">Ningún dato</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        <script src="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script><!-- bootstrap time picker -->
        <script src="<?= base_url() ?>static/moment/moment.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/moment/locale/es.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/bootstrap-datetimepicker-master/build/js/bootstrap-datetimepicker.min.js"></script>
        
        <script>
        $(function() {
            var accesos = function(ins, data){
                var html = '';
                var ver = '';
                var crear = '';
                var editar = '';
                var eliminar = '';
                var listar = '';
                var exportar = '';
                var disabled = '<td class="text-center"><button disabled class="btn btn-default btn-xs" ><i class="fa fa-times"></i></button></td>';

                if(data[5] == '1'){
                    exportar +='<td class="text-center"><button class="btn btn-default btn-xs" rel="detalle" data-json=\'{"iddetallegrupo":' + ins.iddetallegrupo + ',"action":"export"}\' value="'+ins.export+'"><i class="fa fa-'+(ins.export==1?'check-square-o':'square-o')+'"></i></button></td>';
                }else{
                    listar += disabled;
                }
                if(data[4] == '1'){
                    listar +='<td class="text-center"><button class="btn btn-default btn-xs" rel="detalle" data-json=\'{"iddetallegrupo":' + ins.iddetallegrupo + ',"action":"listar"}\' value="'+ins.listar+'"><i class="fa fa-'+(ins.listar==1?'check-square-o':'square-o')+'"></i></button></td>';
                }else{
                    listar += disabled;
                }
                if(data[0] == '1'){
                    ver +='<td class="text-center"><button class="btn btn-default btn-xs" rel="detalle" data-json=\'{"iddetallegrupo":' + ins.iddetallegrupo + ',"action":"ver"}\' value="'+ins.ver+'"><i class="fa fa-'+(ins.ver==1?'check-square-o':'square-o')+'"></i></button></td>';
                }else{
                    ver += disabled;
                }
                if(data[1] == '1'){
                    crear +='<td class="text-center"><button class="btn btn-default btn-xs" rel="detalle" data-json=\'{"iddetallegrupo":' + ins.iddetallegrupo + ',"action":"crear"}\' value="'+ins.crear+'"><i class="fa fa-'+(ins.crear==1?'check-square-o':'square-o')+'"></i></button></td>';
                }else{
                    crear += disabled;
                }
                if(data[2] == '1'){
                    editar +='<td class="text-center"><button class="btn btn-default btn-xs" rel="detalle" data-json=\'{"iddetallegrupo":' + ins.iddetallegrupo + ',"action":"editar"}\' value="'+ins.editar+'"><i class="fa fa-'+(ins.editar==1?'check-square-o':'square-o')+'"></i></button></td>';
                }else{
                    editar += disabled;
                }
                if(data[3] == '1'){
                    eliminar +='<td class="text-center"><button class="btn btn-default btn-xs" rel="detalle" data-json=\'{"iddetallegrupo":' + ins.iddetallegrupo + ',"action":"eliminar"}\' value="'+ins.eliminar+'"><i class="fa fa-'+(ins.eliminar==1?'check-square-o':'square-o')+'"></i></button></td>';
                }else{
                    eliminar += disabled;
                }
                return exportar+listar+ver+crear+eliminar+editar;
            }
            var buscar_grupo = {
                detalle: function(id){
                    $.ajax({
                        url: '<?= base_url() ?>/roles/buscar',
                        type: 'POST',
                        data: {'idgrupo': <?= $idgrupo ?>},
                        dataType: 'JSON',
                        beforeSend: function () {
                            $('#tbody_detalle_list tr').remove();
                            $("#tbody_detalle_list").append('<tr><td align="center" colspan="5"><i class="fa fa-refresh fa-spin"></i> Buscando...</td></tr>');
                        }
                    }).done(function (data) {
                        data = data.data;
                        $('#tbody_detalle_list tr').remove();
                        var total = 0;
                        for(var i in data){
                            var ins = data[i];
                            var html = '<tr>';
                            html +='<td class="h4">'+ins.nombre+'</td>';
                            if( (ins.idpagina === '11') || (ins.idpagina === '9') ){
                                html += accesos(ins, [1, 0, 0, 1, 1, 1]);
                            }else{
                                if(ins.idpagina === '18' || (ins.idpagina === '15') ){
                                    html += accesos(ins, [1, 1, 0, 1, 1, 1]);
                                }else{
                                    if(ins.idpagina === '17'){
                                        html += accesos(ins, [1, 0, 0, 0, 1, 1]);
                                    }else{
                                        if(ins.idpagina === '1'){
                                            html += accesos(ins, [1, 0, 1, 0, 1, 1]);
                                        }else{
                                            if(ins.idpagina === '1'){
                                                html += accesos(ins, [1, 1, 0, 0, 1, 1]);
                                            }else{
                                                html += accesos(ins, [1, 1, 1, 1, 1, 1]);
                                            }
                                        }
                                    }
                                }
                                
                            }
                            html +='</tr>';
                            $("#tbody_detalle_list").append(html);
                            
                        }
                        if(data.length < 1){
                            var html = '<tr>';
                            html +='<td class="text-center" colspan="5">Ningún dato</td>';
                            html +='</tr>';
                            $("#tbody_detalle_list").append(html);
                        }
                        $('#totaldetalle').html(parseFloat(total).toFixed(2)+' $');
                        return;
                    }).fail(function () {
                        $('#tbody_detalle_list tr').remove();
                        $("#tbody_detalle_list").append('<tr><td align="center" colspan="5"><i class="fa fa-warning"></i> Error al recuperar los datos!!</td></tr>');
                        setTimeout(function(){
                            $('#loading_detalle').html('Ningún dato');
                        },2000);
                    });
                }
            }
            buscar_grupo.detalle();
            $('#tbody_detalle_list').on('click', 'button[rel="detalle"]', function () {
                var data = $(this).data('json'),
                    id = data.iddetallegrupo,
                    action = data.action;
                var btn = $(this);
                var icon = btn.html();
                var estado = (icon=='<i class="fa fa-check-square-o"></i>'?0:1);
                
                var loading = '<i class="fa fa-circle-o-notch fa-spin"></i>';
                var warning = '<i class="fa fa-warning"></i>';
                var nuevo_icono = (icon=='<i class="fa fa-check-square-o"></i>'? '<i class="fa fa-square-o"></i>':'<i class="fa fa-check-square-o"></i>');
                $.ajax({
                    url: '<?= base_url() ?>/roles/editar_detalle',
                    type: 'POST',
                    data: {iddetallegrupo: id, 'estado': estado, 'action': action},
                    dataType: 'JSON',
                    beforeSend: function () {
                        btn.html(loading);
                        $('#tbody_detalle_list').find('button[rel="detalle"]').prop('disabled', true);
                    }
                }).done(function (data) {
                    if (data.resp) {
                        btn.val(estado);
                        $('#tbody_detalle_list').find('button[rel="detalle"]').prop('disabled', false);
                        btn.html(nuevo_icono);
                    } else {
                        btn.html(warning);
                        setTimeout(function(){
                            btn.html(icon);
                            $('#tbody_detalle_list').find('button[rel="detalle"]').prop('disabled', false);
                        },2000);
                    }
                    return;
                }).fail(function () {
                    btn.html(warning);
                    setTimeout(function(){
                        btn.html(icon);
                        $('#tbody_detalle_list').find('button[rel="detalle"]').prop('disabled', false);
                    },2000);
                });

            });
            
        });
        </script>
    </div>
</body>

</html>