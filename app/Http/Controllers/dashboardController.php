<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class dashboardController extends Controller
{
    public function index(){
        return view('dashboard.paket');
    }
}
