<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gasto extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'gasto';
        $this->Data->id = 'idgasto';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'gasto');
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
        
        $output->title = 'Gastos';
        $output->nombre = 'Gastos generales';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('gasto.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Gastos');
        $crud->set_crud_url_path(base_url('gasto/index'));

        $crud->set_table('gasto');
        $crud->columns('fecha','valor','idtipogasto');
        $crud->display_as('fecha', 'Fecha del gasto')
        ->display_as('idtipogasto', 'Tipo del gasto')
        ->display_as('valor', 'Valor del gasto')
        ->display_as('idimportadora', 'Importadora');

        $crud->set_relation('idtipogasto','tipogasto','{nombre}');
        $crud->required_fields('idtipogasto','valor','fecha');

        $crud->field_type('estado', 'hidden', 1)
        ->field_type('idimportadora', 'hidden', 1)
        ->field_type('valor', 'integer');

        $crud->callback_column('fecha',array($this,'_callback_fecha'));
        $crud->callback_column('valor',array($this,'_callback_valor'));

        $this->_example_output($crud);
    }

    function _callback_fecha($value, $row){
        return "<i class='fa fa-calendar'></i> $value";
    }
    function _callback_valor($value, $row){
        return "<i class='fa fa-dollar'></i> $value";
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
        $this->load->view('informe/gasto.php',array(
            'title' => 'Informe de gastos',
            'nombre' => '',
            'gastos' => $this->Data->gastosinforme(),
            'data_accessos' => $accesos,
            'subtitle' => 'Buscar por rango o por tipo de gasto',
            'fecha' => $fecha
        ));
    }

    public function listarreporte() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                echo '{"lista":'.json_encode(
                                    $this->Data->gasto_informe($post->idtipogasto, $post->fechai, $post->fechaf)
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
                $dat = $this->Data->gasto_informe($post->idtipogasto, $post->fechai, $post->fechaf);
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
                $mpdf->writeHTML(file_get_contents(base_url() . 'static/html/style.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y/%m/%d %H:%M:%S");
                $url = base_url();
                $htmlPage = file_get_contents('static/html/gasto.html');

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
                $htmlPage = str_ireplace('{{report_nombre}}', 'Informe de gastos', $htmlPage);
                //FIN DE DATOS DE LA FACTURA

                $total = 0;
                $b = 0;
                foreach ($dat as $x):
                    $total = $total + $x->valor;
                    $b++;
                    $htmlTable .= '<tr class="service">';
                    $htmlTable .= '<td class="tableitem">' . $b .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->fecha .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->nombre .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->valor .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->valor .'</td>';
                    $htmlTable .= '</tr>';
                endforeach;
                if(count($dat)==0){
					$htmlTable .= '<tr>';
                    $htmlTable .= '<td colspan="5" align="center">Ningún dato disponible - Impreso '.$fecha .'</td>';
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