<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\OrgType;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrgTypeController extends Controller
{
    public function index()
    {
        $org_types = OrgType::orderBy('sort_id')->get();

        return view('admin.org_types.index', compact('org_types'));
    }

    public function create()
    {
        return view('admin.org_types.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:60|unique:org_types',
        ]);

        $org_type = new OrgType;
        $org_type->sort_id = ($request->sort_id > 0) ? $request->sort_id : $org_type->count() + 1;
        $org_type->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $org_type->title = $request->title;
        $org_type->short_title = $request->short_title;
        $org_type->lang = $request->lang;
        // $org_type->status = ($request->status == 'on') ? 1 : 0;
        $org_type->save();

        return redirect('/admin/org_types')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $org_type = OrgType::findOrFail($id);

        return view('admin.org_types.edit', compact('org_type'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:60',
        ]);

        $org_type = OrgType::findOrFail($id);
        $org_type->sort_id = ($request->sort_id > 0) ? $request->sort_id : $org_type->count() + 1;
        $org_type->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $org_type->title = $request->title;
        $org_type->short_title = $request->short_title;
        $org_type->lang = $request->lang;
        // $org_type->status = ($request->status == 'on') ? 1 : 0;
        $org_type->save();

        return redirect('/admin/org_types')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $org_type = OrgType::find($id);
        $org_type->delete();

        return redirect('/admin/org_types')->with('status', 'Запись удалена!');
    }
}
