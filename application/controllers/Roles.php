<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'grupo';
        $this->Data->id = 'idgrupo';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'roles');
        if($ins->listar == '0'){
            $crud->unset_list();
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

        $output->title = 'Roles de administración para los usuarios';
        $output->nombre = 'Roles de administración';
        $output->subtitle = 'Roles de administración para los usuarios';
		$this->load->view('rol.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        //$crud->unset_add();
        $crud->unset_read();
        $crud->add_action('Accesos','','','fa fa-list', array($this, '_ir_pagina'));
        $crud->set_subject('Roles de usuario');
        $crud->set_crud_url_path(base_url('roles/index'));

        $crud->set_table('grupo');
        $crud->where('idgrupo <> 1');
        $crud->where('idgrupo <> 2');
        $crud->columns('nombre');
        $crud->display_as('nombre', 'Nombre del rol');
        $crud->callback_column('nombre',array($this,'_callback_nombre'));

        $crud->add_fields('nombre');
        $crud->edit_fields('nombre', 'idgrupo');
        $crud->field_type('idgrupo', 'hidden');

        $crud->set_read_fields('nombre');
        $crud->required_fields('nombre');

        if($crud->getState() === 'insert_validation'){
            $crud->set_rules('nombre', 'Nombre', 'min_length[2]|callback_validar_add_nombre|required' );
        }
        if($crud->getState() === 'update_validation'){
            $crud->set_rules('nombre', 'Nombre','trim|min_length[2]|callback_validar_edit_nombre|required');
        }
       


        $this->_example_output($crud);
    }

    function _ir_pagina($value, $row) {
		return base_url().'roles/acceso/'.$row->idgrupo; 
    }
    
    function _callback_nombre($value, $row){
        return "<i class='fa fa-users'></i> $value | <a class='text-primary' href='".base_url()."roles/acceso/".$row->idgrupo."'> Puedes ir a editar los accesos aquí</a>";
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
            $this->input->post('idgrupo'),
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

    public function buscar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
				$post = (object) $_POST;
                $data = array(
                    'data' => $this->Data->buscargrupo($post->idgrupo)
                );
                echo json_encode($data);
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            //echo 'No posee permiso para estar aquí!!!!!!';
            show_404();
        }
    }

    public function acceso($id=''){
        if($id == ''){
            show_404();
        }

        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $accesos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $this->load->view('acceso.php',array(
            'title' => 'Accesos a las página',
            'nombre' => '',
            'idgrupo' => $id,
            'grupo' => $this->Data->buscar_rol($id),
            'data_accessos' => $accesos,
            'subtitle' => '',
            'fecha' => $fecha
        ));
    }

    public function editar_detalle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
			$this->Data->tabla = 'detallegrupo';
			$this->Data->id = 'iddetallegrupo';
            $data = array(
				$post->action => $post->estado
			);
            if ($this->Data->editar($data, $post->iddetallegrupo)) {
                echo '{"resp" : true}';
                exit();
            } else {
                echo '{"resp" : false,'
                . '"error" : "El registro no se guardó!!"}';
                exit();
            }
        }
    }
}