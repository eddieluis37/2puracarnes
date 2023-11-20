<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcentrocosto extends Model
{
    use HasFactory;

    protected $fillable = ['centrocosto_id','name','status'];
}
