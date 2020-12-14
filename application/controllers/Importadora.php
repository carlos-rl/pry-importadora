<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Importadora extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'importadora';
        $this->Data->id = 'idimportadora';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
        $this->load->library('validarIdentificacion');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'importadora');
        if($ins->listar == '0'){
            $crud->unset_list();
        }
        if($ins->ver == '0'){
            $crud->unset_read();
        }
       
        if($ins->editar == '0'){
            $crud->unset_edit();
        }
        
        if($ins->export == '0'){
            $crud->unset_export();
        }
        $output = $crud->render();
        $output->data_accessos = $obtener_permisos;

        $output->title = 'Datos de la importadora';
        $output->nombre = 'Administración de la importadora';
        $output->subtitle = 'Puedes editar';
		$this->load->view('importadora.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Datos de la importadora');
        $crud->set_crud_url_path(base_url('importadora/index'));

        $crud->set_table('importadora');
        $crud->columns('nombre', 'ruc', 'direccion', 'telefono', 'correo');
        $crud->display_as('nombre', 'Nombre')
        ->display_as('ruc', 'RUC')
        ->display_as('direccion', 'Dirección')
        ->display_as('telefono', 'Teléfono celular')
        ->display_as('correo', 'Correo de la importadora');
        //$crud->unset_columns('idimportadora');

        $crud->edit_fields('nombre', 'ruc', 'telefono', 'correo', 'direccion');
        $crud->required_fields('nombre','ruc','telefono', 'correo');

        $crud->field_type('ruc', 'integer');
        $crud->set_rules('ruc', 'RUC', 'min_length[13]|max_length[13]|callback_validar_edit_ruc|required' );
        $crud->set_rules('correo', 'Correo de la importadora', 'trim|valid_email|max_length[100]|required');
        $crud->set_rules('telefono', 'Teléfono de la importadora', 'min_length[8]|max_length[10]|required');
        $crud->field_type('telefono', 'integer');
        //$crud->field_type('direccion', 'text');
        $crud->field_type('direccion', 'string');

        $crud->unset_add();
        $crud->unset_delete();
        $this->_example_output($crud);
    }

    function validar_edit_ruc($str){
        $ruc = new ValidarIdentificacion();
        

        if(!$ruc->validarRucPersonaNatural($str)){
            if(!$ruc->validarRucSociedadPrivada($str)){
                $this->form_validation->set_message('validar_edit_ruc',"El RUC ingresado: <strong>".$str."</strong> no es el correcto");
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
}