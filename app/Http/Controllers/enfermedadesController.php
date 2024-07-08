<?php

namespace App\Http\Controllers;

use App\Models\enfermedades;
use Illuminate\Http\Request;

class enfermedadesController extends Controller
{

    public function index()
    {
        $enfermedad = enfermedades::all();
        return view('enfermedad.index', ['diseases' => $enfermedad]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
        ]);

        enfermedades::create($validatedData);

        return response()->json($validatedData, 201);
    }

    public function edit($id)
    {
        $enfermedad = enfermedades::find($id);
        return response()->json($enfermedad);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
        ]);

        $enfermedad = enfermedades::find($id);
        $enfermedad->update($validatedData);

        return response()->json($enfermedad, 200);
    }
}