<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApproverController extends Controller
{
    public function index(Request $request){
        if(Auth::user() && Auth::user()->role == 0){
            if($request->search == null){
                $search = '';
            }else{
                $search = $request->search;
            }

            $approvers = Approver::with('user')->paginate(25);

            return view('admin.system-management.approver.index', compact('approvers', 'search'));
        }else{
            return redirect('/');
        }
    }

    public function add(){
        // $conditions = ['Central', 'North', 'South', 'Visayas', 'Mindanao', 'On-Site'];

        return view('admin.system-management.approver.add');
    }
}
