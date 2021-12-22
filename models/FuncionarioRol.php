<?php
namespace models;

use Illuminate\Database\Eloquent\Model;

class FuncionarioRol extends Model
{
    protected $table = 'funcionario_rol';
    protected $fillable = ['funcionario_id','rol_id'];

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
}
