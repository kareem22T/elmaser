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
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    use DataFormController;
    use SaveFileTrait;

    public function preview() {
        return view('admin.categories.preview');
    }

    public function getLanguages() {
        $languages = Language::all();

        return $this->jsonData(true, true, '', [], $languages);
    }

    public function getMainCategories() {
        $categories = Category::paginate(15);

        return $this->jsonData(true, true, '', [], $categories);
    }

    public function getSubCategories(Request $request) {
        $categories = Category::find($request->cat_id)->sub_categories;

        return $this->jsonData(true, true, '', [], $categories);
    }

    public function search(Request $request) {
        $languages = Category::with('sub_categories')->where('main_name', 'like', '%' . $request->search_words . '%')
                                ->orWhere('description', 'like', '%' . $request->search_words . '%')
                                ->paginate(10);

        $categories = Category::with('sub_categories')->whereHas('names', function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search_words.'%');
        })->paginate(10);

        return $this->jsonData(true, true, '', [], !$languages->isEmpty() ? $languages : $categories);

    }

    public function addIndex() {
        return view('admin.categories.add');
    }

    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,main_name',
            "color" => "required"
        ], [
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Add failed', [$validator->errors()->first()], []);
        }

        $createCategory = Category::create([
            'main_name' => $request->name,
            'description' => $request->description ? $request->description : null,
            "color" => $request->color
        ]);

        if ($createCategory)
            return $this->jsonData(true, true, 'Category has been added successfuly', [], []);
    }

    public function editIndex ($cat_id) {
        $category = Category::find($cat_id);
        return view('admin.categories.edit')->with(compact('category'));
    }

    public function getCategoryById(Request $request) {
        $category = Category::find($request->category_id);

        return $this->jsonData(true, true, '', [], $category);
    }

    public function getCategoryNames(Request $request) {
        $languages = Language::all();
        $symbols = $languages->pluck('symbol')->all();

        $category_names = Category::find($request->category_id)->names;
        $category_names_key_value = [];

        if ($category_names)
            foreach ($category_names as $key => $cat_name) {
                $category_names_key_value[$cat_name->language->symbol] = $cat_name->name;
            };

        if ($category_names_key_value) :
            $missingLanguages = array_diff($symbols, array_keys($category_names_key_value));
            if ($missingLanguages)
                foreach ($missingLanguages as $lang) {
                    $category_names_key_value[$lang] = null;
                }
        endif;

        return $this->jsonData(true, true, '', [], $category_names_key_value);
    }

    public function editCategory(Request $request) {
        $category = Category::find($request->category_id);

        $validator = Validator::make($request->all(), [
            'main_name' => 'required|unique:categories,main_name,'. $category?->id,
            "color" => "required"
        ], [
            'main_name.required' => 'Please write section main name',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Add failed', [$validator->errors()->first()], []);
        }

        $category?->main_name = $request->main_name;
        $category?->color = $request->color;
        $category?->description = $request->description ? $request->description : null;
        $category?->save();

        if ($category)
            return $this->jsonData(true, true, 'Category has been Updated successfuly', [], []);
    }

    public function getCategoryIndex ($cat_id) {
        $category = Category::with('sub_categories')->find($cat_id);
        return view('admin.categories.category')->with(compact('category'));
    }

    public function delete(Request $request) {
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, true, 'Edit failed', [$validator->errors()->first()], []);
        }

        $category = Category::find($request->cat_id);
        foreach ($category?->articles() as $article) {
            if ($article->thumbnail_path)
                File::delete(public_path('/dashboard/images/uploads/articles_thumbnail/' . $article->thumbnail_path));
            $article->delete();
        }
        $category?->delete();

        if ($category)
            return $this->jsonData(true, true, $request->file_name . 'Category has been deleted succussfuly', [], []);
    }
}
