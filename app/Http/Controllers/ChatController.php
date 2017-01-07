<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Chat;
use App\Match;
use App\Http\Requests;
use App\Events\AddedNewMessage;

class ChatController extends Controller
{
    public function postMessage(Request $request, $match_id)
    {
        $match = Match::findOrFail($match_id);

        $chat = new Chat;

        if ($request->user()->id == $match->user_id OR in_array($request->user()->id, $match->users->lists('id')->toArray())) {
            $chat->match_id = $match->id;
        }
        else {
            return redirect()->back();
        }

        $chat->user_id = $request->user()->id;
        $chat->message = $request->message;
        $chat->save();

        event(new AddedNewMessage($chat));

        return redirect()->back();
    }

    public function postMessageAjax(Request $request, $match_id)
    {
        $match = Match::findOrFail($match_id);

        $chat = new Chat;

        if ($request->user()->id == $match->user_id OR in_array($request->user()->id, $match->users->lists('id')->toArray())) {
            $chat->match_id = $match->id;
        }
        else {
            return redirect()->back();
        }

        $chat->user_id = $request->user()->id;
        $chat->message = $request->message;
        $chat->save();

        event(new AddedNewMessage($chat));

        return response()->json([]);
    }
}
