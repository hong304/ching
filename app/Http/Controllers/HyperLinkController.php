<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class HyperLinkController extends Controller
{
    public function showBookShop(Request $request)
    {
        switch ($request->bookname) {
            case "eat-clean-wok-yourself-to-health":
                $url = 'https://www.amazon.co.uk/Eat-Clean-Wok-Yourself-Health/dp/0007426291/ref=sr_1_4?ie=UTF8&qid=1489384851&sr=8-4&keywords=ching+he+huang';
                break;
            case "exploring-china-a-culinary-adventure-100-recipes-from-our-journey":
                $url = 'https://www.amazon.co.uk/d/Books/Exploring-China-Culinary-Adventure-100-recipes-journey/1849904987/ref=sr_1_6?ie=UTF8&qid=1489387400&sr=8-6&keywords=ching+he+huang';
                break;
            case "chings-fast-food-110-quick-and-healthy-chinese-favourites":
                $url = 'https://www.amazon.co.uk/Chings-Fast-Food-Healthy-Favourites/dp/0007426275/ref=pd_sim_14_4?_encoding=UTF8&psc=1&refRID=DDV41V532GF9KZGKKHXG';
                break;
            case "chings-everyday-easy-chinese":
                $url = 'http://www.amazon.com/Chings-Everyday-Easy-Chinese-Healthy/dp/006207749X/ref=sr_1_4?ie=UTF8&qid=1315204682&sr=8-4';
                break;
            case "chings-chinese-food-in-minutes":
                $url = 'https://www.amazon.co.uk/Chings-Chinese-Minutes-Ching-He-Huang/dp/000726500X/ref=sr_1_1?ie=UTF8&qid=1489387589&sr=8-1&keywords=ching%27s+chinese+food+in+minutes';
                break;
            case "chinese-food-made-easy":
                $url = 'https://www.amazon.co.uk/Chinese-Food-Made-Easy-DVD/dp/B002ATVDGE/ref=sr_1_1?ie=UTF8&s=dvd&qid=1258647337&sr=8-1-catcorr';
                break;
            case "chinese-food-made-easy-100-simple-healthy-recipes-from-easy-to-find-ingredients":
                $url = 'https://www.amazon.co.uk/Chinese-Food-Made-Ching-He-Huang/dp/0007264984/ref=sr_1_1?ie=UTF8&qid=1489387671&sr=8-1&keywords=chinese+food+made+easy';
                break;
            case "china-modern-100-cutting-edge-fusion-style-recipes-for-the-21st-century":
                $url = 'https://www.amazon.co.uk/China-Modern-Cutting-edge-Fusian-style-Recipes/dp/1856269612/ref=sr_1_2?ie=UTF8&qid=1489387735&sr=8-2&keywords=ching+he+huang+china+modern';
                break;
            default:
                $url = '';
                break;
        }

        return Redirect::to($url);
    }
}

;