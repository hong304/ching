<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\RecipeCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App;
use URL;

class SiteMapController extends Controller
{

    public function getSitemapRecipe(){

        // create sitemap
        $sitemap_recipe = App::make("sitemap");

        // set cache
        $sitemap_recipe->setCache('ching.sitemap-recipe', 3600);

        $recipes = Recipe::where('active',1)->get();

        foreach ($recipes as $recipe) {


            $images = [];
            $images[] = ['url' => URL::to($recipe->image->url()), 'title' => $recipe->name, 'caption' => str_limit($recipe->intro, 100)];

            $sitemap_recipe->add(URL::to("recipes/{$recipe->slug}"), $recipe->updated_at, '0.8', 'weekly',$images);
        }

        $recipe_courses = RecipeCourse::get();
        foreach($recipe_courses as $v){
            $sitemap_recipe->add(URL::to("recipes/search/{$v->slug}"), Carbon::parse('now'), '0.8', 'weekly');
        }

        // show sitemap
        return $sitemap_recipe->render('xml');
    }

    public function getSitemapVideo(){

        // create sitemap
        $sitemap = App::make("sitemap");

        // set cache
        $sitemap->setCache('ching.sitemap-video', 3600);


        $video_categories = App\Models\VideoCategory::with('videos')->where('active',1)->get();


        foreach($video_categories as $v){
            $sitemap->add(URL::to("videos/{$v->slug}"), Carbon::parse('now'), '0.8', 'weekly');
            foreach($v->videos as $v1){
                if($v->name == 'Click and Cook') {
                    $sitemap->add(URL::to("recipes/{$v1->recipe->getSlug()}"), $v1->updated_at, '0.8', 'weekly');
                }else
                    $sitemap->add(URL::to("videos/{$v->slug}/{$v1->slug}"), $v1->updated_at, '0.8', 'weekly');
            }
        }

        // show sitemap
        return $sitemap->render('xml');
    }

    public function getSitemapBlog(){

        // create sitemap
        $sitemap = App::make("sitemap");

        // set cache
        $sitemap->setCache('ching.sitemap-blog', 3600);

        $blog_sections = App\Models\BlogCategory::with('blogs')->where('active', 1)->get();

        foreach ($blog_sections as $v) {
            $sitemap->add(URL::to("blog/{$v->name}"), Carbon::parse('now'), '0.9', 'weekly');
            foreach ($v->blogs as $v1) {
                if($v1->image){
                    $images = [];
                    $images[] = ['url' => URL::to($v1->image->url()), 'title' => $v1->title];
//                    $images[] = ['url' => URL::to($v1->image->url()), 'title' => $v1->title, 'caption' => str_limit(trim(
//                        str_replace('&nbsp;','',
//                            str_replace("\n",'',
//                                str_replace("&amp;",'',strip_tags($v1->content))))), 100)];
                    $sitemap->add(URL::to("blog/{$v->name}/{$v1->slug}"), $v1->updated_at, '0.9', 'weekly', $images);
                }else{
                    $sitemap->add(URL::to("blog/{$v->name}/{$v1->slug}"), $v1->updated_at, '0.9', 'weekly');
                }
            }
        }

        // show sitemap
        return $sitemap->render('xml');
    }

    public function getSitemap()
    {

        // create new sitemap object
        $sitemap = App::make("sitemap");

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled
        $sitemap->setCache('ching.sitemap', 3600, false);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached()) {


            // static pages
            $sitemap->add(URL::to('/'), Carbon::parse('now'), '1.0', 'daily');
            $sitemap->add(URL::to('recipes'), Carbon::parse('now'), '1.0', 'daily');
            $sitemap->add(URL::to('videos'), Carbon::parse('now'), '1.0', 'daily');
            $sitemap->add(URL::to('blog'), Carbon::parse('now'), '1.0', 'daily');
            $sitemap->add(URL::to('books'), Carbon::parse('now'), '0.8', 'weekly');
            $sitemap->add(URL::to('amazing-asia'), Carbon::parse('now'), '0.7', 'weekly');
            $sitemap->add(URL::to('lotus-wok'), Carbon::parse('now'), '0.6', 'weekly');
            $sitemap->add(URL::to('books'), Carbon::parse('now'), '0.6', 'weekly');
            $sitemap->add(URL::to('my-story'), Carbon::parse('now'), '0.6', 'weekly');
            $sitemap->add(URL::to('biography'), Carbon::parse('now'), '0.6', 'weekly');
            $sitemap->add(URL::to('privacy-policy'), Carbon::parse('now'), '0.6', 'weekly');
            $sitemap->add(URL::to('terms-and-conditions'), Carbon::parse('now'), '0.6', 'weekly');
            $sitemap->add(URL::to('contact'), Carbon::parse('now'), '0.6', 'weekly');

        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('xml');

    }
}
