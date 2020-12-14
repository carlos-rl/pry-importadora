<?php
function is_logged_in() {
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('estado');
    if (!isset($user)) { 
        return false; 
    } else {
        if($CI->session->userdata('tipo') == 'e'){
            return true;
        }
        return false;
    }
}
function esConsedido($data, $url) {
	$CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('idgrupo');
	if ($user!='1') {
		foreach ($data as $x):
			if($x->identificador==$url){
				if($x->listar==1){
					return $x;
				}else{
					show_404();
				}
			}
		endforeach;
	} else { 
		$list = array(
			'iddetalle_g'=>'all',
			'url'=> $url,
			'idpagina'=>'all',
			'idgrupo'=>'all',
			'ver'=>'1',
			'editar'=>'1',
			'crear'=>'1',
			'eliminar'=>'1',
			'export'=>'1',
			'listar'=>'1'
		); 
		return (object) $list;
	}
}
function esVisible($data, $url) {
	$CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $user = $CI->session->userdata('idgrupo');
	if ($user!='1') { 
		foreach ($data as $x):
			if($x->identificador==$url){
				if($x->listar==1){
					return 'style="display:block"';
				}else{
					return 'style="display:none"';
				}
			}
		endforeach;
	} else {
		return 'style="display:block"';
	}
}

function existeCarrito($idinventario_mercaderia) {
	$CI =& get_instance();
    // We need to use $CI->session instead of $this->session
	$carrito = $CI->session->userdata('carrito');
	$existe = '0';
	foreach ($carrito as $x):
		if($x['id'] == $idinventario_mercaderia){
			$existe = '1';
		}
	endforeach;
	return $existe;
}