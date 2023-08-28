<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AutoCompleteController extends Controller
{
    
public function autoComplete(Request $request)
{
    $keyword = $request->input('keyword');
    
    $autocompleteResults = Redis::zrangebylex('autocomplete_keywords', '[' . $keyword, '[' . $keyword . '\xff');

    // 轉碼
    $decodedResults = array_map(function ($encodedString) {
        return json_decode('"' . $encodedString . '"', true);
    }, $autocompleteResults);

    return response()->json([
        'autocomplete' => $decodedResults,
    ]);
}


public function writeToAutocompleteSet(Request $request)
{
    $keyword = $request->input('keyword');
    $score = $request->input('score');

    try {
        // 將關鍵字和分數寫入 Redis Sorted Set
        Redis::zadd('autocomplete_keywords', [$keyword => $score]);
        
        // 返回成功信息
        return response()->json([
            'success' => true,
            'message' => 'Data written to Redis Sorted Set successfully.',
        ]);
    } catch (\Exception $e) {
        // 返回錯誤信息
        return response()->json([
            'success' => false,
            'message' => 'Error writing data to Redis: ' . $e->getMessage(),
        ]);
    }
}



// public function getAutocompleteKeywords()
// {
//     // 使用 zrange 方法查詢 Sorted Set 中的所有元素
//     $keywords = Redis::zrange('autocomplete_keywords', 0, -1);

//     return response()->json([
//         'keywords' => $keywords,
//     ]);
// }

// 關鍵字查詢相關案件
public function getAutocompleteKeywords(Request $request)
{
    $searchKeyword = $request['keyword'];

    // $decodedKeyword = urlencode($searchKeyword); ////不用編碼，laravel會自動處理
    // $keywords = Redis::zrangebylex('autocomplete_keywords', '[' . $decodedKeyword, '[' . $decodedKeyword . '\xff');

    // dd($searchKeyword);
    // dd($decodedKeyword);


    // $keywords = Redis::zrange('autocomplete_keywords', 0, -1); ////查詢所有案件

    // zrangebylex查詢包含關鍵字
    $keywords = Redis::zrangebylex('autocomplete_keywords', '[' . $searchKeyword, '[' . $searchKeyword . '\xff');

    // dd($request);
   
    return response()->json([
        'keywords' => $keywords,
    ]);
}







}
