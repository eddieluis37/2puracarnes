<?php

namespace App\Models\faster;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faster_details extends Model
{
    use HasFactory;
    protected $table = 'faster_details';
	protected $fillable = ['fasters_id','products_id','meatcut_id','kgrequeridos','newstock','status'];
}