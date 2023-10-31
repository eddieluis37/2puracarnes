<?php

namespace App\Models;

use App\Models\Agreement;
use App\Models\Office;
use App\Models\Type_identification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Third extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type_identification_id', 'identification', 'digito_verificacion', 'office_id', 'agreement_id', 'type_regimen_iva_id', 'direccion', 'province_id', 'celular', 'nombre_contacto', 'status', 'correo', 'cliente', 'proveedor', 'vendedor', 'domiciliario', 'listaprecio_nichoid', 'listaprecio_genericid'];



	public function type_identification()
	{
		return $this->belongsTo(Type_identification::class);
	}


	public function office()
	{
		return $this->belongsTo(Office::class);
	}
	

	public function agreement()
	{
		return $this->belongsTo(Agreement::class);
	}


}
