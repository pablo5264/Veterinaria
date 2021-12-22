<?php

class RegionModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRegiones()
    {
        $reg = $this->_db->query("SELECT id, nombre FROM regiones ORDER BY nombre");

        return $reg->fetchall();
    }

    public function getRegionId($id)
    {
        $reg = $this->_db->prepare("SELECT id, nombre FROM regiones WHERE id = ?");
        $reg->bindParam(1, $id);
        $reg->execute();

        return $reg->fetch();
    }

    public function getRegionNombre($nombre)
    {
        $reg = $this->_db->prepare("SELECT id FROM regiones WHERE nombre = ?");
        $reg->bindParam(1, $nombre);
        $reg->execute();

        return $reg->fetch();
    }

    public function addRegion($nombre)
    {
        $reg = $this->_db->prepare("INSERT INTO regiones(nombre) VALUES(?)");
        $reg->bindParam(1, $nombre);
        $reg->execute();

        $row = $reg->rowCount();

        return $row;
    }

    public function editRegion($id, $nombre)
    {
        $reg = $this->_db->prepare("UPDATE regiones SET nombre = ? WHERE id = ?");
        $reg->bindParam(1, $nombre);
        $reg->bindParam(2, $id);
        $reg->execute();

        $row = $reg->rowCount();

        return $row;
    }
}
