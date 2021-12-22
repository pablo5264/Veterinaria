<?php

class ajaxModel extends Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getPaises()
	{
		$paises = $this->_db->query("select * from paises");
		return $paises->fetchall();
	}

	public function getCiudades($pais)
	{
		$ciudades = $this->_db->query("select * from ciudades where pais={$pais}");

		//arreglo con objeto Json
		$ciudades->setFetchMode(PDO::FETCH_ASSOC);
		return $ciudades->fetchall();
	}

	public function insertarCiudad($ciudad, $pais)
	{
		$this->_db->prepare("insert into ciudades values(null, :ciudad, :pais)")->execute(
			array(
				':ciudad' => $ciudad,
				':pais' => $pais));
	}
}