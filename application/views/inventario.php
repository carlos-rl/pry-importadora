<?php $this->load->view('archivos/typehtml') ?>
<html lang="<?php $this->load->view('archivos/lang') ?>">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?= $title ?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap.min.css">
    <?php foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <?php $this->load->view('archivos/css') ?>
    <style>
    .gc-container .header-tools {
        padding: 5px 5px 10px 5px;
        border-left: 0px solid #DDD;
        border-right: 0px solid #DDD;
    }

    a, a:hover {
        text-decoration: none;
    }
    .gc-container .footer-tools {
        border: 1px solid rgba(158,173,195,.16);
    }
    .btn:hover {
        box-shadow: 0 0px 0px rgba(0,0,0,.23),0 0px 0px rgba(0,0,0,.19);
    }
    .t3 {
        margin-top: 10px;
    }
    .report-div {
        padding: 10px 15px 15px 15px;
        margin: 0px 4px;
        font-weight: bold;
    }
    .filter-row{
        display:none;
    }
    .table > tbody:nth-child(2) > tr > td:nth-child(10){
        vertical-align:middle;
        text-align: center;
    }
    </style>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <h2><?= $nombre ?></h2>
                                <p><?= $subtitle ?></p>
                            </div>
                            <div class="col-sm-6">
                                <button id="stock_btn" data-toggle="modal" data-target=".bs-example-modal-lg" style="font-weight: 9999;" class="btn btn-primary pull-right"><i class="fa fa-list"></i> Producto disponibles</button>
                            </div>
                        </div>
                    </div>
                    <?php echo $output; ?>
                </div>
            </div>
        </div>
        <?php foreach($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>

        
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/skycons/skycons.js"></script>
        

                    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Cantidad disponible de productos</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered" style="width: 100%;" id="table_id">
                                        <thead>
                                            <tr>
                                                <td>Item</td>
                                                <td>Producto/Modelo</td>
                                                <td>Cantidad Disponible</td>
                                            </tr>
                                        </thead>
                                        <tbody id="idbody_productos">
                                            <tr><td colspan="2">Productos</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap.min.js"></script>


        <script>
        $(function() {
            $('.table.table-bordered.grocery-crud-table.table-hover tbody').on('click', 'button[rel="catalogo"]', function() {
                var id = $(this).val();
                var btn = $(this);
                var icon = btn.html();
                var estado = (icon == '<i class="fa fa-check-square-o"></i>' ? 0 : 1);
                var html_ = (icon == '<i class="fa fa-check-square-o"></i>' ? '<i class="fa fa-square-o"></i>' : '<i class="fa fa-check-square-o"></i>');
                var loading = '<i class="fa fa-circle-o-notch fa-spin"></i>';
                var warning = '<i class="fa fa-warning"></i>';
                $.ajax({
                    url: '<?= base_url() ?>/inventario/catalogo',
                    type: 'POST',
                    data: {
                        'id': id,
                        'estado': estado
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.html(loading);
                        btn.prop('disabled', true);
                    }
                }).done(function(data) {
                    if (data.resp) {
                        btn.prop('disabled', false);
                        btn.html(html_);
                    } else {
                        btn.html(warning);
                        setTimeout(function() {
                            btn.html(icon);
                            btn.prop('disabled', false);
                        }, 2000);
                    }
                    return;
                }).fail(function() {
                    btn.html(warning);
                    setTimeout(function() {
                        btn.html(icon);
                        btn.prop('disabled', false);
                    }, 2000);
                });
            });
            var productosStock = function(){
                $.ajax({
                    url: '<?= base_url() ?>/inventario/stock/',
                    type: 'POST',
                    data: {
                        'id': ''
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('#idbody_productos tr').remove();
                        $('#idbody_productos').append('<tr><td colspan="2">Buscando....</td></tr>');
                    }
                }).done(function(data) {
                    $('#idbody_productos tr').remove();
                    var b = 0;
                    for(var i in data){
                        b++;
                        var html = '<tr>';
                        html += '<td class="text-center">'+b+'</td>';
                        html += '<td>'+data[i]['nombre']+' / '+data[i]['modelo']+'</td>';
                        html += '<td>'+data[i]['total']+'</td>';
                        html += '</tr>';
                        $('#idbody_productos').append(html);
                    }
                        $('#table_id').DataTable();
                    return;
                }).fail(function() {
                    alert('Error al recuperar los datos de la cantidad disponible, intente nuevamente.')
                });
            }

            productosStock();

            
        })
        </script>
    </div>
</body>

</html>