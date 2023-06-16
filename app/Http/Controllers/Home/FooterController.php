<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function footerSetup()
    {
        $allFooter = Footer::find(1);
        return view('admin.footer.footer_view', compact('allFooter'));
    }
    public function updateFooter(Request $request)
    { {
            $footer_id = $request->id;

            Footer::findOrFail($footer_id)->update([
                'number' => $request->number,
                'short_description' => $request->short_description,
                'address' => $request->address,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'linkedin' => $request->linkedin,
                'twitter' => $request->twitter,
                'copyright' => $request->copyright,
            ]);

            $toasterNotification = array(
                'message' => 'Footer Page Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($toasterNotification);
        }
    }
}
