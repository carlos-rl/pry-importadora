<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'trabajador';
        $this->Data->id = 'idtrabajador';
		$this->load->helper('url');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
    }
	
    public function index() {
        if(!is_logged_in()){
			show_404();
        }
        $data = array(
            'title' => 'Menú de inicio',
            'url' => 'menu',
            'nameform' => 'welcome',
            'numcompra' => $this->Data->numTabla('compra'),
            'numventa' => $this->Data->numTabla('venta'),
            'numcliente' => $this->Data->numTabla('cliente'),
            'numproveedor' => $this->Data->numTabla('proveedor'),
            'imagen' => $this->Data->listarmercaderia(),
            'v_grafico_1' => $this->Data->venta_inventario_grafico_1(),
            'c_grafico_1' => $this->Data->compra_inventario_grafico_1(),
            'anios' => $this->Data->ventasumanios(),
            'todos_anios' => $this->Data->ventasumtodoasanios(),
            'modulo' => 'menu',
            'atributos' => array($this->Data->id, 'nomcategoria'),
            'barra' => 'sidebar',
            'id' => $this->Data->id
        );
        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $data['data_accessos'] = $obtener_permisos;
        
		$this->load->view('menu', $data);
    }

    public function shop($id='') {
        $data = array(
            'title' => 'Menú de inicio',
            'url' => 'menu',
            'nameform' => 'welcome',
            'marca' => $this->Data->listarDetalleInventarioWeb(),
            'marca_2' => $this->Data->buscarRegistro_em('marca','idmarca = '.$id),
            'inventario' => $this->Data->listarDetalleInventarioWeb_id($id),
            'idimportadora' => $this->Data->buscarRegistro_em('importadora','idimportadora = 1'),
            'modulo' => 'menu',
            'barra' => 'sidebar',
            'id' => $this->Data->id
        );
        
		$this->load->view('shop', $data);
    }

    public function database_backup() {
        $this->load->dbutil();
        $db_format = array('format' => 'zip', 'filename' => 'my_db_backup.sql');
        $backup = $this->dbutil->backup($db_format);
        $dbname = 'backup-' . date('Y-m-d') . '.zip';
        $save = 'static/db_backup/' . $dbname;
        write_file($save, $backup);
        force_download($dbname, $backup);
    }
    
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            $data = $this->editarArray($post);
            switch ($post->action) {
                case 'add':
                    if ($this->Data->crear($data)) {
                        echo '{"resp" : true}';
                        exit();
                    } else {
                        echo '{"resp" : false,'
                        . '"error" : "El registro no se guardó!!"}';
                        exit();
                    }
                    break;
                case 'edit':
                    if ($this->Data->editar($data, $post->id)) {
                        echo '{"resp" : true}';
                        exit();
                    } else {
                        echo '{"resp" : false,'
                        . '"error" : "El registro no se guardó!!"}';
                        exit();
                    }
                    break;

                default:
                    break;
            }
        }
    }

    public function editar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //acciones por POST
            $post = (object) $_POST;
            $this->Data->tabla = 'hacienda';
            $this->Data->id = 'idhacienda';
            $data = array(
                $post->text => $post->value
            );
            if ($this->Data->editar($data, 1)) {
                $idhacienda = $this->Data->buscarRegistro('hacienda',array('idhacienda',$this->session->userdata('idtrabajador')->idhacienda));
                $this->session->set_userdata('idhacienda', $idhacienda);
                echo '{"resp" : true}';
                exit();
            } else {
                echo '{"resp" : false,'
                    . '"error" : "Tus datos no fueron guardados!!"}';
                exit();
            }
        } else {
            show_404();
        }
    }

	
	public function papelera() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                $estado = TRUE;
                $str = 'UPDATE '.$this->Data->tabla.' SET ';
                $json = json_decode($_POST["c"]);
                $tamanioList = count($json);
                for ($i = 0; $i < $tamanioList; $i++) {
                    $str .= 'estado=0 where idcategoria=' . ($json[$i]->idcategoria) . (($i + 1) == $tamanioList ? '' : ' or ');
                }
                $estado = $this->Data->sql($str);
                echo ($estado != 1 ? ($estado == FALSE ? '{"resp" : false,"error":"Dato no eliminado"}' : '{"resp" : false,"error":"' . $estado . '"}') : '{"resp" : true}');
                
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }
	
    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                $estado = TRUE;
                $str = '';
                $json = json_decode($_POST["c"]);
                $tamanioList = count($json);
                for ($i = 0; $i < $tamanioList; $i++) {
                    $str .= $this->Data->id . '=' . ($json[$i]->idcategoria) . (($i + 1) == $tamanioList ? '' : ' or ');
                }
                $estado = $this->Data->eliminarList($str);
                echo ($estado != 1 ? ($estado == FALSE ? '{"resp" : false,"error":"Dato no eliminado"}' : '{"resp" : false,"error":"' . $estado . '"}') : '{"resp" : true}');
                //echo json_encode($str);
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }

    private function editarArray($post) {
		date_default_timezone_set('America/Guayaquil');
		setlocale(LC_ALL, 'es_ES');
		$fecha = strftime("%Y-%m-%d");
		$hora = strftime("%H:%M:%S");
		return array(
			'nomcategoria' => strtoupper($post->nomcategoria)
		);
    }

    public function add($id = '') {
        if($id != ''){
            $listas = array();
            $listas = ($this->session->userdata('carrito') == null ? array(): $this->session->userdata('carrito'));
            $listas[] = array(
                'id'=> $id,
                'data' => $this->Data->buscar_inventarioarticulo($id)
            );
            $this->session->set_userdata('carrito', $listas);
            redirect(base_url() . 'menu/shop');
        }else{
            show_404();
        }
    }

    public function delete($id='') {
        if($id != ''){
            $listas = array();
            $listas = $this->session->userdata('carrito');
            $indice = 0;
            $newlista = array();
            for ($i=0; $i < count($listas) ; $i++) { 
                if($id != $listas[$i]['id'] ){
                    $newlista[] = array(
                        'id'=> $listas[$i]['id'],
                        'data' => $listas[$i]['data']
                    );
                }
            }
            $this->session->set_userdata('carrito', $newlista);
            redirect(base_url() . 'menu/shop');
        }else{
            show_404();
        }
        
    }

    public function checkout() {
        if (true) {
            $data = array(
                'title' => 'Hola',
                'url' => 'menu',
                'idimportadora' => $this->Data->buscarRegistro_em('importadora','idimportadora = 1')
            );
            $this->load->view('checkout', $data); 
        }else{
            show_404();
        }
        
    }

    private function addcliente($post){
        $this->Data->tabla = 'cliente';
        $this->Data->id = 'idcliente';
        $cliente = $this->Data->buscar_cliente($post->email);
        if(!isset($cliente->idcliente)){
            $data = array(
                'nombres' => strtoupper($post->nombres),
                'telefono' => $post->telefono,
                'correo' => $post->email,
                'direccion' => $post->direccion,
                'idgrupo' => 2,
                'idlogin' => 0,
                'tipo' => 'c'
            );
            return $this->Data->crearVC($data);
        }else{
            $this->Data->tabla = 'cliente';
            $this->Data->id = 'idcliente';
            $this->Data->editar(array(
                'nombres' => strtoupper($post->nombres),
                'telefono' => $post->telefono,
                'correo' => strtolower($post->email),
                'direccion' => $post->direccion
            ), $cliente->idcliente);
            return $cliente->idcliente;
        }
    }

    public function ordenar() {
        if($this->session->userdata('carrito')){
            if ((count($this->session->userdata('carrito')) != 0)) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $post = (object) $_POST;
                    $cabecera = $this->session->userdata('carrito');
                    $detalle = $cabecera;
                    $data = array(
                        'idcliente' => $this->addcliente($post),
                        'fecha' => strftime("%Y-%m-%d"),
                        'estado_v' => '0'
                    );
                    $this->Data->tabla = 'venta';
                    $this->Data->id = 'idventa';
                    $idventa = $this->Data->crearVC($data);
                    $sql = 'INSERT INTO venta_mercaderia(idventa, idinventario_mercaderia, precio) values';
                    $total = 0;
                    for ($i = 0; $i < count($detalle); $i++) {
                        $ins = $detalle[$i]['data'];
                        $sql .= '(' . $idventa . ', "' . $ins->idinventario_mercaderia. '", ' . $ins->precio_venta . ')' . ((count($detalle) == $i + 1) ? ' ' : ' ,');
    
                    }
                    $this->Data->sql($sql);
                    $this->session->set_userdata('carrito', array());
                    redirect(base_url() . 'menu/checkout?resp=true');
                } else {
                    show_404();
                }
            }else{
                redirect(base_url() . 'menu/shop');
            }
        }else{
            redirect(base_url() . 'menu/shop');
        }
        
        
    }
	
}