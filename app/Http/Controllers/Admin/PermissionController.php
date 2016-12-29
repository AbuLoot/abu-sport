<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Role;
use App\Permission;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function index()
    {
    	$permissions = Permission::all();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:60|unique:permissions',
        ]);

        $permission = new Permission;
        $permission->title = $request->title;
        $permission->label = $request->label;
        $permission->save();

        return redirect('/admin/permissions')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:60',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->title = $request->title;
        $permission->label = $request->label;
        $permission->save();

        return redirect('/admin/permissions')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect('/admin/permissions')->with('status', 'Запись удалена!');
    }
}