<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paket;

class dashboardPaketController extends Controller
{
    public function index(){
        return view('dashboard.paket',["data_paket" => Paket::Paginate(5)]);
    }
    public function show(Paket $s){
        return view('paket.detail',[
         "s" => $s
        ]);
     }
}
