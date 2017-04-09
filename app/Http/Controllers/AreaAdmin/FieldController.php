<?php

namespace App\Http\Controllers\AreaAdmin;

use Illuminate\Http\Request;

use Auth;

use App\Area;
use App\Field;
use App\Option;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class FieldController extends Controller
{
    protected $organization;

    public function __construct()
    {
        $this->organization = Auth::user()->organization()->first();
    }

    public function index()
    {
        $area = Area::where('org_id', $this->organization->id)->first();

        return view('area-admin.fields.index', compact('area'));
    }

    public function create()
    {
        $areas = Area::where('org_id', $this->organization->id)->get();
        $options = Option::all();

        return view('area-admin.fields.create', compact('areas', 'options'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
        	'area_id' => 'required|numeric',
            'title' => 'required|max:60',
        ]);

        // Creating gallery images
        if ($request->hasFile('images')) {

            $images = [];

            if ( ! file_exists('img/organizations/'.$request->org_id)) {
                mkdir('img/organizations/'.$request->org_id);
            }

            foreach ($request->file('images') as $key => $image)
            {
                if (isset($image)) {

                    $imageName = 'image-'.$key.'-'.str_random(10).'.'.$image->getClientOriginalExtension();

                    // Creating images
                    $imagePath = 'img/organizations/'.$request->org_id.'/'.$imageName;
                    $this->resizeImage($image, 800, 400, $imagePath, 100);

                    // Creating mini images
                    $imagePath = 'img/organizations/'.$request->org_id.'/mini-'.$imageName;
                    $this->resizeImage($image, 400, 200, $imagePath, 100);

                    $images[$key]['image'] = $imageName;
                    $images[$key]['mini_image'] = 'mini-'.$imageName;
                }
            }

            $area->images = serialize($images);
        }

        $field = new Field;
        $field->sort_id = ($request->sort_id > 0) ? $request->sort_id : $field->count() + 1;
        $field->area_id = $request->area_id;
        $field->title = $request->title;
        $field->size = $request->size;
        $field->status = ($request->status == 'on') ? 1 : 0;
        $field->save();

        $field->options()->attach($request->options_id);

        return redirect('panel/admin-fields')->with('status', 'Запись добавлена!');
    }

    public function edit($id)
    {
        $areas = Area::where('org_id', $this->organization->id)->get();
        $field = Field::findOrFail($id);
        $options = Option::all();

        return view('area-admin.fields.edit', compact('areas', 'field', 'options'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
        	'area_id' => 'required|numeric',
            'title' => 'required|max:60',
        ]);

        $field = Field::findOrFail($id);
        $field->sort_id = ($request->sort_id > 0) ? $request->sort_id : $field->count() + 1;
        $field->area_id = $request->area_id;
        $field->title = $request->title;
        $field->size = $request->size;
        $field->status = ($request->status == 'on') ? 1 : 0;
        $field->save();

        $field->options()->sync($request->options_id);

        return redirect('panel/admin-fields')->with('status', 'Запись обновлена!');
    }

    public function destroy($id)
    {
        $field = Field::findOrFail($id);
        $field->delete();

        return redirect('panel/admin-fields')->with('status', 'Запись удалена!');
    }

    public function resizeImage($image, $width, $height, $path, $quality, $color = '#ffffff')
    {
        $frame = Image::canvas($width, $height, $color);
        $newImage = Image::make($image);

        if ($newImage->width() <= $newImage->height()) {
            $newImage->resize(null, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        else {
            $newImage->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        if ($newImage->width() > $width OR $newImage->height() > $height) {
            $newImage->crop($width, $height);
        }

        $frame->insert($newImage, 'center');
        $frame->save($path, $quality);
    }

    public function cropImage($image, $width, $height, $path, $quality)
    {
        $newImage = Image::make($image);

        if ($newImage->width() > $width OR $newImage->height() > $height) {
            $newImage->crop($width, $height);
        }

        $newImage->save($path, $quality);
    }
}