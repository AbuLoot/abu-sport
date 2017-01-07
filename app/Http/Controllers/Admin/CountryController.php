<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Country;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('sort_id')->get();

        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:60|unique:countries',
        ]);

        $country = new Country;

        $country->sort_id = ($request->sort_id > 0) ? $request->sort_id : $country->count() + 1;
        $country->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $country->title = $request->title;
        $country->lang = $request->lang;
        $country->status = ($request->status == 'on') ? 1 : 0;
        $country->save();

        return redirect('/admin/countries')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);

        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:5|max:60',
        ]);

        $country = Country::findOrFail($id);
        $country->sort_id = ($request->sort_id > 0) ? $request->sort_id : $country->count() + 1;
        $country->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $country->title = $request->title;
        $country->lang = $request->lang;
		$country->status = ($request->status == 'on') ? 1 : 0;
        $country->save();

        return redirect('/admin/countries')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();

        return redirect('/admin/countries')->with('status', 'Запись удалена!');
    }
}
