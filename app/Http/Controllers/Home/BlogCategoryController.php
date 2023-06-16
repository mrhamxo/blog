<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function allBlogCategory()
    {
        $blogCategory = BlogCategory::latest()->get();
        return view('admin.blog_category.blog_category_all', compact('blogCategory'));
    }
    public function addBlogCategory()
    {
        return view('admin.blog_category.blog_category_add');
    }
    public function storeBlogCategory(Request $request)
    {
        // $request->validate([
        //     'blog_category' => 'required'
        // ],[
        //     'blog_category.required' => 'Blog Category Name is Required'
        // ]);

        BlogCategory::insert([
            'blog_category' => $request->blog_category,
        ]);

        $toasterNotification = array(
            'message' => 'Blog Category Name Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($toasterNotification);
    }
    public function editBlogCategory($id)
    {
        $editBlogCategory = BlogCategory::findOrFail($id);
        return view('admin.blog_category.blog_category_edit', compact('editBlogCategory'));
    }
    public function updateBlogCategory(Request $request, $id)
    {
        // $blog_id = $request->id;

        BlogCategory::findOrFail($id)->update([
            'blog_category' => $request->blog_category,
        ]);

        $toasterNotification = array(
            'message' => 'Blog Category Name Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog.category')->with($toasterNotification);
    }
    public function deleteBlogCategory( $id)
    {
        BlogCategory::findOrFail($id)->delete();

        $toasterNotification = array(
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($toasterNotification);
    }
}
