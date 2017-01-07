<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Validator;

use App\User;
use App\Profile;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/confirm-register';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'surname' => 'required|min:2|max:40',
            'name' => 'required|min:2|max:40',
            // 'phone' => 'required|min:10|max:40',
            // 'email' => 'required|email|max:255|unique:users',
            'sex' => 'required',
            'password' => 'required|min:6|max:255',
            'rules' => 'accepted'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'surname' => $data['surname'],
            'name' => $data['name'],
            'password' => bcrypt($data['password']),
            'ip' => Request::ip(),
            'location' => serialize(Request::ips()),
        ]);

        $profile = new Profile;
        $profile->sort_id = $user->id;
        $profile->user_id = $user->id;
        $profile->birthday = $data['year'].'-'.$data['month'].'-'.$data['day'];
        $profile->sex = $data['sex'];
        $profile->save();

        return $user;
    }
}
