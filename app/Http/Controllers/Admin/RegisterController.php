<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\DataFormController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use DataFormController;

    public function getLoginIndex() {
        $createAdmin = Admin::all()->count() > 0 ? '' : Admin::create(['username' => 'elmaser', 'password' => Hash::make('admin123'), 'role' => "Master"]);

        return view('admin.login');
    }
    public function ff() {
        return view('admin.sample');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'please enter your username',
            'password.required' => 'please enter your password',
        ]);

        if ($validator->fails()) {
            return $this->jsondata(false, null, 'Login failed', [$validator->errors()->first()], []);
        }

        $credentials = ['username' => $request->input('username'), 'password' => $request->input('password')];

        if (Auth::guard('admin')->attempt($credentials)) {
            return $this->jsonData(true, true, 'Successfully Operation', [], Auth::guard('admin')->user());
        }

        return $this->jsonData(false, null, 'Faild Operation', ['Username or password is not correct!'], []);
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
