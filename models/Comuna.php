<?php
namespace models;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $table = 'comunas';
    protected $fillable = ['nombre', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
}
