<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of empresa
 *
 * @author
 */
class Data extends CI_Model {

    public $tabla;
    public $id;

    public function __construct() {
        
    }

    public function maxid($tabla, $id) {
        $maxid = 0;
        $row = $this->db->query('SELECT MAX(' . $id . ') AS `maxid` FROM ' . $tabla)->row();
        if ($row) {
            $maxid = $row->maxid;
        }
        return $maxid;
    }

    public function sql($sql) {
        $this->db->query($sql);
        return true;
    }

    public function eliminarList($str) {
        try {
            $sql = 'delete from ' . $this->tabla . ' where ' . $str;
            $this->db->query($sql);
            return true;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscar($data) {
        try {
            $this->db->select('*');
            $this->db->from($this->tabla);
            $this->db->where($data);
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return ($resultado == NULL) ? false : $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarRegistro($tabla, $data) {
        try {
            $this->db->select('*');
            $this->db->from($tabla);
            $this->db->where($data);
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return ($resultado == NULL) ? array() : $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarRegistro_em($tabla, $data) {
        try {
            $this->db->select('*');
            $this->db->from($tabla);
            $this->db->where($data);
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return ($resultado == NULL) ? array() : $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function editarConId($data, $id, $idText, $tabla) {
        try {
            $this->db->where($idText, $id);
            $this->db->update($tabla, $data);
            return ($this->db->affected_rows() > 0) ? true : true;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function crear2($data) {
        try {
            $this->db->insert($this->tabla, $data);
            return ($this->db->affected_rows() > 0) ? (array(
                'resp' => true,
                'id' => $this->db->insert_id()
                    )) : (array(
                'resp' => false,
                'id' => 0
            ));
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function crearTabla($data, $tabla) {
        try {
            $this->db->insert($tabla, $data);
            return ($this->db->affected_rows() > 0) ? true : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function crear($data) {
        try {
            $this->db->insert($this->tabla, $data);
            return ($this->db->affected_rows() > 0) ? true : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function existe($name, $text) {
        try {
            $this->db->select();
            $this->db->from($this->tabla);
            $this->db->where($text, $name);
            $resultado = $this->db->get();
            return ($resultado->num_rows() > 0) ? true : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function editar($data, $id) {
        try {
            $this->db->where($this->id, $id);
            $this->db->update($this->tabla, $data);
            return ($this->db->affected_rows() > 0) ? true : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function eliminar($id) {
        try {
            $this->db->where($this->id, $id);
            $this->db->delete($this->tabla);
            return ($this->db->affected_rows() > 0) ? true : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarlistar($tabla, $attr, $attrRsp) {
        try {
            $this->db->select('*');
            $this->db->from($tabla);
            $this->db->where($attr, $attrRsp);
            $consulta = $this->db->get();
            $resultado = $consulta->result_array();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function existe_editar($id, $array=array()) {
        $tamanioList = count($array);
        $listar = (object) $array;
        $str = '';
        $i = 0;
        foreach ($listar as $key => $value) {
            $str .= '('.$key.'="'.$value.'")' . (($i + 1) == $tamanioList ? '' : ' and ');
            $i++;
        }
        $resultado = $this->db->query('select*from ' . $this->tabla . ' where ' . $this->id . '!=' . $id . ' and ' . $str);
        return ($resultado->num_rows() > 0) ? true : false;
    }

    public function listar() {
        try {
            $this->db->select('*');
            $this->db->from($this->tabla);
            $this->db->order_by($this->id . ' desc');
            $consulta = $this->db->get();
            //$resultado = $consulta->result();
            $resultado = $consulta->result_array();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarTabla($tabla) {
        try {
            $this->db->select('*');
            $this->db->from($tabla);
            $consulta = $this->db->get();
            //$resultado = $consulta->result();
            $resultado = $consulta->result();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function ultimoid() {
        try {
            $resultado = $this->db->query('select max(' . $this->id . ') as num from ' . $this->tabla);
            return $resultado->result()->num;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarLogin($nick) {
        try {
            $this->db->select('*');
            $this->db->from('login p');
            $this->db->where('(p.usuario="' . $nick . '")');
            $this->db->where('( p.contrasenia!="" )');
            $this->db->where('( p.estado = 1 )');
            $resultado = $this->db->get();
            return ($resultado->num_rows() > 0) ? $resultado->row() : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function crearVC($data) {
        try {
            $this->db->insert($this->tabla, $data);
            return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function existeEditar_Vehiculo($nombre, $id, $strnombre, $nombre2, $strnombre2) {
        $resultado = $this->db->query('select*from ' . $this->tabla . ' where ' . $this->id . '!=' . $id . ' and (' . $strnombre . '="' . $nombre . '") and (' . $strnombre2 . '="' . $nombre2 . '")');
        return ($resultado->num_rows() > 0) ? true : false;
    }

    public function listarTablaAI($estado) {
        try {
            $this->db->select('count(*) as num');
            $this->db->from($this->tabla);
            $this->db->where('estado', $estado);
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado->num;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function listarTablaAN($estado) {
        try {
            $this->db->select('*');
            $this->db->from($this->tabla);
            $this->db->where('estado', $estado);
			$this->db->order_by($this->id.' desc');
            $consulta = $this->db->get();
            $resultado = $consulta->result_array();
            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function buscar_tabla_hijo($tabla, $id, $text_id) {
        return $this->db->query('SELECT * FROM ' . $tabla.' Where '.$text_id.'='.$id)->row();
    }
    /**Foto */

    public function buscarURLFoto($id) {
        try {
            $this->db->select('*');
            $this->db->from('imagen');
            $this->db->where('idimagen',$id);
            $resultado = $this->db->get();
            return ($resultado->num_rows() > 0) ? $resultado->row()->foto : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarFoto($id) {
        try {
            $this->db->select('*');
            $this->db->from('imagen');
            $this->db->where('idmercaderia',$id);
            $resultado = $this->db->get();
            return ($resultado->num_rows() > 0) ? $resultado->result_array() : array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function valorDeposito($idcuentabancaria) {
        try {
            $this->db->select('sum(valor) as valor');
            $this->db->from('deposito');
            $this->db->where('idcuentabancaria',$idcuentabancaria);
            $resultado = $this->db->get();
            return ($resultado->num_rows() > 0) ? $resultado->row()->valor : 0;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function idCompraMax() {
        try {
            $this->db->select('max(idcompra) as idcompra');
            $this->db->from('compra');
            $resultado = $this->db->get();
            return $resultado->row()->idcompra + 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function compra_mercaderia() {
        try {
            $this->db->select('m.idmercaderia, m.modelo, ma.nombre');
            $this->db->from('mercaderia m');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
			$this->db->order_by('ma.nombre asc');
			$this->db->order_by('m.modelo asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    public function compra_proveedor() {
        try {
            $this->db->select('*');
            $this->db->from('proveedor');
			$this->db->order_by('nombres asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function compra_cuentabancaria() {
        try {
            $this->db->select('c.idcuentabancaria, c.numero, c.tipo, b.nombre');
            $this->db->from('cuentabancaria c');
            $this->db->join('banco b', 'b.idbanco = c.idbanco');
			$this->db->order_by('numero asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function existeserie($serie) {
        try {
            $this->db->select('*');
            $this->db->from('inventario_mercaderia');
            $this->db->where('serie',$serie);
            $resultado = $this->db->get();
            return ($resultado->num_rows() > 0) ? 'true' : 'false';
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function compra_proveedor_buscar($idcompra) {
        try {
            $this->db->select('c.idcompra, c.fecha, c.idproveedor, p.nombres, p.ruc, p.direccion, p.telefono');
            $this->db->from('compra c');
            $this->db->join('proveedor p', 'p.idproveedor = c.idproveedor');
            $this->db->where('c.idcompra',$idcompra);
			$this->db->order_by('p.nombres asc');
            $resultado = $this->db->get();
            return $resultado->row();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function compra_inventario($idcompra) {
        try {   
            $this->db->select('i.idinventario_mercaderia , i.serie, i.costo, i.precio_venta, i.garantia_meses, i.estado_inv, i.idmercaderia, m.modelo, ma.nombre
            ,c.idcompra, c.fecha, c.idproveedor, p.nombres, p.ruc, p.direccion, p.telefono');
            $this->db->from('inventario_mercaderia i');
            $this->db->join('mercaderia m', 'i.idmercaderia = m.idmercaderia');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
            $this->db->join('compra c', 'c.idcompra = i.idcompra');
            $this->db->join('proveedor p', 'p.idproveedor = c.idproveedor');
            $this->db->where('c.idcompra',$idcompra);
			$this->db->order_by('m.modelo asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscar_mercaderia($idmercaderia) {
        try {
            $this->db->select('ma.nombre, m.modelo');
            $this->db->from('mercaderia m');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
            $this->db->where('m.idmercaderia',$idmercaderia);
			$this->db->order_by('ma.nombre asc');
            $resultado = $this->db->get();
            return $resultado->row();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarinventario_devolver_compra() {
        try {
            $this->db->select('m.modelo, inv.idinventario_mercaderia, inv.serie');
            $this->db->from('inventario_mercaderia inv');
            $this->db->join('mercaderia m', 'm.idmercaderia = inv.idmercaderia');
            $this->db->where('inv.estado','1');
			$this->db->order_by('m.modelo asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function existe_devolver_($tipo, $idinventario_mercaderia) {
        try {
            $this->db->select('*');
            $this->db->from('devolucion d');
            $this->db->where('tipo', $tipo);
            $this->db->where('idinventario_mercaderia',$idinventario_mercaderia);
            $resultado = $this->db->get();
            return ($resultado->num_rows() > 0) ? true : false;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarcreditopagar($id) {
        try {
            $this->db->select('p.nombres, p.ruc, cp.deudainicial, cp.saldo, cp.idcompra');
            $this->db->from('credito_pagar cp');
            $this->db->join('proveedor p', 'p.idproveedor = cp.idproveedor');
            $this->db->where('cp.idcredito_pagar',$id);
			$this->db->order_by('p.nombres asc');
            $resultado = $this->db->get();
            return $resultado->row();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarpagodeuda($id) {
        try {
            $this->db->select('pd.idpagodeuda, pd.fecha, pd.numcheque, pd.valorcheque, pd.estado, cb.numero, cb.tipo, b.nombre');
            $this->db->from('pagodeuda pd');
            $this->db->join('cuentabancaria cb', 'cb.idcuentabancaria = pd.idcuentabancaria');
            $this->db->join('banco b', 'b.idbanco = cb.idbanco');
            $this->db->where('pd.idcredito_pagar',$id);
			$this->db->order_by('pd.fecha asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    /**VENTAS */
    public function idVentaMax() {
        try {
            $this->db->select('max(idventa) as idventa');
            $this->db->from('venta');
            $resultado = $this->db->get();
            return $resultado->row()->idventa + 1;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function venta_mercaderia() {
        try {
            $this->db->select('inv.garantia_meses, inv.precio_venta, inv.idinventario_mercaderia, m.idmercaderia, m.modelo, ma.nombre, inv.serie');
            $this->db->from('inventario_mercaderia inv');
            $this->db->join('mercaderia m', 'inv.idmercaderia = m.idmercaderia');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
			$this->db->order_by('inv.serie asc');
            $this->db->where('inv.estado_inv = 1');
            $this->db->where('inv.estado_inv <> 2');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function venta_cliente() {
        try {
            $this->db->select('*');
            $this->db->from('cliente');
			$this->db->order_by('nombres asc');
            $this->db->where('idcliente <> 1');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function venta_inventario($idventa) {
        try {   
            $this->db->select('vd.idventa_mercaderia, vd.precio, i.idinventario_mercaderia , i.serie, i.costo, i.precio_venta, i.garantia_meses, i.estado_inv, i.idmercaderia, m.modelo, ma.nombre
            ,c.idventa, c.fecha, c.idcliente, p.nombres, p.cedula, p.direccion, p.telefono');
            $this->db->from('venta_mercaderia vd');
            $this->db->join('venta c', 'c.idventa = vd.idventa');
            $this->db->join('inventario_mercaderia i', 'i.idinventario_mercaderia = vd.idinventario_mercaderia');
            $this->db->join('mercaderia m', 'i.idmercaderia = m.idmercaderia');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
            $this->db->join('cliente p', 'p.idcliente = c.idcliente');
            $this->db->where('c.idventa',$idventa);
			$this->db->order_by('m.modelo asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function venta_cliente_buscar($idventa) {
        try {
            $this->db->select('c.idventa, c.fecha, c.idcliente, p.nombres, p.cedula, p.direccion, p.telefono, c.estado_v');
            $this->db->from('venta c');
            $this->db->join('cliente p', 'p.idcliente = c.idcliente');
            $this->db->where('c.idventa',$idventa);
			$this->db->order_by('p.nombres asc');
            $resultado = $this->db->get();
            return $resultado->row();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarcreditopagar_venta($id) {
        try {
            $this->db->select('c.nombres, c.cedula, cp.deudainicial, cp.saldo, cp.idventa,cp.idcredito, c.idcliente');
            $this->db->from('credito cp');
            $this->db->join('venta p', 'p.idventa = cp.idventa');
            $this->db->join('cliente c', 'c.idcliente = p.idcliente');
            $this->db->where('cp.idcredito',$id);
			$this->db->order_by('c.nombres asc');
            $resultado = $this->db->get();
            return $resultado->row();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscarpagodeuda_venta($id) {
        try {
            $this->db->select('pd.idcredito, pd.idamortizacion_cuotas, pd.fechapagar, pd.fechapagado, pd.valorcuota, pd.valorabonado, pd.recargo, pd.estado, pd.saldo');
            $this->db->from('amortizacion_cuotas pd');
            $this->db->where('pd.idcredito',$id);
			$this->db->order_by('pd.fechapagar asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarDetallePagoAnticipo($idcredito) {
        try {
            $this->db->select('*');
            $this->db->from('amortizacion_cuotas p');
            $this->db->where('p.idcredito', $idcredito);
            $this->db->where('p.estado', 0);
            $this->db->order_by('p.fechapagar asc');
            $consulta = $this->db->get();
            //$resultado = $consulta->result();
            $resultado = $consulta->result_array();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
/**FIN VENTAS */
    public function numTabla($tabla) {
        try {
            $this->db->select('*');
            $this->db->from($tabla);
            $resultado = $this->db->get();
            return $resultado->num_rows();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarinventario_devolver_venta() {
        try {
            $this->db->select('vm.idventa, m.modelo, inv.idinventario_mercaderia, inv.serie');
            $this->db->from('venta_mercaderia vm');
            $this->db->join('inventario_mercaderia inv', 'inv.idinventario_mercaderia = vm.idinventario_mercaderia');
            $this->db->join('mercaderia m', 'm.idmercaderia = inv.idmercaderia');
            //$this->db->where('vm.idinventario_mercaderia in (select inv2.idinventario_mercaderia from inventario_mercaderia inv2)');
			$this->db->order_by('m.modelo asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarinventario_devolver_venta_buscar($idinventario_mercaderia) {
        try {
            $this->db->select('vm.idventa, m.modelo, inv.idinventario_mercaderia, inv.serie');
            $this->db->from('venta_mercaderia vm');
            $this->db->join('inventario_mercaderia inv', 'inv.idinventario_mercaderia = vm.idinventario_mercaderia');
            $this->db->join('mercaderia m', 'm.idmercaderia = inv.idmercaderia');
            $this->db->where('vm.idinventario_mercaderia', $idinventario_mercaderia);
			$this->db->order_by('m.modelo asc');
            $resultado = $this->db->get();
            return $resultado->row();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarmercaderia() {
        try {
            $this->db->select('i.foto, m.modelo, ma.nombre');
            $this->db->from('imagen i');
            $this->db->join('mercaderia m', 'm.idmercaderia = i.idmercaderia');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
			$this->db->order_by('RAND() LIMIT 5');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarDetalleInventarioWeb() {
        try {
            $this->db->select('m.nombre as nommarca, m.idmarca, count(*) as num');
            $this->db->from('inventario_mercaderia d');
            $this->db->join('mercaderia me', 'me.idmercaderia = d.idmercaderia');
            $this->db->join('marca m', 'm.idmarca = me.idmarca');
            $this->db->where('d.estado <> 0');
            $this->db->where('d.estado_inv <> 2');
			$this->db->group_by(array('m.idmarca'));
            $consulta = $this->db->get();
            //$resultado = $consulta->result();
            $resultado = $consulta->result();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarDetalleInventarioWeb_id($idmarca) {
        try {
            $this->db->select('me.modelo, (select im.foto from imagen im where im.idmercaderia = me.idmercaderia order by rand() limit 1) as imagen, m.nombre as nommarca, m.idmarca, d.idinventario_mercaderia, d.serie, d.costo, d.precio_venta, d.garantia_meses');
            $this->db->from('inventario_mercaderia d');
            $this->db->join('mercaderia me', 'me.idmercaderia = d.idmercaderia');
            $this->db->join('marca m', 'm.idmarca = me.idmarca');
            $this->db->where('d.estado <> 0');
            $this->db->where('d.estado_inv <> 2');
            if($idmarca != ''){
                $this->db->where('me.idmarca', $idmarca);
            }
            $consulta = $this->db->get();
            //$resultado = $consulta->result();
            $resultado = $consulta->result();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscar_inventarioarticulo($idinventario_mercaderia) {
        try {
            $this->db->select('me.modelo, (select im.foto from imagen im where im.idmercaderia = me.idmercaderia order by rand() limit 1) as imagen, m.nombre as nommarca, m.idmarca, d.idinventario_mercaderia, d.serie, d.costo, d.precio_venta, d.garantia_meses');
            $this->db->from('inventario_mercaderia d');
            $this->db->join('mercaderia me', 'me.idmercaderia = d.idmercaderia');
            $this->db->join('marca m', 'm.idmarca = me.idmarca');
            $this->db->where('d.idinventario_mercaderia', $idinventario_mercaderia);
            $consulta = $this->db->get();
            //$resultado = $consulta->result();
            $resultado = $consulta->row();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscar_cliente($correo) {
        try {
            $this->db->select('*');
            $this->db->from('cliente c');
            $this->db->where('c.correo', $correo);
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscargrupo($idgrupo) {
        try {
            $this->db->select('pa.url, d.iddetallegrupo, d.idpagina, pa.nombre, d.estado, d.editar, d.crear, d.eliminar, d.ver, d.listar, d.export');
            $this->db->from('detallegrupo d');
            $this->db->join('pagina pa','pa.idpagina=d.idpagina');
            $this->db->where("d.idgrupo",$idgrupo);
            $this->db->order_by('pa.nombre asc');
            $consulta = $this->db->get();
            $resultado = $consulta->result();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function buscar_rol($idgrupo) {
        try {
            $this->db->select('*');
            $this->db->from('grupo c');
            $this->db->where('c.idgrupo', $idgrupo);
            $consulta = $this->db->get();
            $resultado = $consulta->row();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarDetPag($idgrupo) {
        try {
            $this->db->select('pa.identificador , d.iddetallegrupo, pa.url, d.idpagina,d.idgrupo,d.ver,d.editar,d.crear,d.eliminar, d.listar, d.export');
            $this->db->from('detallegrupo d');
            $this->db->join('pagina pa','pa.idpagina=d.idpagina');
            $this->db->where('d.idgrupo', $idgrupo);
            $consulta = $this->db->get();
            $resultado = $consulta->result();
            return $resultado;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function ventasinforme() {
        try {
            $this->db->select('v.idventa, v.fecha, count(*) as total');
            $this->db->from('venta_mercaderia vd');
            $this->db->join('venta v', 'v.idventa = vd.idventa');
			$this->db->group_by(array('vd.idventa'));
			$this->db->order_by('v.idventa asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function venta_inventario_informe($idventa, $fechai, $fechaf) {
        try {   
            $this->db->select('vd.idventa_mercaderia, vd.precio, i.idinventario_mercaderia , i.serie, i.costo, i.precio_venta, i.garantia_meses, i.estado_inv, i.idmercaderia, m.modelo, ma.nombre
            ,c.idventa, c.fecha, c.idcliente, p.nombres, p.cedula, p.direccion, p.telefono');
            $this->db->from('venta_mercaderia vd');
            $this->db->join('venta c', 'c.idventa = vd.idventa');
            $this->db->join('inventario_mercaderia i', 'i.idinventario_mercaderia = vd.idinventario_mercaderia');
            $this->db->join('mercaderia m', 'i.idmercaderia = m.idmercaderia');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
            $this->db->join('cliente p', 'p.idcliente = c.idcliente');
            if($fechai != ''){
                $this->db->where('(c.fecha>="' . $fechai . '" and c.fecha<="' . $fechaf . '")');
            }
            if($idventa != '0'){
                $this->db->where('c.idventa',$idventa);
            }
            
			$this->db->order_by('c.fecha asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function venta_inventario_grafico_1() {
        try {   
            $this->db->select('month(c.fecha) as total, sum(vd.precio) as precio');
            $this->db->from('venta_mercaderia vd');
            $this->db->join('venta c', 'c.idventa = vd.idventa');

            $this->db->where('year(c.fecha) = year(now())');
			$this->db->group_by(array('month(c.fecha)'));
			$this->db->order_by('c.fecha asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function compra_inventario_grafico_1() {
        try {   
            $this->db->select('month(c.fecha) as total, sum(i.costo) as precio');
            $this->db->from('inventario_mercaderia i');
            $this->db->join('compra c', 'c.idcompra = i.idcompra');

            $this->db->where('year(c.fecha) = year(now())');
			$this->db->group_by(array('month(c.fecha)'));
			$this->db->order_by('c.fecha asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function ventasumanios() {
        try {   
            $this->db->select('year(c.fecha) as anio');
            $this->db->from('venta_mercaderia vd');
            $this->db->join('venta c', 'c.idventa = vd.idventa');
			$this->db->group_by(array('year(c.fecha)'));
            $this->db->order_by('year(c.fecha) desc');
            $this->db->limit(6);
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function ventasumtodoasanios() {
        try {   
            $this->db->select('sum(vd.precio) as precio');
            $this->db->from('venta_mercaderia vd');
            $this->db->join('venta c', 'c.idventa = vd.idventa');
			$this->db->group_by(array('year(c.fecha)'));
            $this->db->order_by('year(c.fecha) desc');
            $this->db->limit(6);
            $resultado = $this->db->get();
            return $resultado->result_array();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function compra_inventario_informe($idcompra, $fechai, $fechaf) {
        try {   
            $this->db->select('i.idinventario_mercaderia , i.serie, i.costo, i.precio_venta, i.garantia_meses, i.estado_inv, i.idmercaderia, m.modelo, ma.nombre
            ,c.idcompra, c.fecha, c.idproveedor, p.nombres, p.ruc, p.direccion, p.telefono');
            $this->db->from('inventario_mercaderia i');
            $this->db->join('mercaderia m', 'i.idmercaderia = m.idmercaderia');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
            $this->db->join('compra c', 'c.idcompra = i.idcompra');
            $this->db->join('proveedor p', 'p.idproveedor = c.idproveedor');
            if($fechai != ''){
                $this->db->where('(c.fecha>="' . $fechai . '" and c.fecha<="' . $fechaf . '")');
            }
            if($idcompra != '0'){
                $this->db->where('c.idcompra',$idcompra);
            }
			$this->db->order_by('m.modelo asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function comprasinforme() {
        try {
            $this->db->select('v.idcompra, v.fecha, count(*) as total');
            $this->db->from('inventario_mercaderia vd');
            $this->db->join('compra v', 'v.idcompra = vd.idcompra');
			$this->db->group_by(array('vd.idcompra'));
			$this->db->order_by('v.idcompra asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function gasto_informe($idtipogasto, $fechai, $fechaf) {
        try {   
            $this->db->select('g.fecha, g.valor, tg.nombre');
            $this->db->from('gasto g');
            $this->db->join('tipogasto tg', 'tg.idtipogasto = g.idtipogasto');
            if($fechai != ''){
                $this->db->where('(g.fecha>="' . $fechai . '" and g.fecha<="' . $fechaf . '")');
            }
            if($idtipogasto != '0'){
                $this->db->where('g.idtipogasto',$idtipogasto);
            }
			$this->db->order_by('g.fecha asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function gastosinforme() {
        try {
            $this->db->select('count(*) as total, tg.nombre, tg.idtipogasto');
            $this->db->from('gasto g');
            $this->db->join('tipogasto tg', 'tg.idtipogasto = g.idtipogasto');

			$this->db->group_by(array('tg.idtipogasto'));
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function proveedor_inventario_informe($fechai, $fechaf) {
        try {   
            $this->db->select('p.nombres, p.ruc, p.telefono, i.precio_venta as pvp, sum(i.costo) as costo');
            $this->db->from('inventario_mercaderia i');
            $this->db->join('mercaderia m', 'i.idmercaderia = m.idmercaderia');
            $this->db->join('marca ma', 'ma.idmarca = m.idmarca');
            $this->db->join('compra c', 'c.idcompra = i.idcompra');
            $this->db->join('proveedor p', 'p.idproveedor = c.idproveedor');
            if($fechai != ''){
                $this->db->where('(c.fecha>="' . $fechai . '" and c.fecha<="' . $fechaf . '")');
            }
            $this->db->group_by(array('p.idproveedor'));

			$this->db->order_by('m.modelo asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function cliente_informe($fechai, $fechaf) {
        try {   
            $this->db->select('*');
            $this->db->from('cliente c');
            if($fechai != ''){
                $this->db->where('(c.fecha>="' . $fechai . '" and c.fecha<="' . $fechaf . '")');
            }
            $this->db->where('c.idcliente <> 1');
			$this->db->order_by('c.nombres asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function comprasinforme_ctaporpagar() {
        try {
            $this->db->select('cp.idcompra, count(*) as total');
            $this->db->from('pagodeuda pd');
            $this->db->join('credito_pagar cp', 'cp.idcredito_pagar = pd.idcredito_pagar');
			$this->db->group_by(array('cp.idcompra'));
			$this->db->order_by('cp.idcompra asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function listarpagodeuda_informe($idcompra, $fechai, $fechaf) {
        try {
            $this->db->select('c.idcompra, pd.idpagodeuda, pd.fecha, pd.numcheque, pd.valorcheque, pd.estado, cb.numero, cb.tipo, b.nombre, p.nombres, p.ruc');
            $this->db->from('pagodeuda pd');
            $this->db->join('credito_pagar cp', 'cp.idcredito_pagar = pd.idcredito_pagar');
            $this->db->join('cuentabancaria cb', 'cb.idcuentabancaria = pd.idcuentabancaria');
            $this->db->join('banco b', 'b.idbanco = cb.idbanco');
            $this->db->join('compra c', 'cp.idcompra = c.idcompra');
            $this->db->join('proveedor p', 'p.idproveedor = c.idproveedor');
            if($fechai != ''){
                $this->db->where('(c.fecha>="' . $fechai . '" and c.fecha<="' . $fechaf . '")');
            }
            if($idcompra != '0'){
                $this->db->where('c.idcompra',$idcompra);
            }
			$this->db->order_by('pd.fecha asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function informe_credito() {
        try {
            $this->db->select('c.idventa, count(*) as total');
            $this->db->from('amortizacion_cuotas ac');
            $this->db->join('credito c', 'c.idcredito = ac.idcredito');
			$this->db->group_by(array('c.idventa'));
			$this->db->order_by('c.idventa asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    

    public function creditopagodeuda_venta($idventa, $fechai, $fechaf) {
        try {
            $this->db->select('c.idventa, cl.nombres, cl.apellidos, cl.cedula, pd.idcredito, pd.idamortizacion_cuotas, pd.fechapagar, pd.fechapagado, pd.valorcuota, pd.valorabonado, pd.recargo, pd.estado, pd.saldo');
            $this->db->from('amortizacion_cuotas pd');
            $this->db->join('credito c', 'c.idcredito = pd.idcredito');
            $this->db->join('venta v', 'v.idventa = c.idventa');
            $this->db->join('cliente cl', 'cl.idcliente = v.idcliente');
            if($fechai != ''){
                $this->db->where('(pd.fechapagar>="' . $fechai . '" and pd.fechapagar<="' . $fechaf . '")');
            }
            if($idventa != '0'){
                $this->db->where('c.idventa',$idventa);
            }
			$this->db->order_by('pd.fechapagar asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function devoluciones_informe($tipo, $fechai, $fechaf) {
        try {
            $this->db->select('i.serie, d.fecha, d.motivo, d.resultado, d.tipo');
            $this->db->from('devolucion d');
            $this->db->join('inventario_mercaderia i', 'i.idinventario_mercaderia = d.idinventario_mercaderia');
            if($fechai != ''){
                $this->db->where('(d.fecha>="' . $fechai . '" and d.fecha<="' . $fechaf . '")');
            }
            if($tipo != '0'){
                $this->db->where('d.tipo',$tipo);
            }
			$this->db->order_by('d.fecha asc');
            $resultado = $this->db->get();
            return $resultado->result();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
}