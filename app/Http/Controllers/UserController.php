<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'id_number' => 'required',
            'name' => 'required',
            'site' => 'required',
            'role' => 'required'
        ]);

        $customMessages = [
            'id_number.required' => 'Please provide the required information.',
            'name.required' => 'Please provide the required information.',
            'site.required' => 'Please select an option from the list.',
            'role.required' => 'Please select an option from the list.'
        ];

        $validator->setCustomMessages($customMessages);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $area = Site::where('id', $request->site)->first()->area;

        $new_user = new User();
        $new_user->id_number = $request->id_number;
        $new_user->name = $request->name;
        $new_user->site = $request->site;
        $new_user->area = $area;
        $new_user->role = $request->role;
        $new_user->key = Str::uuid()->toString();
        $new_user->save();

        return redirect()->route('users.index')->with('success', 'User Has Been Added Successfully!');
    }

    public function edit(Request $request){
        $user = User::where('key', $request->key)->first();
        $sites = Site::where('is_deleted', 0)->get();

        return view('admin.system-management.users.edit', compact('sites', 'user'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id_number' => 'required',
            'name' => 'required',
            'site' => 'required',
            'role' => 'required'
        ]);

        $customMessages = [
            'id_number.required' => 'Please provide the required information.',
            'name.required' => 'Please provide the required information.',
            'site.required' => 'Please select an option from the list.',
            'role.required' => 'Please select an option from the list.'
        ];

        $validator->setCustomMessages($customMessages);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $area = Site::where('id', $request->site)->first()->area;

        $new_user = User::where('key', $request->key)->first();
        $new_user->id_number = $request->id_number;
        $new_user->name = $request->name;
        $new_user->site = $request->site;
        $new_user->area = $area;
        $new_user->role = $request->role;
        $new_user->save();

        return redirect()->route('users.index')->with('success', 'User Has Been Updated Successfully!');
    }

    public function delete(Request $request){
        User::where('key', $request->key)->delete();

        return redirect()->route('users.index')->with('success', 'User Has Been Deleted Successfully!');
    }

    public function reset(Request $request){
        $new_user = User::where('key', $request->key)->first();
        $new_user->first_time_login = 1;
        $new_user->password = Hash::make('password2023');
        $new_user->save();

        return redirect()->route('users.index')->with('success', 'The Password of this user has been reset successfully!');
    }
}
