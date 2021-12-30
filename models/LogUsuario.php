<?php
namespace models;

use Illuminate\Database\Eloquent\Model;

class LogUsuario extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $table = 'log_usuarios';
    protected $fillable = ['id_usuario','nombre','rut','url'];


}
