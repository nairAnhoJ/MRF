<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller{
    public function index(Request $request){
        if(Auth::user() && Auth::user()->role == 0){
            if($request->search == null){
                $search = '';
            }else{
                $search = $request->search;
            }

            $users = User::with('siteDetails')->where('is_deleted', 0)->paginate(25);

            return view('admin.system-management.users.index', compact('users', 'search'));
        }else{
            return redirect('/');
        }
    }

    public function add(){
        $sites = Site::where('is_deleted', 0)->get();

        return view('admin.system-management.users.add', compact('sites'));
    }
}
