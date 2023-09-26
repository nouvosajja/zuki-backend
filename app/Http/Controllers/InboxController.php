<?php

namespace App\Http\Controllers;

use App\Helpers\AppFunction;
use App\Helpers\HttpStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\Inbox\InboxResource;
use App\Models\Inbox;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InboxController extends Controller
{
    public function inboxView(Request $request) {
        // Misalnya, Anda ingin mengambil pesan berdasarkan user ID
        $userId = $request->user()->id;

        // Query untuk mengambil pesan dari tabel inbox berdasarkan user ID
        $inboxMessages = Inbox::where('user_id', $userId)->get();
        
        if ($inboxMessages->isEmpty()) {
        return response()->json([
            'success' => true,
            'message' => 'Inbox Anda kosong. Tidak ada pesan dalam inbox.',
            'data' => [],
        ]);
    }
        
        return response()->json([
            'success' => true,
            'message' => 'Daftar pesan di inbox berhasil diambil.',
            'data' => $inboxMessages,
        ]);
    }
    


public function changePassword(Request $request)
{
    $user = Auth::user();

    // Validasi data yang diterima dari request
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:6',
    ]);

    // Memeriksa apakah kata sandi saat ini cocok
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Current password is incorrect.',
        ]);
    }

    // Mengubah kata sandi pengguna
    $user->update([
        'password' => bcrypt($request->new_password),
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Password updated successfully.',
    ]);
}

    
    public function read(int $id) {
        $pelanggan = auth()->user();
        $inbox = $pelanggan->inbox->find($id);

        if (is_null($inbox)) {
            return HttpStatus::code404('Data not found');
        }
    
        $inbox->read = AppFunction::booleanRequest(true);
        $inbox->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Read inbox',
            'data' => new InboxResource($inbox),
        ]);
    }

    public function create(Request $request) {
        $pelanggan = Pelanggan::find(auth()->user()->id);

        if (is_null($worker)) {
            return HttpStatus::code404("Data not found");
        }
        
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);

        $inbox = new Inbox();
        $inbox->subject = $request->subject;
        $inbox->message = $request->message;
        $worker->inbox()->save($inbox);

        return response()->json([
            'success' => true,
            'message' => 'Inbox sent successfully',
            'data' => [],
        ], 201);
    }

    public function deleteAll() {
        $pelanggan = auth()->user();
        $pelanggan->inbox->each->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Successfully deleted all data',
            'data' => [],
        ]);
    }
    
    public function deleteById(int $id) {
        $pelanggan = auth()->user();
        $inbox = $pelanggan->inbox->find($id);

        if (is_null($inbox)) {
            return HttpStatus::code404('Data not found');
        } else {
            $inbox->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted data',
                'data' => [],
            ]);
        }
    }
}