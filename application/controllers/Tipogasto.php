<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipogasto extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'tipogasto';
        $this->Data->id = 'idtipogasto';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'tipogasto');
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

        $output->title = 'Tipo de gasto';
        $output->nombre = 'Administración de Tipo de gasto';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('tipogasto.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Tipo de gasto');
        $crud->set_crud_url_path(base_url('tipogasto/index'));

        $crud->set_table('tipogasto');
        $crud->columns('nombre');
        $crud->display_as('nombre', 'Nombre');
        //$crud->unset_columns('idtipogasto');

        $crud->add_fields('nombre');
        $crud->edit_fields('nombre', 'idtipogasto');

        $crud->field_type('idtipogasto', 'hidden');
        //$crud->field_type('estado', 'dropdown', array('Umum' => 'Umum', 'Anak' => 'Anak', 'Bedah' => 'Bedah', 'Anastesi' => 'Anastesi', 'Obsgin' => 'Obsgin', 'Paru' => 'Paru', 'Penyakit Dalam' => 'Penyakit Dalam', 'Radiologi' => 'Radiologi'));
        

        $crud->required_fields('nombre');

        //$crud->callback_update(array($this,'funcion'));
        

        if($crud->getState() === 'insert_validation'){
            $crud->set_rules('nombre', 'Nombre', 'min_length[2]|callback_validar_add_nombre|required' );
        }
        //echo 'fffffffff'.$crud->getStateInfo()->primary_key;
        if($crud->getState() === 'update_validation'){
            $crud->set_rules('nombre', 'Nombre','trim|min_length[2]|callback_validar_edit_nombre|required');
        }
        $this->_example_output($crud);
    }

    function validar_add_nombre($str){
        if($this->Data->existe($str, 'nombre')){
            $this->form_validation->set_message('validar_add_nombre',"El nombre: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
    }

    function validar_edit_nombre($str){
        if($this->Data->existe_editar(
            $this->input->post('idtipogasto'),
            array(
                'nombre'=> $str
            )
        )){
            $this->form_validation->set_message('validar_edit_nombre',"El nombre: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
        
    }
}