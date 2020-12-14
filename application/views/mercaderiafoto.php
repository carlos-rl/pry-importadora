<?php $this->load->view('archivos/typehtml') ?>
<html lang="<?php $this->load->view('archivos/lang') ?>">

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title><?= $title ?> </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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

    .form-control {
        padding: 5px 12px;
    }
    </style>
    <!--FOTO-->
    <link href="<?= base_url() ?>static/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>static/bootstrap-fileinput/themes/explorer/theme.min.css" rel="stylesheet"
        type="text/css" />
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

                        <p>
                            <?= $subtitle ?>
                            
                        </p>

                    </div>
                    <div class="panel">
                        <div class="panel-body">
                            <h3 class="title-hero">Galería<a href="<?= base_url('mercaderia') ?>" class="btn btn-primary pull-right">Regresar</a></h3>
                            <div class="table-section">
                                <div class="row">

                                    <div class="col-sm-12 col-lg-12">
                                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                            <form id="demo-form2" class="form-horizontal" role="form"
                                                enctype="multipart/form-data">
                                                <input type="hidden" name="action" id="action" value="imagen">
                                                <input id="file-1" required="" type="file" value=""
                                                    accept="image/png, .jpg, image/gif" multiple class="file-loading"
                                                    data-min-file-count="1" data-max-file-count="5"
                                                    data-preview-file-type="any" name="foto[]">
                                            </form>
                                        </div>
                                    </div><br>
                                    <?php $i= 0; foreach ($listar as $key => $value) { $i++;?>
                                    <div class="col-sm-12 col-lg-3">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <label class="h4">Imagen <?= $i ?> </label>
                                                <button value="<?= $value['idimagen'] ?>"
                                                    class="delete btn btn-danger btn-xs pull-right"><i
                                                        class="fa fa-fw fa-trash"
                                                        title="Eliminar imagen"></i></button>
                                            </div>
                                            <div class="panel-body">
                                                <div class="thumbnail">
                                                    <a href="<?= base_url() ?><?= $value['foto'] ?>"
                                                        style="width: 200px;height: 200px;display: block;background-image: url('<?= base_url() ?><?= $value['foto'] ?>');background-position: center;background-repeat: no-repeat;background-size: cover;">

                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/skycons/skycons.js"></script>

        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        <!--foto-->
        <script src="<?= base_url() ?>static/bootstrap-fileinput/js/plugins/sortable.min.js" type="text/javascript">
        </script>
        <script src="<?= base_url() ?>static/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/bootstrap-fileinput/js/locales/es.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>static/bootstrap-fileinput/themes/explorer/theme.min.js" type="text/javascript">
        </script>
        <script>
        $(function() {

            //FORM ARCHIVO
            var form;
            var fil = $('#file-1').fileinput({
                language: 'es',
                uploadAsync: false,
                uploadUrl: '<?= base_url() ?>mercaderia/editarimagen',
                showUpload: true,
                overwriteInitial: false,
                removeFromPreviewOnError: true,
                allowedFileExtensions: ['png', 'jpg', 'gif'],
                //overwriteInitial: false,
                initialPreviewAsData: true,
                maxFileSize: 2000,
                maxFilesNum: 5,
                'showPreview': true,
                browseClass: "btn btn-primary",
                uploadLabel: 'Subir Imagen',
                browseLabel: 'Examinar &hellip;',
                'browseIcon': '<span class="fa fa-folder-open"><span>',
                dropZoneTitle: '<strong>Arrastre y suelte aquí los archivos <span class="fa fa-image"><span></strong><p style="font-size:10px"><?= $this->session->userdata('nombre') ?></p>',
                previewFileIconSettings: {
                    'xlsx': '<span class="fa fa-file-excel-o"><span>',
                },
                uploadExtraData: {
                    'action': 'imagen',
                    'id': '<?= $id ?>'
                }
                //'elErrorContainer': '#errorBlock'slugCallback: function (filename) {
            });
            var refreshIntervalId;
            $('#file-1').on('filebatchuploadsuccess', function(event, data, previewId, index) {
                var form = data.form,
                    files = data.files,
                    extra = data.extra,
                    response = data.response,
                    reader = data.reader;
                $('#file-1').fileinput('clear');
                //$.isLoading("hide");
                //window.location = '<?= base_url() ?>novedad?id=<?= $id ?>';
                location.reload();
                clearInterval(refreshIntervalId);
            });
            $('#file-1').on('filebatchpreupload', function(event, data, previewId, index) {
                var n = 1;
                var l = document.getElementById("number");
                refreshIntervalId = window.setInterval(function() {
                    l.innerHTML = n + ' s';
                    n++;
                }, 1000);
            });
            $('#file-1').on('filebatchuploaderror', function(event, data, msg) {
                var form = data.form,
                    files = data.files,
                    extra = data.extra,
                    response = data.response,
                    reader = data.reader;
            });
            $('.crea-nuevo').click(function() {
                $('#panel-lista').slideDown('slow');
                $('#panel-form').slideUp('slow');
                $('#file-1').fileinput('clear');
                $('#error_subir').css('display', 'none');
            });
            $('.delete').on('click', function() {
                var id = $(this).val();
                var btn = $(this);
                $.ajax({
                    url: '<?= base_url() ?>/mercaderia/eliminarimagenid',
                    type: 'POST',
                    data: {
                        'id': id
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.delete').prop('disabled', true);
                        btn.html(
                            '<i class="fa fa-fw fa-refresh fa-spin" title="Espere eliminando.."></i>'
                        );
                    }
                }).done(function(data) {
                    if (data.resp) {
                        location.reload();
                    } else {
                        alert('Error al eliminar');
                        location.reload();
                    }
                    return;
                }).fail(function() {
                    alert('Error al eliminar');
                    location.reload();
                });
            })
        });
        </script>
    </div>
</body>

</html>