<?php

class errorController extends Controller
{
	public function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->_view->assign('titulo', 'Error');
		$this->_view->assign('mensaje', $this->_getError());
		$this->_view->renderizar('index', 'error');
	}

	public function access($codigo)
	{
		$this->_view->assign('titulo', 'Error');
		$this->_view->assign('mensaje', $this->_getError($codigo));
		$this->_view->renderizar('access', 'error');
	}

	private function _getError($codigo = false)
	{
		if($codigo):
			$codigo = $this->filtrarInt($codigo);

			if(is_int($codigo)):
				$codigo = $codigo;
			endif;
		else:
			$codigo = 'default';
		endif;	

		$error['default'] = 'Ha ocurrido un error y la pagina no puede mostrarse';
		$error['5050'] = 'Acceso restringido';
		$error['8080'] = 'Tiempo de la sesion esta agotado';

		if(array_key_exists($codigo, $error)):
			return $error[$codigo];
		else:
			return $error['default'];
		endif;
	}

}