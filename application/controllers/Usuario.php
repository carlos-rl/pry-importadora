<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'login';
        $this->Data->id = 'idlogin';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
        $this->load->library('validarIdentificacion');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'usuario');
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

        $output->title = 'Usuarios del sistema';
        $output->nombre = 'Administración de Usuarios del sistema';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('usuario.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();

        //$crud->where('idlogin !=', '1');

        $crud->set_subject('Usuarios del sistema');
        $crud->set_crud_url_path(base_url('usuario/index'));

        $crud->set_table('login');
        $crud->columns('usuario', 'admin', 'idgrupo', 'contrasenia','estado');

        $crud->display_as('usuario', 'Correo del usuario')
        ->display_as('admin', 'Nombre')
        ->display_as('idgrupo', 'Rol del usuario')
        ->display_as('contrasenia', 'Contraseña')
        ->display_as('estado', 'Acceso al login');



        $crud->add_fields('usuario', 'admin', 'idgrupo', 'contrasenia', 'idcliente','estado');
        $crud->edit_fields('usuario', 'admin', 'idgrupo', 'contrasenia', 'idlogin', 'idcliente','estado');

        

        $crud->set_read_fields('usuario', 'admin', 'idgrupo');

        $crud->field_type('estado', 'dropdown', array('1' => 'Activo', '0' => 'Inactivo'));
        $crud->field_type('usuario', 'email')
        ->field_type('idlogin', 'hidden')
        ->field_type('idcliente', 'hidden','1')
        ->field_type('contrasenia', 'password');
        
        $crud->required_fields('usuario', 'admin', 'idgrupo', 'contrasenia');
        $crud->set_relation('idgrupo','grupo','{nombre}');

        $crud->callback_before_insert(array($this,'encrypt_password_callback'));
        $crud->callback_before_update(array($this,'encrypt_password_callback'));
        $crud->callback_edit_field('contrasenia',array($this,'decrypt_password_callback'));



        $crud->set_rules('admin', 'Nombres', 'regex_match[/^[a-z-A-Z ,.]*$/i]' );

        $crud->callback_column('usuario',array($this,'_callback_correo'));
        
        if($crud->getState() === 'insert_validation'){
            $crud->set_rules('usuario', 'Correo del usuario', 'trim|valid_email|min_length[8]|max_length[100]|callback_validar_add_nombre|required' );
        }

        if($crud->getState() === 'update_validation'){
            $crud->set_rules('usuario', 'Correo del usuario', 'trim|valid_email|min_length[8]|max_length[100]|callback_validar_edit_nombre|required');
        }

        $this->_example_output($crud);
    }

    function encrypt_password_callback($post_array, $primary_key = null){
        $post_array['contrasenia'] = $this->encrypt->encode($post_array['contrasenia']);
        return $post_array;
    }

    function decrypt_password_callback($value){
        $decrypted_password = $this->encrypt->decode($value);
        return "<input type='password' class='form-control' name='contrasenia' value='$decrypted_password' />";
    }

    function validar_add_nombre($str){
        if($this->Data->existe($str, 'usuario')){
            $this->form_validation->set_message('validar_add_nombre',"El nombre: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
    }

    function validar_edit_nombre($str){
        if($this->Data->existe_editar(
            $this->input->post('idlogin'),
            array(
                'usuario'=> $str
            )
        )){
            $this->form_validation->set_message('validar_edit_nombre',"El nombre: <strong>".$str."</strong> ya se encuentra en la base de datos");
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
}