<?php

namespace App\Http\Controllers\AreaAdmin;

use Illuminate\Http\Request;

use Auth;
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
        $organization = Auth::user()->organization()->first();

        return view('area-admin.organization.show', compact('organization'));
    }

    public function edit($id)
    {
        $countries = Country::orderBy('sort_id')->get();
        $cities = City::orderBy('sort_id')->get();
        $districts = District::orderBy('sort_id')->get();
        $org_types = OrgType::all();
        $organization = Auth::user()->organization()->first();

        return view('area-admin.organization.edit', compact('org_types', 'countries', 'cities', 'districts', 'organization'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sort_id' => 'numeric',
            'title' => 'required|min:2|max:80',
            'slug' => 'min:2|max:80',
        ]);

        $organization = Auth::user()->organization()->first();

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

        return redirect('panel/admin-organization')->with('status', 'Запись обновлена!');
    }
}
