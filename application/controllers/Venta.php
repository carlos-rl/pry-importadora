<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Venta extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'venta';
        $this->Data->id = 'idventa';
		if(!is_logged_in()){
			show_404();
        }
    }
    
	public function index(){
        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $accesos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($accesos, 'compras');
        if($ins->crear == '0'){
            show_404();
        }

        $this->load->view('venta.php',array(
            'title' => 'Ventas',
            'nombre' => '',
            'idventa_after' => $this->Data->idVentaMax(),
            'idinventario_mercaderia' => $this->Data->venta_mercaderia(),
            'idcliente' => $this->Data->venta_cliente(),
            'data_accessos' => $accesos,
            'subtitle' => '',
            'subtitle' => '',
            'fecha' => $fecha
        ));
    }

    public function detalle($id=''){
        if($id == ''){
            show_404();
        }

        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $obtener_permisos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $this->load->view('venta_detalle.php',array(
            'title' => 'Ventas',
            'nombre' => '',
            'idcompra_after' => $id,
            'escredito' => $this->Data->escredito($id),
            'idinventario' => $this->Data->venta_inventario($id),
            'idmercaderia' => $this->Data->venta_mercaderia(),
            'idcliente' => $this->Data->venta_cliente_buscar($id),
            'data_accessos' => $obtener_permisos,
            'subtitle' => '',
            'subtitle' => '',
            'fecha' => $fecha
        ));
    }

    public function buscarserie() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            echo '{"resp":'.$this->Data->existeserie($post->serie).'}';
        } else {
            show_404();
        }
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            $detalle = json_decode($_POST['detalle']);
            $data = array(
                'idcliente' => $post->idcliente,
                'fecha' => $post->fecha
            );
            $idventa = $this->Data->crearVC($data);

            $sql = 'INSERT INTO venta_mercaderia(idventa, idinventario_mercaderia, precio) values';
            $total = 0;
            for ($i = 0; $i < count($detalle); $i++) {
                $ins = $detalle[$i];
                $sql .= '(' . $idventa . ', "' . $ins->idinventario_mercaderia. '", ' . $ins->precio_venta . ')' . ((count($detalle) == $i + 1) ? ' ' : ' ,');
                $total = $total + $ins->precio_venta;
            }
            $this->Data->sql($sql);
            $this->credito($idventa, $post->idcliente, $post->fechai, $post->cuotas, $total, $post->tipo);
            
            echo '{"resp" : true, "idventa":'.$idventa.'}';
        }
    }

    public function crearnew() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            $detalle = json_decode($_POST['detalle']);
            $data = array(
                'idcliente' => $post->idcliente,
                'fecha' => $post->fecha
            );
            $idventa = $this->Data->crearVC($data);

            $sql = 'INSERT INTO venta_mercaderia(idventa, idinventario_mercaderia, precio) values';
            $total = 0;
            for ($i = 0; $i < count($detalle); $i++) {
                $ins = $detalle[$i];
                $sql .= '(' . $idventa . ', "' . $ins->idinventario_mercaderia. '", ' . $ins->precio_venta . ')' . ((count($detalle) == $i + 1) ? ' ' : ' ,');
                $total = $total + $ins->precio_venta;
            }
            $this->Data->sql($sql);
            $this->credito_new($idventa, $post->idcliente, $post->fechai, $post->cuotas, $total, $post->tipo, $post->pago);
            
            echo '{"resp" : true, "idventa":'.$idventa.'}';
        }
    }

    private function credito_new($idcompra, $idcliente, $fechai, $num_pago, $total, $tipo, $pago) {
        $fecha_actual = $fechai;
        $fechaf  = '';
        $tipo = ($tipo == '1'?'+ 1 month':($tipo == '2'?'+ 1 week':'+15 day'));
        for ($i=0; $i < $num_pago ; $i++) {
            $fecha_actual = date("Y-m-d",strtotime($fecha_actual.$tipo));
            if($num_pago == ($i+1)){
                $fechaf = $fecha_actual;
            }
        }
        $fecha_actual = $fechai;
        $sql = 'INSERT INTO amortizacion_cuotas(fechapagar, valorcuota, idcredito) values';
        $varlop = $total / $num_pago;

        /**credito_pagar */
        $this->Data->tabla = 'credito';
        $this->Data->id = 'idcredito';
        $idcredito_pagar = $this->Data->crearVC(
            array(
                'deudainicial' => $total,
                'saldo' => $total,
                'estado' => ($pago=='si'?1:0),
                'idcliente' => $idcliente,
                'idventa' => $idcompra
            )
        );

        for ($i = 0; $i < $num_pago; $i++) {
            $estado = 0;
            $sql .= '("' . $fecha_actual . '", ' . $varlop. ', '.$idcredito_pagar.')' . ((($num_pago) == $i + 1) ? ' ' : ' ,');
            $fecha_actual = date("Y-m-d",strtotime($fecha_actual.$tipo));
        }
        $this->Data->sql($sql);
        return true;
    }

    public function editarventa() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            $data = array(
                'estado_v' => 1
            );
            $this->Data->editar($data, $post->idventa);
            $this->eliminar_credito($post->idventa);
            $this->credito($post->idventa, $post->idcliente, $post->fechai, $post->cuotas, $post->total, $post->tipo);
            
            echo '{"resp" : true, "idventa":'.$post->idventa.'}';
        }
    }

    private function credito($idcompra, $idcliente, $fechai, $num_pago, $total, $tipo) {
        $fecha_actual = $fechai;
        $fechaf  = '';
        $tipo = ($tipo == '1'?'+ 1 month':($tipo == '2'?'+ 1 week':'+15 day'));
        for ($i=0; $i < $num_pago ; $i++) {
            $fecha_actual = date("Y-m-d",strtotime($fecha_actual.$tipo));
            if($num_pago == ($i+1)){
                $fechaf = $fecha_actual;
            }
        }
        $fecha_actual = $fechai;
        $sql = 'INSERT INTO amortizacion_cuotas(fechapagar, valorcuota, idcredito) values';
        $varlop = $total / $num_pago;

        /**credito_pagar */
        $this->Data->tabla = 'credito';
        $this->Data->id = 'idcredito';
        $idcredito_pagar = $this->Data->crearVC(
            array(
                'deudainicial' => $total,
                'saldo' => $total,
                'estado' => 0,
                'idcliente' => $idcliente,
                'idventa' => $idcompra
            )
        );

        for ($i = 0; $i < $num_pago; $i++) {
            $estado = 0;
            $sql .= '("' . $fecha_actual . '", ' . $varlop. ', '.$idcredito_pagar.')' . ((($num_pago) == $i + 1) ? ' ' : ' ,');
            $fecha_actual = date("Y-m-d",strtotime($fecha_actual.$tipo));
        }
        $this->Data->sql($sql);
        return true;
    }
    
    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                $this->Data->tabla = 'venta_mercaderia';
                $this->Data->id = 'idventa_mercaderia';
                $this->Data->eliminar($post->idventa_mercaderia);
                echo '{"resp":true}';
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }

    private function eliminar_credito($idventa) {
        $this->Data->sql('DELETE FROM credito where idventa = '.$idventa);
        return true;
    }

    public function informe(){
        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $accesos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($accesos, 'ventas');
        if($ins->crear == '0'){
            show_404();
        }
        $this->load->view('informe/venta.php',array(
            'title' => 'Informe de ventas',
            'nombre' => '',
            'ventas' => $this->Data->ventasinforme(),
            'data_accessos' => $accesos,
            'subtitle' => 'Buscar por rango o por cliente',
            'fecha' => $fecha
        ));
    }

    public function listarreporte() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                echo '{"lista":'.json_encode(
                                    $this->Data->venta_inventario_informe($post->idcliente, $post->fechai, $post->fechaf)
                                ).'}';
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }

    public function pdf() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            try {
                require_once(APPPATH . '/libraries/mpdfnew/vendor/autoload.php');
                $post = (object) $_GET;
                $dat = $this->Data->venta_inventario_informe($post->idcliente, $post->fechai, $post->fechaf);
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
                $mpdf->writeHTML(file_get_contents(base_url() . 'static/html/style.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y/%m/%d %H:%M:%S");
                $url = base_url();
                $htmlPage = file_get_contents('static/html/venta.html');

                //DATOS DE LA EMPPRESA
                $idimportadora = $this->session->userdata('idimportadora');
                $htmlPage = str_ireplace('{{imagen}}', (base_url('static/logo-jhael.png')), $htmlPage);
                $htmlPage = str_ireplace('{{impor_nombre}}', $idimportadora->nombre, $htmlPage);
                $htmlPage = str_ireplace('{{impor_direccion}}', $idimportadora->direccion, $htmlPage);
                $htmlPage = str_ireplace('{{impor_telefono}}', $idimportadora->telefono, $htmlPage);
                $htmlPage = str_ireplace('{{impor_ruc}}', $idimportadora->ruc, $htmlPage);
                //FIN DE DATOS DE LA EMPRESA

                //DATOS DE LA FACTURA
                $htmlPage = str_ireplace('{{v_fechai}}', $post->fechai, $htmlPage);
                $htmlPage = str_ireplace('{{v_fechaf}}', $post->fechaf, $htmlPage);
                $htmlPage = str_ireplace('{{fecha_hoy}}', $fecha, $htmlPage);
                $htmlPage = str_ireplace('{{report_nombre}}', 'Informe de ventas', $htmlPage);
                //FIN DE DATOS DE LA FACTURA

                $total = 0;
                $b = 0;
                foreach ($dat as $x):
                    $total = $total + $x->precio_venta;
                    $b++;
                    $htmlTable .= '<tr class="service">';
                    $htmlTable .= '<td class="tableitem">' . $b .'</td>';
                    $htmlTable .= '<td class="tableitem">V-' . str_pad($x->idventa, 8, "0", STR_PAD_LEFT) .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->fecha .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->serie .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->modelo .' ' . $x->nombre .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->garantia_meses .' mes(es)</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->nombres . ' - ' . $x->cedula . '</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->precio_venta .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->precio_venta .'</td>';
                    $htmlTable .= '</tr>';
                endforeach;
                if(count($dat)==0){
					$htmlTable .= '<tr>';
                    $htmlTable .= '<td colspan="9" align="center">Ningún dato disponible - Impreso '.$fecha .'</td>';
                    $htmlTable .= '</tr>';
                }
                $htmlPage = str_ireplace('{{table_row}}', $htmlTable, $htmlPage);
                //echo $htmlPage ;
                $htmlPage = str_ireplace('{{total}}', round($total,2), $htmlPage);
                $mpdf->writeHTML($htmlPage, \Mpdf\HTMLParserMode::HTML_BODY);
                $mpdf->Output('Informe de ventas' . $fecha . '.pdf', 'I');
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }
}