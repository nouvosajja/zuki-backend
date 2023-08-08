<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function index(){
        

        $user = Auth::user();
        return response()->json($user);
    }

    public function register(Request $request){
        $register=[
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'number' => $request->number,
            'address' => $request->address
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
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required'
        // ]);
        
        // $user = User::where('email', $request->email)->first();
        
        // if(!$user || !Hash::check($request->email, $user->password)){
        //     return response([
        //         'email' => ['These credentials do not match our records.']
        //     ]);
        // }

        // return $user->createToken('my-token')->plainTextToken;

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

    // public function logout(Request $request){
    //     $request->user()->currentAccessToken()->delete();
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Logout Success'
    //     ]);
    // }
    public function show(Request $request)
    {
        $user = Auth::user();
        $update=[
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'number' => $request->number,
            'address' => $request->address
        ];

        $user->update($update);
        return response()->json($user);
    }

}
