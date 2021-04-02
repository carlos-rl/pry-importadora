<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Devolverventa extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'devolucion';
        $this->Data->id = 'iddevolucion';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'devolverventa');
        if($ins->listar == '0'){
            $crud->unset_list();
        }
        
        if($ins->crear == '0'){
            $crud->unset_add();
        }
        
        if($ins->eliminar == '0'){
            $crud->unset_delete();
        }
        if($ins->export == '0'){
            $crud->unset_export();
        }
        $output = $crud->render();
        $output->data_accessos = $obtener_permisos;

        $output->title = 'Devoluciones';
        $output->nombre = 'Administración de Devoluciones de ventas';
        $output->subtitle = 'Puedes hacer todas las acciones de administración menos editar';
		$this->load->view('devolverventa.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Devoluciones');
        $crud->set_crud_url_path(base_url('devolverventa/index'));

        $crud->set_table('devolucion');
        $crud->where('tipo =', 'v');

        $crud->columns('fecha', 'motivo', 'resultado', 'idinventario_mercaderia');

        $crud->unset_edit();
        $crud->unset_read();

        $crud->display_as('fecha', 'Fecha de la devolución')
        ->field_type('motivo', 'text')
        ->field_type('resultado', 'text')
        ->display_as('motivo', 'Motivo de la devolución')
        ->display_as('resultado', 'Resultado de la devolución')
        ->display_as('idinventario_mercaderia', 'Serie del inventario devuelto');

        $crud->add_fields('fecha', 'idinventario_mercaderia', 'motivo', 'resultado', 'tipo');

        $crud->field_type('iddevolucion', 'hidden')
        ->field_type('tipo', 'hidden','v');
         

        $crud->required_fields('fecha', 'motivo', 'resultado', 'idinventario_mercaderia');
        

        $crud->set_rules('idinventario_mercaderia', 'Serie - Modelo del inventario devuelto', 'callback_validar_add_idinventario_mercaderia|required' );
        $crud->callback_column('idinventario_mercaderia',array($this,'_callback_nombres'));
        $crud->callback_field('idinventario_mercaderia', function ($value, $primary_key){
            $html = '';
            $html .= '<select class="form-control" name="idinventario_mercaderia" id="idinventario_mercaderia">';
            foreach ($this->Data->listarinventario_devolver_venta() as $key => $x) {
                $html .= '<option value="'.$x->idinventario_mercaderia.'">V-'.str_pad($x->idventa, 8, "0", STR_PAD_LEFT).' - '.$x->serie.' - '.$x->modelo.'</option>';
            }
            $html .= '</select>';
            return $html;
        });
        
        
        $this->_example_output($crud);
    }

    function _callback_nombres($value, $row){
        $venta = $this->Data->listarinventario_devolver_venta_buscar($value);
        if(isset($venta->idventa)){
            return '<a href="'.base_url('venta/detalle/').$venta->idventa.'">Ir a la venta</a> V-'.str_pad($venta->idventa, 8, "0", STR_PAD_LEFT).' - Serie: '.$venta->serie .'';

        }else{
            return 'Venta borrada';
        }
    }

    function validar_add_idinventario_mercaderia($str){
        if($this->Data->existe_devolver_('v', $str)){
            $this->form_validation->set_message('validar_add_idinventario_mercaderia',"No puede devolver 2 veces el mismo inventario con esta mercadería");
            return false;
        }else{
            return true;
        }
    }
    
    public function informe(){
        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $accesos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($accesos, 'devolverventa');
        if($ins->crear == '0'){
            show_404();
        }
        $this->load->view('informe/devolver.php',array(
            'title' => 'Informe de devoluciones',
            'nombre' => '',
            'data_accessos' => $accesos,
            'subtitle' => 'Buscar por rango o por tipo',
            'fecha' => $fecha
        ));
    }

    public function listarreporte() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                echo '{"lista":'.json_encode(
                                    $this->Data->devoluciones_informe($post->tipo, $post->fechai, $post->fechaf)
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
                $dat = $this->Data->devoluciones_informe($post->tipo, $post->fechai, $post->fechaf);
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
                $mpdf->writeHTML(file_get_contents(base_url() . 'static/html/style.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y/%m/%d %H:%M:%S");
                $url = base_url();
                $htmlPage = file_get_contents('static/html/devolver.html');

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
                $htmlPage = str_ireplace('{{report_nombre}}', 'Informe de devolución', $htmlPage);
                //FIN DE DATOS DE LA FACTURA

                $total = 0;
                $b = 0;
                foreach ($dat as $x):
                    $b++;
                    $htmlTable .= '<tr class="service">';
                    $htmlTable .= '<td class="tableitem">' . $b .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->fecha .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->serie .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->motivo .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->resultado .'</td>';
                    $htmlTable .= '<td class="tableitem">' . ($x->tipo=='c'?'Compra':'Venta') .'</td>';
                    $htmlTable .= '</tr>';
                endforeach;
                if(count($dat)==0){
					$htmlTable .= '<tr>';
                    $htmlTable .= '<td colspan="6" align="center">Ningún dato disponible - Impreso '.$fecha .'</td>';
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