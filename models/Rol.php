<?php
namespace models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $fillable = ['nombre'];

    public function funcionarios()
    {
        return $this->belongsToMany(Funcionario::class);
    }

    public function funcionarioRol()
    {
        return $this->hasMany(FuncionarioRol::class);
    }
}
