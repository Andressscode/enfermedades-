<?php

namespace App\Models\Models;

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
    public function index()
    {
        $enfermedad = enfermedades::all();
        return view('enfermedad.index', ['diseases' => $enfermedad]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        enfermedades::create($data);

        return redirect('/diseases')->with('success', 'Disease created successfully!');
    }
}
