<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class plgnController extends Controller
{
    public function index()
    {
        $plgn = Pelanggan::all();
        return response()->json($plgn);
    }
}
