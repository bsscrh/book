<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Org\code\Code;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

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

        //        3. 验证是否有此用户（用户名  密码  验证码）
        if(strtolower($input['code']) != strtolower(session()->get('code')) ){
            return redirect('admin/login')->with('errors','验证码错误');
        }

        $user =  User::where('user_name',$input['username'])->first();

        if(!$user){
            return redirect('admin/login')->with('errors','用户名错误');
        }

        if($input['password'] != Crypt::decrypt($user->user_pass)){
            return redirect('admin/login')->with('errors','密码错误');
        }

//        4. 保存用户信息到session中

        session()->put('user',$user);

//        5. 跳转到后台首页
        return redirect('admin/index');
    }

    //加密算法

    public function jiami()
    {
//        1.md5加密，生成一个32位的字符串
//        $str = 'salt'.'123456';
//        return md5($str);

//        2.哈希加密
//        $str = '123456';
//       $hash = Hash::make($str);
//        if(Hash::check($str,$hash)){
//            return '密码正确';
//        }else{
//            return '密码错误';
//        }


//        3. crypt加密
        $str = '123456';
        $crypt_str = 'eyJpdiI6IjJwQ3BOekg1eFpBQ1VHd2RXcno1aUE9PSIsInZhbHVlIjoiT2hwTEJRVmlubVY2dlBVYWp2aWlrQT09IiwibWFjIjoiYTc0MzVhNmQ0ZTFiMzE2NDBiNWI5NTliODE4ZDc1ZWFiNTE4N2FkMTdkN2QxZTJjOGE5MTFlNWVmMzFmMzM1OCJ9';
//        $crypt_str = Crypt::encrypt($str);
//        return $crypt_str;

        if(Crypt::decrypt($crypt_str) == $str) {
            return "密码正确";
        }
    }
}
