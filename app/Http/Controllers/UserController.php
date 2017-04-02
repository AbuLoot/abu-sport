<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\User;
use App\Feedback;
use App\Http\Requests;

class UserController extends Controller
{
    public function myFriends()
    {
        $user = Auth::user();

        return view('users.my-friends', compact('user'));
    }

    public function userProfile($id)
    {
        $user = User::findOrFail($id);

        return view('users.profile', compact('user'));
    }

    public function allUsers()
    {
        $users = User::where('id', '<>', Auth::id())->get();

        return view('users.all-users', compact('users'));
    }

    public function addToFriends($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return redirect()->back()->with('info', 'That user could not be found');
        }

        if (Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())) {
            return redirect()->back()->with('info', 'Friend request already pending');
        }

        if (Auth::user()->isFriendWith($user)) {
            return redirect()->back()->with('info', 'You are already friends');
        }

        Auth::user()->addFriend($user);

        return redirect()->back()->with('info', 'Friend request sent');
    }

    public function accept($id)
    {
        $user = User::findOrFail($id);

        if (!$user) {
            return redirect()->back()->with('info', 'That user could not be found');
        }

        if (!Auth::user()->hasFriendRequestReceived($user)) {
            return redirect()->back();
        }

        Auth::user()->acceptedFriendRequest($user);

        return redirect()->back()->with('info', 'Friend request accepted');
    }

    public function feedback()
    {
        return view('users.feedback');
    }

    public function storeFeedback(Request $request)
    {
        $this->validate($request, [
            'text' => 'required|min:5|max:60'
        ]);

        $feedback = new Feedback;
        $feedback->user_id = Auth::id();
        $feedback->text = $request->text;
        $feedback->email = Auth::user()->email;
        $feedback->save();

        return redirect('feedback')->with('status', 'Отзыв принят, Спасибо!');
    }
}
