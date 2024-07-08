<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class enfermedades extends Model
{
    use HasFactory;
    protected $table = "enfermedades";
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
   
}


