<?php

class Request
{
	private $_modulo;
	private $_controlador;
	private $_metodo;
	private $_argumentos;
	private $_modules;

	public function __construct(){
		//si existe la url, sanitiza la url
		if(isset($_GET['url'])){
			$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
			$url = explode('/', $url); //divide la url separandola con "/"
			$url = array_filter($url); //elimina los elementos no validos de la url

			//1. obtener url modulo/controlador/metodo/argumentos
			//2. obtener url controlador/metodo/argumentos
			//el modulo de la aplicacion va dentro del array
			//$this->_modules = array('usuarios');
			$this->_modulo = strtolower(@array_shift($url));

			if(!$this->_modulo):
				$this->_modulo = false;
			else:
				if(@	count($this->_modules)):
					if(!in_array($this->_modulo, $this->_modules)):
						$this->_controlador = $this->_modulo;
						$this->_modulo = false;
					else:
						$this->_controlador = strtolower(@array_shift($url));

						if(!$this->_controlador):
							$this->controlador = 'index';
						endif;
					endif;
				else:
					$this->_controlador = $this->_modulo;
					$this->_modulo = false;
				endif;
			endif;

			$this->_metodo = strtolower(@array_shift($url)); //extrae el segundo elemento y lo asigna a metodo
			$this->_argumentos = $url; //lo que queda lo asigna a argumentos
		}


		if(!$this->_controlador){
			$this->_controlador = DEFAULT_CONTROLLER;
		}

		if(!$this->_metodo){
			$this->_metodo = 'index';
		}

		if(!isset($this->_argumentos)){
			$this->_argumentos = array();
		}
	}

	public function getModulo()
	{
		return $this->_modulo;
	}

	public function getControlador()
	{
		return $this->_controlador;
	}

	public function getMetodo()
	{
		return $this->_metodo;
	}

	public function getArgs()
	{
		return $this->_argumentos;
	}
}