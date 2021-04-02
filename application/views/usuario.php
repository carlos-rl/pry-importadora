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
    <link href="<?= base_url() ?>static/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>static/bootstrap-chosen-master/bootstrap-chosen.css" rel="stylesheet" type="text/css" />
    
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
                $('.filter-row > td:nth-child(4) > input:nth-child(1), #admin').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ\s]/g,'');
                });
                $('#usuario').on('input',function(){ 
                    this.value = this.value.replace(/[^a-zA-ZñÑáéíóúÁÉÍÓÚ@.0-9\s]/g,'');
                });
                
                $('.filter-row > td:nth-child(7), .filter-row > td:nth-child(6) > input').remove();
                $('.filter-row > td:nth-child(6)').attr('colspan','2');



                $("input[type='password'][data-eye]").each(function(i) {
                    var $this = $(this),
                        id = 'eye-password-' + i,
                        el = $('#' + id);

                    $this.wrap($("<div/>", {
                        style: 'position:relative',
                        id: id
                    }));

                    $this.css({
                        paddingRight: 60
                    });
                    $this.after($("<div/>", {
                        html: 'Ver',
                        class: 'btn btn-primary btn-xs',
                        id: 'passeye-toggle-' + i,
                    }).css({
                        position: 'absolute',
                        right: 14,
                        top: ($this.outerHeight() / 2) - 10,
                        padding: '0px 7px',
                        fontSize: 10,
                        cursor: 'pointer',
                        color: 'white',
                    }));

                    $this.after($("<input/>", {
                        type: 'hidden',
                        id: 'passeye-' + i
                    }));

                    var invalid_feedback = $this.parent().parent().find('.invalid-feedback');

                    if (invalid_feedback.length) {
                        $this.after(invalid_feedback.clone());
                    }

                    $this.on("keyup paste", function() {
                        $("#passeye-" + i).val($(this).val());
                    });
                    var contras = $this.val();
                    $("#passeye-toggle-" + i).on("click", function() {
                        if ($this.hasClass("show")) {
                            $this.attr('type', 'password');
                            $this.removeClass("show");
                            $(this).removeClass("btn-outline-primary");
                            $this.val(contras)
                        } else {
                            $this.attr('type', 'text');
                            $this.val($("#passeye-" + i).val());
                            $this.addClass("show");
                            $(this).addClass("btn-outline-primary");
                            $this.val(contras)
                        }
                    });
                });
            })
        </script>
    </div>
</body>

</html>