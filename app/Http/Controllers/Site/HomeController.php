<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Term;
use App\Models\Language;
use App\Models\Term_Name;
use App\Models\Term_Title;
use App\Models\Term_Content;
use App\Models\Term_Sound;
use App\Models\Home_category;
use App\Models\Category;
use App\Models\Ad;
use App\Models\Article;
use App\Models\Visit;
use App\Traits\DataFormController;

class HomeController extends Controller
{
    use DataFormController;

    public function getTermIndex() {
        return view('site.term');
    }

    public function getIndex() {
        $categories = Home_category::all();
        $ads = Ad::all()->first();

        $categories_per_home = [];

        foreach ($categories as $cat) {
            $category_with_articles = Category::with(['articles' => function ($query) {
                $query->where('isDraft', false)->latest()->take(4);
            }])->find($cat->category_id);
            $categories_per_home[] = $category_with_articles;
        }

        $latestArticles = Article::where("isDraft", false)->latest()->take(5)->get();

        return view('site.home')->with(compact(['categories_per_home', 'latestArticles', 'ads']));
    }

    public function getArticleIndex($id) {
        $article = Article::with(["visits", "tags"])->find($id);
            if (!$article->visits):
                Visit::create([
                    'article_id' => $article->id,
                    'total_visits' => 1,
                ]);
            else:
                $article->visits->total_visits = (int)$article->visits->total_visits + 1;
                $article->visits->save();
            endif;

        return view('site.article')->with(compact('article'));
    }

}
