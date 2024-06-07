<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\DataFormController;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Setting;
class SettingsController extends Controller
{
    use DataFormController;

    public function index() {
        return view("admin.settings.index");
    }

    public function store(Request $request)
    {
        foreach ($request->except('_token', 'logo', 'shape_section_image', 'partners_image') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return $this->jsonData(true, true, 'Successfully Operation', [], []);
    }

    public function toggleCatAtMainNav($id) {
        $cat = Category::find($id);

        if ($cat) {
            $cat->isAtNavMain = !$cat->isAtNavMain;
            $cat->save();
        }

        return redirect()->back();
    }


}
