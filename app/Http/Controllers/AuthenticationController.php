<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
    {
        
    public function index(Request $request){
        
        $id = $request->user_id;
        $user = User::where('user_id', $id);
        return response()->json($user);
    }
    
    public function getUserAccount()
    {
    $user = Auth::user();

    if (!$user) {
        return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
    }

    return response()->json([
        'success' => true,
        'message' => 'User account details retrieved successfully',
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'number' => $user->number,
            // Add any other user attributes you want to include
        ],
    ]);
    }

    public function getAllUsers()
    {
    // Mengambil semua data pengguna dari tabel 'users'
    $users = User::all();

    return response()->json([
        'success' => true,
        'message' => 'All user accounts retrieved successfully',
        'users' => $users,
    ]);
    }


    public function register(Request $request){
        $register=[
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'number' => $request->number,
            'address' => $request->address,
            'device_token' => $request->device_token
        ];

        $user=User::create($register);
        $succes['token'] = $user->createToken('user')->plainTextToken;
        $succes['name'] = $user->name;
        return response()->json([
            'success' => true,
            'data' => $succes
        ]);


    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication was successful...
            $auth = Auth::user();
            $succes['token'] = $auth->createToken('user')->plainTextToken;
            $succes['name'] = $auth->name;

            return response()->json([
                'success' => true,
                'data' => $succes
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Login Failed'
            ]);
        }
    }

    public function show(Request $request)
    {
        $user = Auth::user();

    // Validasi data yang diterima dari request
    $request->validate([
        'name' => 'required|string',
        'password' => 'nullable|string|min:6', // Password bersifat opsional
        'number' => 'required|string',
        'address' => 'required|string',
    ]);

    // Update data pengguna berdasarkan data yang diterima dari request
    $user->update([
        'name' => $request->name,
        'password' => $request->password ? bcrypt($request->password) : $user->password,
        'number' => $request->number,
        'address' => $request->address,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'User data updated successfully',
        'user' => $user,
    ]);
    }

}
