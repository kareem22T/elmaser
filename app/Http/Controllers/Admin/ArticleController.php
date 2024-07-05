<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\DataFormController;
use App\Traits\SaveFileTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Language;
use App\Models\Category;
use App\Models\Category_Name;
use App\Models\Tag;
use App\Models\Article;
use App\Models\Author;
use App\Models\Article_Title;
use App\Models\Important_article;
use App\Models\Article_Content;
use App\Models\Articles_image;
use App\Models\Home_article;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    use DataFormController;
    use SaveFileTrait;

    public function preview() {
        return view('admin.articles.preview');
    }
    public function Draftpreview() {
        return view('admin.articles.draft');
    }

    public function getLanguages() {
        $languages = Language::all();

        return $this->jsonData(true, true, '', [], $languages);
    }

    public function getMainCategories() {
        $categories = Category::withب('sub_categories')->where('cat_type', 0)->get();

        return $this->jsonData(true, true, '', [], $categories);
    }

    public function getArticles() {
        $Articles = Article::where("isDraft", false)->with('category')->orderby('id', 'desc')->paginate(10);
        // foreach ($Articles as $article) {
        //     $isimportant = Important_article::where("article_id", $article->id)->count() > 0;
        //     $article->isImportant = $isimportant;
        // }

        return $this->jsonData(true, true, '', [], $Articles);
    }


    public function search(Request $request) {
        $articles = Article::latest()->with('category')
                            ->where(function ($query) use ($request) {
                                $query->where('title', 'like', '%' . $request->search_words . '%')
                                    ->orWhere('content', 'like', '%' . $request->search_words . '%')
                                    ->orWhere('author_name', 'like', '%' . $request->search_words . '%');
                            })
                            ->where('isDraft', false)
                            ->paginate(10);

        return $this->jsonData(true, true, '', [], $articles->isEmpty() ? [] : $articles);
    }
    public function getDraftArticles() {
        $Articles = Article::where("isDraft", true)->with('category')->latest()->paginate(10);

        return $this->jsonData(true, true, '', [], $Articles);
    }


    public function Draftsearch(Request $request) {
        $articles = Article::latest()->with('category')
                            ->where(function ($query) use ($request) {
                                $query->where('title', 'like', '%' . $request->search_words . '%')
                                    ->orWhere('content', 'like', '%' . $request->search_words . '%')
                                    ->orWhere('author_name', 'like', '%' . $request->search_words . '%');
                            })
                            ->where('isDraft', true)
                            ->paginate(10);

        return $this->jsonData(true, true, '', [], $articles->isEmpty() ? [] : $articles);
    }


    public function searchIndex(Request $request) {
        $articles = Article::latest()->with(['category'])
                            ->where(function ($query) use ($request) {
                                $query->where('title', 'like', '%' . $request->s . '%')
                                    ->orWhere('content', 'like', '%' . $request->s . '%')
                                    ->orWhere('author_name', 'like', '%' . $request->s . '%');
                            })
                            ->where('isDraft', false)
                            ->paginate(10);

        $search_word =  (string) $request->s;

        if ($request->tag_id) {
            $tag = Tag::with(['articles' => function ($query) {

                $query->latest();

            }])->find($request->tag_id);


            $articles = $tag->articles()->paginate(10);
        }

        $tag_id = $request->tag_id;
        if ($request->tag_id)
            return view("site.search")->with(compact(["articles", "search_word", "tag_id"]));

        return view("site.search")->with(compact(["articles", "search_word"]));
    }

    public function tagIndex($name, $id) {

        $search_word = "";
        if ($id) {
            $tag = Tag::with(['articles' => function ($query) {

                $query->latest();

            }])->find($id);


            $articles = $tag->articles()->paginate(10);
            $search_word =  $tag->name;
        }

        $tag_id = $id;
        if ($id)
            return view("site.tag")->with(compact(["articles", "search_word", "tag_id"]));

        return view("site.tag")->with(compact(["articles", "search_word"]));
    }
    public function authorIndex($name, $id) {

        $search_word = "";
        $author_desc = "";
        if ($id) {
            $tag = Author::with(['articles' => function ($query) {

                $query->latest();

            }])->find($id);


            $articles = $tag?->articles()->paginate(10);
            $search_word =  $tag?->name;
            $author_desc =  $tag?->description;
        }

        $tag_id = $id;
        if ($id)
            return view("site.author")->with(compact(["articles", "search_word", "tag_id", "author_desc"]));

        return view("site.author")->with(compact(["articles", "search_word", "author_desc"]));
    }
    public function categoryIndex(Request $request) {

        if ($request->id == 0) :
            $articles = Article::latest()->where("isDraft", false)->paginate(20);

            return view("site.category")->with(compact(["articles"]));

        else :
            $category = Category::with("articles")->find($request->id);

            $articles = $category?->articles()->where("isDraft", false)->latest()->paginate(20);
            $search_word = $category?->main_name;

            return view("site.category")->with(compact(["articles", "search_word", "category"]));
        endif;
    }

    public function addIndex() {
        return view('admin.articles.add');
    }

    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'content' => 'required',
            'thumbnail' => 'required',
            'author_id' => 'required',
            'intro' => 'required',
        ], [
            'title.required' => 'من فضلك قم بكتابة عنوان الخبر',
            'author_name.required' => 'من فضلك قم بكتابة اسم الكاتب',
            'content.required' => 'من فضلك قم بكتابة محتوى الخبر',
            'intro.required' => 'من فضلك ادخل النبذة المختصرة للخبر',
            'thumbnail.required' => 'من فضلك اختر صورة مصغرة للخبر',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Add failed', [$validator->errors()->first()], []);
        }

        if (!$request->cat_id) {
            return $this->jsondata(false, true, 'Add failed', ['من فضلك قم باختيار القسم'], []);
        }

        if (str_word_count($request->title) > 10)
            return $this->jsondata(false, true, 'Add failed', ['لا يمكن للعنوان ان يتعدى العشر كلمات'], []);

        if (str_word_count($request->sub_title) > 10)
            return $this->jsondata(false, true, 'Add failed', ['لا يمكن للعنوان الفرعي ان يتعدى العشر كلمات'], []);

        $createArticle = Article::create([
            'title' => $request->title,
            'thumbnail_title' => $request->thumbnail_title ?? null,
            'content' => $request->content,
            'sub_title' => $request->sub_title ? $request->sub_title : null,
            'thumbnail_path' => $request->thumbnail ? $request->thumbnail : null,
            'category_id' => $request->cat_id,
            'author_name' => $request->author_name || "xxxx",
            'intro' => $request->intro,
            'isDraft' => $request->draft ? true : false,
            'author_id' => $request->author_id,
            'created_at' => Carbon::now('GMT+3')
        ]);

        if ($request->tags)
            foreach ($request->tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]); // Check if tag exists or create a new one
                $createArticle->tags()->attach($tag->id); // Attach the tag to the Article
            }

            if ($request->isMain) {
                $totalArticles = Home_article::count();
                if ($totalArticles > 4) {
                    $oldestArticles = Home_article::orderBy('id', 'asc')
                    ->take($totalArticles - 4)
                    ->get();

                    foreach ($oldestArticles as $article) {
                        $article->delete();
                    }
                }
                $saveArticle = Home_article::create([
                    'title' => $createArticle->title,
                    'article_id' => $createArticle->id
                ]);
        }

        if ($request->isInNewsBar){
            $isArticleExist = Important_article::where('article_id', $createArticle->id)->get()->count() > 0;
            if (!$isArticleExist) {
                $important_articles = Important_article::all();

                if ($important_articles->count() === 10)
                    $remove_first = Important_article::first()->delete();

                $add_article = Important_article::create(['article_id' => $createArticle->id]);
            }
        }

        if ($createArticle){
            if ($request->draft)
                return $this->jsonData(true, true, ' تم اضافة الخبر الي المسودة', [], []);
            else
                return $this->jsonData(true, true, 'تم اضافة المقال بنجاح', [], []);
        }

    }

    public function editIndex ($cat_id) {
        $Article = Article::find($cat_id);
        return view('admin.articles.edit')->with(compact('Article'));
    }

    public function getArticleById(Request $request) {
        $Article = Article::with('category', "author")->with('tags')->find($request->article_id);

        return $this->jsonData(true, true, '', [], $Article);
    }


    public function editArticle(Request $request) {
        $Article = Article::find($request->article_id);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required',
            'intro' => 'required',
            'author_id' => 'required',
            'cat_id' => 'required'
        ], [
            'title.required' => 'من فضلك قم بكتابة عنوان الخبر',
            'author_name.required' => 'من فضلك قم بكتابة اسم الكاتب',
            'content.required' => 'من فضلك قم بكتابة محتوى الخبر',
            'intro.required' => 'من فضلك ادخل النبذة المختصرة للخبر',
            'thumbnail.required' => 'من فضلك اختر صورة مصغرة للخبر',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Add failed', [$validator->errors()->first()], []);
        }

        if (!$request->cat_id) {
            return $this->jsondata(false, true, 'Add failed', ['من فضلك قم باختيار القسم'], []);
        }

        if (str_word_count($request->title) > 10)
            return $this->jsondata(false, true, 'Add failed', ['لا يمكن للعنوان ان يتعدى العشر كلمات'], []);

        if (str_word_count($request->sub_title) > 10)
            return $this->jsondata(false, true, 'Add failed', ['لا يمكن للعنوان الفرعي ان يتعدى العشر كلمات'], []);

        $Article->title = $request->title;
        $Article->content = $request->content;
        $Article->sub_title = $request->sub_title ? $request->sub_title : null;
        $Article->thumbnail_path = $request->thumbnail;
        if ($request->thumbnail_title)
        $Article->thumbnail_title = $request->thumbnail_title;
        $Article->intro = $request->intro;
        $Article->author_id = $request->author_id;
        $Article->category_id = $request->cat_id;
        $Article->isDraft = $request->draft ? true : false;
        $Article->save();

        DB::table('article_tag')->where('article_id', $Article->id)->delete();
        if ($request->tags)
        foreach ($request->tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]); // Check if tag exists or create a new one
            $Article->tags()->attach($tag->id); // Attach the tag to the Article
        }

        if ($Article){
            if ($request->draft)
                return $this->jsonData(true, true, ' تم تحديث الخبر بنجاح واضافته الي المسودة', [], []);
            else
                return $this->jsonData(true, true, 'تم تحديث الخبر بنجاح', [], []);
        }
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'article_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Edit failed', [$validator->errors()->first()], []);
        }

        $Article = Article::find($request->article_id);
        $Article->delete();

        if ($Article)
            return $this->jsonData(true, true, $request->file_name . ' Article has been deleted succussfuly', [], []);
    }

    public function makeImportant(Request $request) {
        $validator = Validator::make($request->all(), [
            'article_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Edit failed', [$validator->errors()->first()], []);
        }

        $isArticleExist = Important_article::where('article_id', $request->article_id)->get()->count() > 0;
        if ($isArticleExist) {
            return $this->jsondata(false, true, 'Edit failed', ['هذا المقال مضاف بالفعل كعاجل'], []);
        }

        $important_articles = Important_article::all();

        if ($important_articles->count() === 10)
            $remove_first = Important_article::first()->delete();

        $add_article = Important_article::create(['article_id' => $request->article_id]);

        if ($add_article)
            return $this->jsondata(true, true, 'تم اضافة المقال بنجاح كعاجل', [], []);

    }

    public function toggleTrend($id) {

        $article = Article::find($id);
        if ($article) {
            $article->isTrend = !$article->isTrend;
            $article->save();
        }

        return redirect()->back();
    }
}
