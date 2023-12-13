<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        if(Auth::user()){
            return redirect()->route('nchargeable');
        }else{
            return view('login');
        }
    }

    public function authenticate(Request $request){
        $id_number = $request->id_number;
        $password = $request->password;

        if (auth()->attempt(['id_number' => $id_number, 'password' => $password])) {
            if (Auth::user()->first_time_login == 1) {
                return redirect()->route('change.password');
            } else {
                return redirect()->route('nchargeable');
            }
        }

        return redirect()->back()->with('error', 'Invalid credentials. Please try again.')->withInput();
    }

    public function changePassword(){
        if (Auth::user()->first_time_login == 1) {
            return view('change-password');
        } else {
            return redirect()->route('nchargeable');
        }
    }
    
    public function updatePassword(Request $request){
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;

        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required',
        ]);

        if ($password === $password_confirmation) {
            $user = Auth::user();
            $user = User::where('id', Auth::user()->id)->first();
            $user->password = Hash::make($password);
            $user->first_time_login = 0;
            $user->save();

            return redirect()->route('nchargeable');
        } else {
            return redirect()->back()->with('error', 'Password does not match. Please try again.');
        }
    }
}
