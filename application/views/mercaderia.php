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
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>static/date.css">
    <link href="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet"
        type="text/css" />
    <link href="<?= base_url() ?>static/bootstrap-chosen-master/bootstrap-chosen.css" rel="stylesheet"
        type="text/css" />
    <style>
    
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
                        <h2><?= $nombre ?></h2>

                        <p><?= $subtitle ?></p>

                    </div>

                    <?php echo $output; ?>
                </div>
            </div>
        </div>
        <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/skycons/skycons.js"></script>

        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        <script src="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.js" type="text/javascript">
        </script>
        <script>
        $(function() {
            $('#field-modelo').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-Z0-9\s]/g,'');
            });
            $('.table.table-bordered.grocery-crud-table.table-hover tbody').on('click', 'button[rel="catalogo"]', function() {
                var id = $(this).val();
                var btn = $(this);
                var icon = btn.html();
                var estado = (icon == '<i class="fa fa-check-square-o"></i>' ? 0 : 1);
                var html_ = (icon == '<i class="fa fa-check-square-o"></i>' ? '<i class="fa fa-square-o"></i>' : '<i class="fa fa-check-square-o"></i>');
                var loading = '<i class="fa fa-circle-o-notch fa-spin"></i>';
                var warning = '<i class="fa fa-warning"></i>';
                $.ajax({
                    url: '<?= base_url() ?>/mercaderia/catalogo',
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
        })
        </script>

    </div>
</body>

</html>