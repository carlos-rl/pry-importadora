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
                            <div class="col-sm-3">
                                
                                <address class="invoice-address">
                                    <?= $this->session->userdata('idimportadora')->nombre ?>
                                    <br />
                                    <?= $this->session->userdata('idimportadora')->correo ?>
                                    <br />
                                    <?= $this->session->userdata('idimportadora')->direccion ?>
                                </address>
                            </div>
                            <div class="col-sm-6 float-right text-right">
                                <h4 class="invoice-title">Compra</h4>
                                No. <b>#<?= str_pad($idcredito_pagar->idcompra, 8, "0", STR_PAD_LEFT) ?></b>
                                <div class="divider"></div>
                                <a href="<?= base_url('ctaporpagar') ?>" class="btn btn-alt btn-danger">
                                    <span>Cancelar</span>
                                    <i class="glyph-icon fa-refresh"></i>
                                </a>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <div class="row">
                            <div class="col-md-4">
                                <h2 class="invoice-client mrg10T">Información del proveedor y ysu deuda:</h2>
                                <h5><label for=""><label for="" id="nombre"><?= $idcredito_pagar->nombres ?> </label></label> </h5>
                                <address class="invoice-address">
                                <div for="" id=""><strong>RUC: </strong> <?= $idcredito_pagar->ruc ?></div>
                                    <div for="" id=""><strong>Deuda: </strong> $ <?= $idcredito_pagar->deudainicial ?></div>
                                    <div for="" id="telefono"><strong>Saldo: </strong> <?= $idcredito_pagar->saldo=='0'?'<label class="label label-success">Pagado</label>': '$ '.(round($idcredito_pagar->saldo, 2)) ?></div>
                                </address>
                            </div>
                            
                        </div>

                        <table class="table mrg20T table-hover table-bordered" id="tab_logic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pagar la deuda</th>
                                    <th>Fecha</th>
                                    <th>N° de cheque</th>
                                    <th title="Banco donde se va a guardar este pago">Banco</th>
                                    <th title="Cuenta donde se va a guardar este pago">N° Cuenta bancaria</th>
                                    <th class="text-right">Valor a pagar</th>
                                </tr>
                            </thead>
                            <tbody id="body_pago">
                                <?php $existe_ = false; ?>
                                <?php $b = 1; ?>
                                <?php $total = 0; ?>
                                <?php foreach ($idpagodeuda as $key => $x) { ?>
                                    <tr>
                                        <td class=""><?= $b ?></td>
                                        <td class="">
                                            <?php if($x->estado == '1'){ ?>
                                                <button rel="pagar" data-json='{"idpagodeuda":<?= $x->idpagodeuda ?>,"estado":"<?= $x->estado ?>"}' class="btn btn-danger btn-xs" type="button">No pagado</button>
                                            <?php }else{ ?>
                                                <button rel="pagar" data-json='{"idpagodeuda":<?= $x->idpagodeuda ?>,"estado":"<?= $x->estado ?>"}' title="Pagar" class="btn btn-success btn-xs" type="button">Pagado</button>
                                            <?php } ?>
                                            
                                        </td>
                                        <td class=""> <i class="fa fa-calendar"></i> <?= $x->fecha ?></td>
                                        <td class=""><?= ($x->numcheque == ''?'--':$x->numcheque) ?></td>
                                        <td class=""><?= ($x->nombre == ''?'--':$x->nombre) ?></td>
                                        <td class=""><?= $x->numero ?></td>
                                        <td class="text-right text-success">$ <?= round($x->valorcheque, 2) ?></td>
                                    </tr>
                                    <?php $existe_ = true; ?>
                                    <?php $total = $total + $x->valorcheque; ?>
                                    
                                    <?php $b++; ?>
                                <?php } ?>
                                
                                <?php if(!$existe_){ ?>
                                <tr>
                                    <td colspan="7" class="text-center">Ningún dato en la tabla</td>
                                </tr>
                                <?php } ?>
                                
                            </tbody>
                            <tfoot>
                                <tr class="font-bold font-black">
                                    <td colspan="6" class="text-right">TOTAL:</td>
                                    <td class="font-blue font-size-23 text-right" id="total_amount">$<?= round($total, 2) ?></td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <div id="modal_numerocheque" class="modal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="row">
                                <div class="col-md-12"><br>
                                    <label for="">Número de cheque</label>
                                    <input type="text" class="form-control" id="num_cheque" placeholder="Ingresar n° de cheque">
                                </div>
                                <div class="col-md-12">
                                <br>
                                <button class="btn btn-primary" id="aceptarnumero">
                                    Aceptar
                                </button>
                                <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal -->
        <!-- JS Demo -->
        <script type="text/javascript" src="<?= base_url() ?>static/admin/assets/admin-all-demo.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>static/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        
        <script>
        $(function() {
            var pagar = function(btn, dat){
                var icon = btn.html();
                var estado = (dat.estado == '1' ? 0 : 1);
                var loading = '<i class="fa fa-circle-o-notch fa-spin"></i>';
                var warning = '<i class="fa fa-warning"></i>';
                $.ajax({
                    url: '<?= base_url() ?>ctaporpagar/pago',
                    type: 'POST',
                    data: {
                        idpagodeuda:dat.idpagodeuda,
                        estado: estado,
                        numcheque:dat.numcheque
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.prop('disabled', true);
                        btn.html(loading);
                    }
                }).done(function(data) {
                    location.reload();
                    return;
                }).fail(function() {
                    alert('Error al realizar el pago, intente nuevamente');
                    location.reload();
                });
            };
            $('#num_cheque').on('input',function(){ 
                this.value = this.value.replace(/[^0-9]/g,'');
            });
            $('#num_cheque').attr('maxlength',9);
            var enviar_pago = function(btn, numcheque){
                
            }
            var btns_pago;
            $('#aceptarnumero').click(function(){
                var numcheque = $('#num_cheque').val();
                if((numcheque.length < 10) && (numcheque.length > 4) && (isNaN(numcheque) == false)){
                    if ((numcheque != null) && (numcheque != '')) {
                        pagar(btns_pago.btns, {
                            idpagodeuda:btns_pago.idpagodeuda,
                            estado: btns_pago.estado,
                            numcheque:numcheque
                        }, numcheque);
                    }else{
                        alert('Ingresar el N° de cheque')
                    }
                }else{
                    alert('El número no es el correcto, ingrese nuevamente')
                }
            });
            $('#body_pago').on('click', 'button[rel="pagar"]', function () {
                var loading = '<i class="fa fa-circle-o-notch fa-spin"></i>';
                var data = $(this).data('json'),
                        id = data.idpagodeuda;
                var btns = $(this);
                var numcheque = '';
                if(data.estado == '0'){
                    pagar(btns, {
                        idpagodeuda:id,
                        estado: data.estado,
                        numcheque:''
                    }, numcheque);
                }else{
                    btns_pago = {
                        idpagodeuda:id,
                        estado: data.estado,
                        numcheque:'',
                        btns
                    };
                    $('#modal_numerocheque').modal('show');
                }
                
            });
            
            
        });
        </script>
    </div>
</body>

</html>