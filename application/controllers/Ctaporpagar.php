<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ctaporpagar extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'credito_pagar';
        $this->Data->id = 'idcredito_pagar';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'ctaporpagar');
        if($ins->listar == '0'){
            $crud->unset_list();
        }
        if($ins->ver == '0'){
            $crud->unset_read();
        }
        if($ins->crear == '0'){
            $crud->unset_add();
        }
        if($ins->editar == '0'){
            $crud->unset_edit();
        }
        if($ins->eliminar == '0'){
            $crud->unset_delete();
        }
        if($ins->export == '0'){
            $crud->unset_export();
        }
        $output = $crud->render();
        $output->data_accessos = $obtener_permisos;

        $output->title = 'Cuentas por pagar';
        $output->nombre = 'Administración de Cuentas por pagar';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('ctaporpagar.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Cuentas por pagar');
        $crud->set_crud_url_path(base_url('ctaporpagar/index'));

        $crud->set_table('credito_pagar');
        $crud->set_relation('idproveedor','proveedor','{nombres} - {ruc}');
        $crud->set_relation('idcompra','compra','N° 000{idcompra}');
        $crud->columns('idcompra','idproveedor','deudainicial', 'saldo');

        $crud->display_as('saldo', 'Saldo')
        ->display_as('idcompra', 'N° Compra')
        ->display_as('idproveedor', 'Proveedor')
        ->display_as('deudainicial', 'Deuda inicial');

        $crud->add_action('Ir Pagos','','','fa fa-list', array($this, '_ir_pagos'));
        $crud->callback_column('deudainicial',array($this,'_callback_dollar'));
        $crud->callback_column('saldo',array($this,'_callback_dollar'));

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_read();

        $this->_example_output($crud);
    }

    function _ir_pagos($value, $row) {
		return base_url().'ctaporpagar/pagos/'.$row->idcredito_pagar; 
    }

    function _callback_dollar($value, $row){
        return "<i class='fa fa-dollar'></i> ".round($value, 2);
    }

    public function pagos($id=''){
        if($id == ''){
            show_404();
        }

        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        
        $this->load->view('pagodeuda.php',array(
            'title' => 'Pagos de deudas de proveedores',
            'nombre' => '',
            'idcompra_after' => $id,
            'idcredito_pagar' => $this->Data->buscarcreditopagar($id),
            'idpagodeuda' => $this->Data->buscarpagodeuda($id),
            'subtitle' => '',
            'data_accessos' => $obtener_permisos,
            'subtitle' => '',
            'fecha' => $fecha
        ));
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

    public function informe(){
        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $accesos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($accesos, 'compras');
        if($ins->crear == '0'){
            show_404();
        }
        $this->load->view('informe/ctaporpagar.php',array(
            'title' => 'Informe de Cuentas por pagar',
            'nombre' => '',
            'compras' => $this->Data->comprasinforme_ctaporpagar(),
            'data_accessos' => $accesos,
            'subtitle' => 'Buscar por rango o por proveedor',
            'fecha' => $fecha
        ));
    }

    public function listarreporte() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                echo '{"lista":'.json_encode(
                                    $this->Data->listarpagodeuda_informe($post->idproveedor, $post->fechai, $post->fechaf)
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
                $dat = $this->Data->listarpagodeuda_informe($post->idproveedor, $post->fechai, $post->fechaf);
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
                $mpdf->writeHTML(file_get_contents(base_url() . 'static/html/style.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y/%m/%d %H:%M:%S");
                $url = base_url();
                $htmlPage = file_get_contents('static/html/ctaporpagar.html');

                //DATOS DE LA EMPPRESA
                $idimportadora = $this->session->userdata('idimportadora');
                $htmlPage = str_ireplace('{{imagen}}', (base_url('static/logo-jhael.png')), $htmlPage);
                $htmlPage = str_ireplace('{{impor_nombre}}', $idimportadora->nombre, $htmlPage);
                $htmlPage = str_ireplace('{{impor_direccion}}', $idimportadora->direccion, $htmlPage);
                $htmlPage = str_ireplace('{{impor_telefono}}', $idimportadora->telefono, $htmlPage);
                $htmlPage = str_ireplace('{{impor_ruc}}', $idimportadora->ruc, $htmlPage);
                //FIN DE DATOS DE LA EMPRESA

                //DATOS DE LA FACTURA
                $htmlPage = str_ireplace('{{v_fechai}}', $post->fechai, $htmlPage);
                $htmlPage = str_ireplace('{{v_fechaf}}', $post->fechaf, $htmlPage);
                $htmlPage = str_ireplace('{{fecha_hoy}}', $fecha, $htmlPage);
                $htmlPage = str_ireplace('{{report_nombre}}', 'Informe de cuentas por pagar', $htmlPage);
                //FIN DE DATOS DE LA FACTURA

                $total = 0;
                $b = 0;
                foreach ($dat as $x):
                    $total = $total + $x->valorcheque;
                    $b++;
                    $htmlTable .= '<tr class="service">';
                    $htmlTable .= '<td class="tableitem">' . $b .'</td>';
                    $htmlTable .= '<td class="tableitem">C-' . str_pad($x->idcompra, 8, "0", STR_PAD_LEFT) .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->fecha .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->nombres .' ' . $x->ruc .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->numcheque .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->numero .' - '.$x->nombre.'</td>';
                    $htmlTable .= '<td class="tableitem">' . ($x->estado == '0'?'Pagado':'No pagado') .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->valorcheque .'</td>';
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
                $mpdf->Output('Informe de cuentas por pagar' . $fecha . '.pdf', 'D');
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }
}