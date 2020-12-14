<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inventario extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'inventario_mercaderia';
        $this->Data->id = 'idinventario_mercaderia';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
        $this->load->library('validarIdentificacion');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'inventario');
        if($ins->listar == '0'){
            $crud->unset_list();
        }
        if($ins->export == '0'){
            $crud->unset_export();
        }
        $output = $crud->render();
        $output->data_accessos = $obtener_permisos;

        $output->title = 'Gestión de mercadería en Almacén';
        $output->nombre = 'Gestión de mercadería en Almacén';
        $output->subtitle = 'Puedes ver el detalle de cada inventario';
		$this->load->view('inventario.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->set_table('inventario_mercaderia');

        $crud->set_subject('Gestión de mercadería en Almacén');
        $crud->set_crud_url_path(base_url('inventario/index'));

        
        $crud->columns('idcompra', 'idmercaderia', 'serie', 'costo', 'precio_venta', 'garantia_meses', 'estado_inv', 'estado');

        $crud->display_as('idcompra', 'N°  de compra')
        ->display_as('idmercaderia', 'Marca - Mercadería')
        ->display_as('serie', 'Serie del inventario')
        ->display_as('costo', 'Costo')
        ->display_as('precio_venta', 'PVP')
        ->display_as('garantia_meses', 'Meses de garantía')
        ->display_as('estado_inv', 'Estado del inventario')
        ->display_as('estado', '¿Está en el catálogo?');

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_delete();
        $crud->unset_read();

        $crud->callback_column('estado_inv',array($this,'_callback_estado'));
        $crud->callback_column('idcompra',array($this,'_callback_compra'));
        $crud->callback_column('costo',array($this,'_callback_costo'));
        $crud->callback_column('precio_venta',array($this,'_callback_costo'));
        $crud->callback_column('idmercaderia',array($this,'_callback_mercaderia'));
        $crud->callback_column('garantia_meses',array($this,'_callback_meses'));
        $crud->callback_column('estado',array($this,'_callback_estado_ca'));

        
        $this->_example_output($crud);
    }

    function _callback_estado($value, $row){
        if($value == '1'){
            return '<label class="label label-success">Disponible</label>';
        }
        if($value == '2'){
            return '<label class="label label-danger">Vendido</label>';
        }
        if($value == '3'){
            return '<label class="label label-warning">Devuelto</label>';
        }
    }

    function _callback_compra($value, $row){
        return 'N° '.$value.' | <a class="text-primary" href="'.base_url().'compra/detalle/'.$value.'">Ir a la compra</a>';
    }

    function _callback_costo($value, $row){
        return '$ '.$value;
    }

    function _callback_meses($value, $row){
        return '<i class="fa fa-calendar-o"></i> '.$value.' mes(es)';
    }

    function _callback_mercaderia($value, $row){
        $ins = $this->Data->buscar_mercaderia($value);
        return strtoupper($ins->modelo).' - '.strtoupper($ins->nombre);
    }

    public function catalogo() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            $data = array(
				'estado' => $post->estado
			);
            if ($this->Data->editar($data, $post->id)) {
                echo '{"resp" : true}';
                exit();
            } else {
                echo '{"resp" : false,'
                . '"error" : "El registro no se guardó!!"}';
                exit();
            }
        }
    }

    function _callback_estado_ca($value, $row){
        if($value == '1'){
            return '<button rel="catalogo" type="button" value="'.$row->idinventario_mercaderia.'" class="cr-admin btn btn-default btn-xs"><i class="fa fa-check-square-o"></i></button>';
        }else{
            return '<button rel="catalogo" type="button" value="'.$row->idinventario_mercaderia.'" class="cr-admin btn btn-default btn-xs"><i class="fa fa-square-o"></i></button>';
        }
        
    }
}