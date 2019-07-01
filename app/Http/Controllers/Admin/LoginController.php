<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//引入门面
use Input;
use Session;
//引入模型
use App\Admin\Admin;
class LoginController extends Controller
{
    public function test(){
        return '测试';
    }
    //登录页面
    public function index(Request $request){
        if(Input::method()=='POST'){
            $validatedData = $request->validate([
                'username' => 'required',
                'pwd' => 'required',
            ]);
            if($validatedData){
                //验证用户名密码
                $model=new Admin();
                $models=$model->auth($validatedData);
                if($models){
                    //跳转后台首页
                    return redirect('/admin/admin/index');
                }else{
                    //登录失败
                    return view('admin/login/index');
                }
            }
        }else{
            return view('admin/login/index');
        }
    }
}
