<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\api\MsgController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\NoteController;
use App\Http\Controllers\api\ChatController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('cors')->prefix('users')->group(function ()
{
    Route::any('/update', [UserController::class,'update_user']);
});
Route::middleware('cors')->prefix('message')->group(function ()
{
    //
    Route::any('/list', [MsgController::class,'get_list']);
    Route::any('/view/{id?}', [MsgController::class,'view']);
    Route::post('/send', [MsgController::class,'SendMessage']);
    Route::post('/notification', [MsgController::class,'Notification']);
    Route::post('/get_msg', [MsgController::class,'get_view_message']);
    Route::post('/get_user', [MsgController::class,'get_user']);
    Route::post('/change_user', [MsgController::class,'change_user']);
    Route::post('/msg_count', [MsgController::class,'count_list_of_msg']);


    // Route::post('/thread', 'api\MessageController@message_thread');
    // Route::post('/send', 'api\MessageController@send');
    // Route::post('/add_contect', 'api\MessageController@add_contect');
    // Route::post('/delete', 'api\MessageController@delete');

});


Route::prefix('chat')->group(function (){
    Route::post('/get_msg_count', [ChatController::class,'get_msg_count']);
    Route::post('/getmsg', [ChatController::class,'get_msg']);
    Route::post('/update', [ChatController::class,'update']);
    Route::get('/newmsg/{assign_user?}',[ChatController::class,'newmessage']);
});

Route::middleware('cors')->prefix('notes')->group(function (){
    Route::post('/add', [NoteController::class,'add']);
   Route::post('/list', [NoteController::class,'list']);
});