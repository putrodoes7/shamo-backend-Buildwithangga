<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function fetch(Request $request){
        return ResponseFormatter::success($request->user(), 'Data profil berhasil diambil');
    }

    /**
    * @param Request $request
    * @return \Illuminate\Http\JsonResponse
    * @throws \Exception
    * Fungsi login
    */
    public function register(Request $request){
        try{
            //validate
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required','string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required','string','max:255'],
                'password' => ['required', 'string', new password]
            ]);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User Registered');

        }catch(Exception $error){
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authtentication Failed', 500);
        }
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * Fungsi Login
     */
    public function login(Request $request){
        try{
            // validasi dari request
            $credentials = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            
            //cek Auth email dan password
            // $credentials = $request(['email', 'password']);
            if(!Auth::attempt($credentials)){
                return ResponseFormatter::error([
                    'message' => 'Unauthorizhed'
                ], 'Authtentication Failed', 500);
            }

            //cek dengan database
            $user = User::where('email', $request->email)->first();
            if(! Hash::check($request->password, $user->password,[])){
                throw new \Exception('Invalid Credentials');
            }

            //membuat auto token
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Auththenticated');

        }catch(Exception $error){
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authenticated Failed', 500);
        }

    }


    public function logout(Request $request){
        $user = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($user, 'Token revoked');
    }


    public function updateProfile(Request $request){
        $data = $request->all();
        $user = Auth::user();

        $user>update($data);

        ResponseFormatter::success($user, 'Profil updated');
    }
}
