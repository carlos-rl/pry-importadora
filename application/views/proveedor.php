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
        <script>
            $(function(){
                $('#field-nombres').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g,'');
                });
                $('#field-nombres').attr('maxlength', 40);

                $('#field-ruc').on('input',function(){ 
                    this.value = this.value.replace(/[^0-9]/g,'');
                });
                $('#field-telefono').on('input',function(){ 
                    this.value = this.value.replace(/[^0-9]/g,'');
                });
                $('#correo').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-Z@.ñÑáéíóúÁÉÍÓÚ0-9\s]/g,'');
                });
            })
        </script>
    </div>
</body>

</html>