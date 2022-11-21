<?php

namespace App\Http\Controllers;

use Google\Service\Sheets;
use App\Http\Services\GoogleSheetsServices;
use Illuminate\Http\Request;

class GoogleSheetsController extends Controller
{
    public function sheetOperation(Request $request){

        (new GoogleSheetsServices())->writeSheet([
            [
                '3',
                'Update Test 3'
            ]
        ]);

        // (new GoogleSheetsServices())->appendSheet([
        //     [
        //         '3',
        //         'Test 3'
        //     ]
        // ]);

        $data = (new GoogleSheetsServices())->readSheet();

        return response()->json($data);
    }
}
