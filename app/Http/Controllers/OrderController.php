<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Price;

class OrderController extends Controller
{

    public function createOrder(Request $request, string $id)
    {
        
        $user = Auth::user();
        $price = $request->paket_id;
        $paket = Price::where('paket_id', $price)->find("id");

        $paket = Order::create([
            'user_id' => $user->id,
            'price_id' => $request->price_id,
            'status' => 'paid',
        
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('app.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

$params = array(
    'transaction_details' => array(
        'order_id' => $paket->id . uniqid(),
        'gross_amount' => $request->price
    ),
    'customer_details' => array(
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->number,
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
        $redirect_url = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken;

        return response()->json([
            'success'   => True,
            'message'    => 'successfully created payment',
            'data' => [
                'token' => $snapToken,
                'redirect_url' => $redirect_url,
            ],
        ]);

}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required',
        ]);

        $model = Order::findOrFail($id);

        $model->update($validatedData);

        return response()->json(['message' => 'Model updated successfully', 'data' => $model]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
