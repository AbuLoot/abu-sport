<?php

namespace Abuloot\Epay\Http\Controllers;

use Auth;
use Abuloot\Epay\Payment;

use App\Http\Controllers\Controller;

class EpayController extends Controller
{
	public function test()
	{
		return view('epay::epay');
	}

    public function index($amount)
    {
	    if (intval($amount)>0) {
			$path=__DIR__.'/paysys/kkb.utils.php';
	        \File::requireOnce($path);
	       	$path1 = [
	            'MERCHANT_CERTIFICATE_ID' => '00C182B189',
	            'MERCHANT_NAME' => 'Test shop',
	            'PRIVATE_KEY_FN' => __DIR__.'/paysys/test_prv.pem',
	            'PRIVATE_KEY_PASS' => 'nissan',
	            'PUBLIC_KEY_FN' => __DIR__.'/paysys/kkbca.pem',
	            'MERCHANT_ID' => '92061101',
	            'XML_TEMPLATE_FN' => __DIR__.'/paysys/template.xml',
	            'XML_COMMAND_TEMPLATE_FN' => __DIR__.'/paysys/command_template.xml'
	        ];
			$user = Auth::user();
	        $currency_id = "398"; // Øèôð âàëþòû  - 840-USD, 398-Tenge
	        $payment = new Payment;
	        $payment->user_id = Auth::user()->id;
	        $payment->amount = $amount;
			$payment->status="0";
	        $payment->operation_id = 1;
	        $payment->save();
	        $content = process_request($payment->id,$currency_id, intval($payment->amount), $path1); // Âîçâðàùàåò ïîäïèñàííûé è base64 êîäèðîâàííûé XML äîêóìåíò äëÿ îòïðàâêè â áàíê
	        return view('epay.index', compact('user', 'content'));
		}
    }

    public function postLink()
    {
        require_once("/paysys/kkb.utils.php");
        $path1 = [
            'MERCHANT_CERTIFICATE_ID' => '00C182B189',
            'MERCHANT_NAME' => 'Test shop',
            'PRIVATE_KEY_FN' => storage_path() . '\payment\epay\test_prv.pem',
            'PRIVATE_KEY_PASS' => 'nissan',
            'PUBLIC_KEY_FN' => storage_path() . '\payment\epay\kkbca.pem',
            'MERCHANT_ID' => '92061101',
            'XML_TEMPLATE_FN' => __DIR__.'\paysys\template.xml',
            'XML_COMMAND_TEMPLATE_FN' => __DIR__.'\paysys\command_template.xml'
        ];
        $result = 0;
        if (isset($_POST["response"])){
            $response = $_POST["response"];
        }
        
        $result = process_response(stripslashes($response),$path1);
        //foreach ($result as $key => $value) {echo $key." = ".$value."<br>";}
        if (is_array($result)){
            if (in_array("ERROR",$result)){
                if ($result["ERROR_TYPE"]=="ERROR"){
                    echo "System error:".$result["ERROR"];
                } elseif ($result["ERROR_TYPE"]=="system"){
                    echo "Bank system error > Code: '".$result["ERROR_CODE"]."' Text: '".$result["ERROR_CHARDATA"]."' Time: '".$result["ERROR_TIME"]."' Order_ID: '".$result["RESPONSE_ORDER_ID"]."'";
                }elseif ($result["ERROR_TYPE"]=="auth"){
                    echo "Bank system user autentication error > Code: '".$result["ERROR_CODE"]."' Text: '".$result["ERROR_CHARDATA"]."' Time: '".$result["ERROR_TIME"]."' Order_ID: '".$result["RESPONSE_ORDER_ID"]."'";
                }
            }
            if (in_array("DOCUMENT",$result)){
                echo "Result DATA: <BR>";
                foreach ($result as $key => $value) {echo "Postlink Result: ".$key." = ".$value."<br>";}
            }
        } else { echo "System error".$result; }
        //return view('epay.paytest.postlink');
    }

    public function postLinkTest()
    {
        return view('epay.paytest.postlinktest');
    }

