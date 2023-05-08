<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class pktController extends Controller
{
    public function index()
    {
        $plgn = Paket::all();
        return response()->json($plgn);
    }
}
