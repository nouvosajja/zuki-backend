<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;


class priceController extends Controller
{

    public function index()
    {
        $price = Price::all();
        return response()->json($price);
    }
    public function filtered()
    {
        $price = Price::filter(request(['paket_id']))->get();

        return response()->json(
            [
                'filtered' => $price
            ]
        );
    }
}
