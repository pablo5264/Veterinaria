<?php
namespace models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['rut', 'nombre', 'email', 'direccion', 'comuna_id'];

    public function comuna()
    {
        return $this->belongsTo(Comuna::class);
    }
}