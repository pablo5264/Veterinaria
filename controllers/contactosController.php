<?php 
/**
* 
*/
class contactosController extends Controller
{
	private $_contacto;
	private $_asunto;
	
	public function __construct(){
		parent::__construct();
		$this->_contacto = $this->loadModel('contacto');
		$this->_asunto = $this->loadModel('asunto');
	}

	public function index(){
		$this->verificarSession();
		$this->verificarRolAdmin();
		$this->verificarMensajes();

		$this->_view->assign('titulo', 'GalgoPro :: Contactos');
		$this->_view->assign('contactos', $this->_contacto->getContactos());
		$this->_view->renderizar('index');
	}
	
	public function view($id = null){
		$this->verificarSession();
		$this->verificarRolAdmin();
		$this->verificarContactos($id);

		$this->_view->assign('titulo', 'GalgoPro :: Ver Contacto');
		$this->_view->assign('contacto', $this->_contacto->getContactoId($this->filtrarInt($id)));
		$this->_view->assign('enviar', CTRL);

		if ($this->getAlphaNum('enviar') == CTRL) {
			$this->_view->assign('datos', $_POST);

			if (!$this->getSql('nombre')) {
				$this->_view->assign('_error', 'El nombre no existe');
				$this->_view->renderizar('view');
				exit;
			}

			if (!$this->getPostParam('email')) {
				$this->_view->assign('_error', 'El correo electrónico no existe');
				$this->_view->renderizar('view');
				exit;
			}

			if (!$this->validarEmail($this->getPostParam('email'))) {
				$this->_view->assign('_error', 'El correo electrónico no es válido');
				$this->_view->renderizar('view');
				exit;
			}

			if (!$this->getSql('asunto')) {
				$this->_view->assign('_error', 'El asunto no existe');
				$this->_view->renderizar('view');
				exit;
			}

			if (!$this->getSql('respuesta')) {
				$this->_view->assign('_error', 'Escriba una respuesta para este contacto');
				$this->_view->renderizar('view');
				exit;
			}

			$cabeceras = 'From: webmaster@galgopro.cl';

			if(mail($this->getPostParam('email'), $this->getSql('asunto'), $this->getSql('respuesta'), $cabeceras)){
				Session::set('msg_success', 'El correo se ha enviado correctamente');
			}else{
				Session::set('msg_error', 'El correo no se ha enviado... Inténtelo nuevamente');
			}

			$this->redireccionar('contactos');
		}

		$this->_view->renderizar('view');
	}

	public function add(){
		$this->verificarMensajes();
		
		$this->_view->assign('titulo', 'GalgoPro :: Nuevo Contacto');
		$this->_view->assign('asuntos', $this->_asunto->getAsuntos());
		$this->_view->assign('enviar', CTRL);

		if ($this->getAlphaNum('enviar') == CTRL) {
			$this->_view->assign('datos', $_POST);

			if (!$this->getSql('nombre')) {
				$this->_view->assign('_error', 'Ingresa tu nombre');
				$this->_view->renderizar('add');
				exit;
			}

			if (!$this->getPostParam('email')) {
				$this->_view->assign('_error', 'Ingresa tu correo electrónico');
				$this->_view->renderizar('add');
				exit;
			}

			if (!$this->validarEmail($this->getPostParam('email'))) {
				$this->_view->assign('_error', 'El correo electrónico no es válido');
				$this->_view->renderizar('add');
				exit;
			}

			if (!$this->getInt('asunto')) {
				$this->_view->assign('_error', 'Selecciona un asunto');
				$this->_view->renderizar('add');
				exit;
			}

			if (!$this->getSql('mensaje') || strlen($this->getSql('mensaje')) < 5) {
				$this->_view->assign('_error', 'Ingresa un mensaje entendible');
				$this->_view->renderizar('add');
				exit;
			}

			$row = $this->_contacto->addContacto(
				$this->getAlphaNum('nombre'), 
				$this->getPostParam('email'), 
				$this->getInt('asunto'), 
				$this->getSql('mensaje')
			);

			if ($row) {
				Session::set('msg_success', 'Tu mensaje o consulta se ha ingresado satisfactoriamente... Pronto nos comunicaremos contigo');
			}else{
				Session::set('msg_error', 'Lo sentimos, tu mensaje no ha podido ser procesado... Inténtalo nuevamente');
			}

			$this->redireccionar('contactos/add');
		}
		$this->_view->renderizar('add');
	}

	public function edit($id = null){
		$this->verificarSession();
		$this->verificarRolAdmin();
		$this->verificarContactos($id);

		$row = $this->_contacto->editContacto($this->filtrarInt($id));

		if ($row) {
			Session::set('msg_success', 'El contacto ha cambiado de estado satisfactoriamente');
		}else{
			Session::set('msg_error', 'No se ha podido modificar el estado del contacto... Inténtelo nuevamente');
		}

		$this->redireccionar('contactos');
	}

	###################################################################################################
	private function verificarContactos($id){
		if (!$this->filtrarInt($id)) {
			$this->redireccionar('contactos');
		}

		if (!$this->_contacto->getContactoId($this->filtrarInt($id))) {
			$this->redireccionar('contactos');
		}
	}
}