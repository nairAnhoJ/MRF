<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login');
    }

    public function authenticate(Request $request){
        $id_number = $request->id_number;
        $password = $request->password;

        if (auth()->attempt(['id_number' => $id_number, 'password' => $password])) {
            if (Auth::user()->first_time_login == 1) {
                return redirect()->route('change.password');
            } else {
                return redirect()->route('nchargable');
            }
        }

        return redirect()->back()->with('error', 'Invalid credentials. Please try again.')->withInput();
    }
}
