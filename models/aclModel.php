<?php

class aclModel extends Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getRole($roleId)
	{
		$role = $this->_db->query("select * from roles where id = $roleId");
		return $role->fetch();
	}

	public function getRoles()
	{
		$role = $this->_db->query("select * from roles");
		return $role->fetchall();
	}

	public function getPermisosAll()
	{
		$permisos = $this->_db->query("select * from permisos");
		$permisos = $permisos->fetchall(PDO::FETCH_ASSOC);

		for($i = 0;$i <count($permisos);$i++):
			if($permisos[$i]['llave'] == ''):
				continue;
			endif;

			$data[$permisos[$i]['llave']] = array(
				'key' => $permisos[$i]['llave'],
				'valor' => 'x',
				'nombre' => $permisos[$i]['permiso'],
				'id' => $permisos[$i]['id']
				);
		endfor;

		return $data;
	}

	public function getPermisosRole($roleId)
	{
		$data = array();

		$permisos = $this->_db->query("select * from permisos_roles where roles = $roleId");
		$permisos = $permisos->fetchall(PDO::FETCH_ASSOC);

		for($i = 0;$i <count($permisos);$i++):
			$key = $this->getPermisoKey($permisos[$i]['permiso']);

			if($key == ''):
				continue;
			endif;

			if($permisos[$i]['valor'] == 1):
				$v = 1;
			else:
				$v = 0;
			endif;

			$data[$key] = array(
				'key' => $key,
				'valor' => $v,
				'nombre' => $this->getPermisoNombre($permisos[$i]['permiso']),
				'id' => $permisos[$i]['permiso']
				);
		endfor;

		$data = array_merge($this->getPermisosAll(), $data);
		return $data;
	}

	public function eliminarPermisoRole($roleId, $permisoId)
	{
		$this->_db->query("delete from permisos_roles where roles = $roleId and permiso = $permisoId");
	}

	public function editarPermisoRole($roleId, $permisoId, $valor)
	{
		$this->_db->query("update permisos_roles set roles = $roleId, permiso = $permisoId, valor = '$valor'");
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
}