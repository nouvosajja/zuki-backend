<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AuthenticationController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Price;
use App\Models\User;
use App\Models\Inbox;
use App\Models\admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\NotifController;
use Illuminate\Support\Carbon;
use Midtrans\Snap;
use App\Http\Controllers\InboxController;


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
        
        $inbox = Inbox::create([
            'user_id' => $user->id,
            'subject' => 'Pesanan Anda telah berhasil dibuat',
            'message' => 'Terima kasih telah melakukan pemesanan. Kami akan segera memproses pesanan Anda.',
            'type' => 'order', // Anda dapat mengganti tipe pesan sesuai kebutuhan
            'redirect_id' => $order->id, // Anda dapat menggunakan ID pesanan sebagai referensi
            'tanggal_inbox' => $currentDate,
        ]);
        
        $adminUsers = User::where('role', 1)->pluck('device_token')->toArray();
        $adminTitle = 'Ada pesanan baru';
        $adminMessage = 'Ada pesanan baru yang perlu diproses.';
        $sendNotif = new NotifController();
        $sendNotif->sendNotification($adminUsers, $adminTitle, $adminMessage);
        

        
            // Mengirim notifikasi kepada pengguna (user)
        $device_token = User::where('role', 0)->pluck('device_token')->toArray();   
        $judulUser = 'Pesanan Dibuat';
        $pesanUser = 'Pesanan Anda telah berhasil dibuat.';
        $sendNotifUser = new NotifController();
        $sendNotifUser->sendNotification($device_token, $judulUser, $pesanUser);
        
        


        return response()->json([
            'success'   => True,
            'message'    => 'successfully created payment',
            'user_id' => $request->user_id,
            'price_id' => $request->price_id,
            'paket_id' => $request->paket_id,
            'berat' => $request->berat,
            'total_harga' => $request->total_harga,
        ]);
    }
    
    public function index()
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    public function show(Order $order)
    {
        
    }

    public function edit(Order $order)
    {
        
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required',
        ]);

        $model = Order::findOrFail($id);

        $model->update($validatedData);

        return response()->json(['message' => 'Model updated successfully', 'data' => $model]);
    }

    public function destroy(Order $order)
    {
        
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

    public function inputBerat(Request $request, $id) {
    
    $order = Order::find($id);
    
    $user = User::find($order->user_id);
    $currentDate = Carbon::now();
    $validatedData = $request->validate([
        'berat' => 'required|numeric',
        'total_harga' => 'required|numeric',
        
    ]);


    //Set your Merchant Server Key
    \Midtrans\Config::$serverKey = config('app.server_key');
    //Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    \Midtrans\Config::$isProduction = false;
    //Set sanitization on (default)
    \Midtrans\Config::$isSanitized = true;
    //Set 3DS transaction for credit card to true
    \Midtrans\Config::$is3ds = true;

    $discountAmount = 0;
    if ($validatedData['berat'] > 5) {
        $discountAmount = floor(($validatedData['berat'] - 5) / 5) * 10000;
    }

    $totalHargaSetelahDiskon = $validatedData['total_harga'] - $discountAmount;

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    }

    $order->berat = $validatedData['berat'];
    
    // Memeriksa apakah ada diskon yang diberikan
    if ($discountAmount > 0) {
        $order->total_harga = $totalHargaSetelahDiskon;
        $order->promo = 1; // Diskon diberikan
    } else {
        $order->total_harga = $validatedData['total_harga'];
        $order->promo = 0; // Tidak ada diskon
    }
    
    $order->status_pesanan = 'dikonfirmasi'; // Assuming you want to update the status as well
    $order->save();

    $params = array(
        'transaction_details' => array(
            'order_id' => $order->id,
            'gross_amount' => $order->total_harga, // Menggunakan total harga setelah diskon
        ),
        'customer_details' => array(
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->number,
        ),
    );
    
    $inboxInputBerat = Inbox::create([
        'user_id' => $user->id,
        'subject' => 'Pesanan anda telah selesai',
        'message' => 'Silahkan segera selesaikan pembayaran anda',
        'type' => 'order', // Sesuaikan dengan kebutuhan
        'redirect_id' => $order->id, // ID pesanan sebagai referensi
        'tanggal_inbox' => $currentDate, // Tanggal saat ini
    ]);

    // Generate the Snap Token setelah total harga diperbarui
    $snapToken = Snap::getSnapToken($params);
    
    // Mengupdate snap_token pada order setelah menghasilkan Snap Token
    $order->snap_token = $snapToken;
    $order->save();
    
    $judulUser = 'Pesanan anda telah selesai';
    $pesanUser = 'Silahkan segera selesaikan pembayaran anda';
    $sendNotifUser = new NotifController();
    $sendNotifUser->sendNotification([$user->device_token], $judulUser, $pesanUser); // Menggunakan device_token pengguna
    

    return response()->json(['success' => true, 'message' => 'Berat updated successfully', 'data' => $order, 'snap_token' => $snapToken]);
    }

    public function setOrderSelesai($id)
    {
    // Mencari pesanan berdasarkan ID
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    }

    // Mengubah status_pesanan menjadi "selesai"
    $order->status_pesanan = 'selesai';
    $order->save();

    // Anda juga dapat menambahkan notifikasi atau tindakan lain yang sesuai di sini

    return response()->json(['success' => true, 'message' => 'Order marked as selesai', 'data' => $order]);
    }


    public function listOrderByUser(Request $request){
        $userId = $request->user()->id; // Mengambil ID pengguna yang sedang masuk

    // Mengambil semua pesanan berdasarkan ID pengguna
    $orders = Order::where('user_id', $userId)->orderBy('created_at', 'desc') // Mengurutkan berdasarkan kolom created_at secara descending (terbaru ke terlama)
                   ->get();

    return response()->json([
        'success' => true,
        'message' => 'Daftar pesanan berdasarkan pengguna',
        'data' => $orders,
    ]);
    }
    
    public function userAll(Request $request){
        
        $id = $request->user_id;
        $user = User::where('user_id', $id);
        return response()->json($user);
    }

    public function midtransCallback(Request $request) 
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        if ($request->status_code == '200'){
                $order->update([
                'status' => 'paid'
            ]);
        }
        
        return response(['message' => 'Callback success']);
    }

     
     public function listOrderMenungguDikonfirmasi()
    {
    $orders = Order::where('user_id', $userId)
                  ->where('status_pesanan', 'menunggu_dikonfirmasi')
                  ->get();

    return response()->json([
        'success' => true,
        'message' => 'List pesanan belum dikonfirmasi',
        'data' => $orders,
    ]);
    }     

    
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
            ->select('orders.*', 'pakets.nama_pkt as nama_paket', 'users.name as name_user', 'users.address as address_user', 'prices.nama as name_prices', 'prices.harga as harga_price', 'prices.waktu as waktu_price', 'orders.created_at as createdAt_orders', 'orders.berat', 'orders.status_pesanan', 'orders.status')
            ->orderBy('orders.created_at', 'desc')
            ->distinct()
            ->get();
            
            // Loop through the transactions
    foreach ($transactions as $transaction) {
        // Contoh notifikasi untuk pengguna
        $userNotification = new NotifController();
        $userNotification->sendNotification(
            $transaction->user_id,
            'Pesanan Baru',
            'Pesanan baru dengan ID ' . $transaction->id . ' telah dibuat.'
        );

        // Contoh notifikasi untuk admin (role 1)
        $admins = User::where('role', 1)->get();
        foreach ($admins as $admin) {
            $adminNotification = new NotifController();
            $adminNotification->sendNotification(
                $admin->device_token, // Sesuaikan dengan cara Anda menyimpan device_token admin
                'Pesanan Baru',
                'Pesanan baru dengan ID ' . $transaction->id . ' telah dibuat oleh pengguna ' . $transaction->name_user . '.'
            );
    
        return response()->json([
            'transactions' => $transactions
        ]);
    }

}
}
}
