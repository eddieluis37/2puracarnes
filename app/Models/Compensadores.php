<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensadores extends Model
{
    use HasFactory;

    protected $table = 'compensadores';
	protected $fillable = ['users_id','categoria_id','thirds_id', 'centrocosto_id','factura','fecha_compensado','fecha_cierre','status'];

   /*  public function compensadores_detail()
    {
        return $this->hasMany(Compensadores_detail::class);
    } */

 /*    public function details()
    {
        return $this->hasMany(Compensadores_detail::class);
    } */
}
