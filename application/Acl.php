<?php

class Acl
{
	private $_db;
	private $_id;
	private $_role;
	private $_permisos;

	public function __construct($id = false){
		if($id):
			$this->_id = (int) $id;
		else:
			if(Session::get('id_usuario')):
				$this->_id = Session::get('id_usuario');
			else:
				$this->_id = 0;
			endif;
		endif;

		$this->_db = new Database();
		$this->_role = $this->getRole();
		$this->_permisos = $this->getPermisosRole();
		$this->compilarAcl();
	}

	public function compilarAcl()
	{
		$this->_permisos = array_merge(
			$this->_permisos,
			$this->getPermisosUsuario()
			);
	}

	public function getRole()
	{
		$role = $this->_db->query("select role from usuarios  where id = {$this->_id}");
		$role = $role->fetch();
		return $role['role'];
	}

	public function getPermisosRoleId()
	{
		$ids = $this->_db->query("select permiso from permisos_roles where roles = '{$this->_role}'");
		$ids = $ids->fetchall(PDO::FETCH_ASSOC);

		$id = array();
		
		for($i = 0;$i < count($ids);$i++):
			$id[] = $ids[$i]['permiso'];
		endfor;

		return $id;
	}

	public function getPermisosRole()
	{
		$permisos = $this->_db->query("select * from permisos_roles where roles = '{$this->_role}'");
		$permisos = $permisos->fetchall(PDO::FETCH_ASSOC);
		$data = array();

		for($i = 0;$i < count($permisos);$i++):
			$key = $this->getPermisoKey($permisos[$i]['permiso']);
			if($key == ''):
				continue;
			endif;

			if($permisos[$i]['valor']):
				$v = true;
			else:
				$v = false;
			endif;

			$data[$key] = array(
				'key' => $key,
				'permiso' => $this->getPermisoNombre($permisos[$i]['permiso']),
				'valor' => $v,
				'heredado' => false,
				'id' => $permisos[$i]['permiso']
				);
		endfor;

		return $data;
	}

	public function getPermisoKey($permisoId)
	{
		$permisoId = (int) $permisoId;
		$key = $this->_db->query("select llave from permisos where id = $permisoId");
		$key = $key->fetch();
		return $key['llave'];
	}

	public function getPermisoNombre($permisoId)
	{
		$permisoId = (int) $permisoId;
		$key = $this->_db->query("select permiso from permisos where id = $permisoId");
		$key = $key->fetch();
		return $key['permiso'];
	}

	public function getPermisosUsuario()
	{
		$ids = $this->getPermisosRoleId();
		if(count($ids)):
			$permisos = $this->_db->query("select * from permisos_usuarios where usuario = {$this->_id}
											and permiso in(" . implode(',', $ids). ")");
			$permisos = $permisos->fetchall(PDO::FETCH_ASSOC);
		else:
			$permisos = array();
		endif;

		$data = array();

		for($i = 0;$i < count($permisos);$i++):
			$key = $this->getPermisoKey($permisos[$i]['permiso']);
			if($key == ''):
				continue;
			endif;

			if($permisos[$i]['valor']):
				$v = true;
			else:
				$v = false;
			endif;

			$data[$key] = array(
				'key' => $key,
				'permiso' => $this->getPermisoNombre($permisos[$i]['permiso']),
				'valor' => $v,
				'heredado' => false,
				'id' => $permisos[$i]['permiso']
				);
		endfor;

		return $data;
	}

	public function getPermisos()
	{
		if(isset($this->_permisos) && count($this->_permisos)):
			return $this->_permisos;
		endif;
	}

	public function permiso($key)
	{
		if(array_key_exists($key, $this->_permisos)):
			if($this->_permisos[$key]['valor'] == true || $this->_permisos[$key]['valor'] == 1):
				return true;
			endif;

			return false;
		endif;
	}

	public function acceso($key)
	{
		if($this->permiso($key)):
			Session::tiempo();
			return;
		endif;

		header('Location: ' . BASE_URL . 'error/access/5050');
		exit;
	}
}