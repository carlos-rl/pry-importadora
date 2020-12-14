<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deposito extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'deposito';
        $this->Data->id = 'iddeposito';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'deposito');
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

        $output->title = 'Depósitos';
        $output->nombre = 'Depósitos a Cuentas bancarias';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('deposito.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Depósitos');
        $crud->set_crud_url_path(base_url('deposito/index'));

        $crud->set_table('deposito');
        $crud->columns('idcuentabancaria','fecha','numtransaccion','valor');
        $crud->display_as('idcuentabancaria', 'Cuenta bancaria')
        ->display_as('fecha', 'Fecha del depósito')
        ->display_as('numtransaccion', 'N°  de transacción')
        ->display_as('valor', 'Valor');

        $crud->set_relation('idcuentabancaria','cuentabancaria','{numero}');
        
        
        
        $crud->add_fields('idcuentabancaria','fecha','numtransaccion','valor');
        $crud->edit_fields('idcuentabancaria','fecha','numtransaccion','valor','iddeposito');
        $crud->set_read_fields('idcuentabancaria','fecha','numtransaccion','valor');

        $crud->required_fields('idcuentabancaria','fecha','numtransaccion','valor');
        $crud->field_type('numtransaccion', 'integer')
        ->field_type('valor', 'integer')
        ->field_type('iddeposito', 'hidden');

        $crud->callback_column('tipo',array($this,'_callback_tipo'));
        $crud->callback_column('idcuentabancaria',array($this,'_callback_ctab'));
        $crud->callback_column('valor',array($this,'_callback_valor'));

        if($crud->getState() === 'insert_validation'){
            $crud->set_rules('numtransaccion', 'N° Transacción', 'min_length[2]|callback_validar_add_numtransaccion' );
        }
        if($crud->getState() === 'update_validation'){
            $crud->set_rules('numtransaccion', 'N° Transacción','trim|min_length[2]|callback_validar_edit_numtransaccion');
        }

        $this->_example_output($crud);
    }

    function validar_add_numtransaccion($str){
        if($this->Data->existe($str, 'numtransaccion')){
            $this->form_validation->set_message('validar_add_numtransaccion',"N° Transacción: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
    }

    function validar_edit_numtransaccion($str){
        if($this->Data->existe_editar(
            $this->input->post('iddeposito'),
            array(
                'numtransaccion'=> $str
            )
        )){
            $this->form_validation->set_message('validar_edit_numtransaccion',"N° Transacción: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
        
    }

    function _callback_ctab($value, $row){
        return "<i class='fa fa-university'></i> $value";
    }

    function _callback_valor($value, $row){
        return "<i class='fa fa-dollar'></i> ".$value;
    }
}