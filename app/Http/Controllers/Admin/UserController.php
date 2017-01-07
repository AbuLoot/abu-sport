<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Image;
use Storage;

use App\User;
use App\Role;
use App\City;
use App\Organization;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	protected $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}

	public function index()
	{
		$users = User::all();
		$cities = City::orderBy('sort_id')->get();

		return view('admin.users.index', compact('users', 'cities'));
	}

	public function edit($id)
	{
		$user = User::findOrFail($id);
		$roles = Role::all();
		$cities = City::orderBy('sort_id')->get();
		$organizations = Organization::all();

		return view('admin.users.edit', compact('user', 'roles', 'cities', 'organizations'));
	}

	public function update(Request $request, $id)
	{
        $this->validate($request, [
            'name' => 'required|max:60',
            'surname' => 'required|max:60',
        	'phone' => 'required',
        	'email' => 'required',
        ]);

		$user = User::findOrFail($id);

		if ($request->hasFile('avatar')) {

			if (!file_exists('img/profiles/'.$id)) {
				mkdir('img/profiles/'.$id);
			}

			if (file_exists('img/profiles/'.$id)) {
				Storage::delete('img/profiles/'.$id.'/'.$user->profile->avatar);
			}

			$imageName = 'preview-image-'.str_random(10).'.'.$request->avatar->getClientOriginalExtension();
			$imagePath = 'img/profiles/'.$id.'/'.$imageName;

			$this->resizeImage($request->avatar, 200, 150, $imagePath, 100);
			$user->profile->avatar = $imageName;
		}

		$user->sort_id = ($request->sort_id > 0) ? $request->sort_id : $user->count() + 1;
		$user->name = $request->name;
		$user->surname = $request->surname;
		$user->phone = $request->phone;
		$user->email = $request->email;
		$user->status = ($request->status == 1) ? 1 : 0;
		$user->save();

		$user->organization()->sync([$request->org_id]);
		$user->roles()->sync($request->roles_id);

		$user->profile->city_id = $request->city_id;
		$user->profile->birthday = $request->birthday;
		$user->profile->growth = $request->growth;
		$user->profile->weight = $request->weight;
		$user->profile->sex = $request->sex;
		$user->profile->save();

		return redirect('/admin/users')->with('status', 'Запись обновлена!');
	}

	public function SearchUsers()
	{
		$users = User::join('profiles', 'profiles.user_id','=','users.id') ->orderBy('users.sort_id');

		if (!empty($this->request->input('name'))) {
			$users->where('name', 'like', '%'.$this->request->input('name').'%');
		}
		if (!empty($this->request->input('surname'))) {
			$users->where('surname', 'like', '%'.$this->request->input('surname').'%');
		}
		if (!empty($this->request->input('email'))) {
			$users->where('email', 'like', '%'.$this->request->input('email').'%');
		}
		if (!empty($this->request->input('city_id')) && $this->request->input('city_id') != "null") {
			$users->where('profiles.city_id', $this->request->input('city_id'));
		}
		if (!empty($this->request->input('ip'))) {
			$users->where('ip', 'like', '%'.$this->request->input('ip').'%');
		}
		if (!empty($this->request->input('sort_id'))) {
			$users->where('users.sort_id', 'like', '%'.$this->request->input('sort_id').'%');
		}
		if (!empty($this->request->input('status')) && $this->request->input('status') != "null") {
			$users->where('users.status', $this->request->input('status'));
		}

		return $users->get();
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
