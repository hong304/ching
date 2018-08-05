<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

class AdminBlogController extends Controller
{

    public function showIndex()
    {
        return view('admin.blog.blog-list');
    }

    public function ajaxGetBlogData(Request $request)
    {
        $blog = Blog::select(['id', 'title', 'published', 'created_at', 'updated_at', 'slug'])->orderBy('id', 'desc');
        return Datatables::of($blog)
            ->addColumn('edit', function ($blog) {
                if ($blog->id > 631) {
                    return '<a href="' . route("adminBlog.edit", $blog->id) . '" ><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>';
                }
                return "-";
            })
            ->addColumn('delete', function ($blog) {
                if ($blog->id > 631) {
                    return '<a href="javascript:void(0);" onclick="deleteBlog(' . $blog->id . ')"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                }
                return "-";
            })
            ->addColumn('preview', function ($blog) {
                if ($blog->id > 631 && !$blog->published) {
                    return '<a href="' . route("blog_details", $blog->slug) . '" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i> Preview</a>';
                }
                return "-";
            })
            ->removeColumn('slug')
            ->editColumn('published', function ($blog) {
                if ($blog->published) {
                    return '<i class="fa fa-check text-color main" aria-hidden="true"></i>';
                }
                return '<i class="fa fa-times text-color error" aria-hidden="true"></i>';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('startDate')) {
                    $query->where('created_at', '>=', $request->get('startDate'));
                }

                if ($request->has('endDate')) {
                    $query->where('updated_at', '<=', $request->get('endDate'));
                }

                if ($request->has('published')) {
                    $query->where('published', $request->get('published'));
                }

                if ($request->has('search')) {
                    $query->where('title', 'LIKE', '%' . $request->get('search')['value'] . '%');
                }

            })
            ->make();
    }

    public function showEditBlog(Request $request)
    {
        if ($request->id <= 631) {
            return redirect()->route('adminBlog.index');
        }
        $blogCategories = BlogCategory::all();
        $blogTags = BlogTag::all();
        $blog = Blog::with('tags')->where('id', $request->id)->with('image')->first();
        $tagArr = [];
        foreach ($blog->tags as $tag) {
            array_push($tagArr, $tag->id);
        }
        $blog->tagArr = $tagArr;
        $imageCategories = array("other", "blog", "recipe", "video");
        return view('admin.blog.edit-blog', compact('blogCategories', 'blogTags', 'blog', 'imageCategories'));
    }

    public function editBlog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog_title' => 'required',
            'slug' => 'unique:blogs,slug,' . $request->blog_id,
            'blog_category' => 'required',
            'blog_image' => 'image|mimes:jpeg,png,jpg|max:1024',
            'blog_content' => 'required',
            'scheduled_hour' => 'numeric',
            'scheduled_minute' => 'numeric',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } elseif (!$request->file('blog_image') && !$request->blog_image_id) {
            return back()
                ->withErrors("Please select or upload an image.")
                ->withInput();
        } elseif (Blog::where('slug', $request->slug)->where('id', '!=', $request->blog_id)->first()){
            return back()
                ->withErrors("The slug is same with another blog, please change it.")
                ->withInput();
        } else{
            $blog = Blog::find($request->blog_id);
            $blog->slug = $request->slug;
            $blog->blog_category_id = $request->blog_category;
            $blog->published = $request->published;
            $blog->title = $request->blog_title;
            $blog->content = $request->blog_content;
            if ($request->file('blog_image')) {
                $new_image = $request->file('blog_image');
                $image_id = Image::newImageToCDN($new_image);
                if ($image_id) {
                    $blog->image_id = $image_id;
                } else {
                    return back()
                        ->withErrors("Image Upload Failed, please upload again.")
                        ->withInput();
                }
            } else {
                $blog->image_id = $request->blog_image_id;
            }
            if ($request->scheduled_date) {
                $publishTime = new \DateTime($request->scheduled_date);
                $publishHour = ($request->scheduled_hour) ? $request->scheduled_hour : 0;
                $publishMinute = ($request->scheduled_minute) ? $request->scheduled_minute : 0;
                $blog->publish_at = $publishTime->setTime($publishHour, $publishMinute, 0);
            } else {
                $blog->publish_at = null;
            }
            $blog->save();
            $blog->tags()->detach();
            if ($request->blog_tags) {
                foreach ($request->blog_tags as $tag) {
                    if (ctype_digit(strval($tag))) {
                        $blog->tags()->attach($tag);
                    } else {
                        $newBlogTag = new BlogTag();
                        $newBlogTag->name = $tag;
                        $newBlogTag->save();

                        $blog->tags()->attach($newBlogTag->id);
                    }
                }
            }
        }

        return redirect()
            ->route('adminBlog.index')
            ->with('message', 'Blog is edited')
            ->with('status', 'success');
    }

    public function showCreateBlog(Request $request)
    {
        $blogCategories = BlogCategory::all();
        $blogTags = BlogTag::all();

        $imageCategories = array("other", "blog", "recipe", "video");

        return view('admin.blog.create-blog', compact('blogCategories', 'blogTags', 'imageCategories'));
    }

    public function createBlog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog_title' => 'required',
            'slug' => 'unique:blogs,slug',
            'blog_category' => 'required',
            'blog_image' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
            'blog_content' => 'required',
            'scheduled_hour' => 'numeric',
            'scheduled_minute' => 'numeric',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        } elseif (!$request->file('blog_image') && !$request->blog_image_id) {
            return back()
                ->withErrors("Please select or upload an image.")
                ->withInput();
        } elseif (Blog::findBySlug($request)){
            return back()
                ->withErrors("The slug is same with another blog, please change it.")
                ->withInput();
        } else{
            $blog = new Blog();
            if (isset($request->id)) {
                $blog = Blog::where('id', $request->id);
            }
            $blog->slug = $request->slug;
            $blog->blog_category_id = $request->blog_category;
            $blog->published = $request->published;
            $blog->title = $request->blog_title;
            $blog->content = $request->blog_content;
            if ($request->blog_image) {
                $new_image = $request->file('blog_image');
                $image_id = Image::newImageToCDN($new_image);
                if ($image_id) {
                    $blog->image_id = $image_id;
                } else {
                    return back()
                        ->withErrors("Image Upload Failed, please upload again.")
                        ->withInput();
                }
            } else {
                $blog->image_id = $request->blog_image_id;
            }

            if(!$request->published && $request->scheduled_date){
                $publishTime = new \DateTime($request->scheduled_date);
                $publishHour = ($request->scheduled_hour) ? $request->scheduled_hour : 0;
                $publishMinute = ($request->scheduled_minute) ? $request->scheduled_minute : 0;
                $blog->publish_at = $publishTime->setTime($publishHour, $publishMinute, 0);
            }

            $blog->save();
            if ($request->blog_tags) {
                foreach ($request->blog_tags as $tag) {
                    if (ctype_digit(strval($tag))) {
                        $blog->tags()->attach($tag);
                    } else {
                        $newBlogTag = new BlogTag();
                        $newBlogTag->name = $tag;
                        $newBlogTag->save();

                        $blog->tags()->attach($newBlogTag->id);
                    }
                }
            }
        }

        return redirect()
            ->route('adminBlog.index')
            ->with('message', 'Blog is created.')
            ->with('status', 'success');
    }

    public function deleteBlog(Request $request)
    {
        Blog::destroy($request->id);

        return redirect()
            ->route('adminBlog.index')
            ->with('message', 'Blog with id ' . $request->id . ' is deleted.')
            ->with(('status'), 'success');
    }

}

;