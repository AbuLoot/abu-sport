<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Storage;

use App\Country;
use App\City;
use App\District;
use App\OrgType;
use App\Organization;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::orderBy('sort_id')->get();

        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        $org_types = OrgType::all();
        $countries = Country::orderBy('sort_id')->get();
        $cities = City::orderBy('sort_id')->get();
        $districts = District::orderBy('sort_id')->get();

        return view('admin.organizations.create', compact('org_types', 'countries', 'cities', 'districts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'sort_id' => 'numeric',
            'title' => 'required|min:2|max:80',
            'slug' => 'min:2|max:80',
        ]);

        $organization = new Organization;

        if ($request->hasFile('image')) {

            $request->file('image')->move('img/organizations', $request->image->getClientOriginalName());

            $organization->logo = $request->image->getClientOriginalName();
        }

        $organization->sort_id = ($request->sort_id > 0) ? $request->sort_id : $organization->count() + 1;
        $organization->country_id = $request->country_id;
        $organization->city_id = $request->city_id;
        $organization->district_id = $request->district_id;
        $organization->org_type_id = $request->org_type_id;
        $organization->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $organization->title = $request->title;
        $organization->phones = $request->phones;
        $organization->website = $request->website;
        $organization->emails = $request->emails;
        $organization->address = $request->address;
        $organization->latitude = $request->latitude;
        $organization->longitude = $request->longitude;
        $organization->balance = $request->balance?$request->balance:0;
        $organization->lang = $request->lang;
        $organization->status = ($request->status == 'on') ? 1 : 0;
        $organization->save();

        return redirect('/admin/organizations')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $org_types = OrgType::all();
        $countries = Country::orderBy('sort_id')->get();
        $cities = City::orderBy('sort_id')->get();
        $districts = District::orderBy('sort_id')->get();
        $organization = Organization::findOrFail($id);

        return view('admin.organizations.edit', compact('org_types', 'countries', 'cities', 'districts', 'organization'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sort_id' => 'numeric',
            'title' => 'required|min:2|max:80',
            'slug' => 'min:2|max:80',
        ]);

        $organization = Organization::findOrFail($id);

        if ($request->hasFile('image')) {

            $request->file('image')->move('img/organizations', $request->image->getClientOriginalName());

            $organization->image = $request->image->getClientOriginalName();

            if (file_exists('img/organizations/'.$organization->image)) {
                Storage::delete('img/organizations/'.$organization->image);
            }
        }

        $organization->sort_id = ($request->sort_id > 0) ? $request->sort_id : $organization->count() + 1;
        $organization->country_id = $request->country_id;
        $organization->city_id = $request->city_id;
        $organization->district_id = $request->district_id;
        $organization->org_type_id = $request->org_type_id;
        $organization->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $organization->title = $request->title;
        $organization->phones = $request->phones;
        $organization->website = $request->website;
        $organization->emails = $request->emails;
        $organization->address = $request->address;
        $organization->latitude = $request->latitude;
        $organization->longitude = $request->longitude;
        $organization->balance = $request->balance;
        $organization->lang = $request->lang;
        $organization->status = ($request->status == 'on') ? 1 : 0;
        $organization->save();

        return redirect('/admin/organizations')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $organization = Organization::find($id);

        if (file_exists('img/organizations/'.$organization->image)) {
            Storage::delete('img/organizations/'.$organization->image);
        }

        $organization->delete();

        return redirect('/admin/organizations')->with('status', 'Запись удалена!');
    }
}
