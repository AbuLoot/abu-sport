<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Auth;
use Storage;

use App\SMS;
use App\User;
use App\Profile;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use AbuLoot\Sms\MobizonApi as Mobizon;

class AuthCustomController extends Controller
{
    public function postLogin(Request $request)
    {
        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        $request->merge(['phone' => $phone]);

        $this->validate($request, [
            'phone' => 'required|min:11|max:11'
        ]);

        if ($request->phone[0] == 8) {
            $request->merge(['phone' => substr_replace($request->phone, '7', 0, 1)]);
        }

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password, 'status' => 1])) {
            return redirect('/');
        }
        else {
            return redirect()->back()->withInput()->withWarning('Не правильный логин или пароль или не подтвержден номер телефона.');
        }
    }

    protected function postRegister(Request $request)
    {
		$phone = preg_replace('/[^0-9]/', '', $request->phone);

		$request->merge(['phone' => $phone]);

        $this->validate($request, [
            'surname' => 'required|min:2|max:40',
            'name' => 'required|min:2|max:40',
            'phone' => 'required|min:11|max:11|unique:users',
            // 'email' => 'required|email|max:255|unique:users',
            'sex' => 'required',
            'password' => 'required|min:6|max:255',
            'rules' => 'accepted'
        ]);

        if ($request->phone[0] == 8) {
        	$request->merge(['phone' => substr_replace($request->phone, '7', 0, 1)]);
        }

        $user = User::where('phone', $request->phone)->first();

        if ( ! empty($user->phone)) {
            if ($user->status == 0) {
                return redirect()->back()->withInput()->withErrors('Такой номер уже зарегестрирован, но не подтвержден. Проверьте sms сообщение или запросите повторное подтверждение номера.');
            }
            else {
                return redirect()->back()->withInput()->withErrors('Пользователь с таким номером уже зарегестрирован.');
            }
        }

        $code = rand(10000, 99999);

        $responseApi = $this->sendSms($request->phone, $code);

        if ($responseApi == true) {

            $user = new User();
            $user->surname = $request->surname;
            $user->name = $request->name;
            $user->phone = $request->phone;
            // $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->ip = $request->ip();
            $user->location = serialize($request->ips());
            $user->balance = 10000;
            $user->status = 0;
            $user->save();

            $profile = new Profile;
            $profile->sort_id = $user->id;
            $profile->user_id = $user->id;
            $profile->city_id = 1;
            $profile->phone = $request->phone;
            $profile->sex = $request['sex'];
            $profile->save();

            $sms = new SMS();
            $sms->user_id = $user->id;
            $sms->phone = $request->phone;
            $sms->code = $code;
            $sms->save();

            // $request->merge(['user_id' => $user->id]);

            return redirect('confirm-register')->withInput()->withInfo('На ваш номер был отправлен sms c кодом, введите его для подтверждение регистрации.');
        }
        else {
            return redirect()->back()->withInput()->withErrors('Неверный Номер Телефона');
        }
    }

    public function getConfirmRegister()
    {
        return view('auth.confirm-register');
    }

    public function postConfirmRegister(Request $request)
    {
        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        $request->merge(['phone' => $phone]);

        $this->validate($request, [
            'phone' => 'required|min:11|max:11',
            'code' => 'required|numeric|min:5'
        ]);

        if ($request->phone[0] == 8) {
            $request->merge(['phone' => substr_replace($request->phone, '7', 0, 1)]);
        }

        $sms = SMS::where('phone', $request->phone)
            // ->where('user_id', $request->id)
            ->where('code', $request->code)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($sms == true) {

            $user = User::where('phone', $sms->phone)->first();
            $user->status = 1;
            $user->save();

            $user->assignRole('user');

            return redirect('login')->withInput()->withStatus('Вы успешно подтвердили регистрацию, теперь войдите через свой номер и пароль');
        }
        else {
            return redirect()->back()->withInput()->withErrors('Неверный номер телефона или неверный код подтверждение');
        }
    }

    public function sendSms($phone, $code)
    {
        $apiKey = config('sms.key');
        $mobizonApi = new Mobizon($apiKey);

        $alphaname = 'abusoft.kz'; // KAZINFO - Default alphaname MobizonApi
        $smsData = [
            'recipient' => $phone,
            'text'      => $code . ' - ваш код для регистрации в AbuSport',
            'from'      => $alphaname, //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
        ];

        // Create sms-log.txt if not exists
        if (!Storage::exists('sms-log.txt')) {
            Storage::disk('local')->put('sms-log.txt', 'Start');
        }

        if ($mobizonApi->call('message', 'sendSMSMessage', $smsData)) {

            $messageId = $mobizonApi->getData('messageId');

            // Record to sms-log.txt
            Storage::prepend('sms-log.txt', 'Message created with ID:' . $messageId . PHP_EOL);

            if ($messageId) {

                $response = true;

                // return 'Get message info...' . PHP_EOL;
                $messageStatuses = $mobizonApi->call('message', 'getSMSStatus', [
                        'ids' => [$messageId, '13394', '11345', '4393']
                    ], [], true
                );

                if ($mobizonApi->hasData()) {

                    foreach ($mobizonApi->getData() as $messageInfo)
                    {
                        Storage::prepend('sms-log.txt', 'Message # ' . $messageInfo->id . " status:\t" . $messageInfo->status);
                    }
                }
            }
        }
        else {

            $response = false;

            // Record to sms-log.txt
            Storage::prepend('sms-log.txt', 'An error occurred while sending message: [' . $mobizonApi->getCode() . '] ' . $mobizonApi->getMessage());
            Storage::prepend('sms-log.txt', json_encode($mobizonApi->getData()));
        }

        Storage::prepend('sms-log.txt', PHP_EOL);

        return $response;
    }

    public function getLogout()
    {
        Auth::logout();

        return redirect('/');
    }
}
