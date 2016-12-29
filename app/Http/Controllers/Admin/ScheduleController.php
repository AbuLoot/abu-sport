<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Area;
use App\Schedule;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index()
    {
    	$schedules = Schedule::all();
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
    	$areas = Area::all();

        return view('admin.schedules.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'field_id' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $schedule = new Schedule;
        $schedule->sort_id = ($request->sort_id > 0) ? $request->sort_id : $schedule->count() + 1;
        $schedule->field_id = $request->field_id;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->date = $request->date;
        $schedule->week = $request->week;
        $schedule->price = $request->price;
        $schedule->status = ($request->status == 'on') ? 1 : 0;
        $schedule->save();

        return redirect('/admin/schedules')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
    	$areas = Area::all();
        $schedule = Schedule::findOrFail($id);

        return view('admin.schedules.edit', compact('schedule', 'areas'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'field_id' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->sort_id = ($request->sort_id > 0) ? $request->sort_id : $schedule->count() + 1;
        $schedule->field_id = $request->field_id;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        $schedule->date = $request->date;
        $schedule->week = $request->week;
        $schedule->price = $request->price;
        $schedule->status = ($request->status == 'on') ? 1 : 0;
        $schedule->save();

        return redirect('/admin/schedules')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $schedule = Schedule::find($id);
        $schedule->delete();

        return redirect('/admin/schedules')->with('status', 'Запись удалена!');
    }
}