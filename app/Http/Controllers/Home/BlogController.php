<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    public function allBlog()
    {
        $allBlog = Blog::latest()->get();
        return view('admin.blogs.blogs_all', compact('allBlog'));
    }
    public function addBlog()
    {
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('admin.blogs.blogs_add', compact('categories'));
    }
    public function storeBlog(Request $request)
    {
        $image = $request->file('blog_image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(430, 327)->save('upload/blog/' . $name_gen);
        $save_url = 'upload/blog/' . $name_gen;

        Blog::insert([
            'blog_category_id' => $request->blog_category_id,
            'blog_title' => $request->blog_title,
            'blog_tags' => $request->blog_tags,
            'blog_description' => $request->blog_description,
            'blog_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $toasterNotification = array(
            'message' => 'Blog Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.blog')->with($toasterNotification);
    }
    public function editBlog($id)
    {
        $editBlog = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('admin.blogs.blogs_edit', compact('editBlog', 'categories'));
    }
    public function updateBlog(Request $request)
    {
        $blog_id = $request->id;

        if ($request->file('blog_image')) {
            $image = $request->file('blog_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(430, 327)->save('upload/blog/' . $name_gen);
            $save_url = 'upload/blog/' . $name_gen;

            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
                'blog_image' => $save_url,
            ]);

            $toasterNotification = array(
                'message' => 'Blog Updated with Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog')->with($toasterNotification);
        } else {
            Blog::findOrFail($blog_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'blog_title' => $request->blog_title,
                'blog_tags' => $request->blog_tags,
                'blog_description' => $request->blog_description,
            ]);

            $toasterNotification = array(
                'message' => 'Blog Updated without Image Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('all.blog')->with($toasterNotification);
        }
    }
    public function deleteBlog($id)
    {
        $deleteBlog = Blog::findOrFail($id);
        $img = $deleteBlog->blog_image;
        unlink($img);

        Blog::findOrFail($id)->delete();

        $toasterNotification = array(
            'message' => 'Blog Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($toasterNotification);
    }
    public function blogDetails($id)
    {
        $allBlogs = Blog::latest()->limit(5)->get();
        $blogDetails = Blog::findOrFail($id);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('frontend.blog_details', compact('blogDetails', 'allBlogs', 'categories'));
    }
    public function categoryBlog($id)
    {
        $blogPost = Blog::where('blog_category_id', $id)->orderBy('id', 'DESC')->get();
        $allBlogs = Blog::latest()->limit(5)->get();
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        $categoryName = BlogCategory::findOrFail($id);
        return view('frontend.cat_blog_details', compact('blogPost', 'allBlogs', 'categories', 'categoryName'));
    }
    public function homeBlog()
    {
        $allBlogs = Blog::latest()->paginate(2);
        $categories = BlogCategory::orderBy('blog_category', 'ASC')->get();
        return view('frontend.blog', compact('allBlogs', 'categories'));
    }
}
