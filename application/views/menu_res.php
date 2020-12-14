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
</head>

<body>
    <div id="sb-site">
        <div id="loading">
            <div class="svg-icon-loader">
                <img src="<?= base_url('static/admin/') ?>assets/images/svg-loaders/bars.svg" width="40" alt="">
            </div>
        </div>

        <div id="page-wrapper">
            <?php $this->load->view('web/sidebar') ?>
            <div id="page-content-wrapper">
                <div id="page-content">
                    <?php $this->load->view('web/nav') ?>
                    <div id="page-title">
                        <h2>Labels &amp; Badges</h2>
                        <p>Create numbers indicators, unread counts and text indicators.</p>

                    </div>

                    <div class="panel">
                        <div class="panel-body">
                            <h3 class="title-hero">
                                Labels
                            </h3>
                            <div class="example-box-wrapper">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Result</th>
                                                    <th>Helper class</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="bs-label label-primary">Primary</span></td>
                                                    <td><code>.label-primary</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-default">Default</span></td>
                                                    <td><code>.label-default</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-success">Success</span></td>
                                                    <td><code>.label-success</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-danger">Danger</span></td>
                                                    <td><code>.label-danger</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-warning">Warning</span></td>
                                                    <td><code>.label-warning</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-info">Info</span></td>
                                                    <td><code>.label-info</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-blue-alt">Blue alternate</span></td>
                                                    <td><code>.label-blue-alt</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-yellow">Yellow</span></td>
                                                    <td><code>.label-yellow</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-purple">Purple</span></td>
                                                    <td><code>.label-purple</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-azure">Azure</span></td>
                                                    <td><code>.label-azure</code></td>
                                                </tr>
                                                <tr>
                                                    <td><span class="bs-label label-black">Black</span></td>
                                                    <td><code>.label-black</code></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h1 class="mrg10A">Example heading <span
                                                class="bs-label label-primary">New</span></h1>
                                        <h2 class="mrg10A">Example heading <span
                                                class="bs-label label-primary">New</span></h2>
                                        <h3 class="mrg10A">Example heading <span
                                                class="bs-label label-primary">New</span></h3>
                                        <h4 class="mrg10A">Example heading <span
                                                class="bs-label label-primary">New</span></h4>
                                        <h5 class="mrg10A">Example heading <span
                                                class="bs-label label-primary">New</span></h5>
                                        <h6 class="mrg10A">Example heading <span
                                                class="bs-label label-primary">New</span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>


        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>


    </div>
</body>

</html>