<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\City;
use App\District;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::orderBy('sort_id')->get();

        return view('admin.districts.index', compact('districts'));
    }

    public function create()
    {
        $cities = City::orderBy('sort_id')->get();

        return view('admin.districts.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:60|unique:districts',
        ]);

        $district = new District;

        $district->sort_id = ($request->sort_id > 0) ? $request->sort_id : $district->count() + 1;
        $district->city_id = $request->city_id;
        $district->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $district->title = $request->title;
        $district->lang = $request->lang;
        $district->save();

        return redirect('/admin/districts')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
    	$cities = City::orderBy('sort_id')->get();
        $district = District::findOrFail($id);

        return view('admin.districts.edit', compact('cities', 'district'));
    }

    public function update(Request $request, $id)
    {    	
        $this->validate($request, [
            'title' => 'required|min:5|max:60',
        ]);

        $district = District::findOrFail($id);
        $district->sort_id = ($request->sort_id > 0) ? $request->sort_id : $district->count() + 1;
        $district->city_id = $request->city_id;
        $district->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $district->title = $request->title;
        $district->lang = $request->lang;
        $district->save();

        return redirect('/admin/districts')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $district = District::find($id);
        $district->delete();

        return redirect('/admin/districts')->with('status', 'Запись удалена!');
    }
}
