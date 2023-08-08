<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class dashboardPelangganController extends Controller
{
    public function index(){
        return view('dashboard.pelanggan',["data_pelanggan" => Pelanggan::Paginate(5)]);
    }
    public function show(pelanggan $s){
        return view('pelanggan.detail',[
         "s" => $s
        ]);
     }
}
