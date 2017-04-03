<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Validator;

use App\Sport;
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

class MatchController extends Controller
{
    public function getMatch($sport_slug, $area_id, $match_id)
    {
        $sport = Sport::where('slug', $sport_slug)->firstOrFail();
        $match = Match::findOrFail($match_id);

        return view('match.match', compact('sport', 'match'));
    }

    public function getChat($sport_slug, $area_id, $match_id)
    {
        $sport = Sport::where('slug', $sport_slug)->firstOrFail();
        $match = Match::findOrFail($match_id);

        return view('match.match-chat', compact('sport', 'match'));
    }

    public function createMatch($setDays = 3)
    {
        $sports = Sport::all();
        $areas = Area::all();
        $active_area = Area::firstOrFail();

        // Get days
        $days = $this->getDays($setDays);

        return view('match.create-match', compact('sports', 'areas', 'days', 'active_area'));
    }

    public function createMatchInArea($sport_slug, $area_id, $setDays = 3)
    {
        $sport = Sport::where('slug', $sport_slug)->firstOrFail();
        $area = $sport->areas()->where('id', $area_id)->firstOrFail();

        // Get days
        $days = $this->getDays($setDays);

        return view('match.create-match-in-area', compact('sport', 'days', 'area'));
    }

    public function storeMatch(Request $request)
    {
        $this->validate($request, [
            'number_of_players' => 'required|numeric',
            'hours' => 'required',
        ]);

        foreach ($request->hours as $key => $date_hour)
        {
            list($fields[], $date[], $hours[]) = explode(' ', $date_hour);

            if ($key >= 1) {

                $i = $key - 1;
                list($num_hour, $zeros) = explode(':', $hours[$i]);
                $num_hour = ($num_hour < 9) ? '0'.($num_hour + 1) : $num_hour + 1;

                if ($fields[$i] != $fields[$key]) {
                    return redirect()->back()->withInput()->withWarning('Матч должен состоятся в одном поле');
                }

                if ($date[$i] != $date[$key]) {
                    return redirect()->back()->withInput()->withWarning('Матч должен состоятся в один день');
                }

                if ($num_hour.':'.$zeros != $hours[$key]) {
                    return redirect()->back()->withInput()->withWarning('Выберите время последовательно');
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
            return redirect()->back()->withInput()->withWarning('У вас недостаточно денег для создания матча');
        }

        // Segment 4 = sport slug
        // Segment 5 = area id
        $segments = explode('/', $request->headers->get('referer'));

        // Check area
        $area = Area::find($segments[5]);

        if (is_null($area)) {
            return redirect()->back()->withInput()->withWarning('Нет данных');
        }

        // Check field
        $field = $area->fields()->where('id', $fields[0])->first();

        if (is_null($field)) {
            return redirect()->back()->withInput()->withWarning('Нет данных');
        }

        // Check for the existence of the match
        $matches = $field->matches()->where('date', $date[0])->get();

        foreach ($matches as $item_match)
        {
            if ($item_match->start_time == $hours[0] OR $item_match->end_time == $hours[0] OR
                $item_match->start_time == last($hours) OR $item_match->end_time == last($hours)) {
                return redirect()->back()->withInput()->withWarning('Поле занято');
            }
            elseif ($item_match->start_time >= $hours[0] AND $item_match->end_time <= last($hours)) {
                return redirect()->back()->withInput()->withWarning('Поле занято');
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
        $match->status = 0;
        $match->save();

        // Notify Area Admin
        event(new NotifyNewMatch($match));

        // Notify All Users
        event(new CreatedNewMatch($match));

        return redirect()->back()->with('status', 'Запись добавлена!');
    }

    public function joinMatch(Request $request, $match_id)
    {
        $date = date('Y-m-d');
        $date_time = date('Y-m-d H:i:s');

        $match = Match::whereDate('date', '>=', $date)
            ->where('id', $request->match_id)
            ->firstOrFail();

        if ($match->users()->wherePivot('user_id', $request->user()->id)->first()) {
            return redirect()->back()->with('status', 'Вы уже в игре!');
        }

        if ($match->users->count() > $match->number_of_players) {
            return redirect()->back()->with('status', 'Нет свободного места!');
        }

        $price_for_each = $match->price / $match->number_of_players;

        if ($request->user()->balance < $price_for_each) {
            return redirect()->back()->with('status', 'У вас недостаточно денег для участья в игре');
        }

        $match->users()->attach($request->user()->id);

        // Taking from balance
        $request->user()->balance = $request->user()->balance - $price_for_each;
        $request->user()->save();

        // User joined to match
        event(new JoinedToMatch($match, Auth::id()));

        event(new NotifyNewPlayer($match->id, $match->users()->count(), Auth::id(), Auth::user()->surname . ' ' . Auth::user()->name));

        return redirect()->back()->with('status', 'Вы в игре!');
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

        return redirect()->back()->with('info', 'Вы вышли из игры!');
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
