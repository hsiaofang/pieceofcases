<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SchemeController extends Controller
{

    // 傳入排程狀態 => 【SchemeProgress】
    public function newCaseStep(Request $request)
    {
        // return '123';
        $schemeJson = $request['schemeJson'];
        // return $schemeJson;
        $results = DB::select('CALL newCaseStep(?)', [$schemeJson]);
        return $results;
    }
}