<?php

namespace App\Models\alistamiento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transfer_details extends Model
{
    use HasFactory;
    protected $table = 'transfer_details';
	protected $fillable = ['transfers_id','products_id','meatcut_id','kgrequeridos','newstock','status'];
}
