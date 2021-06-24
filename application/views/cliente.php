<?php $this->load->view('archivos/typehtml') ?>
<html lang="<?php $this->load->view('archivos/lang') ?>">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?= $title ?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
    </style>
    <!-- Data Tables -->
    <link href="<?= base_url() ?>static/dataTables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css"/>
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

                    


                    <table id="users" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>First name</th>
                                <th>First name</th>
                                <th>First name</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/skycons/skycons.js"></script>

        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        <!-- Data Tables -->
        <script src="<?= base_url() ?>static/lib/DataTables/media/js/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>static/lib/DataTables/media/js/dataTables.responsive.min.js"></script>
		<script src="<?= base_url() ?>static/lib/DataTables/media/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript">
		$(document).ready(function() {
			var table = $('#users').DataTable({
				serverSide: true,
                "ajax": {
                    url: '<?php echo base_url('cliente/load_data'); ?>',
                    "type": "POST",
                    data: {
                        "action": "Jsons",
                        "fechai": '',
                        "fechaf": '',
                        "estado":<?= (isset($_GET['papel'])?0:1) ?>
                        }
                },
                pageLength: 10,
                responsive: true,
                language: {
                        "sSearch": "<span class='fa fa-search'></span> ",
                        "sZeroRecords": "No se encontraron resultados",
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ":Activar para ordenar la columna de manera descendente"
                        },
                        "oPaginate": {"sFirst": "Primero", "sLast": "Último", "sNext": "<span class='fa fa-chevron-right'></span>", "sPrevious": "<span class='fa fa-chevron-left'></span>"},
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrando _MENU_",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ <b>Total: </b> _MAX_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros<br>",
                        "sInfoFiltered": "(de un total de _MAX_ registros)",
                        "sInfoPostFix": ""
                    },
                "columns": [                               
                        { 
                            "data": "0", "render": function (d, t, f) {
                                    return d+'asasss';
                                },
                                sDefaultContent: "",
                                className: 'gradeA',
                                "orderable": true
                        },
                        { 
                            "data": "1", "render": function (d, t, f) {
                                    return d+'asasss';
                                },
                                sDefaultContent: "",
                                className: 'gradeA',
                                "orderable": true
                        },
                        { 
                            "data": "2", "render": function (d, t, f) {
                                    return d+' <input type="button" class="deleteTrans" value="Delete"/>';
                                },
                                sDefaultContent: "",
                                className: 'gradeA',
                                "orderable": true
                        }
                    ]
			});
            $('#users tbody').on('click', '.deleteTrans', function () {
                var row = $(this).closest('tr');
                var transactionID = table.row( row ).data()["DT_RowId"];
                console.log(transactionID);
            });
		});
	</script>
        <script>
            $(function(){
                $('#field-nombres').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g,'');
                });
                $('#field-nombres').attr('maxlength', 40);

                $('#field-apellidos').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g,'');
                });
                $('#field-apellidos').attr('maxlength', 40);

                $('#field-cedula').on('input',function(){ 
                    this.value = this.value.replace(/[^0-9]/g,'');
                });
                $('#field-telefono').on('input',function(){ 
                    this.value = this.value.replace(/[^0-9]/g,'');
                });
                $('#correo').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-Z@._ñÑáéíóúÁÉÍÓÚ0-9-\s]/g,'');
                });
            })
        </script>
    </div>
</body>

</html>