<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ventas extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'venta';
        $this->Data->id = 'idventa';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'ventas');
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
        $output->crear_ = $ins->crear;
        $output->data_accessos = $obtener_permisos;

        $output->title = 'Ventas creadas';
        $output->nombre = 'Ventas creadas';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('ventas.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->unset_add();
        $crud->unset_read();
        $crud->add_action('Mercaderías vendidas','','','fa fa-list', array($this, '_ir_imagen'));
        $crud->set_subject('Ventas');
        $crud->set_crud_url_path(base_url('ventas/index'));

        $crud->set_table('venta');
        $crud->columns('idcliente', 'fecha', 'estado_v');
        $crud->display_as('idcliente', 'Detalle del cliente')
        ->display_as('fecha', 'Fecha de la venta')
        ->display_as('estado_v', 'Estado de la venta');
        $crud->callback_column('fecha',array($this,'_callback_fecha'));
        $crud->callback_column('estado_v',array($this,'_callback_estado'));

        $crud->add_fields('idcliente', 'fecha', 'idventa');
        $crud->edit_fields('idcliente', 'fecha', 'idventa');

        $crud->set_read_fields('idcliente', 'fecha');
        $crud->set_relation('idcliente','cliente','{cedula} - {nombres}');
        $crud->required_fields('idcliente','fecha');

        $crud->field_type('idventa', 'hidden');

        if($crud->getState() === 'update_validation'){
            $crud->set_rules('idcliente', 'Cliente','callback_validar_edit_nombre');
        }

        $this->_example_output($crud);
    }

    function _ir_imagen($value, $row) {
		return base_url().'venta/detalle/'.$row->idventa; 
    }
    
    function _callback_fecha($value, $row){
        return "<i class='fa fa-calendar'></i> $value";
    }

    function _callback_estado($value, $row){
        if($value == '0'){
            return '<a href="'.base_url().'venta/detalle/'.$row->idventa.'" class="bs-label label-warning">Venta reservada</a>';
        }else{
            return '<span class="bs-label label-success">Venta guardada</span>';
        }
        
    }

    function validar_edit_nombre($str){
        if($str == '1'){
            $this->form_validation->set_message('validar_edit_nombre',"Cliente seleccionado no válido");
            return false;
        }else{
            return true;
        }
        
    }
}