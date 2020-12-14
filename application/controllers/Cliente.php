<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'cliente';
        $this->Data->id = 'idcliente';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
        $this->load->library('validarIdentificacion');
    }
    
    public function _example_output($crud){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'cliente');
        //unset_add
        //unset_delete
        //unset_edit
        //unset_read
        //unset_list
        //unset_print
        //unset_export
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
        

        $output->title = 'Clientes';
        $output->data_accessos = $obtener_permisos;
        $output->nombre = 'Administración de Clientes';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
        
        $this->load->view('cliente.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->where('idcliente !=', '1');
        $crud->where('tipo =', 'c');

        $crud->set_subject('Clientes');
        $crud->set_crud_url_path(base_url('cliente/index'));

        $crud->set_table('cliente');
        $crud->columns('nombres', 'cedula', 'telefono', 'correo', 'direccion');

        $crud->display_as('nombres', 'Nombres completos')
        ->display_as('apellidos', 'Apellidos')
        ->display_as('cedula', 'Cédula')
        ->display_as('direccion', 'Dirección')
        ->display_as('telefono', 'Teléfono')
        ->display_as('correo', 'Correo');



        $crud->add_fields('nombres', 'apellidos', 'cedula', 'telefono', 'correo', 'direccion', 'tipo', 'idgrupo', 'idcliente');
        $crud->edit_fields('nombres', 'apellidos', 'cedula', 'telefono', 'correo', 'direccion', 'tipo', 'idgrupo', 'idcliente');

        $crud->set_read_fields('nombres', 'apellidos', 'cedula', 'telefono', 'correo', 'direccion');

        $crud->field_type('estado', 'invisible')
        ->field_type('telefono', 'integer')
        ->field_type('cedula', 'integer')
        ->field_type('idgrupo', 'hidden', 2)
        ->field_type('idcliente', 'hidden')
        ->field_type('tipo', 'hidden','c');
        
        $crud->required_fields('direccion', 'telefono', 'correo','nombres','apellidos', 'cedula');



        $crud->set_rules('correo', 'Correo del cliente', 'trim|valid_email|max_length[100]|required');
        $crud->set_rules('nombres', 'Nombres', 'regex_match[/^[a-z-A-Z ,.]*$/i]' );
        $crud->set_rules('apellidos', 'apellidos', 'regex_match[/^[a-z-A-Z ,.]*$/i]' );



        $crud->callback_column('nombres',array($this,'_callback_nombres'));
        $crud->callback_column('telefono',array($this,'_callback_telefono'));
        $crud->callback_column('correo',array($this,'_callback_correo'));
        
        if($crud->getState() === 'insert_validation'){
            $crud->set_rules('cedula', 'Cédula', 'min_length[10]|max_length[10]|callback_validar_add_cedula|required' );
        }

        if($crud->getState() === 'update_validation'){
            $crud->set_rules('cedula', 'Cédula', 'min_length[10]|max_length[10]|callback_validar_edit_cedula|required');
        }

        
        $this->_example_output($crud);
    }

    function validar_add_cedula($str){
        $ruc = new ValidarIdentificacion();
        if(!$ruc->validarCedula($str)){
            $this->form_validation->set_message('validar_add_cedula',"La cédula ingresada: <strong>".$str."</strong> no es el correcto");
            return false;
        }

        if($this->Data->existe($str, 'cedula')){
            $this->form_validation->set_message('validar_add_cedula',"La cédula: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
    }

    function validar_edit_cedula($str){
        $ruc = new ValidarIdentificacion();
        if(!$ruc->validarCedula($str)){
            $this->form_validation->set_message('validar_edit_cedula',"La cédula ingresado: <strong>".$str."</strong> no es el correcto");
            return false;
        }

        if($this->Data->existe_editar(
            $this->input->post('idcliente'),
            array(
                'cedula'=> $str
            )
        )){
            $this->form_validation->set_message('validar_edit_cedula',"La cédula: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
        
    }

    function _callback_nombres($value, $row){
        return "<i class='fa fa-user'></i> $value".$row->apellidos;
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
        $this->load->view('informe/cliente.php',array(
            'title' => 'Informe de clientes',
            'nombre' => '',
            'ventas' => $this->Data->comprasinforme(),
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
                                    $this->Data->cliente_informe($post->fechai, $post->fechaf)
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
                $dat = $this->Data->cliente_informe($post->fechai, $post->fechaf);
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
                $mpdf->writeHTML(file_get_contents(base_url() . 'static/html/style.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y/%m/%d %H:%M:%S");
                $url = base_url();
                $htmlPage = file_get_contents('static/html/cliente.html');

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
                $htmlPage = str_ireplace('{{report_nombre}}', 'Informe de compras', $htmlPage);
                //FIN DE DATOS DE LA FACTURA

                $total = 0;
                $b = 0;
                foreach ($dat as $x):
                    $b++;
                    $htmlTable .= '<tr class="service">';
                    $htmlTable .= '<td class="tableitem">' . $b .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->fecha .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->nombres .' ' . $x->apellidos .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->cedula .' mes(es)</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->telefono .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->direccion .'</td>';
                    $htmlTable .= '</tr>';
                endforeach;
                if(count($dat)==0){
					$htmlTable .= '<tr>';
                    $htmlTable .= '<td colspan="10" align="center">Ningún dato disponible - Impreso '.$fecha .'</td>';
                    $htmlTable .= '</tr>';
                }
                $htmlPage = str_ireplace('{{table_row}}', $htmlTable, $htmlPage);
                //echo $htmlPage ;
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