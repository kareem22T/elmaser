<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;
use App\Traits\DataFormController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManageAdminControler extends Controller
{
    use DataFormController;
    function index() {
        return view('admin.dashboard.admins');
    }

    public function get() {
        $Writers = Admin::where('role', "Writer")->where('id', '!=', Auth::guard('admin')->user()->id)->get();
        $Publisher = Admin::where('role', "Publisher")->where('id', '!=', Auth::guard('admin')->user()->id)->get();

        return  $this->jsondata(true, null, 'Successful Operation', [], [
            "Writers" => $Writers,
            "Publisher" => $Publisher,
        ]);
    }

    public function add (Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:admins',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, null, 'Add failed', [$validator->errors()->first()], []);
        }

        $createAdmin = Admin::create(['username' => $request->username, 'password' => Hash::make($request->password), 'role' => $request->role]);

        if ($createAdmin)
            return $this->jsondata(true, null, $request->role . ' has added successfuly', [], []);
    }

    public function update (Request $request) {
        $validator = Validator::make($request->all(), [
            'admin_id' => 'required|unique:admins',
            'username' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, null, 'update failed', [$validator->errors()->first()], []);
        }

        $admin = Admin::find($request->admin_id);

        $isEmailTaken = Admin::where("id", "!=", $admin->id)->where("email", $request->email)->get()->count() > 0;
        if ($isEmailTaken) {
            return $this->jsondata(false, null, 'update failed', ["This Email is already taken"], []);
        }

        $admin->username = $request->username;
        $admin->role = $request->role;
        if($request->password)
            $admin->password = Hash::make($request->password);
        $admin->save();
        if ($admin)
            return $this->jsondata(true, null, $request->username . ' info updated successfuly', [], []);
    }

    public function delete (Request $request) {
        $validator = Validator::make($request->all(), [
            'admin_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, null, 'delete failed', [$validator->errors()->first()], []);
        }

        $admin = Admin::find($request->admin_id);
        $admin->delete();
        if ($admin)
            return $this->jsondata(true, null,  'admin has deleted successfuly', [], []);
    }

}
