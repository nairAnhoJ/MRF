<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MrfController extends Controller
{
    public function rentalIndex(){

        $brands = DB::table('brands')->orderBy('name', 'asc')->get();

        return view('create-mrf/for-rental-unit', compact('brands'));
    }
}
