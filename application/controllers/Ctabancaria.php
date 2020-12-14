<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ctabancaria extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'cuentabancaria';
        $this->Data->id = 'idcuentabancaria';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'ctabancaria');
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

        $output->title = 'Cuentas bancarias';
        $output->nombre = 'Cuentas bancarias';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('ctabancaria.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Cuentas bancarias');
        $crud->set_crud_url_path(base_url('ctabancaria/index'));

        $crud->set_table('cuentabancaria');
        $crud->columns('idbanco','numero','tipo','saldo');
        $crud->display_as('idbanco', 'Banco')
        ->display_as('tipo', 'Tipo de cuenta')
        ->display_as('saldo', 'Saldo de la cuenta')
        ->display_as('numero', 'N° de cuenta');

        $crud->set_relation('idbanco','banco','{nombre}');
        $crud->field_type('tipo', 'dropdown', array('2' => 'Corriente', '1' => 'Ahorros'));
        
        
        $crud->add_fields('idbanco','numero','tipo','saldo');
        $crud->edit_fields('idbanco','numero','tipo','saldo');
        $crud->set_read_fields('idbanco','numero','saldo');

        $crud->required_fields('idbanco','numero','tipo','saldo');
        $crud->field_type('numero', 'integer');
        $crud->field_type('saldo', 'integer');

        $crud->callback_column('tipo',array($this,'_callback_tipo'));
        $crud->callback_column('numero',array($this,'_callback_numero'));
        $crud->callback_column('saldo',array($this,'_callback_saldo'));

        $this->_example_output($crud);
    }

    function _callback_tipo($value, $row){
        if($value == '1'){
            return "Ahorros";
        }else{
            return "Corriente";
        }
        
    }
    function _callback_numero($value, $row){
        return "<i class='fa fa-university'></i> $value";
    }
    function _callback_saldo($value, $row){
        $valordepositos = $this->Data->valorDeposito($row->idcuentabancaria);
        $valordepositos = ($valordepositos == ''?'0':$valordepositos);
        return "<i class='fa fa-dollar'></i> ".($valordepositos+$value);
    }
}