<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Option;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::orderBy('sort_id')->get();

        return view('admin.options.index', compact('options'));
    }

    public function create()
    {
        return view('admin.options.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:60|unique:options',
        ]);

        $option = new Option;

        $option->sort_id = ($request->sort_id > 0) ? $request->sort_id : $option->count() + 1;
        $option->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $option->title = $request->title;
        $option->lang = $request->lang;
        $option->save();

        return redirect('/admin/options')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $option = Option::findOrFail($id);

        return view('admin.options.edit', compact('option'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:60',
        ]);

        $option = Option::findOrFail($id);
        $option->sort_id = ($request->sort_id > 0) ? $request->sort_id : $option->count() + 1;
        $option->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $option->title = $request->title;
        $option->lang = $request->lang;
        $option->save();

        return redirect('/admin/options')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $option = Option::find($id);
        $option->delete();

        return redirect('/admin/options')->with('status', 'Запись удалена!');
    }
}
