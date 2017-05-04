<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Storage;

use App\Sport;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SportController extends Controller
{
    public function index()
    {
        $sports = Sport::orderBy('sort_id')->get();

        return view('admin.sports.index', compact('sports'));
    }

    public function create()
    {
        return view('admin.sports.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'sort_id' => 'numeric',
            'title' => 'required|min:2|max:80',
            'slug' => 'min:2|max:80',
        ]);

        $sport = new Sport;

        if ($request->hasFile('image')) {

        	$request->file('image')->move('img/sport', $request->image->getClientOriginalName());

        	$sport->image = $request->image->getClientOriginalName();
        }

        $sport->sort_id = ($request->sort_id > 0) ? $request->sort_id : $sport->count() + 1;
        $sport->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $sport->title = $request->title;
        $sport->title_description = $request->title_description;
        $sport->meta_description = $request->meta_description;
        $sport->content = $request->content;
        $sport->rules = $request->rules;
        $sport->lang = $request->lang;
        $sport->status = ($request->status == 'on') ? 1 : 0;
        $sport->save();

        return redirect('/admin/sports')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $sport = Sport::findOrFail($id);

        return view('admin.sports.edit', compact('sport'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sort_id' => 'numeric',
            'title' => 'required|min:2|max:80',
            'slug' => 'min:2|max:80',
        ]);

        $sport = Sport::findOrFail($id);

        if ($request->hasFile('image')) {

        	$request->file('image')->move('img/sport', $request->image->getClientOriginalName());

        	$sport->image = $request->image->getClientOriginalName();

	        if (file_exists('img/sport/'.$sport->image)) {
	        	Storage::delete('img/sport/'.$sport->image);
	        }
        }

        $sport->sort_id = ($request->sort_id > 0) ? $request->sort_id : $sport->count() + 1;
        $sport->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $sport->title = $request->title;
        $sport->title_description = $request->title_description;
        $sport->meta_description = $request->meta_description;
        $sport->content = $request->content;
        $sport->rules = $request->rules;
        $sport->lang = $request->lang;
        $sport->status = ($request->status == 'on') ? 1 : 0;
        $sport->save();

        return redirect('/admin/sports')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $sport = Sport::find($id);

        if (file_exists('img/sport/'.$sport->image)) {
            Storage::delete('img/sport/'.$sport->image);
        }

        $sport->delete();

        return redirect('/admin/sports')->with('status', 'Запись удалена!');
    }
}