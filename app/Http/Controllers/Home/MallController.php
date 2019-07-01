<?php

namespace App\Http\Controllers\Home;

use App\Home\Comments;
use App\Home\Content;
use App\Home\Focus;
use App\Home\Support;
use App\Home\Type;
use App\Home\User;
use App\Home\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//使用门面
use Input;
use DB;
use Rediss;
class MallController extends Controller
{
    //查询商品
    public function mall(){
        if(isset($_POST['page']) && isset($_POST['len'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $res = DB::table('mall')
                ->offset($offset)
                ->limit($limit)
                ->get();
            $arr = [
                'status' => 1,
                'contents' => $res,
            ];
        }else{
            $arr = [
                'status' => 0,
                'contents' => [],
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }
}
