<?php

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

Route::post('users', function(Request $request) {
    $users = User::where('id', '!=', $request['user_id'])->get();
    return response()->json($users);
});

Route::get('users/{id}', function($id) {
    $user = User::find($id);
    return response()->json($user);
});

Route::get('users/{id}/chats', function ($id) {
    $user = User::find($id);
    $chats = $user->chats;

    // $chats =  [Chat1, Chat2];
    // $chat = Chat1

    foreach ($chats as $chat) {
        $chat['chats_with'] = $chat->chats_with($user->id);
    }

    return response()->json($chats);
});

Route::get('users/{id}/chats/{chatid}/messages', function ($id, $chatid) {
    $user = User::find($id);
    $chat = $user->chats()->where('chat_id', $chatid)->first();
    $messages = $chat->messages;
    return response()->json($messages);
});

Route::post('/messages', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'body' => 'required',
        'sender_id' => 'required',
        'recepient_id' => 'required',
        'chat_id' => 'required'
    ]);


    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    $message = ChatMessage::create($request->all());

    if ($message) {
       return response()->json(['status' => 'success']);
    } else {
        return response()->json(['error' => 'error']);
    }
});
