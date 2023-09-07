<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Price;
use App\Models\User;
use App\Models\admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NotifController;
use Illuminate\Support\Carbon;
use Midtrans\Snap;


class OrderController extends Controller
{

    public function createOrder(Request $request)
    {
        $user = Auth::user();
        $price = $request->paket_id;
        $paket = Price::where('paket_id', $price)->first();
        $currentDate = Carbon::now();


        $order = Order::create([
            'user_id' => $request->user_id,
            'price_id' => $request->price_id,
            'paket_id' => $request->paket_id,
            'tanggal_pesanan' => $currentDate,
            'status' => 'unpaid',
        
        ]);

        // Set your Merchant Server Key
        //\Midtrans\Config::$serverKey = config('app.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        //\Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        //\Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        //\Midtrans\Config::$is3ds = true;

        // $params = array(
        //     'transaction_details' => array(
        //         'order_id' => $paket->id . uniqid(),
        //         'gross_amount' => $paket->harga,
        //     ),
        //     'customer_details' => array(
        //         'name' => $user->name,
        //         'email' => $user->email,
        //         'phone' => $user->number,
        //     ),
        // );

        // $snapToken = \Midtrans\Snap::getSnapToken($params);
        // $redirect_url = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken;

        $userAdmin = User::whereNotNull('device_token')
            ->where('role', '1')
            ->pluck('device_token')
            ->all();

        // notification untuk admin ada pesanan baru
         $judul = 'Ada pesanan baru';
         $pesan = 'Haloo wirr, pesanan baru menunggu diproses';
         
        $sendNotif = new NotifController();
        $sendNotif->sendNotification($userAdmin, $judul, $pesan);

        return response()->json([
            'success'   => True,
            'message'    => 'successfully created payment',
            'user_id' => $request->user_id,
            'price_id' => $request->price_id,
            'paket_id' => $request->paket_id,
            'berat' => $request->berat,
            'total_harga' => $request->total_harga,
            //'data' => [
               //'token' => $snapToken,
                //'redirect_url' => $redirect_url,
            //],
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

    public function notifPesananSelesai($id) {
        $order = Order::where('id', $id)->first();
        $user_id = $order->user_id;

        $device_token = User::where('id', $user_id)->select('device_token')->get();

        // notification untuk user selesai pesanan
        $judul = 'Pesanan selesai';
        $pesan = 'Pesananmu sudah selesai dan menunggu pembayaran';
        $sendNotif = new NotifController();
        $sendNotif->sendNotification($device_token, $judul, $pesan);

        return response()->json([
            'success'   => true,
            'message'    => 'successfully send notification',
        ]);
    }

    public function listOrder() {
        $order = Order::where('status_pesanan', 'menunggu_konfirmasi')->get();

        return response()->json([
            'success'   => true,
            'message'    => 'successfully get list order',
            'data' => $order,
        ]);
    }

    public function confirmOrder(Request $request, $id) {
        // $orderId = $request->order_id;
        // $order = Order::find($orderId);
    
        // if (!$orderId) {
        //     return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        // }
    
        // // $order->status_pesanan = 'dikonfirmasi';
        // $order->update([
        //     'status_pesanan' => 'dikonfirmasi',
        //     'berat' => $request->berat   

        // ]);

    
        // return response()->json(['success' => true, 'message' => 'Order confirmed successfully']);

        DB::table('orders')
        ->where('id', $id)
        ->update([
            'berat'            => $request->berat,  
            'status_pesanan'       => 'dikonfirmasi'
        ]);

        //You can return a response or redirect as needed
        return response()->json(['message' => 'Data confirmed successfully', 
    ]);
    }

    public function finishOrder(Request $request) {
        $order_Id = $request->order_id;
        $price_Id = $request->price_id;
        $order = Order::find($order_Id);
    
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
    
        // $order->status_pesanan = 'selesai';
        $order->update([
            'status_pesanan' => 'Selesai',
            'price_id' => $price_Id,
        ]);

        // notification untuk user pesanan selesai
        $judul = 'Pesanan selesai';
        $pesan = 'Haloo wirr, Pesanan kamu telah selesai';
        NotifController::sendNotification($order->user_id, $judul, $pesan);

    
        return response()->json(['success' => true, 'message' => 'Order finish successfully']);
    }

    // public function inputBerat(){
    //     $order = Order::where('status_pesanan', 'dikonfirmasi')->get();

    //     return response()->json([
    //         'success'   => true,
    //         'message'    => 'successfully get list order',
    //         'data' => $order,
    //     ]);
    // }

    public function inputBerat(Request $request, $id) {

        $users = Auth::user();
        $validatedData = $request->validate([
            'berat' => 'required|numeric',
            'total_harga' => 'required|numeric',
        ]);

        $order = Order::find($id);

        //Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('app.server_key');
        //Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        //Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        //Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->id,
                'gross_amount' => $validatedData['total_harga'],
            ),
            'customer_details' => array(
                'name' => $users->name,
                'email' => $users->email,
                'phone' => $users->number,
            ),
        );

         // Generate the Snap Token
        $snapToken = Snap::getSnapToken($params);
        $redirect_url = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken;
    
        // $order->update([
        // 'snap_token' => $snapToken,
        // ]);
    
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
    
        $order->berat = $validatedData['berat'];
        $order->total_harga = $validatedData['total_harga'];
        $order->status_pesanan = 'dikonfirmasi'; // Assuming you want to update the status as well
        $order->snap_token = $snapToken;
        $order->save();
    
        return response()->json(['success' => true, 'message' => 'Berat updated successfully', 'data' => $order, 'snap_token'=>$snapToken,]);
    }

    public function listOrderByUser(){
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('status_pesanan', 'dikonfirmasi')->get();

        

        return response()->json([
            'success'   => true,
            'message'    => 'successfully get list order',
            'data' => $order,
            // 'data' => [
            //    'token' => $snapToken,
            //     'redirect_url' => $redirect_url,
            // ],
        ]);
    }

    
//     public function midtransCallback(Request $request){

//     $orderId = $request->input('order_id');
//     // $transactionStatus = $request->input('status');

//     $order = Order::find($orderId);

//     if (!$order) {
//         return response()->json(['success' => false, 'message' => 'Order not found'], 404);
//     }

//     if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
//         // Payment is successful
//         $order->update([
//             'status' => 'paid', 
//         ]);

//     return response()->json(['success' => true, 'message' => 'Callback processed successfully']);
    
//     }
// }

    // public function midtransCallback(Request $request)
    // {
    //     $orderId = $request->input('order_id');
    //     $transactionStatus = $request->input('status');
    //     $order = Order::find($orderId);

    //     if (!$order) {
    //         return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    //     }

    //     if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
    //         // Payment is successful
    //         $order->update([
    //             'status' => 'paid', 
    //         ]);

    //         return response()->json(['success' => true, 'message' => 'Callback processed successfully']);
    //     }
    // }

    public function midtransCallback(Request $request) 
    // {
    //     // Parse the incoming callback data
    //     $data = $request->all();
    
    //     // Verify the signature
    //     $signatureKey = config('app.server_key');
    //     $orderId = $data['id'];
    //     $statusCode = $data['status'];
    //     $grossAmount = $data['total_harga'];
    //     $signature = $data['snap_token'];
    
    //     $stringToDigest = $orderId . $statusCode . $grossAmount . $signatureKey;
    //     $generatedSignature = hash('sha512', $stringToDigest);
    
    //     if ($generatedSignature !== $signature) {
    //         return response()->json(['success' => false, 'message' => 'Invalid signature'], 400);
    //     }
    
    //     // Find the order based on the received order_id
    //     $order = Order::find($orderId);
    
    //     if (!$order) {
    //         return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    //     }
    
    //     // Update order status based on the callback status
    //     if ($statusCode == 'unpaid') {
    //         // Payment success
    //         $order->status_pesanan = 'paid';
    //         // You might want to perform other actions here, like sending notifications, updating stock, etc.
    //     } else {
    //         // Payment failure or other status
    //         $order->status_pesanan = 'unpaid';
    //     }
    
    //     $order->save();
    
    //     return response()->json(['success' => true, 'message' => 'Callback processed successfully']);
    // }
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if($hashed !== $request->signature_key) {
            return response(['message' => 'Invalid Signature'], 403);
        }

        $order = Order::find($request->order_id)->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        if($request->transaction_status == 'settlement'){
            $order->update([
                'status' => 'paid'
            ]);
        }

        
        return response(['message' => 'Callback success']);
    }
    //     if ($hashed == $request->signature_key) {
    //         if ($request->transaction_status == 'capture' or $request->transaction_status == 'settlement' ) {
    //             $order = Order::find($request->order_id);
    //             $order->update(['status' => 'paid']);
    //         }
    //     }
    // }
          

    
    public function listOrderSelesai(){
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->where('status_pesanan', 'selesai')->get();

        return response()->json([
            'success'   => true,
            'message'    => 'successfully get list order',
            'data' => $order,
        ]);
    }

    public function filtered() {
        $transactions = DB::table('orders')
            ->join('prices', 'orders.price_id', '=', 'prices.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('pakets', 'orders.paket_id', '=', 'pakets.id')
            ->select('orders.*', 'pakets.nama_pkt as nama_paket', 'users.name as name_user', 'prices.nama as name_prices', 'prices.harga as harga_price', 'prices.waktu as waktu_price', 'orders.created_at as createdAt_orders', 'orders.berat', 'orders.status_pesanan', 'orders.status')
            ->orderBy('orders.id', 'desc')
            ->distinct()
            ->get();
    
        return response()->json([
            'transactions' => $transactions
        ]);
    }

}
