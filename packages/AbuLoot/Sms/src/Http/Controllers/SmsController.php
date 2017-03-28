<?php namespace AbuLoot\Sms\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AbuLoot\Sms\MobizonApi as Mobizon;

class SmsController extends Controller
{
	public function index()
	{
		$apiKey = config('sms.key');
		$mobizonApi = new Mobizon($apiKey);

		if ($mobizonApi->call('user', 'GetOwnBalance') && $mobizonApi->hasData('balance')) {
			echo 'Current user balance: ' . $mobizonApi->getData('currency') . ' ';
		    echo $mobizonApi->getData('balance') . PHP_EOL;
		}
		else {
		    echo 'Error occurred while fetching user balance: [' . $mobizonApi->getCode() . '] ' . $mobizonApi->getMessage() . PHP_EOL;
		}
	}

	public function sendSms($phone, $name)
	{
		$apiKey = config('sms.key');
		$mobizonApi = new Mobizon($apiKey);

		// KAZINFO - Default alphaname MobizonApi
		$alphaname = 'abusoft.kz'; 
		$smsData = [
		    'recipient' => $phone,
		    'text'      => 'Test message to ' . $name . ' from AbuSport',
		    'from'      => $alphaname, //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
		];

		if ($mobizonApi->call('message', 'sendSMSMessage', $smsData)) {

		    $messageId = $mobizonApi->getData('messageId');
		    echo 'Message created with ID:' . $messageId . PHP_EOL;

		    if ($messageId) {

		        echo 'Get message info...' . PHP_EOL;
		        $messageStatuses = $mobizonApi->call('message', 'getSMSStatus', [
		                'ids' => [$messageId, '13394', '11345', '4393']
		            ], [], true
		        );

		        if ($mobizonApi->hasData()) {

		            foreach ($mobizonApi->getData() as $messageInfo)
		            {
		                echo 'Message # ' . $messageInfo->id . " status:\t" . $messageInfo->status . PHP_EOL;
		            }
		        }
		    }
		}
		else {
		    echo 'An error occurred while sending message: [' . $mobizonApi->getCode() . '] ' . $mobizonApi->getMessage() . 'See details below:' . PHP_EOL;
		    var_dump(array($mobizonApi->getCode(), $mobizonApi->getData(), $mobizonApi->getMessage()));
		}
	}
}