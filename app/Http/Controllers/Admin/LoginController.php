<?php

namespace App\Http\Controllers\Admin;

use App\Org\code\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function code()
    {
        $code = new Code();
        return $code->make();
    }

    //处理用户登录到方法
    public function doLogin(Request $request)
    {
        //1. 接收表单提交的数据
        $input = $request->except('_token');

        $rule = [
            'username'=>'required|between:4,18',
            'password'=>'required|between:4,18|alpha_dash',
        ];

        $msg = [
            'username.required'=>'用户名必须输入',
            'username.between'=>'用户名长度必须在4-18位之间',
            'password.required'=>'密码必须输入',
            'password.between'=>'密码长度必须在4-18位之间',
            'password.alpha_dash'=>'密码必须是数组字母下滑线',
        ];

        $validator = Validator::make($input,$rule,$msg);

        if ($validator->fails()) {
            return redirect('admin/login')
                ->withErrors($validator)
                ->withInput();
        }

    }
}
