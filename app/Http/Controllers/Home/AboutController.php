<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\MultiImage;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Image;

class AboutController extends Controller
{
    public function aboutPage()
    {
        $aboutPage = About::find(1);
        return view('admin.about.about_page_all', compact('aboutPage'));
    }
    public function updateAbout(Request $request)
    {
        $about_id = $request->id;

        if ($request->file('about_image')) {
            $image = $request->file('about_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(523, 605)->save('upload/home_about/' . $name_gen);
            $save_url = 'upload/home_about/' . $name_gen;

            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'about_image' => $save_url,
            ]);

            $toasterNotification = array(
                'message' => 'About Page Updated with Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($toasterNotification);
        } else {
            About::findOrFail($about_id)->update([
                'title' => $request->title,
                'short_title' => $request->short_title,
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
            ]);

            $toasterNotification = array(
                'message' => 'About Page Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($toasterNotification);
        }
    }
    public function homeAbout()
    {
        $aboutPage = About::find(1);
        return view('frontend.about_page', compact('aboutPage'));
    }
    public function aboutMultiImage()
    {
        return view('admin.about.multi_image');
    }
    public function storeMultiImage(Request $request)
    {

        $image = $request->file('multi_image');

        foreach ($image as $multi_image) {
            $name_gen = hexdec(uniqid()) . '.' . $multi_image->getClientOriginalExtension();

            Image::make($multi_image)->resize(220, 220)->save('upload/multi_images/' . $name_gen);
            $save_url = 'upload/multi_images/' . $name_gen;

            MultiImage::insert([
                'multi_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);
        }

        $toasterNotification = array(
            'message' => 'Multi Image Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.multi.image')->with($toasterNotification);
    }
    public function allMultiImage()
    {
        $allMultiImage = MultiImage::all();
        return view('admin.about.all_multi_image', compact('allMultiImage'));
    }
    public function EditMultiImage($id)
    {
        $editMultiImage = MultiImage::findOrFail($id);
        return view('admin.about.edit_multi_image', compact('editMultiImage'));
    }
    public function updateMultiImage(Request $request)
    {
        $multi_image_id = $request->id;

        if ($request->file('multi_image')) {
            $image = $request->file('multi_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(220, 220)->save('upload/multi_images/' . $name_gen);
            $save_url = 'upload/multi_images/' . $name_gen;

            MultiImage::findOrFail($multi_image_id)->update([
                'multi_image' => $save_url,
            ]);

            $toasterNotification = array(
                'message' => 'Multi Images Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.multi.image')->with($toasterNotification);
        }
    }
    public function DeleteMultiImage($id)
    {
        // first method to delete image
        $deleteMultiImage = MultiImage::findOrFail($id);
        $img = $deleteMultiImage->multi_image;
        unlink($img);

        MultiImage::findOrFail($id)->delete();

        // 2nd method to delete image
        // $deleteMultiImage = MultiImage::findOrFail($id);

        // $deleteMultiImage->delete();

        $toasterNotification = array(
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($toasterNotification);

    }
}
