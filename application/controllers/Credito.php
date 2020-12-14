<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Credito extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'credito';
        $this->Data->id = 'idcredito';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'credito');
        if($ins->listar == '0'){
            $crud->unset_list();
        }
        if($ins->eliminar == '0'){
            $crud->unset_delete();
        }
        if($ins->export == '0'){
            $crud->unset_export();
        }
        $output = $crud->render();
        $output->data_accessos = $obtener_permisos;

        $output->title = 'Créditos de clientes con sus ventas';
        $output->nombre = 'Administración de Créditos por pagar';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('credito.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Créditos de clientes con sus ventas');
        $crud->set_crud_url_path(base_url('credito/index'));

        $crud->set_table('credito');
        $crud->set_relation('idventa','venta','N° 000{idventa}');
        $crud->columns('idventa','idcliente', 'saldo','deudainicial');

        $crud->display_as('saldo', 'Saldo')
        ->display_as('idcliente', 'Cliente')
        ->display_as('idventa', 'N° Venta')
        ->display_as('deudainicial', 'Deuda inicial');

        $crud->add_action('Ir Pagos','','','fa fa-list', array($this, '_ir_pagos'));

        $crud->callback_column('deudainicial',array($this,'_callback_dollar'));
        $crud->callback_column('saldo',array($this,'_callback_dollar'));
        $crud->callback_column('idcliente',array($this,'_callback_cliente'));

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_read();

        $this->_example_output($crud);
    }

    function _callback_cliente($value, $row) {
        $cliente = $this->Data->venta_cliente_buscar($row->idventa);
		return "<i class='fa fa-user'></i> ". $cliente->nombres.' CI.'.$cliente->cedula ;
    }

    function _ir_pagos($value, $row) {
		return base_url().'credito/pagos/'.$row->idcredito; 
    }

    function _callback_dollar($value, $row){
        return "<i class='fa fa-dollar'></i> $value";
    }

    public function pagos($id=''){
        if($id == ''){
            show_404();
        }

        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $this->load->view('pagodeuda_credito.php',array(
            'title' => 'Amortización de cuotas',
            'nombre' => '',
            'idcompra_after' => $id,
            'idcredito_pagar' => $this->Data->buscarcreditopagar_venta($id),
            'data_accessos' => $obtener_permisos,
            'subtitle' => '',
            'subtitle' => '',
            'fecha' => $fecha
        ));
    }

    public function detalle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
				$post = (object) $_POST;
                echo json_encode($this->Data->buscarpagodeuda_venta($post->idcredito));
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }

    public function pago() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->Data->tabla = 'pagodeuda';
            $this->Data->id = 'idpagodeuda';
            $post = (object) $_POST;
            $data = array(
                'estado' => $post->estado,
                'numcheque' => $post->numcheque
			);
            if ($this->Data->editar($data, $post->idpagodeuda)) {
                echo '{"resp" : true}';
                exit();
            } else {
                echo '{"resp" : false,'
                . '"error" : "El registro no se guardó!!"}';
                exit();
            }
        }
    }

    public function pagar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->Data->tabla = 'amortizacion_cuotas';
            $this->Data->id = 'idamortizacion_cuotas';
            $post = (object) $_POST;
            $data = array(
                'estado' => $post->estado_pago,
            );
            if($post->estado_pago == '0'){
                $data['saldo'] = 0;
                $data['fechapagado'] = null;
            }else{
                $data['saldo'] = $post->valorcuota;
                $data['fechapagado'] = strftime("%Y-%m-%d");
            }
            if ($this->Data->editar($data, $post->idamortizacion_cuotas)) {
                echo '{"resp" : true}';
                exit();
            } else {
                echo '{"resp" : false,'
                . '"error" : "El registro no se guardó!!"}';
                exit();
            }
        }
    }

    public function saldo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            $data = array(
                'saldo' => $post->saldo,
            );
            if($post->saldo == '0'){
                $data['estado'] = 1;
            }else{
                $data['estado'] = 0;
            }
            if ($this->Data->editar($data, $post->idcredito)) {
                echo '{"resp" : true}';
                exit();
            } else {
                echo '{"resp" : false,'
                . '"error" : "El registro no se guardó!!"}';
                exit();
            }
        }
    }

    public function anticipo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->Data->tabla = 'amortizacion_cuotas';
            $this->Data->id = 'idamortizacion_cuotas';
            $post = (object) $_POST;
            $data = array(
                'valorabonado' => $post->valorabonado
            );
            $valorabonado = $post->valorabonado;
            if($post->valorabonado > $post->valorcuota){
                $data['estado'] = 1;
                $data['saldo'] = $post->valorcuota;
                $data['fechapagado'] = strftime("%Y-%m-%d");
                $valorabonado = $valorabonado - $post->valorcuota;
            }

            $this->Data->editar($data, $post->idamortizacion_cuotas);


            
            $i = 0;
            $lista = $this->Data->listarDetallePagoAnticipo($post->idcredito);
            $data = array();
            while ($valorabonado > 0) {
                $ins = $lista[$i];
                if($ins['valorcuota'] == $valorabonado){
                    $data['estado'] = 1;
                    $data['saldo'] = $valorabonado;
                    $data['valorabonado'] = 0;
                    $valorabonado = 0;
                    
                    $data['fechapagado'] = strftime("%Y-%m-%d");
                }
                if($ins['valorcuota'] > $valorabonado){
                    $data['estado'] = 2;
                    $data['valorabonado'] = 0;
                    $data['saldo'] =  $ins['valorcuota'] - ($ins['valorcuota'] - $valorabonado);
                    $valorabonado = 0;
                }
                if($ins['valorcuota'] < $valorabonado){
                    $data['estado'] = 1;
                    $data['valorabonado'] = 0;
                    $data['saldo'] =  $ins['valorcuota'];
                    $valorabonado = $valorabonado - $ins['valorcuota'];
                    $data['fechapagado'] = strftime("%Y-%m-%d");
                }

                $this->Data->editar($data, $ins['idamortizacion_cuotas']);
                $i++;
            }

            echo '{"resp" : true}';
        }
        
    }

    public function informe(){
        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $accesos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($accesos, 'compras');
        if($ins->crear == '0'){
            show_404();
        }
        $this->load->view('informe/credito.php',array(
            'title' => 'Informe de ventas a crédito',
            'nombre' => '',
            'ventas' => $this->Data->informe_credito(),
            'data_accessos' => $accesos,
            'subtitle' => 'Buscar por rango o por Número de venta',
            'fecha' => $fecha
        ));
    }

    public function listarreporte() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                echo '{"lista":'.json_encode(
                                    $this->Data->creditopagodeuda_venta($post->idventa, $post->fechai, $post->fechaf)
                                ).'}';
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }

    public function pdf() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            try {
                require_once(APPPATH . '/libraries/mpdfnew/vendor/autoload.php');
                $post = (object) $_GET;
                $dat = $this->Data->creditopagodeuda_venta($post->idventa, $post->fechai, $post->fechaf);
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
                $mpdf->writeHTML(file_get_contents(base_url() . 'static/html/style.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y/%m/%d %H:%M:%S");
                $url = base_url();
                $htmlPage = file_get_contents('static/html/credito.html');

                //DATOS DE LA EMPPRESA
                $idimportadora = $this->session->userdata('idimportadora');
                $htmlPage = str_ireplace('{{impor_nombre}}', $idimportadora->nombre, $htmlPage);
                $htmlPage = str_ireplace('{{impor_direccion}}', $idimportadora->direccion, $htmlPage);
                $htmlPage = str_ireplace('{{impor_telefono}}', $idimportadora->telefono, $htmlPage);
                $htmlPage = str_ireplace('{{impor_ruc}}', $idimportadora->ruc, $htmlPage);
                //FIN DE DATOS DE LA EMPRESA

                //DATOS DE LA FACTURA
                $htmlPage = str_ireplace('{{v_fechai}}', $post->fechai, $htmlPage);
                $htmlPage = str_ireplace('{{v_fechaf}}', $post->fechaf, $htmlPage);
                $htmlPage = str_ireplace('{{fecha_hoy}}', $fecha, $htmlPage);
                $htmlPage = str_ireplace('{{report_nombre}}', 'Informe de ventas a créditos', $htmlPage);
                //FIN DE DATOS DE LA FACTURA

                $total = 0;
                $b = 0;
                foreach ($dat as $x):
                    $total = $total + $x->valorcuota;
                    $b++;
                    $htmlTable .= '<tr class="service">';
                    $htmlTable .= '<td class="tableitem">' . $b .'</td>';
                    $htmlTable .= '<td class="tableitem">V-' . str_pad($x->idventa, 8, "0", STR_PAD_LEFT) .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->fechapagar .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->nombres .' ' . $x->apellidos .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->valorabonado .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->valorcuota .'</td>';
                    $htmlTable .= '<td class="tableitem">' . ($x->estado=='1'?'Pagado':'No apagado') .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->valorcuota .'</td>';
                    $htmlTable .= '</tr>';
                endforeach;
                if(count($dat)==0){
					$htmlTable .= '<tr>';
                    $htmlTable .= '<td colspan="8" align="center">Ningún dato disponible - Impreso '.$fecha .'</td>';
                    $htmlTable .= '</tr>';
                }
                $htmlPage = str_ireplace('{{table_row}}', $htmlTable, $htmlPage);
                //echo $htmlPage ;
                $htmlPage = str_ireplace('{{total}}', round($total,2), $htmlPage);
                $mpdf->writeHTML($htmlPage, \Mpdf\HTMLParserMode::HTML_BODY);
                $mpdf->Output('reporte_' . $fecha . '.pdf', 'D');
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }
}