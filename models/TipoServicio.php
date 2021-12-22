<?php
namespace models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = 'servicio_tipos';
    protected $fillable = ['id','nombre' ];

    public function tipoServicios()
    {
        return $this->belongsTo(TipoServicio::class);
    }

  
}
