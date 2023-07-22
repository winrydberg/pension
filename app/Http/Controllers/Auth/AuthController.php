<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage(){
        return view('auth.login');
    }

    /**
     * AUTHENTICATE AND LOGIN USER
     */
    public function authenticateUser(Request $request){
        try{
            $credentials = $request->only('email', 'password');

            $user = User::where('email', $request->email)->first();

            if($user && ($user->is_active ==false || $user->is_active ==null)){
                return response()->json([
                    'status' => 'error',
                    'message' => 'User account has been deactivated. Contact administrators for help'
                ]);
            }
            
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return response()->json([
                    'status' => 'success',
                    'url' => url('/dashboard'),
                    'message' => 'Login successful. Redirecting to dashboard'
                ]);
            } else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid Login Credentials'
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to login. Contact Administrators'
            ]);
        }
    }


    public function logoutUser(){
        Auth::logout();
        return redirect()->to('/');
    }
}
