<?php

namespace App\Http\Controllers;

use App\Model\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getUserMessages(Request $request, $userId) {
        $messages = Message::where('recipient_id',$userId)->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request, $senderId, $recipientId) {

        $message = new Message();

        $message->fill(['sender_id' => $senderId, 'recipient_id' => $recipientId, 'message' => $request->input('message')]);

        $message->save();

        return response()->json([]);
    }
}