<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use App\Area;
use App\Match;
use App\Schedule;
use App\Http\Requests;
use App\Events\LeftMatch;
use App\Events\JoinedToMatch;
use App\Events\NotifyNewMatch;
use App\Events\NotifyNewPlayer;
use App\Events\NotifyLeftPlayer;
use App\Events\CreatedNewMatch;

class MatchAjaxController extends Controller
{
    public function storeMatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number_of_players' => 'required|numeric',
            'hours' => 'required',
        ]);

        $messages = [];
        $index = 0;

        if ($validator->fails()) {

            foreach ($validator->errors()->messages() as $message)
            {
                foreach ($message as $value)
                {
                    $messages['errors'][$index++] = $value;
                }
            }

            return response()->json($messages);
        }

        foreach ($request->hours as $key => $date_hour)
        {
            list($fields[], $date[], $hours[]) = explode(' ', $date_hour);

            if ($key >= 1) {

                $i = $key - 1;
                list($num_hour, $zeros) = explode(':', $hours[$i]);
                $num_hour = ($num_hour < 9) ? '0'.($num_hour + 1) : $num_hour + 1;

                if ($fields[$i] != $fields[$key]) {
                    $messages['errors'][$index++] = 'Матч должен состоятся в одном поле';
                    return response()->json($messages);
                }

                if ($date[$i] != $date[$key]) {
                    $messages['errors'][$index++] = 'Матч должен состоятся в один день';
                    return response()->json($messages);
                }

                if ($num_hour.':'.$zeros != $hours[$key]) {
                    $messages['errors'][$index++] = 'Выберите время последовательно';
                    return response()->json($messages);
                }
            }
        }

        $day = $this->getDays(1, $date[0]);
        $schedules = Schedule::where('field_id', $fields[0])->where('week', (int) $day[0]['index_weekday'])->get();

        $price = 0;

        foreach ($schedules as $schedule)
        {
            foreach ($hours as $hour)
            {
                if ($schedule->start_time <= $hour AND $schedule->end_time >= $hour) {
                    $price += $schedule->price;
                }
            }
        }

        // Check balance for create match
        $price_for_each = $price / $request->number_of_players;

        if ($price_for_each > $request->user()->balance) {
            $messages['errors'][$index++] = 'У вас недостаточно денег для создания матча';
            return response()->json($messages);
        }

        // Taking from balance
        $request->user()->balance = $request->user()->balance - $price_for_each;
        $request->user()->save();


        // Segment 4 = sport slug
        // Segment 5 = area id
        $segments = explode('/', $request->headers->get('referer'));

        $area = Area::find($segments[5]);

        if (is_null($area)) {
            $messages['errors'][$index++] = 'Нет данных';
            return response()->json($messages);
        }

        $field = $area->fields()->where('id', $fields[0])->first();

        if (is_null($field)) {
            $messages['errors'][$index++] = 'Нет данных';
            return response()->json($messages);
        }

        // Check match
        $matches = $field->matches()->where('date', $date[0])->get();

        foreach ($matches as $item_match)
        {
            if ($item_match->start_time == $hours[0] OR $item_match->end_time == $hours[0] OR
                $item_match->start_time == last($hours) OR $item_match->end_time == last($hours)) {
                $messages['errors'][$index++] = 'Поле занято';
                return response()->json($messages);
            }
            elseif ($item_match->start_time >= $hours[0] AND $item_match->end_time <= last($hours)) {
                $messages['errors'][$index++] = 'Поле занято';
                return response()->json($messages);
            }
        }

        // Create match
        $match = new Match();
        $match->user_id = $request->user()->id;
        $match->field_id = $fields[0];
        $match->start_time = $hours[0];
        $match->end_time = last($hours);
        $match->date = $date[0];
        $match->match_type = $request->match_type;
        $match->number_of_players = $request->number_of_players;
        $match->price = $price;
        $match->status = 1;
        $match->save();

        // Notify Area Admin
        // event(new NotifyNewMatch($match, $segments[4]));

        // Notify All Users
        event(new CreatedNewMatch($match, $segments[4]));

        $messages['success'][$index++] = 'Ваша заявка принята для обработки';
        return response()->json($messages);
    }

    public function joinMatch(Request $request, $match_id)
    {
        $date = date('Y-m-d');
        $date_time = date('Y-m-d H:i:s');

        $match = Match::whereDate('date', '>=', $date)
            ->where('id', $request->match_id)
            ->firstOrFail();

        if ($match->users()->wherePivot('user_id', $request->user()->id)->first()) {
            $messages['errors'][0] = 'Вы уже в игре!';
            return response()->json($messages);
        }

        if ($match->users->count() > $match->number_of_players) {
            $messages['errors'][0] = 'Нет свободного места!';
            return response()->json($messages);
        }

        $price_for_each = $match->price / $match->number_of_players;

        if ($request->user()->balance < $price_for_each) {
            $messages['errors'][0] = 'У вас недостаточно денег для участья в игре';
            return response()->json($messages);
        }

        $match->users()->attach($request->user()->id);

        // Taking from balance
        $request->user()->balance = $request->user()->balance - $price_for_each;
        $request->user()->save();

        // User joined to match
        event(new JoinedToMatch($match, Auth::id()));

        event(new NotifyNewPlayer($match->id, $match->users()->count(), Auth::id(), Auth::user()->surname . ' ' . Auth::user()->name));

        $messages['success'] = 'Вы в игре!';
        $messages['csrf'] = csrf_token();
        return response()->json($messages);
    }

    public function leftMatch(Request $request, $match_id)
    {
        $date = date('Y-m-d');
        $date_time = date('Y-m-d H:i:s');

        $match = Match::whereDate('date', '>=', $date)
            ->where('id', $request->match_id)
            ->firstOrFail();

        $match->users()->detach($request->user()->id);

        $price_for_each = $match->price / $match->number_of_players;

        // Return balance
        $request->user()->balance = $request->user()->balance + $price_for_each;
        $request->user()->save();

        // User left from match
        event(new LeftMatch($match, $request->user()->id));

        event(new NotifyLeftPlayer($match->id, Auth::id()));

        $messages['success'][0] = 'Вы вышли из игры!';
        return response()->json($messages);
    }

    public function getDays($setDays, $date = '')
    {
        $days = [];
        $result = [];

        $date_min = ($date) ? $date : date("Y-m-d");
        $date_max = date("Y-m-d", strtotime($date_min." + $setDays day"));
        $start    = new \DateTime($date_min);
        $end      = new \DateTime($date_max);
        $interval = \DateInterval::createFromDateString("1 day");
        $period   = new \DatePeriod($start, $interval, $end);

        foreach($period as $dt)
        {
            $result["year"] = $dt->format("Y-m-d");
            $result["month"] = trans('data.month.'.$dt->format("m"));
            $result["day"] = $dt->format("d");
            $result["weekday"] = trans('data.week.'.$dt->format("w"));
            $result["short_weekday"] = trans('data.short_week.'.$dt->format("w"));
            $result["index_weekday"] = $dt->format("w");

            array_push($days, $result);
        }

        return $days;
    }
}
