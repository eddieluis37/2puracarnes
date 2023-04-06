<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_identification extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function thirds()
    {
    	return $this->hasMany(Third::class);
    }


}
