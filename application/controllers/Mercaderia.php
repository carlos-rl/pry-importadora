<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mercaderia extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'mercaderia';
        $this->Data->id = 'idmercaderia';
		if(!is_logged_in()){
			show_404();
        }
        $this->load->library('grocery_CRUD');
    }
    
    public function _example_output($crud = null){
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($obtener_permisos, 'mercaderia');
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

        $output->title = 'Mercaderías';
        $output->nombre = 'Registros de mercadería';
        $output->subtitle = 'Puedes hacer todas las acciones de administración';
		$this->load->view('mercaderia.php',(array)$output);
	}

	public function index(){
        /**$crud->set_rules('phone', 'No. Telefon', 'trim|required|numeric');
     $crud->set_rules('user_email', 'Email', 'trim|required|valid_email'); */
        $crud = new grocery_CRUD();
        $crud->add_action('Galería','','','fa fa-image', array($this, '_ir_imagen'));
        $crud->set_subject('Mercaderías');
        $crud->set_crud_url_path(base_url('mercaderia/index'));

        $crud->set_table('mercaderia');
        $crud->columns('nombre','idmarca', 'modelo', 'descripcion');
        $crud->display_as('nombre', 'Nombre de la mercadería')->display_as('modelo', 'Modelo')
        ->display_as('descripcion', 'Descripción')
        ->display_as('idmarca', 'Marca');

        

        $crud->add_fields('nombre','idmarca', 'modelo', 'descripcion', 'idimportadora');
        $crud->edit_fields('nombre','idmarca', 'modelo', 'descripcion', 'idmercaderia', 'idimportadora');

        $crud->set_read_fields('nombre','idmarca', 'modelo', 'descripcion', 'idimportadora');
        $crud->set_relation('idmarca','marca','{nombre}');
        $crud->required_fields('idmarca','modelo','nombre');

        $crud->field_type('descripcion', 'text')
        ->field_type('idmercaderia', 'hidden')
        ->field_type('idimportadora', 'hidden', 1);

        

        if($crud->getState() === 'insert_validation'){
            $crud->set_rules('modelo', 'Modelo', 'min_length[2]|callback_validar_add_modelo|required' );
        }
        if($crud->getState() === 'update_validation'){
            $crud->set_rules('modelo', 'Modelo','trim|min_length[2]|callback_validar_edit_modelo|required');
        }
        $this->_example_output($crud);
    }

    function _ir_imagen($value, $row) {
		return base_url().'mercaderia/foto/'.$row->idmercaderia; 
	}

    function validar_add_modelo($str){
        if($this->Data->existe($str, 'modelo')){
            $this->form_validation->set_message('validar_add_modelo',"El modelo: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
    }

    function validar_edit_modelo($str){
        if($this->Data->existe_editar(
            $this->input->post('idmercaderia'),
            array(
                'modelo'=> $str
            )
        )){
            $this->form_validation->set_message('validar_edit_modelo',"El modelo: <strong>".$str."</strong> ya se encuentra en la base de datos");
            return false;
        }else{
            return true;
        }
        
    }

    public function foto($id = '') {
        $this->Data->tabla = 'imagen';
        $this->Data->id = 'idimagen';
        if($id == ''){
            redirect(base_url('mercaderia'));
        }
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $data = array(
            'title' => 'Agregar foto',
            'nombre' => 'Registros de fotos de mercadería',
            'subtitle' => 'Puedes añadir más imágenes a este modelo',
            'urlform' => 'data',
            'url' => 'imagen',
            'id' => $id,
            'listar'=> $this->Data->listarFoto($id),
            'data_accessos' => $obtener_permisos,
            'modulo' => 'imagen',
            'activo' => $this->Data->listarTablaAI(1),
            'papelera' => $this->Data->listarTablaAI(0),
            'breadcrumb' => array(
                array(
                    'url' => base_url(),
                    'name' => 'Inicio'
                )
            ),
            'barra' => 'sidebar'
        );
		$this->load->view('mercaderiafoto', $data);
    }
    
    public function eliminarimagenid() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->Data->tabla = 'imagen';
                $this->Data->id = 'idimagen';
                $this->existeImg('./' . $this->Data->buscarURLFoto($_POST['id']));
                echo '{"resp":' . $this->Data->sql('DELETE FROM imagen where idimagen=' . $_POST['id']) . '}';
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            //echo 'No posee permiso para estar aquí!!!!!!';
            show_404();
        }
    }

	private function existeImg($url) {
        if (file_exists($url)) {
            if (unlink($url)) {
                return true;
            }
        }
        return true;
    }
	
	public function editarimagen() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //acciones por POST
            $this->Data->tabla = 'imagen';
            $this->Data->id = 'idimagen';
            $post = (object) $_POST;
            $tipo = '';
            $config['upload_path'] = "./uploads";
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload');

            $files = $_FILES;
            $number_of_files = count($_FILES['foto']['name']);
            $errors = 0;
            $data = array(
            );
            $sql = 'INSERT INTO imagen(idmercaderia,foto) values';


            for ($i = 0; $i < $number_of_files; $i++) {
                $tipo = $files['foto']['type'][$i];
                $_FILES['foto']['name'] = $files['foto']['name'][$i];
                $_FILES['foto']['type'] = $files['foto']['type'][$i];
                $_FILES['foto']['tmp_name'] = $files['foto']['tmp_name'][$i];
                $_FILES['foto']['error'] = $files['foto']['error'][$i];
                $_FILES['foto']['size'] = $files['foto']['size'][$i];


                $titulo = date("Ymd-His");
                $config['file_name'] = $titulo . $i;
                $sql .= '(' . $post->id . ',"' . ('uploads/' . $titulo . $i . '.' . (explode('/', $files['foto']['type'][$i])[1] == 'jpeg' ? 'jpg' : 'png')) . '")' . (($number_of_files == $i + 1) ? ' ' : ' ,');
                $this->upload->initialize($config);
                if (!$this->upload->do_upload("foto")) {
                    $errors++;
                }
            }
            if ($this->Data->sql($sql)) {
                echo json_encode(['resp' => TRUE]);
                exit();
            } else {
                echo json_encode(['resp' => FALSE]);
                exit();
            }
            echo json_encode(['resp' => FALSE]);
            exit();
        } else {
            //echo 'No posee permiso para estar aquí!!!!!!';
            show_404();
        }
    }

    

}