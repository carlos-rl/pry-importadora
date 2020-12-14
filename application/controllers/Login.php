<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Data');
        $this->Data->tabla = 'login';
        $this->Data->id = 'idlogin';
    }

    public function index() {
        date_default_timezone_set('America/Guayaquil');
        setlocale(LC_ALL, 'es_ES');
        $fecha = strftime("%Y-%m-%d");
        $data = array(
            'title' => 'Login',
            'breadcrumb' => 'Login',
            'page_header' => 'Login',
            'list_title' => 'Login',
            'nameform' => 'login',
            'titleform' => 'Administración del login'
        );
        $this->load->view('login', $data);
    }

    public function prueba() {
        $msg = 'jha-el@2020';
        $encrypted_string = $this->encrypt->encode($msg);
        echo ($encrypted_string);
    }

	private function iniciar_Sesion($user, $post){
		if ($user != FALSE && $user != NULL) {
			if (($this->encrypt->decode($user->contrasenia) == $post->pass)) {
                date_default_timezone_set('America/Guayaquil');
                setlocale(LC_ALL, 'es_ES');
                $fecha = strftime("%Y-%m-%d");
                $hora = strftime("%H:%M:%S");
                
				$sessionData = array(
					'idcliente' => $user,
					'admin' => $user->admin,
					'estado' => $user->estado,
					'idcompra' => 0,
					'tipo' => $user->tipo,
					'idimportadora' => $this->Data->buscarRegistro_em('importadora','idimportadora = 1'),
					'tipo' => $user->tipo,
					'idgrupo' => $user->idgrupo,
                    'idlogin' => $user->idlogin
                );
                
				$this->session->set_userdata($sessionData);
				return array('resp'=>true);
			} else {
				return array(
				'resp' => false,
				'msj' => "Usuario o contraseña no es válido"
				);
			}
		} else {
			return array(
				'resp' => false,
				'msj' => "Usuario Inválido"
				);
		}
    }
    

	function is_mobile(){
        return false;
		if(preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT'])){
			return true;
		} else { 
			return false;
		}
	}

    public function iniciar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //acciones por POST
            $post = (object) $_POST;
            
            if ($this->session->userdata('admin')) {
                $this->session->sess_destroy();
            }
            if ($this->session->userdata('idcliente')) {
                $this->session->sess_destroy();
            }

			if (trim($post->usuario) != "" && trim($post->pass) != "") {
				$user = $this->Data->buscarLogin($post->usuario);
				if(isset($user)){
                    if($user != false){
                        if($user->estado == '1'){
                            if($user->tipo != 'c'){
                                echo json_encode($this->iniciar_Sesion($user,$post));
                                exit();
                            }else{
                                echo json_encode($this->iniciar_SesionCliente($user,$post));
                                exit();
                            }
                            
                        }else{
                            echo '{"resp":false,"msj":"El usuario no está activo"}';
                            exit();
                        }
                    }else {
                        echo '{"resp":false,"msj":"El usuario o contraseña no es válido"}';
                        exit();
                    }
				} else {
					echo '{"resp":false,"msj":"El usuario o contraseña no es válido"}';
					exit();
				}
				
			} else {
				echo '{"resp":false,"msj":"Datos enviados no válido"}';
				exit();
			}
        } else {
            show_404();
        }
    }

    public function logout() {
        date_default_timezone_set('America/Guayaquil');
        setlocale(LC_ALL, 'es_ES');
        $hora = strftime("%H:%M:%S");
        $this->session->sess_destroy();
        redirect(base_url() . 'login');
    }

    public function salir_tienda() {
        date_default_timezone_set('America/Guayaquil');
        setlocale(LC_ALL, 'es_ES');
        $this->session->sess_destroy();
        redirect(base_url() . 'menu/inicio');
    }

    public function reset() {
        $data = array(
            'title' => 'Cambiar Contraseña',
            'breadcrumb' => 'Reset',
            'page_header' => 'Reset',
            'list_title' => 'Reset',
            'nameform' => 'pass',
            'titleform' => 'Cambio de pass'
        );
        $this->load->view('pass', $data);
    }

    public function cambiarpass() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $post = (object) $_POST;
                $data = array(
                    'clave' => $this->encrypt->encode($post->pwd)
                );
                if ($this->Data->editar($data, $post->id)) {
                    $this->logout();
                    exit();
                } else {
                    echo '{"resp" : false,'
                    . '"error" : "El registro no se guardó!!"}';
                    exit();
                }
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            //echo 'No posee permiso para estar aquí!!!!!!';
            show_404();
        }
    }

    public function sendpass() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $post = (object) $_POST;
                $user = $this->Data->buscaremail($post->correo);
                if($user['resp']){//EXISTE USUARIO
                    $codigo = $this->createRandomCode();
                    $fechaRecuperacion = date("Y-m-d H:i:s", strtotime('+24 hours'));
                    $this->Data->tabla = 'recovery_pass';
                    $this->Data->id = 'idrecovery';
                    $data = array(
                        'codigo' => $codigo,
                        'fecha' => $fechaRecuperacion,
                        'estado' => 0,
                        'idlogin' => $user['data']->idlogin
                    );
                    if( $user['recovery']['estado']!=0 ){
                        $this->sendMail(($user['data']->nombre.' '), $user['data']->correo, $codigo);
                        if ($this->Data->crear($data)) {

                            echo '{"resp":true}';
                            exit();
                        } else {
                            echo '{"resp":false,"msj":"Error en la base de datos!!"}';
                            exit();
                        }
                    } else {
                        $current = date("Y-m-d H:i:s");
                        if (strtotime($current) > strtotime($user['recovery']['fecha'])) {
                            $data = array(
                                'codigo' => $codigo,
                                'fecha' => $fechaRecuperacion,
                                'estado' => 0,
                                'idlogin' => $user['data']->idlogin
                            );
                            $this->sendMail(($user['data']->nombre.' '),$user['data']->correo, $codigo);
                            if ($this->Data->editar($data, $user['recovery']['idrecovery'])) {

                                echo '{"resp" : true}';
                                exit();
                            } else {
                                echo '{"resp" : false,'
                                    . '"msj" : "Intente nuevamente!!"}';
                                exit();
                            }
                        } else {
                            echo '{"resp":false,"msj":"Ya tienes un código de verficación válida <strong>expira en: </strong><br><code>'. $this->diferencia($user['recovery']['fecha']) .'</code>"}';
                            exit();
                        }
                    }
                }else{
                    echo '{"resp":false,"msj":"El correo no se encuentra en la base de datos o no está activo!!"}';
                    exit();
                }
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            //echo 'No posee permiso para estar aquí!!!!!!';
            show_404();
        }
    }

    public function diferencia($fecha){
        $date1 = new DateTime("now");
        $date2 = new DateTime($fecha);
        $diff = $date1->diff($date2);
        return $this->get_format($diff);
        // 3036 seconds to go [number is variable]
        //echo ( ($diff->days * 24 ) * 60 ) + ( $diff->i * 60 ) + $diff->s . ' seconds';
        // passed means if its negative and to go means if its positive
        //echo ($diff->invert == 1 ) ? ' passed ' : ' to go ';
    }

    private function get_format($df) {
        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->y > 0) {
            // years
            $str .= ($df->y > 1) ? $df->y . ' Años ' : $df->y . ' Año ';
        } if ($df->m > 0) {
            // month
            $str .= ($df->m > 1) ? $df->m . ' Meses ' : $df->m . ' Mes ';
        } if ($df->d > 0) {
            // days
            $str .= ($df->d > 1) ? $df->d . ' Días ' : $df->d . ' Día ';
        } if ($df->h > 0) {
            // hours
            $str .= ($df->h > 1) ? $df->h . ' Horas ' : $df->h . ' Hora ';
        } if ($df->i > 0) {
            // minutes
            $str .= ($df->i > 1) ? $df->i . ' Minutos ' : $df->i . ' Minuto ';
        } if ($df->s > 0) {
            // seconds
            $str .= ($df->s > 1) ? $df->s . ' Segundos ' : $df->s . ' Segundo ';
        }

        return $str;
    }

    public function editarpass($idlogin = null) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['pass'])) {
                $this->Data->tabla = 'recovery_pass';
                $this->Data->id = 'idrecovery';
                $data = array(
                    'pass' => $this->encrypt->encode($_POST['pass']),
                    'estado' => 1
                );
                if ($this->Data->editar($data, $_GET['codigo'])) {
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

    public function logins() {
        //$var = $this->encrypt->encode('@cademic02020');
        $var = $this->encrypt->encode('asdfg12345');
        echo date("Y-m-d H:i:s", strtotime('-24 hours'));
    }

    private function createRandomCode()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return time().$pass;
    }

    private function sendMail($nombre, $correo, $codigo) {
        require_once(APPPATH . '/libraries/correo/vendor/autoload.php');
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        $data_smtp = $this->Data->listarTablaOneData('tb_smtp');
        try {
            /*
             *      Servidor SMTP: smtp.gmail.com
                    Usuario SMTP: Tu usuario de Gmail completo (email), por ejemplo tuemail@gmail.com
                    Contraseña SMTP: Tu contraseña de Gmail.
                    Puerto SMTP: 587
                    TLS/SSL: Requerido.
             * */
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                     // Enable verbose debug output
            if($data_smtp->host_smtp==''){
                echo '{"resp" : false,'
                    . '"msj" : "Datos SMTP no definidos"}';
                exit();
            }
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = $data_smtp->host_smtp;                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $data_smtp->usuario_smtp;                     // SMTP username
            $mail->Password   = $data_smtp->pass_smtp;                               // SMTP password
            $mail->SMTPSecure = $data_smtp->secure_smtp;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = $data_smtp->port_smtp;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('crojano@altitude.ec', 'Cambio de contraseña');
            $mail->addAddress($correo, $nombre);
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


            $template = file_get_contents('static/html/index.html');
            $template = str_replace("{{name}}", $nombre, $template);
            $template = str_replace("{{title_sistem}}", 'Sistema Distribuidora - Los juanes', $template);
            $template = str_replace("{{title_telefono}}", '0900000000', $template);
            $template = str_replace("{{action_url}}", base_url().'login/newpass/'.$codigo, $template);
            $template = str_replace("{{year}}", date('Y'), $template);
            $template = str_replace("{{operating_system}}", $this->getOS(), $template);
            $template = str_replace("{{browser_name}}", $this->getBrowser(), $template);
            $mail->Subject = 'Recuperación de contraseña - Sistema Distribuidora - Los juanes';
            $mail->Body    = $template;
            if (!$mail->send()) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    public function pruebasendmail() {
        require_once(APPPATH . '/libraries/correo/vendor/autoload.php');
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $empresa = $this->Data->listarTablaOneData('empresa');
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = $empresa->host_smtp;                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $empresa->usuario_smtp;                     // SMTP username
                $mail->Password   = $empresa->pass_smtp;                               // SMTP password
                $mail->SMTPSecure = $empresa->secure_smtp;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = $empresa->port_smtp;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                //Recipients
                $mail->setFrom($empresa->email_smtp, $empresa->from_smtp);
                if($mail->smtpConnect()){
                    $mail->smtpClose();
                    echo '{"resp":true}';
                }
                else{
                    echo '{"resp":false}';
                }
            } catch (Exception $ex) {
                echo '{"resp":false,"sms":"' . $ex->getMessage() . '"}';
            }
        } else {
            echo '{"resp":false}';
        }
    }

    private function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform  = "Unknown OS Platform";

        $os_array     = array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    private function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        = "Unknown Browser";

        $browser_array = array(
            '/msie/i'      => 'Internet Explorer',
            '/firefox/i'   => 'Firefox',
            '/safari/i'    => 'Safari',
            '/chrome/i'    => 'Chrome',
            '/edge/i'      => 'Edge',
            '/opera/i'     => 'Opera',
            '/netscape/i'  => 'Netscape',
            '/maxthon/i'   => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i'    => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }

    //CAMBIO DE CONTRASEÑA
    public function newpass($codigo = null){
        if($codigo!=null){
            $instancia = $this->Data->buscarCodigo($codigo);
            $recovery = $instancia['data'];
            if($instancia['resp']){
                $current = date("Y-m-d H:i:s");
                if (strtotime($current) < strtotime($recovery->fecha)) {
                    date_default_timezone_set('America/Guayaquil');
                    setlocale(LC_ALL, 'es_ES');
                    $fecha = strftime("%Y-%m-%d");
                    $data = array(
                        'title' => 'Login',
                        'breadcrumb' => 'Login',
                        'page_header' => 'Login',
                        'list_title' => 'Login',
                        'nameform' => 'login',
                        'recovery' => $recovery,
                        'titleform' => 'Administración del login'
                    );
                    $this->load->view('login_new_pass', $data);
                } else {
                    $mensaje = 'El código de recuperación de contraseña ha expirado. Por favor intenta de nuevo. <br><a href="'.base_url().'">Ir al menú</a>';
                    echo $mensaje;
                }
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['pass'])) {
                $data = array(
                    'username' => 'admin',
                    'pass' => ('asdfg12345'),
                    'name' => 'Administrador Web'
                );
                if ($this->Data->crear($data)) {
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

}
