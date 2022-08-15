<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');
// Route::group(['middleware' => 'auth:api'], function () {
//     Route::get("logout" , "UserController@logout");
//     });

Route::post('user-register',[UserController::class,'userRegitser']);
Route::post('login', [UserController::class,'login']);
//Route::get('user-list', [UserController::class,'user_list']);
Route::post('user-list',[UserController::class, 'user_List']);
Route::post('add-kameti', [UserController::class, 'kameti']);
Route::post('add-kameti-member',[UserController::class, 'kameti_member']);
Route::post('update-profile',[UserController::class, 'profile']);
Route::post('get-kameti-terms-and-condition',[UserController::class, 'kameti_terms_and_condition']);
Route::post('add-ekameti-type',[UserController::class, 'ekameti_type']);
Route::get('ekameti-type-list',[UserController::class, 'ekameti_type_list']);
Route::post('push-notification',[UserController::class, 'pushnotification']);
Route::post('admin-login',[UserController::class, 'adminLogin']);
Route::get('ekameti_member',[UserController::class, 'ekameti_member']);
Route::post('user-ekameti-list',[UserController::class, 'user_ekameti_list']);
Route::post('term_condition',[UserController::class,'term_condition']);
Route::post('update-password', [UserController::class,'Update_Password']);
Route::post('join-kameti', [UserController::class,'Join_Kameti']);
Route::post('ekameti-member-delete',[UserController::class, 'ekameti_member_delete']);
Route::post('update-kameti-status', [UserController::class,'Update_Kameti_Status']);
Route::post('searching-user', [UserController::class,'Searching_User']);
Route::post('admin-reference', [UserController::class,'Admin_Reference']);
Route::post('pending-kameti', [UserController::class,'Pending_Kameti']);
Route::post('drop-kameti', [UserController::class,'Drop_Kameti']);
Route::post('pending-kametis', [UserController::class,'Pending_Kametis']);
Route::post('delete-member', [UserController::class,'Delete_Member']);
Route::post('ekameti-detail', [UserController::class,'Ekameti_Detail']);
Route::post('update-mobile', [UserController::class,'Update_Mobile']);
Route::post('fetch-notification', [UserController::class,'Fetch_Notification']);
Route::post('delete-kameti', [UserController::class,'Delete_Kameti']);
Route::post('drop-kameti-list', [UserController::class,'Drop_Kameti_list']);