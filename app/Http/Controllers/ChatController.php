<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageEvent;

class ChatController extends Controller
{
    public function messages(User $user, Request $request)
{
    // Optional: restrict chat only between different user_types
    if (auth()->user()->user_type == $user->user_type) {
        return response()->json(['error' => 'Chat not allowed with same user type'], 403);
    }
    $order = $request->order_id;
    //dd($order);
    $messages = Message::where(function ($query) use ($user) {
        $query->where('sender_id', auth()->id())
              ->where('receiver_id', $user->id);
    })->orWhere(function ($query) use ($user) {
        $query->where('sender_id', $user->id)
              ->where('receiver_id', auth()->id());
    })->orderBy('created_at')->get();

    $unseenMessages = $messages->where('receiver_id', $user->id)->where('is_read', false);
    foreach ($unseenMessages as $msg) {
        $msg->is_read = true;
        $msg->save();

        // Fire broadcast to sender so they see "✔ Seen"
        broadcast(new MessageEvent($msg));
    }

    return response()->json($messages);
}

public function send(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'message' => 'required|string|max:1000',
    ]);

    $receiver = User::find($request->receiver_id);

    if (auth()->user()->user_type == $receiver->user_type) {
        return response()->json(['error' => 'Chat not allowed with same user type'], 403);
    }

    $message = Message::create([
        'sender_id' => auth()->id(),
        'receiver_id' => $receiver->id,
        'message' => $request->message,
    ]);

    return response()->json($message);
}
}
