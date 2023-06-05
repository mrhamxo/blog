<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;

class PortfolioController extends Controller
{
    public function allPortfolio()
    {
        // $allPortfolio = Portfolio::all();
        $allPortfolio = Portfolio::latest()->get();
        return view('admin.porfolio.portfolio_view', compact('allPortfolio'));
    }
    public function addPortfolio()
    {
        $addPortfolio = Portfolio::find(1);
        return view('admin.porfolio.portfolio_add', compact('addPortfolio'));
    }
    public function storePortfolio(Request $request)
    {
        $request->validate(
            [
                'portfolio_name' => 'required',
                'portfolio_title' => 'required',
                'portfolio_image' => 'required',
            ],
            [
                'portfolio_name.required' => 'Portfolio Name is Required',
                'portfolio_title.required' => 'Portfolio Title is Required',
            ]
        );
        $image = $request->file('portfolio_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(1020, 519)->save('upload/portfolio/' . $name_gen);
        $save_url = 'upload/portfolio/' . $name_gen;

        Portfolio::insert([
            'portfolio_name' => $request->portfolio_name,
            'portfolio_title' => $request->portfolio_title,
            'portfolio_description' => $request->portfolio_description,
            'portfolio_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $toasterNotification = array(
            'message' => 'Portfolio Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.portfolio')->with($toasterNotification);
    }
    public function editPortfolio($id)
    {
        $editPortfolio = Portfolio::findOrFail($id);
        return view('admin.porfolio.portfolio_edit', compact('editPortfolio'));
    }
    public function updatePortfolio(Request $request)
    {
        $portfolio_id = $request->id;

        if ($request->file('portfolio_image')) {
            $image = $request->file('portfolio_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::make($image)->resize(1020, 519)->save('upload/portfolio/'.$name_gen);
            $save_url = 'upload/portfolio/'.$name_gen;

            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
                'portfolio_image' => $save_url,
            ]);

            $toasterNotification = array(
                'message' => 'Portfolio Updated with Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portfolio')->with($toasterNotification);
        } else {
            Portfolio::findOrFail($portfolio_id)->update([
                'portfolio_name' => $request->portfolio_name,
                'portfolio_title' => $request->portfolio_title,
                'portfolio_description' => $request->portfolio_description,
            ]);

            $toasterNotification = array(
                'message' => 'Portfolio Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.portfolio')->with($toasterNotification);
        }
    }
    public function deletePortfolio($id){
        // first method to delete portfolio image
        $deletePortfolio = Portfolio::findOrFail($id);
        $img = $deletePortfolio->portfolio_image;
        unlink($img);

        Portfolio::findOrFail($id)->delete();

        // 2nd method to delete portfolio image
        // $deletePortfolio = Portfolio::findOrFail($id);

        // $deletePortfolio->delete();

        $toasterNotification = array(
            'message' => 'portfolio Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($toasterNotification);

    }
    public function portfolioDetails($id)
    {
        $portfolioDetails = Portfolio::findOrFail($id);
        return view('frontend.portfolio_details', compact('portfolioDetails'));
    }
}
