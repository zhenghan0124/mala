<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class BaseController extends Controller
{
    //验证用户是否登录
    public function __construct()
    {
        $this->request = request();
        $this->middleware(function ($request, $next) {
            if (!Session::get('admin')) {
                echo "<script>alert('请先登录!');location.href='" . url('/admin/login/index') . "';</script>";
            }
            return $next($request);
        });
    }
}
