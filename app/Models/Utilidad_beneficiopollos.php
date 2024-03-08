<?php

namespace App\Models;
use App\Models\Beneficiopollo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilidad_beneficiopollos extends Model
{
    public function beneficiopollos()
    {
        return $this->belongsTo(Beneficiopollo::class);
    }
}
