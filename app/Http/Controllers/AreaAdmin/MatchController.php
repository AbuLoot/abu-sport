<?php

namespace App\Http\Controllers\AreaAdmin;

use Illuminate\Http\Request;

use Auth;
use Response;
use Validator;

use App\Area;
use App\Match;
use App\Events\StartedMatch;
use App\Events\CreatedNewMatch;
use App\Events\CreatedNewMatchByDate;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MatchController extends Controller
{
    protected $organization;

    public function __construct()
    {
        $this->organization = Auth::user()->organization()->first();
    }

    public function index($time = 'new-matches')
    {
        $area = Area::where('org_id', $this->organization->id)->first();

        if ($time == 'new-matches') {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->where('date', '>=', date('Y-m-d'))->where('status', 0)->get();
	        	$matches[$field->id] = $data;
	        }

	        return view('area-admin.matches.new-matches', compact('area', 'matches'));
        }
        elseif ($time == 'today') {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->where('date', '=', date('Y-m-d'))->where('status', 1)->get();
	        	$matches[$field->id] = $data;
	        }
        }
        elseif ($time == 'comming') {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->where('date', '>', date('Y-m-d'))->get();
	        	$matches[$field->id] = $data;
	        }
        }
        elseif ($time == 'past') {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->where('date', '<', date('Y-m-d'))->where('status', 1)->get();
	        	$matches[$field->id] = $data;
	        }
        }
        else {

	        foreach ($area->fields as $field)
	        {
	        	$data = Match::where('field_id', $field->id)->get();
	        	$matches[$field->id] = $data;
	        }
        }

        return view('area-admin.matches.index', compact('area', 'matches'));
    }

    public function ajaxStart($id)
    {
        list($field_id, $match_id) = explode('-', $id);
        $messages = [];
        $index = 0;

        $area = Area::where('org_id', $this->organization->id)->first();

        // Check field
        $field = $area->fields()->where('id', $field_id)->first();

        if (is_null($field)) {
            $messages['errors'][$index++] = 'Нет данных';
            return response()->json($messages);
        }

        // Start match
        $match = $field->matches()->where('id', $match_id)->first();
        $match->status = 1;
        $match->save();

        // Notify All Users
        event(new StartedMatch($match, $area->sport->slug));

        $messages['success'] = 'Матч начат!';
        return response()->json($messages);
    }

    public function start($id)
    {
        list($field_id, $match_id) = explode('-', $id);
        $messages = [];
        $index = 0;

        $area = Area::where('org_id', $this->organization->id)->first();

        // Check field
        $field = $area->fields()->where('id', $field_id)->first();

        if (is_null($field)) {
            $messages['errors'][$index++] = 'Нет данных';
            return response()->json($messages);
        }

        // Start match
        $match = $field->matches()->where('id', $match_id)->first();
        $match->status = 1;
        $match->save();

        // Notify All Users
        event(new StartedMatch($match, $area->sport->slug));

        return redirect()->back()->with('status', 'Матч начат!');
    }

    public function destroy($id)
    {
        $match = Match::find($id);
        $match->delete();

        return redirect()->back()->with('status', 'Запись удалена!');
    }
}