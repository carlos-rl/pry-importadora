<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Devolvercompra extends CI_Controller {
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
        $ins = esConsedido($obtener_permisos, 'devolvercompra');
        if($ins->listar == '0'){
            $crud->unset_list();
        }
        if($ins->ver == '0'){
            $crud->unset_read();
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
        $output->nombre = 'Administración de Devoluciones de compras';
        $output->subtitle = 'Puedes hacer todas las acciones de administración menos editar';
		$this->load->view('devolvercompra.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_subject('Devoluciones');
        $crud->set_crud_url_path(base_url('devolvercompra/index'));

        $crud->set_table('devolucion');
        $crud->where('tipo =', 'c');

        $crud->columns('fecha', 'motivo', 'resultado', 'idinventario_mercaderia');
        $crud->set_relation('idinventario_mercaderia','inventario_mercaderia','{serie}');

        $crud->unset_edit();

        $crud->display_as('fecha', 'Fecha de la devolución')
        ->field_type('motivo', 'text')
        ->field_type('resultado', 'text')
        ->display_as('motivo', 'Motivo de la devolución')
        ->display_as('resultado', 'Resultado de la devolución')
        ->display_as('idinventario_mercaderia', 'Serie del inventario devuelto');

        $crud->add_fields('fecha', 'idinventario_mercaderia', 'motivo', 'resultado');
        $crud->edit_fields('fecha', 'idinventario_mercaderia', 'motivo', 'resultado');

        $crud->field_type('iddevolucion', 'hidden')
        ->field_type('tipo', 'hidden','c');
         

        $crud->required_fields('fecha', 'motivo', 'resultado', 'idinventario_mercaderia');

        if($crud->getState() === 'insert_validation'){
            $crud->set_rules('idinventario_mercaderia', 'Serie - Modelo del inventario devuelto', 'min_length[2]|callback_validar_add_idinventario_mercaderia|required' );
            $crud->callback_field('idinventario_mercaderia', function ($value, $primary_key){
                $html = '';
                $html .= '<select class="form-control" name="idinventario_mercaderia" id="idinventario_mercaderia">';
                foreach ($this->Data->listarinventario_devolver_compra() as $key => $x) {
                    $html .= '<option value="'.$x->idinventario_mercaderia.'">'.$x->serie.' - '.$x->modelo.'</option>';
                }
                $html .= '</select>';
                return $html;
            });
        }

        
        
        $this->_example_output($crud);
    }

    function validar_add_idinventario_mercaderia($str){
        if($this->Data->existe_devolver_('c', $str)){
            $this->form_validation->set_message('validar_add_idinventario_mercaderia',"No puede devolver 2 veces el mismo inventario de la compra");
            return false;
        }else{
            return true;
        }
    }
    

}