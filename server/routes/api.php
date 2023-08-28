<?php
// 引入所有 Controller
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;




// 身分驗證和使用者相關
Route::post('/auth/signup', [UserController::class, 'signup']);
Route::post('/auth/login', [UserController::class, 'login']);
Route::post('/auth/logout', [UserController::class, 'logout']);
//比對token
Route::post('checktoken',[UserController::class, 'checkToken']);


// 個人資訊相關
Route::group(['prefix' => 'users'], function () {
    Route::post('/{myUserName}/{myUserID}', [InformationController::class, 'updateUser']); 
    Route::post('/update-phone', [InformationController::class, 'updatePhone']); 
    Route::post('/update-email/{myuserID}/{myemail}', [InformationController::class, 'updateEmail']);
    Route::post('/update-portfolio/{myuserID}/{myportfolio}', [InformationController::class, 'updatePortfolio']);
    Route::post('/update-education', [InformationController::class, 'updateExperience']);
});


// 頭像相關
Route::post('/users/upload-photo', [InformationController::class, 'uploadPhoto']);
Route::get('/users/show-photo/{userID}', [InformationController::class, 'showPhoto']);
Route::put('/users/update-photo/{userID}', [InformationController::class, 'updatePhoto']);

// 收藏相關
Route::post('/users/enterFavorite', [CasesController::class, 'collectionList']);
Route::post('/users/collectionState', [CasesController::class, 'createCollection']);


// 案件相關
Route::group(['prefix' => 'cases'], function () {
    Route::post('/add', [CasesController::class, 'insertCase']);
    Route::get('/', [CasesController::class, 'getCases']);
    Route::get('/citys', [CasesController::class, 'getCitys']);
    Route::get('/sub-citys', [CasesController::class, 'getSubCitys']);
    Route::get('/categorys', [CasesController::class, 'getCategorys']);
    Route::get('/sub-categorys', [CasesController::class, 'getSubCategorys']);
    Route::get('/{caseID}', [CasesController::class, 'getCaseInfo']);
    Route::post('/{caseID}/bidders', [CasesController::class, 'newBidder']);
    Route::post('/addCollection', [CasesController::class, 'addCollection']);
    // ... 其他案件相關的路由
});

// 聊天相關
Route::group(['prefix' => 'chat'], function () {
    Route::get('/messages', [ChatController::class, 'getMessage']);
    Route::get('/other-users', [ChatController::class, 'getChatOtherUser']);
    Route::post('/send-message', [ChatController::class, 'sendMessage']);
});

// 排程相關
Route::post('/scheme/new-case-step', [SchemeController::class, 'newCaseStep']);

// 支付相關
Route::post('/payment/pay', [PaymentController::class, 'checkout']);
Route::post('/payment/collaboration', [PaymentController::class, 'collaboration']);
Route::post('/payment/callback', [PaymentController::class, 'callback']);

// 後台管理
Route::group(['prefix' => 'backstage'], function () {
    Route::get('/all-users', [BackstageController::class, 'rootCheckUser']);
    Route::get('/all-cases', [BackstageController::class, 'rootCheckCase']);
});



Route::get('/autocomplete', [CasesController::class, 'autoComplete']);
Route::post('/write-to-autocomplete-set', [AutoCompleteController::class, 'writeToAutocompleteSet']);
Route::post('/get-autocomplete-keywords', [AutoCompleteController::class, 'getAutocompleteKeywords']);
Route::get('/suggest-keywords', [AutoCompleteController::class, 'suggestKeywords']);
Route::get('/search-history', [CasesController::class, 'getSearchHistory']);
Route::get('/search', [CasesController::class, 'search']);

