<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;





class CasesController extends Controller
{
    // 提案
    // public function insertCase(Request $request)
    // {
    //     $caseID = (int)$request['caseID'];
    //     $userID = (int)$request['userID'];
    //     $name = $request['name'];
    //     $category = $request['category'];
    //     $subCategory = $request['subCategory'];
    //     $budget = (int)$request['budget'];
    //     $deadline = $request['deadline'];
    //     $city = $request['city'];
    //     $subCity = $request['subCity'];
    //     $description = $request['description'];
    //     $contactName = $request['contactName'];
    //     $contactAble = (int)$request['contactAble'];
    //     $contactPhone = $request['contactPhone'];
    //     $contactTime = $request['contactTime'];
    //     $status = $request['status'];
    //     $Files = $request->file('allFiles');
    //     $allFileName = '';
    
    //     if ($Files !== null) {
    //         foreach ($Files as $file) {
    //             $fileName = $file->getClientOriginalName();
    //             $newFileName = time() . '_' . $fileName;
    //             $fileContents = file_get_contents($file);
                
    //             Storage::disk('s3')->put($newFileName, $fileContents, 'public');
                
    //             $fileUrl = Storage::disk('s3')->url($newFileName);
                
    //             $allFileUrls[] = $fileUrl;
    //         }
    //     }
    
    //     try {
    //         $results = DB::select("CALL addMyCase(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [
    //             $caseID, $userID, $name, $category, $subCategory, $budget, $deadline, $city, $subCity, 
    //             $description, $contactName, $contactAble, $contactPhone, $contactTime, $status, implode(',', $allFileUrls)
    //         ]);
            
    //         return $results;
    //     } catch (\Exception $e) {
    //         return response()->json(['result' => '插入案件失败']);
    //     }
    // public function insertCase(Request $request)
    // {

