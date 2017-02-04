<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use DB;
use Auth;
use Storage;
use App;
use App\User;
use App\SMS;   
use App\Profile;
use App\Sport;  
use App\Area; 
use App\MatchUser; 
use App\Match; 
use App\Feedback;
use App\Payment;
use App\Chat;
use App\Http\Controllers\Controller;
use AbuLoot\Sms\MobizonApi as Mobizon;
use App\Events\AddedNewMessage;

class ApiController extends Controller
{
	public function requestmessages(Request $request)
    {
	    $ps=array();
		try {  
		    $chats = DB::table('chats')->where('match_id', '=', $request->matchid)->get();	    
            foreach($chats as $chat){
			    $ar['id']=$chat->id;
				$ar['message']=$chat->message;
				$ar['created_at']=$chat->created_at;
				$user = User::find($chat->user_id);
				$ar['username']=$user->name;
				$ar['user_id']=$user->id;
                array_push($ps,$ar); 				
			}	
			$response['messages']=$ps;
			$response['error']=false;			
		}catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }	
    }
    public function requestaddmessage(Request $request)
    {
		try{   
			$chat = new Chat;
			$chat->match_id =$request->match_id;
			$chat->user_id = $request->user_id;
			$chat->message = $request->message;
			$chat->save();
			/*event(
					new AddedNewMessage($chat)
			);*/
				$response['error']=false;
					
		}catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }	
    }
	public function requestprofile(Request $request)
	{
		$response=array();						
						
		if(isset($request->userid) && $request->userid!=''){
		 $user= User::find($request->userid);
					$user->name = $request->name;
					$user->surname =$request->surname;
					$user->email = $request->email;
					$user->save();
					$response['profile']=$user;
					$response['error']=false;
		}else{
		
			$response['error']=true;	
		}

		return Response::json($response);
		
   }
	public function requestcallbacklist($userid)
	{
	   try {   
            $callbacks = DB::table('feedbacks')->where('user_id', '=', $userid)->get();	       
            $response['callbacks']= $callbacks;
            $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}
	public function requestnewcallback(Request $request)
	{
	$response=array();						
						
			if(isset($request->userid) && $request->userid!=''){
			    $response['error']=false;
			    $feedback = new Feedback;				
				$feedback->user_id = $request->userid;
				$feedback->email = $request->email;	
				$feedback->text = $request->text;
						if($feedback->save()){ 
							$response['error']=false;
						}
						else{  	 	     
						     $response['error']=true;
						}						 				
			}else{
			
				$response['error']=true;	
			}
			
			return Response::json($response);
			
   }
	public function requestsms($mobile,$name,$surname,$email,$password,$sex)
	{
		  
		  $response = array();

			if(isset($mobile) && $mobile!=''){
			
				 $user=User::wherePhone($mobile)->first();
				 $code = rand(10000, 99999);
				 if($user==true){		
					            if ($user->status == 0) {
									$response['error']=true;
									$response['message']="Такой номер уже зарегестрирован, но не подтвержден. Проверьте sms сообщение или запросите повторное подтверждение номера.";
									return redirect()->back()->withInput()->withErrors('');
								}
								else {
								    $response['error']=true;
									$response['message']="Пользователь с таким номером уже зарегестрирован.";

								}
					
				 }else{				    
				     $responseApi = $this->sendSms($mobile, $code);
					 if($responseApi){					    
						$user = new User();
						$user->surname = $surname;
						$user->name = $name;
						$user->phone = $mobile;
						$user->email = $email;
						$user->password = bcrypt($password);
						$user->ip = \Request::ip();
						$user->location = serialize(\Request::ips());
						$user->status = 0;
						$user->balance="0";
						$user->save();

						$profile = new Profile;
						$profile->sort_id = $user->id;
						$profile->user_id = $user->id;
						$profile->phone = $mobile;
						$profile->sex = $sex;
						$profile->save();

						$sms = new SMS();
						$sms->user_id = $user->id;
						$sms->phone = $mobile;
						$sms->code = $code;
						$sms->save();					 					 					 					 
						$response['error']=false;
						$response['message']="На ваш номер был отправлен sms c кодом, введите его для подтверждение регистрации.";  												 
					 }else{
					      $response['error']=true;
						  $response['message']="Неверный номер телефона";
					 
					 }
				 }	
			}else{
			  
			 $response['error']=true;
	         $response['message']="Sorry!mobile number is missing";
			
			}
            
          return Response::json($response);
        
	}		
	public function requestverifyotp($otp)
	{
	$response=array();						
						
			if(isset($otp) && $otp!=''){
			
			 $sms= DB::table('sms')
              ->where('code', '=', $otp)
              ->first();
				    if(count($sms)>0){
			
						$user= User::find($sms->user_id);
						$user->status = 1;
						$user->save();
						$response['profile']=$user;
						$response['error']=false;
					}else{
					
						$response['error']=true;
							
					}
			}else{
			
				$response['error']=true;	
			}
			
			return Response::json($response);
			
   }
    public function requestlogin($phone,$password)
	{
		  $response = array();
			if(isset($phone) && $phone!=''){	
               if (Auth::attempt(['phone' => $phone, 'password' => $password, 'status' => 1])) {
                    $user=User::wherePhone($phone)->first();
					 if($user==true){		
							$response['profile']=$user;
							$response['error']=false;
					 }else{				    
						$response['error']=true;
					 }	
                }		
				else{			  
			      $response['error']=true;			
				}				  
				
			}else{			  
			 $response['error']=true;			
			}
            
          return Response::json($response);
			
   }
    public function requestsports()
	{
	   try{           
            $sports = Sport::all();    
            $response['sports']= $sports;
            $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}
	public function requestplaygrounds($sportid)
	{
	   try{   
	        $ps=array();
	        $sport = Sport::where('id', $sportid)->first();
    	    $areas = $sport->areas()->get();
            foreach($areas as $area){
			    $ar['id']=$area->id;
				$ar['title']=$area->title;
				$ar['sport_id']=$area->sport_id;
				$ar['image']=$area->image;
				$ar['images']=$area->images;
				$ar['status']=$area->status;
				$ar['address']=$area->address;
				$ar['description']=$area->description;
			    $ar['matchcount']=$area->fieldsMatchesCount;
				$ar['latitude']=$area->latitude;
				$ar['longitude']=$area->longitude;
                array_push($ps,$ar); 				
			}			
            $response['areas']= $ps;
            $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}	
	public function requestmatches($areaid)
	{		
	   try {   
	    $ms=array();
	    $date= date("Y-m-d");
		$hour=date("H:i");
	    $matches = DB::table('fields')
            ->join('matches', 'fields.id', '=', 'matches.field_id')
            ->select('matches.*')
			->where('matches.date','>=',$date)
			->whereIn('matches.field_id',DB::table('fields')->select('fields.id')->from('fields')->where('fields.area_id', '=', $areaid))
			->orderBy('date', 'asc')	
            ->get();         			
			foreach($matches as $match){						
			  $mt['id']=$match->id;
			  $mt['field_id']=$match->field_id;
			  $mt['price']=$match->price;
			  $mt['date']=$match->date;
			  $mt['match_type']=$match->match_type;
			  $mt['game_type']=$match->game_type;
			  $mt['game_format']=$match->game_format;
			  $mt['start_time']=$match->start_time;
			  $endTime = strtotime("+60 minutes", strtotime($match->end_time));						
			  $mt['end_time']=date("H:i",$endTime);
			  $mt['number_of_players']=$match->number_of_players;
			  $mplayers = DB::table('match_user')->select('match_user.user_id')->where('match_user.match_id', '=', $match->id)->get();
			  $mt['joined_players']=count($mplayers)+1;
			  array_push($ms,$mt);
			}
            $response['matches']= $ms;
            $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }						
	}
	public function requestmatchplayers($matchid)
	{	
     $res=array();		
	 try {   
	     $organizer = DB::table('matches')->select('matches.user_id')->where('matches.id', '=', $matchid)->first();
		 $org=DB::table('users')->select('users.id','users.name','users.email','users.phone')
				  ->where('users.id', '=', $organizer->user_id)
				  ->first();
		 array_push($res,$org);	 
	     $mplayers = DB::table('match_user')->select('match_user.user_id')->where('match_user.match_id', '=', $matchid)->get();
		 foreach($mplayers as $d){
		   $user=DB::table('users')->select('users.id','users.name','users.email','users.phone')
				  ->where('users.id', '=', $d->user_id)
				  ->first();
		   array_push($res,$user);	  
		 }   
        $response['players']= $res;
        $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}
	public function requestjoinmatch($matchid,$userid)
	{	
	$user = User::find(intval($userid));
	$match = Match::find(intval($matchid));	
				if($match->users()->attach($userid)){ 
							$response['error']=false;
							$response['message']="Player joined success";  
						}
						else{  	 	     
						     $response['error']=true;
						     $response['message']="Player failed";
				}
						 
				return Response::json($response);
			
	}
	public function requestexitmatch($matchid,$userid)
	{	
		$deletedRows=DB::table('match_user')->where('user_id', '=', $userid)->where('match_id', '=', $matchid)->delete();
				if($deletedRows>0){ 
					$response['error']=false;
					$response['message']="Player deleted success";  
				}
				else{  	 	     
				    $response['error']=true;
				    $response['message']="Player failed";
				}				 
				return Response::json($response);
			
	}
	public function requestweekdays($playgroundid,$selecteddate){
		//$schedules = DB::table('schedules')->select('schedules.field_id','schedules.start_time','schedules.end_time','schedules.price','schedules.status','schedules.date')->where('schedules.field_id', '=', 1)->where('schedules.week', '=', 1)->get();
		try{   
		     $days=array();
			 $result=array();
			 $schresult=array();
			 $fullschedule=array();
			 $month_r = array();
			 $date_min= date("Y-m-d");
			 $date_max= date("Y-m-d",strtotime($date_min." + 7 day"));
			 $start = new \DateTime($date_min);
             $end = new \DateTime($date_max);   
		     $interval = \DateInterval::createFromDateString("1 day");
			 $period   = new \DatePeriod($start, $interval, $end);
		   foreach($period as $dt){
						$month_r=array(
						"01" => "Янв",	
						"02" => "Фев", 
						"03" => "Март", 
						"04" => "Апр", 
						"05" => "Май", 
						"06" => "Июнь", 
						"07" => "Июль", 
						"08" => "Авг", 
						"09" => "Сен", 
						"10" => "Окт", 
						"11" => "Ноя", 
						"12" => "Дек"); 
						$day_r = array( 
						"1" => "Пнд", 
						"2" => "Втр", 
						"3" => "Срд", 
						"4" => "Чтв", 
						"5" => "Птн", 
						"6" => "Сбт", 
						"0" => "Вск"); 
							  $result["year"] = $dt->format("Y-m-d");
							  $result["month"] = $month_r[$dt->format("m")];
							  $result["day"]= $dt->format("d");     
							  $result["weekday"]=$day_r[$dt->format("w")];
							  array_push($days,$result);}	
				$hours=array(
							'0' => '00:00',
							'1' => '01:00',
							'2' => '02:00',
							'3' => '03:00',
							'4' => '04:00',
							'5' => '05:00',
							'6' => '06:00',
							'7' => '07:00',
							'8' => '08:00',
							'9' => '09:00',
							'10' => '10:00',
							'11' => '11:00',
							'12' => '12:00',
							'13' => '13:00',
							'14' => '14:00',
							'15' => '15:00',
							'16' => '16:00',
							'17' => '17:00',
							'18' => '18:00',
							'19' => '19:00',
							'20' => '20:00',
							'21' => '21:00',
							'22' => '22:00',
							'23' => '23:00');
            $response['days'] =$days;
			$week = new \DateTime($selecteddate);			
			$fields = DB::table('fields')->select('fields.id','fields.title')->where('fields.area_id','=',$playgroundid)->where('fields.status','=',1)->get();			
			foreach($fields as $field){
				$schedules = DB::table('schedules')->select('schedules.field_id','schedules.start_time','schedules.end_time','schedules.price','schedules.status','schedules.date')->where('schedules.field_id', '=', $field->id)->where('schedules.week', '=', $week->format("w"))->get();
				$times = DB::table('matches')->select('matches.field_id','matches.start_time','matches.end_time')->where('matches.field_id','=',$field->id)->where('matches.date','=',$selecteddate)->get();							
				 //print_r($times);
				 
				foreach($hours as $hour){
				    $selectedtime=$selecteddate." ".$hour;
				    if($selectedtime>=date("Y-m-d H:i")){
						$schresult['start_time']=$hour;
						$endTime = strtotime("+60 minutes", strtotime($hour));
						$schresult['end_time'] =date("H:i",$endTime);
						$schresult['field_id']= $field->id;
						$schresult['title'] = $field->title;
						$schresult['status']=0;
						foreach($schedules as $schedule){
							if($schedule->start_time <= $hour AND $schedule->end_time >= $hour){
							  $schresult['price']=$schedule->price;							  		
							  $schresult['date']=$selecteddate;	
							  break;
							}						
						}
						foreach($times as $match){
							if($match->start_time <= $hour AND $match->end_time >= $hour){
								$schresult['status']=1;
							}
						}
						array_push($fullschedule,$schresult);
					}
				}			
			}	
			$response['schedules']= $fullschedule;					
			$response['error']=false;
		} catch (Exception $e) {
			$response['error'] = true;
		} finally {
			return Response::json($response);
		}
	}

	public function requestmatchcreate(Request $request)
	{	
		        $match = new Match;				
				$match->sort_id = 1;
				$match->user_id = intval($request->userid);	
				$match->field_id = intval($request->fieldid);
				$match->start_time = $request->starttime;
				$match->end_time = $request->endtime;
				$match->date = $request->date;
				$match->match_type = $request->matchtype;
				$match->game_type = $request->gametype;	
				$match->number_of_players = intval($request->numberofplayers);
				$match->game_format = $request->format;
				$match->price = intval($request->price);
				$match->description = $request->description;
				$match->status =1;
				if($match->save()){ 
							$response['error']=false;
							$response['message']="Match created success";  
						}
						else{  	 	     
						     $response['error']=true;
						     $response['message']="Create match failed";
						}
						 
				return Response::json($response);
			
	}
	public function sendSms($phone,$code)
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
    public function requestsign64(Request $request){
	 try {   
	  	if(intval($request->amount)>0){    
			$path=__DIR__.'/Payment/paysys/kkb.utils.php';
			\File::requireOnce($path);
			  $path1 = [
				'MERCHANT_CERTIFICATE_ID' => '00C182B189',
				'MERCHANT_NAME' => 'Test shop',
				'PRIVATE_KEY_FN' => __DIR__.'/Payment/paysys/test_prv.pem',
				'PRIVATE_KEY_PASS' => 'nissan',
				'PUBLIC_KEY_FN' => __DIR__.'/Payment/paysys/kkbca.pem',
				'MERCHANT_ID' => '92061101',
				'XML_TEMPLATE_FN' => __DIR__.'/Payment/paysys/template.xml',
				'XML_COMMAND_TEMPLATE_FN' => __DIR__.'/Payment/paysys/command_template.xml'
			];   
			$user= User::find($request->userid);
			$currency_id = "398"; // Шифр валюты  - 840-USD, 398-Tenge
			$payment = new Payment;
			$payment->user_id = $user->id;
			$payment->amount = $request->amount;
			$payment->status="0";
			$payment->operation_id = 1;
			$payment->save();
			$content = process_request($payment->id,$currency_id, $payment->amount, $path1);
			$response['content']=$content;
			$response['error']=false;
			//$response['content']="PGRvY3VtZW50PjxtZXJjaGFudCBjZXJ0X2lkPSIwMGMxODNkNzBiIiBuYW1lPSJOZXcgRGVtbyBTaG9wIj48b3JkZXIgb3JkZXJfaWQ9IjEwMTAwMDE3MDciIGFtb3VudD0iMTAiIGN1cnJlbmN5PSIzOTgiPjxkZXBhcnRtZW50IG1lcmNoYW50X2lkPSI5MjA2MTEwMyIgYW1vdW50PSIxMCIvPjwvb3JkZXI+PC9tZXJjaGFudD48bWVyY2hhbnRfc2lnbiB0eXBlPSJSU0EiPm5rWGQ4NkRBcGMrSVc5Qy9qQUZoaVVyS2VrUVZoaDQxQXBEbXVQWnBGQmF2WnZMaUhFdDh6SXNmK0xmR01WSE91NzlxdVEwcUlaUVllRWVjUGJhdWxiWEsxUmVJQ3VMdVNlU1NXdEUyQlBDWTZvUjEybVIzNlJJZUVOMnNUQm1mRkdGeG4wbkpaMzJMV2hYNWFrWVc3WEJOdWN1UlQzNlRVWHBzMXhqUmwyQT08L21lcmNoYW50X3NpZ24+PC9kb2N1bWVudD4=";;
			$response['user']=$user; 
	  }
	}catch (Exception $e){
            $response['error']=true;
    }finally{
            return Response::json($response);
    }	
	}
	
}