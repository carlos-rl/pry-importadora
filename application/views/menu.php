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
    <link rel="stylesheet" type="text/css"
        href="<?= base_url('static/admin/') ?>assets/widgets/owlcarousel/owlcarousel.css">
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
                        <h2>Dashboard</h2>

                        <!--
                            <p>The most complete user interface framework that can be used to create stunning admin
                            dashboards
                            and presentation websites.</p>
                        -->

                    </div>

                    <div class="row">
                        <div class="col-md-8">

                            <div class="row">
                                <div class="col-md-3">
                                    <a href="<?= base_url('compras') ?>" title="Compas"
                                        class="tile-box tile-box-shortcut btn-danger">
                                        <span class="bs-badge badge-absolute"><?= str_pad($numcompra, 8, "0", STR_PAD_LEFT) ?></span>
                                        <div class="tile-header">
                                            Compras
                                        </div>
                                        <div class="tile-content-wrapper">
                                            <i class="glyph-icon fa fa-dollar"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="<?= base_url('ventas') ?>" title="Ventas"
                                        class="tile-box tile-box-shortcut btn-success">
                                        <span
                                            class="bs-badge badge-absolute"><?= str_pad($numventa, 8, "0", STR_PAD_LEFT) ?></span>
                                        <div class="tile-header">
                                            Ventas
                                        </div>
                                        <div class="tile-content-wrapper">
                                            <i class="glyph-icon fa fa-archive"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="<?= base_url('cliente') ?>" title="Clientes"
                                        class="tile-box tile-box-shortcut btn-info">
                                        <span class="bs-badge badge-absolute"><?= str_pad($numcliente-1, 8, "0", STR_PAD_LEFT) ?></span>   
                                        <div class="tile-header">
                                            Clientes
                                        </div>
                                        <div class="tile-content-wrapper">
                                            <i class="glyph-icon fa fa-user"></i>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="<?= base_url('proveedor') ?>" title="Proveedores"
                                        class="tile-box tile-box-shortcut btn-warning">
                                        <span class="bs-badge badge-absolute"><?= str_pad($numproveedor, 8, "0", STR_PAD_LEFT) ?></span>   

                                        <div class="tile-header">
                                            Proveedores
                                        </div>
                                        <div class="tile-content-wrapper">
                                            <i class="glyph-icon fa fa-users"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="panel mrg20T">
                                <div class="panel-body">
                                    <h3 class="title-hero">
                                        Comparación de compras y ventas de este mes
                                    </h3>

                                    <div class="example-box-wrapper">
                                        <div id="data-example-1" class="mrg20B" style="width: 100%; height: 300px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-box dashboard-box-chart bg-white content-box">
                                <div class="content-wrapper">
                                    <div class="header">
                                        <?php $total= 0; for ($i = 0; $i < count($todos_anios); $i++) { 
                                            $total = $total+ ($todos_anios[$i]['precio']);
                                        } ?>
                                        $ <?= round($total, 2) ?>
                                        <span>Ventas realizadas durante <b> los primeros</b> 6 años</span>
                                    </div>
                                    <div class="center-div sparkline-big-alt">
                                    <?php for ($i = 0; $i < count($todos_anios); $i++) { ?>
                                        <?= round($todos_anios[$i]['precio'], 2) ?><?= (((count($todos_anios)) == $i + 1) ? ' ' : ' ,') ?>
                                    <?php } ?>    
                                    </div>
                                    <div class="row list-grade">
                                        <?php foreach ($anios as $key => $x) { ?>
                                        <div class="col-md-2"><?= $x->anio ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="content-box">
                                <div class="panel-body">
                                    <h3 class="title-hero">
                                        Modelos y marcas de la mercaderías
                                    </h3>

                                    <div class="example-box-wrapper">
                                        <div
                                            class="owl-carousel-4 slider-wrapper inverse arrows-outside carousel-wrapper">
                                            <?php foreach ($imagen as $key => $x) { ?>
                                            <div>
                                                <div class="thumbnail-box-wrapper mrg5A">
                                                    <div class="thumbnail-box">
                                                        <img src="<?= base_url($x->foto) ?>" alt="">
                                                    </div>
                                                    <div class="thumb-pane">
                                                        <h3 class="thumb-heading animated rollIn">
                                                            <a title="Modelo" href="#" title="">
                                                                <?= $x->modelo ?>
                                                            </a>
                                                            <small><?= $x->nombre ?></small>
                                                        </h3>
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
            </div>
        </div>

        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/skycons/skycons.js"></script>

        <!-- Data tables -->

        <!--<link rel="stylesheet" type="text/css" href="assets/widgets/datatable/datatable.css">-->
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/datatable/datatable.js">
        </script>
        <script type="text/javascript"
            src="<?= base_url('static/admin/') ?>assets/widgets/datatable/datatable-bootstrap.js"></script>
        <script type="text/javascript"
            src="<?= base_url('static/admin/') ?>assets/widgets/datatable/datatable-tabletools.js"></script>

        <script type="text/javascript">
        /* Datatables basic */

        $(document).ready(function() {
            $('#datatable-example').dataTable();
        });

        /* Datatables hide columns */

        $(document).ready(function() {
            var table = $('#datatable-hide-columns').DataTable({
                "scrollY": "300px",
                "paging": false
            });

            $('#datatable-hide-columns_filter').hide();

            $('a.toggle-vis').on('click', function(e) {
                e.preventDefault();

                // Get the column API object
                var column = table.column($(this).attr('data-column'));

                // Toggle the visibility
                column.visible(!column.visible());
            });
        });

        /* Datatable row highlight */

        $(document).ready(function() {
            var table = $('#datatable-row-highlight').DataTable();

            $('#datatable-row-highlight tbody').on('click', 'tr', function() {
                $(this).toggleClass('tr-selected');
            });
        });


        $(document).ready(function() {
            $('.dataTables_filter input').attr("placeholder", "Search...");
        });
        </script>

        <!-- Chart.js -->

        <script type="text/javascript"
            src="<?= base_url('static/admin/') ?>assets/widgets/charts/chart-js/chart-core.js"></script>

        <script type="text/javascript"
            src="<?= base_url('static/admin/') ?>assets/widgets/charts/chart-js/chart-doughnut.js"></script>
        <script type="text/javascript"
            src="<?= base_url('static/admin/') ?>assets/widgets/charts/chart-js/chart-demo-1.js"></script>

        <!-- Flot charts -->

        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/charts/flot/flot.js">
        </script>
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/charts/flot/flot-resize.js">
        </script>
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/charts/flot/flot-stack.js">
        </script>
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/charts/flot/flot-pie.js">
        </script>
        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/charts/flot/flot-tooltip.js">
        </script>
        
        <script type="text/javascript">
        $(function() {
            var a = [], b = [];
            var ventas = <?= json_encode($v_grafico_1) ?>;
            var compras = <?= json_encode($c_grafico_1) ?>;
            for (let i = 0; i < ventas.length; i++) {
                const ins = ventas[i];
                a.push([ins.total, ins.precio]);
            }
            for (let i = 0; i < compras.length; i++) {
                const ins = compras[i];
                b.push([ins.total, ins.precio]);
            }

            console.log(b)
            var d = $.plot($("#data-example-1"), [{
                data: a,
                label: "Compras"
            }, {
                data: b,
                label: "Ventas"
            }], {
                series: {
                    shadowSize: 0,
                    lines: {
                        show: !0,
                        lineWidth: 2
                    },
                    points: {
                        show: !0
                    }
                },
                grid: {
                    labelMargin: 10,
                    hoverable: !0,
                    clickable: !0,
                    borderWidth: 1,
                    borderColor: "rgba(82, 167, 224, 0.06)"
                },
                legend: {
                    backgroundColor: "#fff"
                },
                yaxis: {
                    tickColor: "rgba(0, 0, 0, 0.06)",
                    font: {
                        color: "rgba(0, 0, 0, 0.4)"
                    }
                },
                xaxis: {
                    tickColor: "rgba(0, 0, 0, 0.06)",
                    font: {
                        color: "rgba(0, 0, 0, 0.4)"
                    }
                },
                colors: [getUIColor("success"), getUIColor("gray")],
                tooltip: !0,
                tooltipOpts: {
                    content: "x: %x, y: %y"
                }
            });
            $("#data-example-1").bind("plothover", function(a, b) {
                $("#x").text(b.x.toFixed(2)), $("#y").text(b.y.toFixed(2))
            }), $("#data-example-1").bind("plotclick", function(a, b, c) {
                c && ($("#clickdata").text("You clicked point " + c.dataIndex + " in " + c.series
                    .label + "."), d.highlight(c.series, c.datapoint))
            })
        })
        </script>

        <!-- Sparklines charts -->

        <script type="text/javascript"
            src="<?= base_url('static/admin/') ?>assets/widgets/charts/sparklines/sparklines.js"></script>
        <script type="text/javascript"
            src="<?= base_url('static/admin/') ?>assets/widgets/charts/sparklines/sparklines-demo.js"></script>

        <!-- Owl carousel -->

        <script type="text/javascript" src="<?= base_url('static/admin/') ?>assets/widgets/owlcarousel/owlcarousel.js">
        </script>

        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>

        <script>
        $(document).ready(function() {
            $(".owl-carousel-1").owlCarousel({
                lazyLoad: !0,
                items: 4,
                navigation: !0,
                navigationText: ["<i class='glyph-icon icon-angle-left'></i>",
                    "<i class='glyph-icon icon-angle-right'></i>"
                ]
            }), $(".owl-carousel-2").owlCarousel({
                lazyLoad: !0,
                itemsCustom: [
                    [0, 2],
                    [450, 4],
                    [600, 7],
                    [700, 9],
                    [1e3, 10],
                    [1200, 12],
                    [1400, 13],
                    [1600, 15]
                ],
                navigation: !0,
                navigationText: ["<i class='glyph-icon icon-angle-left'></i>",
                    "<i class='glyph-icon icon-angle-right'></i>"
                ]
            }), $(".owl-carousel-3").owlCarousel({
                lazyLoad: !0,
                autoPlay: 3e3,
                items: 2,
                stopOnHover: !0,
                navigation: !0,
                navigationText: ["<i class='glyph-icon icon-angle-left'></i>",
                    "<i class='glyph-icon icon-angle-right'></i>"
                ],
                paginationSpeed: 1e3,
                goToFirstSpeed: 2e3,
                singleItem: !1,
                autoHeight: !0,
                transitionStyle: "goDown"
            }), $(".owl-carousel-4").owlCarousel({
                lazyLoad: !0,
                autoPlay: 3e3,
                items: 1,
                stopOnHover: !0,
                navigation: !1,
                paginationSpeed: 1e3,
                goToFirstSpeed: 2e3,
                singleItem: !1,
                autoHeight: !0,
                pagination: !1,
                transitionStyle: "goDown"
            }), $(".owl-carousel-5").owlCarousel({
                lazyLoad: !0,
                autoPlay: 3e3,
                items: 3,
                stopOnHover: !0,
                navigation: !1,
                paginationSpeed: 1e3,
                goToFirstSpeed: 2e3,
                singleItem: !1,
                autoHeight: !0,
                pagination: !1,
                transitionStyle: "goDown"
            }), $(".next").click(function() {
                owl.trigger("owl.next")
            }), $(".prev").click(function() {
                owl.trigger("owl.prev")
            }), $(".owl-slider-1").owlCarousel({
                lazyLoad: !0,
                autoPlay: 3e3,
                stopOnHover: !0,
                navigation: !0,
                navigationText: ["<i class='glyph-icon icon-angle-left'></i>",
                    "<i class='glyph-icon icon-angle-right'></i>"
                ],
                paginationSpeed: 1e3,
                goToFirstSpeed: 2e3,
                singleItem: !0,
                autoHeight: !0,
                transitionStyle: "goDown"
            }), $(".owl-slider-2").owlCarousel({
                lazyLoad: !0,
                autoPlay: 3e3,
                stopOnHover: !0,
                navigation: !0,
                navigationText: ["<i class='glyph-icon icon-angle-left'></i>",
                    "<i class='glyph-icon icon-angle-right'></i>"
                ],
                paginationSpeed: 1e3,
                goToFirstSpeed: 2e3,
                singleItem: !0,
                autoHeight: !0,
                transitionStyle: "fade"
            }), $(".owl-slider-3").owlCarousel({
                lazyLoad: !0,
                autoPlay: 3e3,
                stopOnHover: !0,
                navigation: !1,
                navigationText: ["<i class='glyph-icon icon-angle-left'></i>",
                    "<i class='glyph-icon icon-angle-right'></i>"
                ],
                paginationSpeed: 1e3,
                goToFirstSpeed: 2e3,
                singleItem: !0,
                autoHeight: !1
            }), $(".owl-slider-4").owlCarousel({
                lazyLoad: !0,
                autoPlay: 3e3,
                stopOnHover: !0,
                navigation: !0,
                navigationText: ["<i class='glyph-icon icon-angle-left'></i>",
                    "<i class='glyph-icon icon-angle-right'></i>"
                ],
                paginationSpeed: 1e3,
                goToFirstSpeed: 2e3,
                singleItem: !0,
                autoHeight: !1
            }), $(".owl-slider-5").owlCarousel({
                lazyLoad: !0,
                autoPlay: 3e3,
                stopOnHover: !0,
                navigation: !1,
                paginationSpeed: 1e3,
                goToFirstSpeed: 2e3,
                singleItem: !0,
                autoHeight: !0,
                transitionStyle: "goDown"
            })
        });
        </script>
    </div>
</body>

</html>