<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compensadore extends Model
{
    use HasFactory;


    public function third()
    {
    	return $this->belongsTo(Third::class);
    }
    
}
