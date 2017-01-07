<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Page;
use App\Http\Requests;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('sort_id')->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(PageRequest $request)
    {
        $page = new Page;

        $page->sort_id = ($request->sort_id > 0) ? $request->sort_id : $page->count() + 1;
        $page->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $page->title = $request->title;
        $page->title_description = $request->title_description;
        $page->meta_description = $request->meta_description;
        $page->content = $request->content;
        $page->lang = $request->lang;
        $page->status = ($request->status == 'on') ? 1 : 0;
        $page->save();

        return redirect('/admin/pages')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $page = Page::findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->sort_id = ($request->sort_id > 0) ? $request->sort_id : $page->count() + 1;
        $page->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $page->title = $request->title;
        $page->title_description = $request->title_description;
        $page->meta_description = $request->meta_description;
        $page->content = $request->content;
        $page->lang = $request->lang;
        $page->status = ($request->status == 'on') ? 1 : 0;
        $page->save();

        return redirect('/admin/pages')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $page = Page::find($id);
        $page->delete();

        return redirect('/admin/pages')->with('status', 'Запись удалена!');
    }
}
