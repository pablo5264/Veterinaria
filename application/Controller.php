<?php
//esta clase no puede ser instanciada
abstract class Controller
{
	protected $_view;

	public function __construct(){
		$this->_view = new View(new Request);
	}
	//obliga a las clases hijas a implementar un metodo index por defecto
	abstract function index();

	protected function loadModel($modelo)
	{
		$modelo = $modelo . 'Model';
		$rutaModelo = ROOT . 'models' . DS . $modelo . '.php';

		if(is_readable($rutaModelo)):
			require_once $rutaModelo;
			$modelo = new $modelo;
			return $modelo;
		else:
			throw new Exception("Error de modelo");

		endif;
	}

	protected function verificarSession(){
		if (!Session::get('autenticado')) {
			$this->redireccionar('usuarios/login');
		}
	}

	protected function verificarRolAdmin(){
		foreach (Session::get('usuario_roles')->funcionarioRol as $funcionarioRol) {
			//echo $funcionarioRol->rol->nombre;
			if ($funcionarioRol->rol->nombre == 'Administrador(a)') {
				return true;
			}
		}

		$this->redireccionar();
	}

	protected  function verificarMensajes(){
		if (Session::get('msg_success')) {
			$msg_success = Session::get('msg_success');
			$this->_view->assign('_mensaje', $msg_success);
			Session::destroy('msg_success');
		}

		if (Session::get('msg_error')) {
			$msg_error = Session::get('msg_error');
			$this->_view->assign('_error', $msg_error);
			Session::destroy('msg_error');
		}
	}

	protected function getLibrary($libreria)
	{
		$rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';

		if(is_readable($rutaLibreria)):
			require_once $rutaLibreria;
		else:
			throw new Exception("Error de libreria");

		endif;
	}

	//filtrar variable que viene via post en el formulario
	protected function getTexto($clave)
	{
		if(isset($_POST[$clave]) && !empty($_POST[$clave])):
			$_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES); //transforma comillas simpes y dobles
			return $_POST[$clave];
		endif;

		return '';
	}

	//metodo que valida numeros enviados via post en el formulario
	protected function getInt($clave)
	{
		if(isset($_POST[$clave]) && !empty($_POST[$clave])):
			$_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT); //valida numeros tipo integer
			return $_POST[$clave];
		endif;

		return 0;
	}

	protected function redireccionar($ruta = false)
	{
		if($ruta):
			header('Location:' . BASE_URL . $ruta);
			exit;
		else:
			header('Location:' . BASE_URL);
			exit;
		endif;
	}

	//metodo que filtra un id que viene por get en un formulario o enlace
	protected function filtrarInt($int)
	{
		$int = (int) $int;

		if(is_int($int)):
			return $int;
		else:
			return 0;
		endif;
	}

	//metodo que devuelve los parametros sin filtrar
	protected function getPostParam($clave)
	{
		if(isset($_POST[$clave])):
			return $_POST[$clave];
		endif;
	}

	//metodo que filtra las inyecciones sql
	protected function getSql($clave)
	{
		if(isset($_POST[$clave]) && !empty($_POST[$clave])):
			$_POST[$clave] = strip_tags($_POST[$clave]);

			//if(!get_magic_quotes_gpc()):
			//	$_POST[$clave] = mysql_escape_string($_POST[$clave]);
			//endif;

			return trim($_POST[$clave]);
		endif;
	}

	//reemplaza los caracteres diferentes a los patrones de preg_replace
	protected function getAlphaNum($clave)
	{
		if(isset($_POST[$clave]) && !empty($_POST[$clave])):
			$_POST[$clave] = (string) preg_replace('/[^A-Z0-9_][*\s][?\-]/i', '', $_POST[$clave]);
			return trim($_POST[$clave]);
		endif;
	}

	public function validarEmail($email)
	{
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
			return false;
		endif;

		return  true;
	}

	public function validarUrl($url)
	{
		if(!filter_var($url, FILTER_VALIDATE_URL)):
			return false;
		endif;

		return true;
	}

	public function inArray($clave)
	{
		if (is_array($clave)) {
			foreach ($_POST[$clave] as $clave) {
				$arreglo = implode(',', $clave);
			}
			return $arreglo;
		}
		return $_POST[$clave];
	}

	protected function validaRut($rut)
	{
		$rut = preg_replace('/[^k0-9]/i', '', $rut);
		$dv  = substr($rut, -1);
		$numero = substr($rut, 0, strlen($rut)-1);
		$i = 2;
		$suma = 0;
		foreach(array_reverse(str_split($numero)) as $v)
		{
			if($i==8)
				$i = 2;

			$suma += $v * $i;
			++$i;
		}

		$dvr = 11 - ($suma % 11);

		if($dvr == 11)
			$dvr = 0;
		if($dvr == 10)
			$dvr = 'K';

		if($dvr == strtoupper($dv))
			return true;
		else
			return false;
	}
}