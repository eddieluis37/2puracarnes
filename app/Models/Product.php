<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;


	protected $fillable = ['category_id', 'meatcut_id', 'level_product_id', 'unitofmeasure_id', 'name', 'code', 'barcode', 'status', 'cost', 'price_fama', 'price_insti', 'price_horeca', 'price_hogar', 'iva', 'otro_impuesto', 'stock', 'alerts', 'image'];

	protected $table = 'products';


	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function ventas()
	{
		return $this->hasMany(SaleDetail::class);
	}


	public function getImagenAttribute()
	{
		if ($this->image != null)
			return (file_exists('storage/products/' . $this->image) ? $this->image : 'noimg.jpg');
		else
			return 'noimg.jpg';
	}

	public function getPriceAttribute($value)
	{
		//comma por punto
		//return str_replace('.', ',', $value);
		// punto por coma
		return str_replace(',', '.', $value);
	}
	public function setPriceAttribute($value)
	{
		//$this->attributes['price'] = str_replace(',', '.', $value);
		$this->attributes['price_fama'] = str_replace(',', '.', preg_replace('/,/', '', $value, preg_match_all('/,/', $value) - 1));
	}


	public function centroCostos()
	{
		return $this->belongsToMany(CentroCosto::class, 'centro_costo_products', 'product_id', 'centro_costo_id')
			->withPivot('quantity');
	}

	public function centroCostoProductos()
	{
		return $this->belongsTo(Centro_costo_product::class);
	}

	public function notacredito_details()
	{
		return $this->belongsTo(NotacreditoDetail::class);
	}

	public function notadebito_details()
	{
		return $this->belongsTo(NotadebitoDetail::class);
	}

	public function compensadores_details()
    {
        return $this->hasMany(Compensadores_detail::class, 'products_id');
    }

	public function despostere()
    {
        return $this->hasOne(Despostere::class, 'products_id');
    }

	public function despostecerdo()
    {
        return $this->hasOne(Despostecerdo::class, 'products_id');
    }

	public function despostepollo()
    {
        return $this->hasOne(Despostepollo::class, 'products_id');
    }

	/* public function details()
    {
        return $this->hasMany(Compensadores_detail::class);
    } */
}
