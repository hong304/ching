<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class BlogController extends Controller
{
	public function showIndex(Request $request)
	{
		
		if ($request->slug) {
			$blog = Blog::queryBySlug($request->slug)->with('comments');
			if (Auth::check() && !Auth::user()->admin) {
				$blog = $blog->where('published', true);
				
			}
			$blog = $blog->firstOrFail();
			$blog_comments = BlogComment::where('blog_id', $blog->id)->orderBy('created_at', 'desc')->with('user')->get();
			$random_related_blogs = Blog::where('blog_category_id', $blog->blog_category_id)->with('category')->inRandomOrder()->take(3)->get();
			return view('front.blog.blog-details', compact('blog', 'blog_comments', 'random_related_blogs'));
		} else {
			$blog_categories = BlogCategory::select('name', 'id')->get();
			
			$blogs = Blog::where('published', 1)->orderBy('created_at', 'desc')->with('category');
			
			if ($request->cat)
				$blogs = $blogs->whereHas('category', function ($q) use ($request) {
					$q->where('name', $request->cat);
				});

//            if ($request->year && $request->month)
//                $blogs = $blogs->whereYear('created_at', '=', $request->year)->whereMonth('created_at', '=', $request->month);
			
			$blogs = $blogs->paginate(30);
			
			if ($request->page > $blogs->lastPage())
				abort(404);
			
			return view('front.blog.blog', compact('blog_categories', 'blogs'))->with('cat_id', $request->cat);
		}
		
	}
	
	public function generateRSS()
	{
		// create new feed
		$feed = \App::make("feed");
		
		$feed->setCache(60);
		
		// check if there is cached feed and build new only if is not
		if (!$feed->isCached()) {
			// creating rss feed with our most recent 20 posts
			$blog = Blog::where('published', 1)->orderBy('created_at', 'desc')->with('image')->with('category')->get();
			
			// set your feed's title, description, link, pubdate and language
			$feed->title = 'ChingHeHuang.com';
			$feed->description = 'ChingHeHuang Blog';
			$feed->logo = asset('/images/ching-logo-dark.svg');
			$feed->link = route('blog-rss');
			$feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
			$feed->pubdate = $blog->first()->created_at;
			$feed->lang = 'en';
			$feed->setShortening(true); // true or false
			$feed->setTextLimit(100); // maximum length of description text
			
			foreach ($blog as $b) {
				// set item's title, author, url, pubdate, description, content
				$feed->add(
					$b->title,
					"Ching He Huang",
					route('blog', ['cat' => $b->category->name, 'slug' => $b->getSlug()]),
					$b->created_at,
					$b->category->name,
					$b->blog_content);
			}
		}
		// first param is the feed format
		// optional: second param is cache duration (value of 0 turns off caching)
		// optional: you can set custom cache key with 3rd param as string
		return $feed->render('atom');
		
		// to return your feed as a string set second param to -1
		// $xml = $feed->render('atom', -1);
	}
}