<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Image;
use Storage;

use App\City;
use App\Http\Requests;

class ProfileController extends Controller
{
    public function balance()
    {
        $user = Auth::user();

        return view('profile.balance', compact('user'));
    }

    public function topUpBalance(Request $request)
    {
        $this->validate($request, [
            'balance' => 'required|numeric|min:3'
        ]);

        $user = Auth::user();

        $balance = $user->balance + $request->balance;
        $user->balance = $balance;
        $user->save();

        return redirect('/my-balance')->with('status', 'Баланс пополнен!');
    }

    public function myMatches()
    {
        return view('profile.my-matches');
    }

    public function profile()
    {
        $user = Auth::user();

        return view('profile.my-page', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        $cities = City::orderBy('sort_id')->get();

        $date = [];

        list($date['year'], $date['month'], $date['day']) = explode('-', $user->profile->birthday);

        return view('profile.edit', compact('user', 'cities', 'date'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'surname' => 'required|min:2|max:40',
            'name' => 'required|min:2|max:40',
            'phone' => 'required|min:11|max:11',
            'email' => 'required|email|max:255',
            'city_id' => 'required|numeric',
            'sex' => 'required',
            'day' => 'required|numeric|between:1,31',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric'
        ]);

        $user = Auth::user();

        $user->surname = $request->surname;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        if ($request->hasFile('avatar')) {

            if (!file_exists('img/users/'.$id)) {
                mkdir('img/users/'.$id);
            }

            if (!empty($user->profile->avatar)) {
                Storage::delete('img/users/'.$id.'/'.$user->profile->avatar);
            }

            $imageName = 'avatar-'.str_random(10).'.'.$request->avatar->getClientOriginalExtension();
            $imagePath = 'img/users/'.$id.'/'.$imageName;

            $this->resizeImage($request->avatar, 200, 200, $imagePath, 100);
            $user->profile->avatar = $imageName;
        }

        $user->profile->city_id = $request->city_id;
        $user->profile->birthday = $request['year'].'-'.$request['month'].'-'.$request['day'];
        $user->profile->growth = $request->growth;
        $user->profile->weight = $request->weight;
        $user->profile->sex = $request->sex;
        $user->profile->save();

        return redirect('/my-profile')->with('status', 'Запись обновлена!');
    }

    public function resizeImage($image, $width, $height, $path, $quality, $color = '#ffffff')
    {
        // $frame = Image::canvas($width, $height, $color);
        $newImage = Image::make($image);

        if ($newImage->width() <= $newImage->height()) {
            $newImage->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        else {
            $newImage->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        // $frame->insert($newImage, 'center');
        $newImage->save($path, $quality);
    }

    public function cropImage($image, $width, $height, $path, $quality)
    {
        $newImage = Image::make($image);

        if ($newImage->width() > $width OR $newImage->height() > $height) {
            $newImage->crop($width, $height);
        }

        $newImage->save($path, $quality);
    }
}
