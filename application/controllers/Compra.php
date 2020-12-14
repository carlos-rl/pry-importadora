<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Compra extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->Data->tabla = 'compra';
        $this->Data->id = 'idcompra';
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
        $this->load->view('compra.php',array(
            'title' => 'Compras',
            'nombre' => '',
            'idcompra_after' => $this->Data->idCompraMax(),
            'idmercaderia' => $this->Data->compra_mercaderia(),
            'idproveedor' => $this->Data->compra_proveedor(),
            'idcuentabancaria' => $this->Data->compra_cuentabancaria(),
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
        $this->load->view('compra_detalle.php',array(
            'title' => 'Compras',
            'nombre' => '',
            'idcompra_after' => $id,
            'idinventario' => $this->Data->compra_inventario($id),
            'idmercaderia' => $this->Data->compra_mercaderia(),
            'idproveedor' => $this->Data->compra_proveedor_buscar($id),
            'idcuentabancaria' => $this->Data->compra_cuentabancaria(),
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
                'idproveedor' => $post->idproveedor,
                'fecha' => $post->fecha
            );
            $idcompra = $this->Data->crearVC($data);

            $sql = 'INSERT INTO inventario_mercaderia(idcompra, serie, costo, precio_venta, garantia_meses, idmercaderia) values';
            $total = 0;
            for ($i = 0; $i < count($detalle); $i++) {
                $ins = $detalle[$i];
                $sql .= '(' . $idcompra . ', "' . $ins->serie. '", ' . $ins->costo . ', ' . $ins->precio_venta . ', ' . $ins->garantia_meses . ', ' . $ins->idmercaderia . ')' . ((count($detalle) == $i + 1) ? ' ' : ' ,');
                $total = $total + $ins->costo;
            }
            $this->Data->sql($sql);
            $this->credito($idcompra, $post->idproveedor, $post->fechai, $post->cuotas, $total, $post->tipo, $post->idcuentabancaria);
            
            echo '{"resp" : true, "idcompra":'.$idcompra.'}';
        }
    }

    private function credito($idcompra, $idproveedor, $fechai, $num_pago, $total, $tipo, $idcuentabancaria) {
        $fecha_actual = $fechai;
        $fechaf  = '';
        $tipo = ($tipo == '1'?'+ 1 month':'+ 1 week');
        for ($i=0; $i < $num_pago ; $i++) {
            $fecha_actual = date("Y-m-d",strtotime($fecha_actual.$tipo));
            if($num_pago == ($i+1)){
                $fechaf = $fecha_actual;
            }
        }
        $fecha_actual = $fechai;
        $sql = 'INSERT INTO pagodeuda(fecha, valorcheque, idcredito_pagar, idcuentabancaria) values';
        $varlop = $total / $num_pago;

        /**credito_pagar */
        $this->Data->tabla = 'credito_pagar';
        $this->Data->id = 'idcredito_pagar';
        $idcredito_pagar = $this->Data->crearVC(
            array(
                'deudainicial' => $total,
                'saldo' => $total,
                'estado' => 0,
                'idcompra' => $idcompra,
                'idproveedor' => $idproveedor
            )
        );

        for ($i = 0; $i < $num_pago; $i++) {
            $estado = 0;
            $sql .= '("' . $fecha_actual . '", ' . $varlop. ', "' . $idcredito_pagar. '", '.$idcuentabancaria.')' . ((($num_pago) == $i + 1) ? ' ' : ' ,');
            $fecha_actual = date("Y-m-d",strtotime($fecha_actual.$tipo));
        }
        $this->Data->sql($sql);
        return true;
    }
    
    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                $this->Data->tabla = 'inventario_mercaderia';
                $this->Data->id = 'idinventario_mercaderia';
                $this->Data->eliminar($post->idinventario_mercaderia);
                echo '{"resp":true}';
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }

    public function informe(){
        $diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;

        $accesos = $this->Data->listarDetPag($this->session->userdata('idgrupo'));
        $ins = esConsedido($accesos, 'compras');
        if($ins->crear == '0'){
            show_404();
        }
        $this->load->view('informe/compra.php',array(
            'title' => 'Informe de compras',
            'nombre' => '',
            'compras' => $this->Data->comprasinforme(),
            'data_accessos' => $accesos,
            'subtitle' => 'Buscar por rango o por Número de compra',
            'fecha' => $fecha
        ));
    }

    public function listarreporte() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $post = (object) $_POST;
            try {
                echo '{"lista":'.json_encode(
                                    $this->Data->compra_inventario_informe($post->idcompra, $post->fechai, $post->fechaf)
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
                $dat = $this->Data->compra_inventario_informe($post->idcompra, $post->fechai, $post->fechaf);
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
                $mpdf->writeHTML(file_get_contents(base_url() . 'static/html/style.css'), \Mpdf\HTMLParserMode::HEADER_CSS);
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y/%m/%d %H:%M:%S");
                $url = base_url();
                $htmlPage = file_get_contents('static/html/compra.html');

                //DATOS DE LA EMPPRESA
                $idimportadora = $this->session->userdata('idimportadora');
                $htmlPage = str_ireplace('{{impor_nombre}}', $idimportadora->nombre, $htmlPage);
                $htmlPage = str_ireplace('{{impor_direccion}}', $idimportadora->direccion, $htmlPage);
                $htmlPage = str_ireplace('{{impor_telefono}}', $idimportadora->telefono, $htmlPage);
                $htmlPage = str_ireplace('{{impor_ruc}}', $idimportadora->ruc, $htmlPage);
                //FIN DE DATOS DE LA EMPRESA

                //DATOS DE LA FACTURA
                $htmlPage = str_ireplace('{{v_fechai}}', $post->fechai, $htmlPage);
                $htmlPage = str_ireplace('{{v_fechaf}}', $post->fechaf, $htmlPage);
                $htmlPage = str_ireplace('{{fecha_hoy}}', $fecha, $htmlPage);
                $htmlPage = str_ireplace('{{report_nombre}}', 'Informe de compras', $htmlPage);
                //FIN DE DATOS DE LA FACTURA

                $total = 0;
                $b = 0;
                foreach ($dat as $x):
                    $total = $total + $x->costo;
                    $b++;
                    $htmlTable .= '<tr class="service">';
                    $htmlTable .= '<td class="tableitem">' . $b .'</td>';
                    $htmlTable .= '<td class="tableitem">C-' . str_pad($x->idcompra, 8, "0", STR_PAD_LEFT) .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->fecha .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->serie .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->modelo .' ' . $x->nombre .'</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->garantia_meses .' mes(es)</td>';
                    $htmlTable .= '<td class="tableitem">' . $x->nombres . ' - ' . $x->ruc . '</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->costo .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->precio_venta .'</td>';
                    $htmlTable .= '<td class="tableitem">$ ' . $x->costo .'</td>';
                    $htmlTable .= '</tr>';
                endforeach;
                if(count($dat)==0){
					$htmlTable .= '<tr>';
                    $htmlTable .= '<td colspan="10" align="center">Ningún dato disponible - Impreso '.$fecha .'</td>';
                    $htmlTable .= '</tr>';
                }
                $htmlPage = str_ireplace('{{table_row}}', $htmlTable, $htmlPage);
                //echo $htmlPage ;
                $htmlPage = str_ireplace('{{total}}', round($total,2), $htmlPage);
                $mpdf->writeHTML($htmlPage, \Mpdf\HTMLParserMode::HTML_BODY);
                $mpdf->Output('reporte_' . $fecha . '.pdf', 'D');
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            show_404();
        }
    }
}