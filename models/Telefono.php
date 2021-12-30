<?php
namespace models;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
   protected $table = 'telefonos';
   protected $fillable = ['numero','movil','telefonoable_id','telefonoable_type'];

   public function telefonoable()
   {
       return $this->morphTo();
   }
}
