<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    public function create(){
        return view('paket.create');
    }

    public function store(Request $request){
        $validateData = $request->validate([
            'nama_pkt'       => 'required',
        ]
        );

        Paket::create($validateData);
        return redirect('dashboard/paket/all')->with('success','Berhasil ditambah');
    }
}