    public function process_response($response,$config)
    {
        // -----===++[Process incoming XML to array of values with verifying electronic sign]++===-----
        // variables:
        // $response - string: XML response from bank
        // $config_file - string: full path to config file
        // returns:
        // array with parced XML and sign verifying result
        // if array has in values "DOCUMENT" following values available
        // $data['CHECKRESULT'] = "[SIGN_GOOD]" - sign verify successful
        // $data['CHECKRESULT'] = "[SIGN_BAD]" - sign verify unsuccessful
        // $data['CHECKRESULT'] = "[SIGN_CHECK_ERROR]" - an error has occured while sign processing full error in that string after ":"
        // if array has in values "ERROR" following values available
        // $data["ERROR_TYPE"] = "ERROR" - internal error occured
        // $data["ERROR"] = "Config not exist" - the configuration file not found
        // $data["ERROR_TYPE"] = "system" - external error in bank process
        // $data["ERROR_TYPE"] = "auth" - external autentication error in bank process
        // example:
        // income data:
        // $response = "<document><bank><customer name="123"><merchant name="test merch">
        // <order order_id="000001" amount="10" currency="398"><department amount="10"/></order></merchant>
        // <merchant_sign type="RSA"/></customer><customer_sign type="RSA"/><results timestamp="2001-01-01 00:00:00">
        // <payment amount="10" response_code="00"/></results></bank>
        // <bank_sign type="SHA/RSA">;skljfasldimn,samdbfyJHGkmbsa;fliHJ:OIUHkjbn</bank_sign ></document>"
        // $config_file = "config.txt"
        // result:
        // $data['BANK_SIGN_CHARDATA'] = ";skljfasldimn,samdbfyJHGkmbsa;fliHJ:OIUHkjbn"
        // $data['BANK_SIGN_TYPE'] = "SHA/RSA"
        // $data['CUSTOMER_NAME'] = "123"
        // $data['CUSTOMER_SIGN_TYPE'] = "RSA"
        // $data['DEPARTMENT_AMOUNT'] = "10"
        // $data['MERCHANT_NAME'] = "test merch"
        // $data['MERCHANT_SIGN_TYPE'] = "RSA"
        // $data['ORDER_AMOUNT'] = "10"
        // $data['ORDER_CURRENCY'] = "398"
        // $data['ORDER_ORDER_ID'] = "000001"
        // $data['PAYMENT_AMOUNT'] = "10"
        // $data['PAYMENT_RESPONSE_CODE'] = "00"
        // $data['RESULTS_TIMESTAMP'] = "2001-01-01 00:00:00"
        // $data['TAG_BANK'] = "BANK"
        // $data['TAG_BANK_SIGN'] = "BANK_SIGN"
        // $data['TAG_CUSTOMER'] = "CUSTOMER"
        // $data['TAG_CUSTOMER_SIGN'] = "CUSTOMER_SIGN"
        // $data['TAG_DEPARTMENT'] = "DEPARTMENT"
        // $data['TAG_DOCUMENT'] = "DOCUMENT"
        // $data['TAG_MERCHANT'] = "MERCHANT"
        // $data['TAG_MERCHANT_SIGN'] = "MERCHANT_SIGN"
        // $data['TAG_ORDER'] = "ORDER"
        // $data['TAG_PAYMENT'] = "PAYMENT"
        // $data['TAG_RESULTS'] = "RESULTS"
        // $data['CHECKRESULT'] = "[SIGN_GOOD]"
        //
        // -----===++[Îáðàáîòêàâõîäÿùåãî XML â ìàññèâ çíà÷åíèé ñ ïðîâåðêîé ýëåêòðîííîé ïîäïèñè]++===-----
        // Ïåðåìåííûå:
        // $response - ñòðîêà: XML îòâåò îò áàíêà
        // $config_file - ñòðîêà: ïîëíûé ïóòü ê ôàéëó êîíôèãóðàöèè
        // âîçâðàùàåò:
        // ìàññèâ ñ íàðåçàííûì XML è ðåçóëüòàòîì ïðîâåðêè ïîäïèñè
        // åñëè â ìàññèâå åñòü çíà÷åíèå "DOCUMENT" äîñòóïíû ñëåäóþùèå çíà÷åíèÿ
        // $data['CHECKRESULT'] = "[SIGN_GOOD]" - ïðîâåðêà ïîäïèñè óñïåøíà
        // $data['CHECKRESULT'] = "[SIGN_BAD]" - ïðîâåðêà ïîäïèñè ïðîâàëåíà
        // $data['CHECKRESULT'] = "[SIGN_CHECK_ERROR]" - ïðîèçîøëà îøèáêà âî âðåìÿ îáðàáîòêè ïîäïèñè, ïîäíîå ïîèñàíèå îøèáêè â ýòîé æå ñòðîêå ïîñëå ":"
        // åñëè â ìàññèâå åñòü çíà÷åíèå "ERROR" äîñòóïíû ñëåäóþùèå çíà÷åíèÿ
        // $data["ERROR_TYPE"] = "ERROR" - ïðîèçîøëà âíóòðåííÿÿ îøèáêà
        // $data["ERROR"] = "Config not exist" - íå íàéäåí ôàéë êîíôèãóðàöèè
        // $data["ERROR_TYPE"] = "system" - âíåøíÿÿ îøèáêà ïðè îáðàáîòêå äàííûõ â áàíêå
        // $data["ERROR_TYPE"] = "auth" - âíåøíÿÿ îøèáêà àâòîðèçàöèè ïðè îáðàáîòêå äàííûõ â áàíêå
        // ïðèìåð:
        // âõîäíûå äàííûå:
        // $response = "<document><bank><customer name="123"><merchant name="test merch">
        // <order order_id="000001" amount="10" currency="398"><department amount="10"/></order></merchant>
        // <merchant_sign type="RSA"/></customer><customer_sign type="RSA"/><results timestamp="2001-01-01 00:00:00">
        // <payment amount="10" response_code="00"/></results></bank>
        // <bank_sign type="SHA/RSA">;skljfasldimn,samdbfyJHGkmbsa;fliHJ:OIUHkjbn</bank_sign ></document>"
        // $config_file = "config.txt"
        // ðåçóëüòàò:
        // $data['BANK_SIGN_CHARDATA'] = ";skljfasldimn,samdbfyJHGkmbsa;fliHJ:OIUHkjbn"
        // $data['BANK_SIGN_TYPE'] = "SHA/RSA"
        // $data['CUSTOMER_NAME'] = "123"
        // $data['CUSTOMER_SIGN_TYPE'] = "RSA"
        // $data['DEPARTMENT_AMOUNT'] = "10"
        // $data['MERCHANT_NAME'] = "test merch"
        // $data['MERCHANT_SIGN_TYPE'] = "RSA"
        // $data['ORDER_AMOUNT'] = "10"
        // $data['ORDER_CURRENCY'] = "398"
        // $data['ORDER_ORDER_ID'] = "000001"
        // $data['PAYMENT_AMOUNT'] = "10"
        // $data['PAYMENT_RESPONSE_CODE'] = "00"
        // $data['RESULTS_TIMESTAMP'] = "2001-01-01 00:00:00"
        // $data['TAG_BANK'] = "BANK"
        // $data['TAG_BANK_SIGN'] = "BANK_SIGN"
        // $data['TAG_CUSTOMER'] = "CUSTOMER"
        // $data['TAG_CUSTOMER_SIGN'] = "CUSTOMER_SIGN"
        // $data['TAG_DEPARTMENT'] = "DEPARTMENT"
        // $data['TAG_DOCUMENT'] = "DOCUMENT"
        // $data['TAG_MERCHANT'] = "MERCHANT"
        // $data['TAG_MERCHANT_SIGN'] = "MERCHANT_SIGN"
        // $data['TAG_ORDER'] = "ORDER"
        // $data['TAG_PAYMENT'] = "PAYMENT"
        // $data['TAG_RESULTS'] = "RESULTS"
        // $data['CHECKRESULT'] = "[SIGN_GOOD]"
        $xml_parser = new Xml();
        $result = $xml_parser->parse($response);

        if (in_array("ERROR",$result)) {
            return $result;
        }

        if (in_array("DOCUMENT",$result)) {
            $kkb = new KKBSign();
            $kkb->invert();
            $data = split_sign($response,"BANK");
            $check = $kkb->check_sign64($data['LETTER'], $data['RAWSIGN'], $config['PUBLIC_KEY_FN']);
            if ($check == 1)
                $data['CHECKRESULT'] = "[SIGN_GOOD]";
            elseif ($check == 0)
                $data['CHECKRESULT'] = "[SIGN_BAD]";
            else
                $data['CHECKRESULT'] = "[SIGN_CHECK_ERROR]: ".$kkb->estatus;
            return array_merge($result,$data);
        }
        return "[XML_DOCUMENT_UNKNOWN_TYPE]";
    }
}