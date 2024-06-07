<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\DataFormController;
use App\Traits\SaveFileTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Home_category;
use App\Models\Home_article;
use App\Models\News_bar;
use App\Models\Editor_master;
use App\Models\Category;
use App\Models\Ad;
use App\Models\Article;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    use DataFormController;
    use SaveFileTrait;

    public function index() {
        return view('admin.edit-home');
    }

    public function savePageContent(Request $request) {
        $validator = Validator::make($request->all(), [
            'editor_master' => 'required',
            'manager_name' => 'required',
        ], [
            'editor_master.required' => 'ادخل اسم رئيس التحرير',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'upload failed', [$validator->errors()->first()], []);
        }

        Home_category::truncate();
        Home_article::truncate();

        if ($request->categories)
        foreach ($request->categories as $category) {
            $cat = Category::find($category);
            $saveCategories = Home_category::create([
                'name' => $cat->main_name,
                'category_id' => $category
            ]);
        }

        if ($request->articles)
        foreach ($request->articles as $article) {
            $art = Article::find($article);
            $saveArticle = Home_article::create([
                'title' => $art->title,
                'article_id' => $article
            ]);
        }

        if ($request->news_bar) {
            $news_Bar = News_bar::all();
            if ($news_Bar->count() > 0) {
                $news_Bar->first()->text = $request->news_bar;
                $news_Bar->first()->save();
            } else {
                $news_Bar = News_bar::create([
                    'text' => $request->news_bar
                ]);
            }
        }
        if ($request->editor_master) {
            $editor_master = Editor_master::all();
            if ($editor_master->count() > 0) {
                $editor_master->first()->name = $request->editor_master;
                $editor_master->first()->manager_name = $request->manager_name;
                $editor_master->first()->save();
            } else {
                $editor_master = Editor_master::create([
                    'name' => $request->editor_master,
                    'manager_name' => $request->manager_name,
                ]);
            }
        }

        $ads = Ad::all();
        if ($ads->count() == 0)
            $ad = Ad::create([
                'ad_1' => null,
                'ad_2' => null,
                'ad_3' => null,
                'mobile_ad_1' => null,
                'mobile_ad_2' => null,
                'mobile_ad_3' => null,
                'main_ad' => null,
            ]);
        $ads = Ad::all();
        if ($request->ad_1):
            $ad_1 = $this->saveFile($request->ad_1, 'images/uploads/ads', 'ad_1');
            $ads->first()->ad_1 = $ad_1;
        endif;
        if ($request->ad_2):
            $ad_2 = $this->saveFile($request->ad_2, 'images/uploads/ads', 'ad_2');
            $ads->first()->ad_2 = $ad_2;
        endif;
        if ($request->ad_3):
            $ad_3 = $this->saveFile($request->ad_3, 'images/uploads/ads', 'ad_3');
            $ads->first()->ad_3 = $ad_3;
        endif;
        if ($request->mobile_ad_1):
            $mobile_ad_1 = $this->saveFile($request->mobile_ad_1, 'images/uploads/ads', 'mobile_ad_1');
            $ads->first()->mobile_ad_1 = $mobile_ad_1;
        endif;
        if ($request->mobile_ad_2):
            $mobile_ad_2 = $this->saveFile($request->mobile_ad_2, 'images/uploads/ads', 'mobile_ad_2');
            $ads->first()->mobile_ad_2 = $mobile_ad_2;
        endif;
        if ($request->mobile_ad_3):
            $mobile_ad_3 = $this->saveFile($request->mobile_ad_3, 'images/uploads/ads', 'mobile_ad_3');
            $ads->first()->mobile_ad_3 = $mobile_ad_3;
        endif;
        if ($request->main_ad):
            $main_ad = $this->saveFile($request->main_ad, 'images/uploads/ads', 'main_ad');
            $ads->first()->main_ad = $main_ad;
        endif;
        $ads->first()->save();


        return $this->jsondata(true, true, 'تم حفظ المحتوى بنجاح', [], []);
    }

    public function returnHomeCategoriesandArticles() {
        $categories = Home_category::all();
        $articles = Home_article::all();
        $newsBar = News_bar::all()->first();
        $editor_master = Editor_master::all()->first();
        $ads = Ad::all()->first();

        // Get the category ID in an array
        $categoryIds = $categories->pluck('category_id')->toArray();
        $articleIds = $articles->pluck('article_id')->toArray();

        // Get the category name in an array
        $categoryNames = $categories->pluck('name')->toArray();
        $articleNames = $articles->pluck('title')->toArray();

        return $this->jsondata(true, true, 'عملية ناجحة', [], ["catids" => $categoryIds, "catnames" => $categoryNames, "artids" => $articleIds, "artnames" => $articleNames, 'newsbar' => $newsBar, "ads" => $ads, "editor_master" => $editor_master]);
    }

}
