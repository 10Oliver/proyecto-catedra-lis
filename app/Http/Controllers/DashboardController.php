<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cupon;

class DashboardController extends Controller
{
   public function index()
{
    $cupones = \App\Models\Cupon::latest()->take(5)->get();

    // Forzar que el archivo correcto se está cargando
    return view('dashboard', compact('cupones'))->with('debug', 'DashboardController index cargado');
}

}
