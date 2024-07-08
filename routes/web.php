<?php

use App\Http\Controllers\enfermedadesController;
use App\Models\enfermedades;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
     $Enfermedades = enfermedades::all();
    return view('vistasEnfermedades/index', [
       'enfermedades' =>$Enfermedades

    ]);
});
use App\Http\Controllers\EnfermedadController;

Route::resource('enfermedades', enfermedadesController::class);
Route::post('enfermedades/create',[enfermedadesController::class,'store']);
Route::match(['post', 'patch'], 'enfermedades/{id}', [enfermedadesController::class, 'update']);

