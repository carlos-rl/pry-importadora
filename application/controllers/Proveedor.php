<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proveedor extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'proveedor';
        $this->Data->id = 'idproveedor';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
        $this->load->library('validarIdentificacion');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'proveedor');
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

        $output->title = 'Proveedores';
        $output->nombre = 'Administración de Proveedores';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('proveedor.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Proveedores');
        $crud->set_crud_url_path(base_url('proveedor/index'));

        $crud->set_table('proveedor');
        $crud->columns('nombres', 'ruc', 'direccion', 'telefono', 'correo');

        $crud->display_as('nombres', 'Nombres completos')
        ->display_as('ruc', 'RUC')
        ->display_as('direccion', 'Dirección')
        ->display_as('telefono', 'Teléfono')
        ->display_as('correo', 'Correo');

        
        $crud->edit_fields('nombres', 'ruc', 'direccion', 'telefono', 'correo', 'idproveedor');
        $crud->field_type('estado', 'invisible');
        $crud->field_type('idproveedor', 'hidden');
        $crud->field_type('telefono', 'integer');
        $crud->field_type('ruc', 'integer');
        $crud->required_fields('direccion', 'telefono', 'ruc','nombres', 'correo');



        $crud->set_rules('correo', 'Correo del proveedor', 'trim|valid_email|max_length[100]');
        //$crud->set_rules('nombres', 'Nombres', 'regex_match[/^[a-z-A-Z ,.]*$/i]|required' );

        $crud->callback_field('correo',function ($value = '', $primary_key = null) {
            return '<input type="email" maxlength="70" value="'.$value.'" class="form-control" id="correo" name="correo" title="Introduzca una dirección de correo válida" class="form-control" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" >';
        });

        $crud->callback_column('nombres',array($this,'_callback_nombres'));
        $crud->callback_column('telefono',array($this,'_callback_telefono'));
        $crud->callback_column('correo',array($this,'_callback_correo'));
        
        if($crud->getState() === 'insert_validation'){
            $crud->set_rules('ruc', 'RUC', 'min_length[13]|max_length[13]|callback_validar_add_ruc|required' );
        }

        if($crud->getState() === 'update_validation'){
            $crud->set_rules('ruc', 'RUC', 'min_length[13]|max_length[13]|callback_validar_edit_ruc|required');
        }

        $this->_example_output($crud);
    }

    function validar_add_ruc($str){
        $ruc = new ValidarIdentificacion();
        if(!$ruc->validarRucPersonaNatural($str)){
            if(!$ruc->validarRucSociedadPrivada($str)){
                $this->form_validation->set_message('validar_add_ruc',"El RUC ingresado: <strong>".$str."</strong> no es el correcto");
                return false;
            }
        }

        if($this->Data->existe($str, 'ruc')){
            $this->form_validation->set_message('validar_add_ruc',"El RUC: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
    }

    function validar_edit_ruc($str){
        $ruc = new ValidarIdentificacion();
        if(!$ruc->validarRucPersonaNatural($str)){
            if(!$ruc->validarRucSociedadPrivada($str)){
                $this->form_validation->set_message('validar_edit_ruc',"El RUC ingresado: <strong>".$str."</strong> no es el correcto");
                return false;
            }
        }

        if($this->Data->existe_editar(
            $this->input->post('idproveedor'),
            array(
                'ruc'=> $str
            )
        )){
            $this->form_validation->set_message('validar_edit_ruc',"El nombre: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
        
    }

    function _callback_nombres($value, $row){
        return "<i class='fa fa-user'></i> $value";
    }

    function _callback_telefono($value, $row){
        return "<i class='fa fa-phone'></i> $value";
    }

    function _callback_correo($value, $row){
        return "<i class='fa fa-envelope'></i> $value";
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
        $this->load->view('informe/proveedor.php',array(
            'title' => 'Informe de proveedores',
            'nombre' => '',
            'data_accessos' => $accesos,
            'subtitle' => 'Buscar por rango',
            'fecha' => $fecha
        ));
    }

    public function listarreporte() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                echo '{"lista":'.json_encode(
                                    $this->Data->proveedor_inventario_informe($post->fechai, $post->fechaf)
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
                $dat = $this->Data->proveedor_inventario_informe($post->fechai, $post->fechaf);
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
                $mpdf->writeHTML(file_get_contents(base_url() . 'static/html/style.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y/%m/%d %H:%M:%S");
                $url = base_url();
                $htmlPage = file_get_contents('static/html/proveedor.html');

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
                $htmlPage = str_ireplace('{{report_nombre}}', 'Informe de provedores', $htmlPage);
                //FIN DE DATOS DE LA FACTURA

                $total = 0;
                $b = 0;
                foreach ($dat as $x):
                    $total = $total + $x->costo;
                    $b++;
                    $htmlTable .= '<tr class="service">';
                    $htmlTable .= '<td class="tableitem">' . $b .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->nombres .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->ruc .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->telefono .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . round($x->costo, 2) .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . round($x->costo, 2) .'</td>';
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
                $mpdf->Output('Informe de proveedores' . $fecha . '.pdf', 'D');
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }
}