    //     $caseID = (int)$request['caseID'];
    //     $userID = (int)$request['userID'];
    //     $name = $request['name'];
    //     $category = $request['category'];
    //     $subCategory = $request['subCategory'];
    //     $budget = (int)$request['budget'];
    //     $deadline = $request['deadline'];
    //     $city = $request['city'];
    //     $subCity = $request['subCity'];
    //     $description = $request['description'];
    //     $contactName = $request['contactName'];
    //     $contactAble = (int)$request['contactAble'];
    //     $contactPhone = $request['contactPhone'];
    //     $contactTime = $request['contactTime'];
    //     $status = $request['status'];
    //     $Files = $request->file('allFiles');
    //     $allFileName = '';
    //     if($Files !== null){
    //          // 處理檔案附檔名及轉碼問題
    //         $allFileName = 'proposalFiles/'; // 初始設定標頭【proposalFiles/】，自定義的folder name
    //         $filesNameArray = []; // 存放所有的檔案包括檔名.副檔名
    //         for($i = 0; $i < count($Files); $i++){
    //             $fileName = $Files[$i]->getClientOriginalName(); // 檔案名稱
    //             $Files[$i]->storeAs('proposalFiles', $fileName); // 將要儲存在 storage 的哪個資料夾名稱
    //             $allFileName .= (string)$fileName . ",proposalFiles/"; // 將 加上逗號
    //             array_push($filesNameArray, $fileName); // 將 【$fileName】 push to 【$filesNameArray】
    //         }
    //         $allFileName = substr($allFileName, 0, -15) . ''; // 將最後的【,files/】移除並加上【"】
    //     }
    //     // 為了將其取出
    //     // $result = DB::select("CALL newPortfolio($userID, $allFileName)")[0]->result; // file name saved in DB
    //     // $filesName = DB::select("select portfolio from myresume where userID = $userID")[0]->portfolio; // get the file name from the DB
    //     try {
    //         $results = DB::select("CALL addMyCase(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$caseID,$userID, $name, $category, $subCategory, $budget, $deadline, $city,$subCity, $description, $contactName,$contactAble, $contactPhone, $contactTime, $status, $allFileName]);
    //         return $results;
    //     } catch (\Exception $e) {
    //         return response()->json(['result' => '插入案件失败']);
    //     }
    //     // CALL addMyCase(0,26,'組裝娃娃','B','B02','20000','2025/12/23','g','g09','幫忙組裝娃娃','娃娃女王',1,'0915758668','0110','刊登中','null','null','null','null','null');
    // }


//     public function insertCase(Request $request)
// {
//     $Files = $request->file('allFiles');
//     $allFileUrls = [];

//     if ($Files !== null) {
//         foreach ($Files as $file) {
//             $fileName = $file->getClientOriginalName();
//             $newFileName = time() . '_' . $fileName;
//             $fileContents = file_get_contents($file);

//             // 上傳到 S3 存儲桶
//             Storage::disk('s3')->put($newFileName, $fileContents, 'public');

//             // 取得上傳後的 URL
//             $fileUrl = Storage::disk('s3')->url($newFileName);

//             // 將 URL 加入陣列
//             $allFileUrls[] = $fileUrl;
    // 其他字段从请求中获取
//     $caseID = (int)$request['caseID'];
//     $userID = (int)$request['userID'];
//     $name = $request['name'];
//     $category = $request['category'];
//     $subCategory = $request['subCategory'];
//     $budget = (int)$request['budget'];
//     $deadline = $request['deadline'];
//     $city = $request['city'];
//     $subCity = $request['subCity'];
//     $description = $request['description'];
//     $contactName = $request['contactName'];
//     $contactAble = (int)$request['contactAble'];
//     $contactPhone = $request['contactPhone'];
//     $contactTime = $request['contactTime'];
//     $status = $request['status'];

//     try {
//         $results = DB::select("CALL addMyCase(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [
//             $caseID, $userID, $name, $category, $subCategory, $budget, $deadline, $city, $subCity,
//             $description, $contactName, $contactAble, $contactPhone, $contactTime, $status, implode(',', $allFileUrls),
//         ]);

//         return $results;
//     } catch (\Exception $e) {
//         return response()->json(['result' => '插入案件失败']);
//     }
// }
    public function insertCase(Request $request)
    {

        $caseID = (int)$request['caseID'];
        $userID = (int)$request['userID'];
        $name = $request['name'];
        $category = $request['category'];
        $subCategory = $request['subCategory'];
        $budget = (int)$request['budget'];
        $deadline = $request['deadline'];
        $city = $request['city'];
        $subCity = $request['subCity'];
        $description = $request['description'];
        $contactName = $request['contactName'];
        $contactAble = (int)$request['contactAble'];
        $contactPhone = $request['contactPhone'];
        $contactTime = $request['contactTime'];
        $status = $request['status'];
        $Files = $request->file('allFiles');
        $allFileName = '';
        // 其他字段从请求中获取
        $caseID = (int)$request['caseID'];
        $userID = (int)$request['userID'];
        $name = $request['name'];
        $category = $request['category'];
        $subCategory = $request['subCategory'];
        $budget = (int)$request['budget'];
        $deadline = $request['deadline'];
        $city = $request['city'];
        $subCity = $request['subCity'];
        $description = $request['description'];
        $contactName = $request['contactName'];
        $contactAble = (int)$request['contactAble'];
        $contactPhone = $request['contactPhone'];
        $contactTime = $request['contactTime'];
        $status = $request['status'];

        if($Files !== null){
             // 處理檔案附檔名及轉碼問題
            $allFileName = 'proposalFiles/'; // 初始設定標頭【proposalFiles/】，自定義的folder name
            $filesNameArray = []; // 存放所有的檔案包括檔名.副檔名
            for($i = 0; $i < count($Files); $i++){
                $fileName = $Files[$i]->getClientOriginalName(); // 檔案名稱
                $Files[$i]->storeAs('proposalFiles', $fileName); // 將要儲存在 storage 的哪個資料夾名稱
                $allFileName .= (string)$fileName . ",proposalFiles/"; // 將 加上逗號
                array_push($filesNameArray, $fileName); // 將 【$fileName】 push to 【$filesNameArray】
            }
            $allFileName = substr($allFileName, 0, -15) . ''; // 將最後的【,files/】移除並加上【"】
        }
        // 為了將其取出
        // $result = DB::select("CALL newPortfolio($userID, $allFileName)")[0]->result; // file name saved in DB
        // $filesName = DB::select("select portfolio from myresume where userID = $userID")[0]->portfolio; // get the file name from the DB
        try {
            $results = DB::select("CALL addMyCase(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$caseID,$userID, $name, $category, $subCategory, $budget, $deadline, $city,$subCity, $description, $contactName,$contactAble, $contactPhone, $contactTime, $status, $allFileName]);
            return $results;
        } catch (\Exception $e) {
            return response()->json(['result' => '插入案件失败']);
        }
        // CALL addMyCase(0,26,'組裝娃娃','B','B02','20000','2025/12/23','g','g09','幫忙組裝娃娃','娃娃女王',1,'0915758668','0110','刊登中','null','null','null','null','null');
    }




    // 獲取母、子類別
    public function getCategorys()
    {
        $results = DB::select('CALL caseListBigClass()');
        return response()->json($results);
    }
    public function getSubCategorys()
    {
        $results = DB::select('CALL caseClass()');
        return response()->json($results);
    }

    // 獲得母、子地區
    public function getCitys()
    {
        $results = DB::select('CALL caseListCity()');
        return $results;
    }
    public function getSubCitys()
    {
        $results = DB::select('CALL caseDistrict()');
        return $results;
    }


    // 搜尋並返回特定條件的案例
    public function getCases(Request $request)
    {
        $bigClassID = $request->input('bigClassID');
        $classID = $request->input('classID');
        $cityID = $request->input('cityID');
        $districtID = $request->input('districtID');
        $page = $request->input('page');
        $results = DB::select('CALL caseFilter(?,?,?,?,?)', [$bigClassID,$classID,$cityID,$districtID,$page]);
        // return $results;

        //* 假如圖片存在AWS S3
        // $filesName = [];
        // // 取出每個物件的 files 欄位資料
        // for($i = 0; $i < count($results); $i++) {
        //     array_push($filesName, $results[$i]->image);
        // };
        // // return $filesName;
        // // 將其字串變為陣列
        // for($i = 0; $i < count($filesName); $i++) {
        //     $filesName[$i] = explode(',', $filesName[$i]);
        // };


        //* 假如圖片存在 storage
        $filesName = [];
        // 取出每個物件的 files 欄位資料
        for($i = 0; $i < count($results); $i++) {
            array_push($filesName, $results[$i]->image);
        };
        // return $filesName;
        // 將其字串變為陣列
        for($i = 0; $i < count($filesName); $i++) {
            $filesName[$i] = explode(',', $filesName[$i]);
        };
        // 取得第一個的【jpg】||【jpeg】檔，否則為null
        $newFileArray=[];
        for($i = 0; $i < count($filesName); $i++) {
            // 假如一筆以上的資料，判斷有無【jpg】||【jpeg】檔
            if(count($filesName[$i]) > 1){
                for($j = 0; $j < count($filesName[$i]); $j++) {
                    //* 假如是AWS S3 就找https
                    if(substr( $filesName[$i][$j],0,5) === 'https') {
                        array_push($newFileArray,$filesName[$i][$j]);
                        break;
                    }
                    //* 假如是本地端 就找檢查jpg，jpeg
                    if(strpos($filesName[$i][$j],'jpg')  !== false|| strpos($filesName[$i][$j],'jpeg')  !== false ){
                        array_push($newFileArray,$filesName[$i][$j]);
                        break;
                    }
                }
                if(count($newFileArray) === 0){
                    array_push($newFileArray,null);
                }
            }

            // 只有一筆資料，判斷有無【jpg】||【jpeg】檔
            if(count($filesName[$i]) === 1){
                //* 假如是AWS S3 就找https
                if(substr( $filesName[$i][0],0,5) === 'https') {
                    array_push($newFileArray,$filesName[$i][0]);
                    continue;
                }
                if(strpos($filesName[$i][0],'jpg')  !== false|| strpos($filesName[$i][0],'jpeg')  !== false){
                    // array_push($newFileArray,true);
                    array_push($newFileArray,$filesName[$i][0]);
                }else{
                    array_push($newFileArray,null);
                }
            }
        };

        //* 本地圖片取得storage 路徑，AWS S3 則直接回傳
        for($i = 0; $i < count($newFileArray); $i++) {
            //* 假如是 S3
            if(substr( $newFileArray[$i],0,5) === 'https') {
                $results[$i]->image = $newFileArray[$i];
                continue;
            }
            //* 假如是 本地
            if($newFileArray[$i] === null ){
                // array_push($filesObject,  null);
                $results[$i]->image = null;
            }else{
                if(base64_encode(Storage::get($newFileArray[$i]))===''){
                    $file = null;
                }else{
                    $file = base64_encode(Storage::get($newFileArray[$i]));// 一串長得很奇怪的亂碼
                }
                // array_push($filesObject,  $file); // 原本是想另外修改再丟到前端
                $results[$i]->image = $file; // 直接修改 資料庫回傳的資料
            }
        }
        return $results;

    }

    // 取得當前被點擊案件資訊
    public function getCaseInfo(Request $request)
    {
        $caseID =  (int)$request['caseID'];
        $userID =  (int)$request['userID'];

        $results = DB::select('CALL enterCase(?,?)',[$caseID, $userID]);
        // return $results;
        //* 處理檔案編碼
        $results[0]->image = explode(',', $results[0]->image);

        for($i = 0; $i < count($results[0]->image); $i++){
            //* handle aws s3 file
            if(substr( $results[0]->image[$i],0,5) === 'https') {
                $results[0]->image[$i] = $results[0]->image[$i];
            }else{
             //* handle local storage file
                $results[0]->image[$i] = base64_encode(Storage::get($results[0]->image[$i]));
            }
        }
        //* 處理頭像編碼
        $results[0]->profilePhoto = base64_encode(Storage::get($results[0]->profilePhoto));
        return $results;
    }

    // 取得當前被點擊案件的類似案件
    public function getSimilarCase(Request $request)
    {
        $currentCaseId =  $request['currentCaseId'];
        $currentUserId =  $request['currentUserId'];
        // return $classID;
        $results = DB::select('CALL similarCase(?,?)',[$currentCaseId,$currentUserId]);
        return $results;
    }

    // 新增報價人員
    public function newBidder(Request $request)
    {
        $caseID =  (int)$request['caseID'];
        $userID =  (int)$request['userID'];
        $quotation =  (int)$request['quotation'];
        $win =  $request['win']; // 前端為甚麼要傳這個，還有tinyint 是甚麼型別
        $selfRecommended =  $request['selfRecommended'];
        $results = DB::select('CALL newBidder(?,?,?,?,?)',[$caseID,$userID,$quotation,$win,$selfRecommended]);
        return $results;
    }

    // 取得當前被點擊案件的報價人員
    public function getBidder(Request $request)
    {
        $caseID =  (int)$request['caseID'];
        $results = DB::select('CALL getBidder(?)',[$caseID]);
        return $results;
    }

    // 取得當前被點擊案件的報價人員
    public function addCollection(Request $request)
    {
        $caseID =  (int)$request['caseID'];
        $userID =  (int)$request['userID'];
        $results = DB::select('CALL createCollection(?,?)',[$userID,$caseID]);
        return $results;
    }

    // 進到我的收藏
    public function collectionList(Request $request)
    {
        // return '123';
        $page = $request['page'];
        // $pagehead = ($page - 1) * 30;
        $myuserID = $request['userID'];
        // 呼叫存儲過程執行 SQL 查詢
        $results = DB::select('CALL enterCollection(?, ?)', [$myuserID, $page]);
        //  // 在結果中加入完整的 S3 圖片網址
        // foreach ($results as &$result) {
        //     $result->image_url = $result->img; // 使用 img 欄位的值作為圖片網址
        // }
        // dd($results);

        return response()->json($results);
    }



    // 收藏案件icon
    public function createCollection(Request $request) {
        $myuserID = $request['userID'];
        $mycaseID = $request['caseID'];

        $results = DB::select('CALL createCollection(?, ?)', [$myuserID, $mycaseID]);

        return response()->json($results);
    }


    //儲存歷史紀錄
    public function storeSearch(Request $request)
{
    $keyword = $request->input('keyword');
    Redis::lpush('search_history', $keyword);

    return response()->json(['message' => 'Search keyword stored successfully']);
}




   
    





    public function getSearchHistory()
    {
        $searchHistory = Redis::zrange('search_history', 0, -1, 'WITHSCORES');


        $indexedSearchHistory = [];
        $count = count($searchHistory);
        for ($i = 0; $i < $count; $i += 2) {
            $indexedSearchHistory[$searchHistory[$i]] = $searchHistory[$i + 1];
        }
        arsort($indexedSearchHistory, SORT_NUMERIC);

        $searchResults = [];
        foreach ($indexedSearchHistory as $keyword => $timestamp) {
            $searchResults[] = [
                'keyword' => $keyword,
                'timestamp' => (int) $timestamp,
                'formatted_timestamp' => date('Y-m-d H:i:s', $timestamp),
            ];
        }


        return response()->json($searchResults);
    }





    public function searchCases(Request $request)
    {
        $keyword = $request['searchKeyword'];

        $allCasesBinary = Redis::smembers('cases');

        $filteredCases = [];

        foreach ($allCasesBinary as $caseBinary) {
            $caseUtf8 = mb_convert_encoding($caseBinary, 'UTF-8', 'binary');
            echo "Keyword: $keyword | Case: $caseUtf8\n"; 
            if (strpos($caseUtf8, $keyword) !== false) {

                $filteredCases[] = $caseUtf8;
            }
        }

        return response()->json([
            'filteredCases' => $filteredCases,
            'message' => "Search results for $keyword",
        ]);




    }

    public function autoComplete(Request $request)
    {
        $searchTerm = $request->query('newTerm');


        $caseNames = [
            '水管爆掉',
            '水電消防半技工',
            '電路維修',
            '搬家人員',
            '搬家清潔',
            '國中數學',
            '國中理化',
            '國二數學',
            '折紙鶴',
            '折蓮花',
            '國二數學',

        ];

        $suggestions = [];

        foreach ($caseNames as $caseName) {
            if (mb_substr($caseName, 0, mb_strlen($searchTerm)) === $searchTerm) {
                $suggestions[] = $caseName;
            }
        }

        return response()->json($suggestions);

    }
















}




//3  image: "proposalFiles/Logo.png"
//3  "proposalFiles/Logo.png"

//11  image: "proposalFiles/Jason履歷.pdf,proposalFiles/S__19955786.jpg"


// 10 "\"proposalFiles/S__19955786.jpg\""