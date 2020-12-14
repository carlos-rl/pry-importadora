<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Compras extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'compra';
        $this->Data->id = 'idcompra';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'compras');
        if($ins->listar == '0'){
            $crud->unset_list();
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

        $output->title = 'Compras creadas';
        $output->nombre = 'Compras creadas';
        $output->crear_ = $ins->crear;
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('compras.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->unset_add();
        $crud->unset_read();
        $crud->add_action('Mercaderías','','','fa fa-list', array($this, '_ir_imagen'));
        $crud->set_subject('Compras');
        $crud->set_crud_url_path(base_url('compras/index'));

        $crud->set_table('compra');
        $crud->columns('idproveedor', 'fecha');
        $crud->display_as('idproveedor', 'Detalle del proveedor');
        $crud->callback_column('fecha',array($this,'_callback_fecha'));

        $crud->add_fields('idproveedor', 'fecha', 'idcompra');
        $crud->edit_fields('idproveedor', 'fecha', 'idcompra');

        $crud->set_read_fields('idproveedor', 'fecha');
        $crud->set_relation('idproveedor','proveedor','{ruc} - {nombres}');
        $crud->required_fields('idproveedor','fecha');

        $crud->field_type('idcompra', 'hidden');


        $this->_example_output($crud);
    }

    function _ir_imagen($value, $row) {
		return base_url().'compra/detalle/'.$row->idcompra; 
    }
    
    function _callback_fecha($value, $row){
        return "<i class='fa fa-calendar'></i> $value";
    }
}