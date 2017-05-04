<?php

namespace App\Http\Controllers\AreaAdmin;

use Illuminate\Http\Request;

use Auth;
use Image;
use Storage;

use App\Sport;
use App\City;
use App\District;
use App\Area;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    protected $organization;

    public function __construct()
    {
        $this->organization = Auth::user()->organization()->first();
    }

    public function index()
    {
        $areas = Area::where('org_id', $this->organization->id)->get();

        return view('area-admin.areas.show', compact('organization', 'areas'));
    }

    public function edit($id)
    {
        $sports = Sport::all();
        $cities = City::orderBy('sort_id')->get();
        $districts = District::orderBy('sort_id')->get();
        $area = Area::where('id', $id)->where('org_id', $this->organization->id)->first();

        return view('area-admin.areas.edit', compact('sports', 'organization', 'cities', 'districts', 'area'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'sort_id' => 'numeric',
            'title' => 'required|min:2|max:80',
            'slug' => 'min:2|max:80',
        ]);

        $area = Area::findOrFail($id);

        if ($request->hasFile('image')) {

            if ( ! file_exists('img/organizations/'.$area->org_id)) {
                mkdir('img/organizations/'.$area->org_id);
            }

            if (file_exists('img/organizations/'.$area->org_id)) {
                Storage::delete('img/organizations/'.$area->org_id.'/'.$area->image);
            }

            $imageName = 'preview-image-'.str_random(10).'.'.$request->image->getClientOriginalExtension();
            $imagePath = 'img/organizations/'.$area->org_id.'/'.$imageName;

            $this->resizeImage($request->image, 345, 200, $imagePath, 100);
            $area->image = $imageName;
        }

        if ($request->hasFile('images')) {

            $images = unserialize($area->images);

            if ( ! file_exists('img/organizations/'.$area->org_id)) {
                mkdir('img/organizations/'.$area->org_id);
            }

            foreach ($request->file('images') as $key => $image)
            {
                if (isset($image)) {

                    $imageName = 'image-'.$key.'-'.str_random(10).'.'.$image->getClientOriginalExtension();

                    // Creating images
                    $imagePath = 'img/organizations/'.$area->org_id.'/'.$imageName;
                    $this->resizeImage($image, 800, 400, $imagePath, 100);

                    // Creating mini images
                    $imagePath = 'img/organizations/'.$area->org_id.'/mini-'.$imageName;
                    $this->resizeImage($image, 400, 200, $imagePath, 100);

                    if (isset($images[$key])) {

                        Storage::delete([
                            'img/organizations/'.$area->org_id.'/'.$images[$key]['image'],
                            'img/organizations/'.$area->org_id.'/'.$images[$key]['mini_image']
                        ]);

                        $images[$key]['image'] = $imageName;
                        $images[$key]['mini_image'] = 'mini-'.$imageName;
                    }
                    else {
                        $images[$key]['image'] = $imageName;
                        $images[$key]['mini_image'] = 'mini-'.$imageName;
                    }
                }
            }

            $images = array_sort_recursive($images);
            $area->images = serialize($images);
        }

        $area->sort_id = ($request->sort_id > 0) ? $request->sort_id : $area->count() + 1;
        $area->sport_id = $request->sport_id;
        // $area->org_id = $request->org_id;
        $area->city_id = $request->city_id;
        $area->district_id = $request->district_id;
        $area->slug = (empty($request->slug)) ? str_slug($request->title) : $request->slug;
        $area->title = $request->title;
        $area->phones = $request->phones;
        $area->emails = $request->emails;
        $area->address = $request->address;
        $area->latitude = $request->latitude;
        $area->longitude = $request->longitude;
        $area->description = $request->description;
        $area->start_time = $request->start_time;
        $area->end_time = $request->end_time;
        $area->lang = $request->lang;
        $area->status = ($request->status == 'on') ? 1 : 0;
        $area->save();

        return redirect('panel/admin-areas')->with('status', 'Запись обновлена!');
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