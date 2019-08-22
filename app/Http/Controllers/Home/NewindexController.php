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
class NewindexController extends Controller
{
    //新版分类接口
    public function donewtype()
    {
        //获取分类
        $types=DB::table('newtype')
            ->where('status','=','1')
            ->orderBy('location','desc')
            ->get();
//        var_dump($types);exit;
        if ($types) {
            $arr = [
                'status' => 1,
                'type' => $types,
            ];
        } else {
            $arr = [
                'status' => 1,
                'type' => [],
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));

    }

    //首页获取
    public function donewindex()
    {

        //获取内容
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['len']) ? $_POST['len'] : 10;
        $offset = ($page - 1) * $limit;
//        $_POST['uid'] = '1557122526';
        if ($_POST['typeid'] != '') {
            $type=DB::table('newtype')
                ->where('status','=','1')
                ->inRandomOrder()
                ->first();
            $type->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$type->pic;
//            $contents = $content->getContent($offset, $limit, $_POST['typeid']);
            $contents = DB::table('newcontent')
                //过滤掉已经禁用的类型文章
//                ->join('newtype', function ($join) {
//                    $join->on('newcontent.typeid', '=', 'type.id')
//                        ->where('newtype.status', '=', 1);
//                })
                ->where('typeid','=',$_POST['typeid'])
//                ->where('recommended','=',2)
                ->where('status','=',1)
                ->where('audit','=',2)
                ->inRandomOrder()
                ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
        } else {
            $type=DB::table('newtype')
                ->where('status','=','1')
                ->inRandomOrder()
                ->first();
            $type->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$type->pic;
//            $contents = $content->getContents($offset, $limit);
            $contents = DB::table('newcontent')
                //过滤掉已经禁用的类型文章
//                ->join('newtype', function ($join) {
//                    $join->on('newcontent.typeid', '=', 'type.id')
//                        ->where('newtype.status', '=', 1);
//                })
//                ->where('recommended','=',2)
                ->where('status','=',1)
                ->where('audit','=',2)
                ->inRandomOrder()
                ->orderBy('download','desc')
                ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
        }
//        var_dump($contents);exit;
        if (!$contents->isEmpty()) {
                foreach($contents as $value){
                    //判断是否存在域名
                    if(strpos($value->photo, 'https') !== false){
                        $value->photo = $value->photo;
                    }else{
                        $value->photo = 'https://duanju.58100.com'.$value->photo;
                    }
//                    $value->photo = 'https://duanju.58100.com/'.$value->photo;
                    $value->imgurl = 'https://duanju.58100.com/newadmin/Uploads/'.$value->imgurl;
                }
                foreach ($contents as $v) {
                    $contentid[] = $v->id;
                }
                if($contentid){
                    $collection = DB::table('newcollection')
                        ->where('uid', '=', $_POST['uid'])
                        ->whereIn('contentid', $contentid)
                        ->get();
                }else{
                    $collection = [];
                }
                if ($collection) {
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'collection' => $collection,
                        'type' => $type
                    ];
                }else {
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'collection' => [],
                        'type' => $type
                    ];
                }
        } else {
                $arr = [
                    'status' => 1,
                    'contents' => [],
                    'collection' => [],
                    'type' => []
                ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //首页获取
    public function donewindexs()
    {
        //获取内容
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['len']) ? $_POST['len'] : 10;
        $limit1 = $limit/2;
        $limit2 = $limit/2;
        // $offset = ($page - 1) * $limit;
        $offset1 = ($page - 1) * $limit1;
        $offset2 = ($page - 1) * $limit2;
        // $_POST['uid'] = '1557122526';
        // $_POST['typeid'] = '';
        if ($_POST['typeid'] != '') {
            $type=DB::table('newtype')
                ->where('status','=','1')
                ->inRandomOrder()
                ->first();
            $type->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$type->pic;
//            $contents = $content->getContent($offset, $limit, $_POST['typeid']);
            //前面5条后台发布
            $contents_admin = DB::table('newcontent')
                //过滤掉已经禁用的类型文章
//                ->join('newtype', function ($join) {
//                    $join->on('newcontent.typeid', '=', 'type.id')
//                        ->where('newtype.status', '=', 1);
//                })
                ->where('typeid','=',$_POST['typeid'])
//                ->where('recommended','=',2)
                ->where('fabutype','=',2)
                ->where('status','=',1)
                ->where('audit','=',2)
                ->inRandomOrder()
                ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset1)
                ->limit($limit1)
                ->get();
            //后面5条用户发布
            $contents_user = DB::table('newcontent')
                //过滤掉已经禁用的类型文章
//                ->join('newtype', function ($join) {
//                    $join->on('newcontent.typeid', '=', 'type.id')
//                        ->where('newtype.status', '=', 1);
//                })
                ->where('typeid','=',$_POST['typeid'])
//                ->where('recommended','=',2)
                ->where('fabutype','=',1)
                ->where('status','=',1)
                ->where('audit','=',2)
                // ->inRandomOrder()
                // ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset2)
                ->limit($limit2)
                ->get();
        } else {
            $type=DB::table('newtype')
                ->where('status','=','1')
                ->inRandomOrder()
                ->first();
            $type->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$type->pic;
//            $contents = $content->getContents($offset, $limit);
            //前面5条后台发布
            $contents_admin = DB::table('newcontent')
                //过滤掉已经禁用的类型文章
//                ->join('newtype', function ($join) {
//                    $join->on('newcontent.typeid', '=', 'type.id')
//                        ->where('newtype.status', '=', 1);
//                })
//                ->where('recommended','=',2)
                ->where('status','=',1)
                ->where('audit','=',2)
                ->where('fabutype','=',2)
                ->inRandomOrder()
                ->orderBy('download','desc')
                ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset1)
                ->limit($limit1)
                ->get();
            //后面5条用户发布
            $contents_user = DB::table('newcontent')
                //过滤掉已经禁用的类型文章
//                ->join('newtype', function ($join) {
//                    $join->on('newcontent.typeid', '=', 'type.id')
//                        ->where('newtype.status', '=', 1);
//                })
//                ->where('recommended','=',2)
                ->where('fabutype','=',1)
                ->where('status','=',1)
                ->where('audit','=',2)
                // ->inRandomOrder()
                // ->orderBy('download','desc')
                // ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset2)
                ->limit($limit2)
                ->get();
        }
        //将获取到的后台发布数据解析为数组
        $admin_content =[]; 
        foreach ($contents_admin as $k=>$v) { 
        $m = []; 
        foreach ($v as $i=>$j) { 
        $m[$i] = $j; 
        } 
        $admin_content[$k] = $m; 
        } 
        
        //将获取到的用户发布数据解析为数组
        $user_content =[]; 
        foreach ($contents_user as $k=>$v) { 
        $m = []; 
        foreach ($v as $i=>$j) { 
        $m[$i] = $j; 
        } 
        $user_content[$k] = $m; 
        } 
        $contents = array_merge($admin_content,$user_content);
        // var_dump($contents);exit;
        // var_dump($admin_content);
        // var_dump($user_content);exit;
        // var_dump($contentss);exit;
        // if (!$contents->isEmpty()) {
        if (!empty($contents)) {
                $content = array();
                foreach($contents as $value){
                    //判断是否存在域名
                    if(strpos($value['photo'], 'https') !== false){
                        $value['photo'] = $value['photo'];
                    }else{
                        $value['photo'] = 'https://duanju.58100.com'.$value['photo'];
                    }
//                    $value->photo = 'https://duanju.58100.com/'.$value->photo;
                    $value['imgurl'] = 'https://duanju.58100.com/newadmin/Uploads/'.$value['imgurl'];
                    $content[] = $value;
                }
                foreach ($content as $v) {
                    $contentid[] = $v['id'];
                }
                if($contentid){
                    $collection = DB::table('newcollection')
                        ->where('uid', '=', $_POST['uid'])
                        ->whereIn('contentid', $contentid)
                        ->get();
                }else{
                    $collection = [];
                }
                if ($collection) {
                    $arr = [
                        'status' => 1,
                        'contents' => $content,
                        'collection' => $collection,
                        'type' => $type
                    ];
                }else {
                    $arr = [
                        'status' => 1,
                        'contents' => $content,
                        'collection' => [],
                        'type' => $type
                    ];
                }
        } else {
                $arr = [
                    'status' => 1,
                    'contents' => [],
                    'collection' => [],
                    'type' => []
                ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //通过id获取当前文章
    public function contentone()
    {
        if (isset($_POST['id']) && isset($_POST['uid'])) {
            $models = DB::table('newcontent')
                ->where('id','=',$_POST['id'])
                ->first();
            $models->imgurl = 'https://duanju.58100.com/newadmin/Uploads/'.$models->imgurl;
            //判断是否存在域名
            if(strpos($models->photo, 'https') !== false){
                $models->photo = $models->photo;
            }else{
                $models->photo = 'https://duanju.58100.com'.$models->photo;
            }
//            $models->photo = 'https://duanju.58100.com/'.$models->photo;
//            $supports = DB::table('support')
//                ->where('contentid', '=', $_POST['id'])
//                ->where('uid', '=', $_POST['uid'])
//                ->first();
//            if ($supports) {
//                $support = 1;
//            } else {
//                $support = 0;
//            }
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $contents = DB::table('newcontent')
                ->where('typeid', '=', $models->typeid)
                ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
            $collections = DB::table('newcollection')
                ->where('contentid', '=', $_POST['id'])
                ->where('uid', '=', $_POST['uid'])
                ->first();
            //判断是否关注
            $focus = DB::table('focus')
                ->where('uid', '=', $_POST['uid'])
                ->where('buid', '=', $models->uid)
                ->first();
            if ($focus) {
                $focus = 1;
            } else {
                $focus = 0;
            }
            if ($collections) {
                $collection = 1;
            } else {
                $collection = 0;
            }
            if ($models) {
                $arr = [
                    'status' => 1,
                    'content' => $contents,
                    'models' => $models,
                    'focus' => $focus,
                    'collection' => $collection,
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'content' => [],
                    'models' => [],
                    'focus' => $focus,
                    'collection' => [],
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //同名专辑
    public function album()
    {
        if (isset($_POST['typeid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $contents = DB::table('newcontent')
                ->where('typeid', '=', $_POST['typeid'])
                ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
            foreach ($contents as $value){
                $value->imgurl = 'https://duanju.58100.com/newadmin/Uploads/'.$value->imgurl;
                //判断是否存在域名
                if(strpos($value->photo, 'https') !== false){
                    $value->photo = $value->photo;
                }else{
                    $value->photo = 'https://duanju.58100.com'.$value->photo;
                }
//                $value->photo = 'https://duanju.58100.com/'.$value->photo;
            }
            if ($contents) {
                $arr = [
                    'status' => 1,
                    'content' => $contents,
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'content' => [],
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //下载接口
    public function download()
    {
        if (isset($_POST['contentid'])) {
            $content = DB::table('newcontent')
                ->where('id', '=', $_POST['contentid'])
                ->first();
            if($content->uid == '1557122526'){
                $download = DB::table('newcontent')
                ->where('id', '=', $_POST['contentid'])
                ->increment('xiazai');
                $download = DB::table('newcontent')
                ->where('id', '=', $_POST['contentid'])
                ->increment('download');
            }else{
                $download = DB::table('newcontent')
                ->where('id', '=', $_POST['contentid'])
                ->increment('download');
            }
            
            if ($download) {
                $arr = [
                    'status' => 1,
                    'info' => '下载成功',
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'info' => '下载失败',
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //分享接口
    public function share()
    {
        if (isset($_POST['contentid'])) {
            $download = DB::table('newcontent')
                ->where('id', '=', $_POST['contentid'])
                ->increment('share');
            if ($download) {
                $arr = [
                    'status' => 1,
                    'info' => '分享成功',
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'info' => '分享失败',
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //首页日签推荐
    public function daily()
    {
        //当前日期
        $date = date('Y年m月d日');
        //今天是几月
        $month = date('m');
        if($month == '01'){
            $month = 1;
        }elseif ($month == '02'){
            $month = 2;
        }elseif ($month == '03'){
            $month = 3;
        }elseif ($month == '04'){
            $month = 4;
        }elseif ($month == '05'){
            $month = 5;
        }elseif ($month == '06'){
            $month = 6;
        }elseif ($month == '07'){
            $month = 7;
        }elseif ($month == '08'){
            $month = 8;
        }elseif ($month == '09'){
            $month = 9;
        }elseif ($month == '10'){
            $month = 10;
        }elseif ($month == '11'){
            $month = 11;
        }elseif ($month == '12'){
            $month = 12;
        }
        //获取月份图片
        $monthimg = DB::table('yuefen')
            ->where('month','=',$month)
            ->first();
        $monthimg->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$monthimg->pic;
        //今天是周几
        $weekarray = array("周日","周一","周二","周三","周四","周五","周六");
        $week = $weekarray[date("w")];
        if($week == '周一'){
            $week = 1;
        }elseif ($week == '周二'){
            $week = 2;
        }elseif ($week == '周三'){
            $week = 3;
        }elseif ($week == '周四'){
            $week = 4;
        }elseif ($week == '周五'){
            $week = 5;
        }elseif ($week == '周六'){
            $week = 6;
        }elseif ($week == '周日'){
            $week = 7;
        }
        //获取周图片
        $weekimg = DB::table('riqian')
            ->where('week','=',$week)
            ->first();
        $weekimg->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$weekimg->pic;
            if ($weekimg) {
                $arr = [
                    'status' => 1,
                    'weekimg' => $weekimg,
                    'monthimg' => $monthimg,
                    'date' => $date
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'info' => '查询失败',
                ];
            }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //合集接口
    public function heji()
    {
        if (isset($_POST['typeid'])) {
                $type = DB::table('newtype')
                    ->where('id', '=', $_POST['typeid'])
                    ->first();
                $type->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$type->pic;
                $type->img = 'https://duanju.58100.com/newadmin/Uploads/'.$type->img;
                if($type){
                    $download = DB::table('newcontent')
                        ->where('typeid', '=', $_POST['typeid'])
                        ->sum("download");
                    $count = DB::table('newcontent')
                        ->where('typeid', '=', $_POST['typeid'])
                        ->count();
                    $arr = [
                        'status' => 1,
                        'download' => $download,
                        'count' => $count,
                        'type' => $type,
                    ];
                }else{
                    $arr = [
                        'status' => 1,
                        'download' => [],
                        'count' => [],
                        'type' => [],
                    ];
                }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //用户中心
    public function personal()
    {
        if (isset($_POST['uid']) && isset($_POST['buid'])) {
            //判断是否关注
            $focus = DB::table('focus')
                ->where('uid', '=', $_POST['uid'])
                ->where('buid', '=', $_POST['buid'])
                ->first();
            $userinfo = DB::table('userinfo')
                ->where('uid', '=', $_POST['buid'])
                ->first();
            if ($userinfo->name) {
                $userinfo->name = $userinfo->name;
            } else {
                $userinfo->name = $userinfo->nickname;
            }
            if ($userinfo->photo) {
                $userinfo->pic = $userinfo->photo;
            } else {
                $userinfo->pic = $userinfo->avatarurl;
            }
            //判断是否存在域名
            if(strpos($userinfo->pic, 'https') !== false){
                $userinfo->pic = $userinfo->pic;
            }else{
                $userinfo->pic = 'https://duanju.58100.com'.$userinfo->pic;
            }
            if ($focus) {
                $focus = 1;
            } else {
                $focus = 0;
            }
            if($userinfo){
                $arr = [
                    'status' => 1,
                    'focus' => $focus,
                    'userinfo' => $userinfo,
                ];
            }else{
                $arr = [
                    'status' => 1,
                    'focus' => [],
                    'userinfo' => [],
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //用户发布过得图片
    public function usercontentlist()
    {
        if (isset($_POST['uid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $contents = DB::table('newcontent')
                ->where('uid', '=', $_POST['uid'])
                ->orderBy('tjtime','desc')
                ->orderBy('date','desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
            foreach ($contents as $value){
                $value->imgurl = 'https://duanju.58100.com/newadmin/Uploads/'.$value->imgurl;
                //判断是否存在域名
                if(strpos($value->photo, 'https') !== false){
                    $value->photo = $value->photo;
                }else{
                    $value->photo = 'https://duanju.58100.com'.$value->photo;
                }
//                $value->photo = 'https://duanju.58100.com/'.$value->photo;
            }
            if ($contents) {
                $arr = [
                    'status' => 1,
                    'content' => $contents,
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'content' => [],
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //收藏中心
    public function mycollection()
    {
//        $_POST['openid'] = 'otV6H5GC3JusKGe_thoKdkATzLvk';
//        $_POST['uid'] = '5cf87770e9ab3';
        if (isset($_POST['uid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            //获取被关注人
            $mycollection = DB::table('newcollection')
                ->where('uid', '=', $_POST['uid'])
//                ->orderBy('id', 'desc')
//                ->offset($offset)
//                ->limit($limit)
                ->get();
            if ($mycollection->isEmpty()) {
                $arr = [
                    'status' => 1,
                    'contents' => [],
                    'collection' => []
                ];
            }else {
                foreach ($mycollection as $v) {
                    $contentid[] = $v->contentid;
                }

                $contents = DB::table('newcontent')
                    ->whereIn('id', $contentid)
                    ->where('status', '=', 1)
                    ->where('audit', '=', 2)
                    ->orderBy('time', 'desc')
                    ->orderBy('date', 'desc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();

                if (!$contents->isEmpty()) {
                    foreach($contents as $value){
                        //判断是否存在域名
                        if(strpos($value->photo, 'https') !== false){
                            $value->photo = $value->photo;
                        }else{
                            $value->photo = 'https://duanju.58100.com'.$value->photo;
                        }
//                        $value->photo = 'https://duanju.58100.com/'.$value->photo;
                        $value->imgurl = 'https://duanju.58100.com/newadmin/Uploads/'.$value->imgurl;
                    }
//                    foreach ($contents as $v) {
//                        $contentid[] = $v->id;
//                    }
//                    if($contentid){
//                        $collection = DB::table('newcollection')
//                            ->where('uid', '=', $_POST['uid'])
//                            ->whereIn('contentid', $contentid)
//                            ->get();
//                    }else{
//                        $collection = [];
//                    }
//                    if ($collection) {
                        $arr = [
                            'status' => 1,
                            'contents' => $contents,
                        ];
//                    }else {
//                        $arr = [
//                            'status' => 1,
//                            'contents' => $contents,
//                        ];
//                    }
                } else {
                    $arr = [
                        'status' => 1,
                        'contents' => [],
                    ];
                }
            }
        }else{
            $arr = [
                'status' => 0,
                'contents' => [],
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //动态
    public function mycontents()
    {
        if (isset($_POST['uid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
                $contents = DB::table('newcontent')
                    ->where('uid', $_POST['uid'])
                    ->where('status', '=', 1)
                    ->where('audit', '=', 2)
                    ->orderBy('time', 'desc')
                    ->orderBy('date', 'desc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();

                if (!$contents->isEmpty()) {
                    foreach($contents as $value){
                        //判断是否存在域名
                        if(strpos($value->photo, 'https') !== false){
                            $value->photo = $value->photo;
                        }else{
                            $value->photo = 'https://duanju.58100.com'.$value->photo;
                        }
//                        $value->photo = 'https://duanju.58100.com/'.$value->photo;
                        $value->imgurl = 'https://duanju.58100.com/newadmin/Uploads/'.$value->imgurl;
                    }
                    foreach ($contents as $v) {
                        $contentid[] = $v->id;
                    }
                    if($contentid){
                        $collection = DB::table('newcollection')
                            ->where('uid', '=', $_POST['uid'])
                            ->whereIn('contentid', $contentid)
                            ->get();
                    }else{
                        $collection = [];
                    }
                    if ($collection) {
                        $arr = [
                            'status' => 1,
                            'contents' => $contents,
                            'collection' => $collection
                        ];
                    }else {
                        $arr = [
                            'status' => 1,
                            'contents' => $contents,
                            'collection' => []
                        ];
                    }
                } else {
                    $arr = [
                        'status' => 1,
                        'contents' => [],
                        'collection' => []
                    ];
                }
        }else{
            $arr = [
                'status' => 0,
                'contents' => [],
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //我关注人的文章
    public function myfocus()
    {
//        $_POST['openid'] = 'otV6H5GC3JusKGe_thoKdkATzLvk';
//        $_POST['uid'] = '5cf87770e9ab3';
        if (isset($_POST['uid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            //获取被关注人
            $focus = DB::table('focus')
                ->where('uid', '=', $_POST['uid'])
                ->get();
            if ($focus->isEmpty()) {
                $arr = [
                    'status' => 1,
                    'contents' => [],
                    'collection' => []
                ];
            }else {
                foreach ($focus as $v) {
                    $uid[] = $v->buid;
                }

                $contents = DB::table('newcontent')
                    ->whereIn('uid', $uid)
                    ->where('status', '=', 1)
                    ->where('audit', '=', 2)
                    ->orderBy('time', 'desc')
                    ->orderBy('date', 'desc')
                    ->offset($offset)
                    ->limit($limit)
                    ->get();

                if (!$contents->isEmpty()) {
                    foreach($contents as $value){
                        //判断是否存在域名
                        if(strpos($value->photo, 'https') !== false){
                            $value->photo = $value->photo;
                        }else{
                            $value->photo = 'https://duanju.58100.com'.$value->photo;
                        }
//                        $value->photo = 'https://duanju.58100.com/'.$value->photo;
                        $value->imgurl = 'https://duanju.58100.com/newadmin/Uploads/'.$value->imgurl;
                    }
                    foreach ($contents as $v) {
                        $contentid[] = $v->id;
                    }
                    if($contentid){
                        $collection = DB::table('newcollection')
                            ->where('uid', '=', $_POST['uid'])
                            ->whereIn('contentid', $contentid)
                            ->get();
                    }else{
                        $collection = [];
                    }
                    if ($collection) {
                        $arr = [
                            'status' => 1,
                            'contents' => $contents,
                            'collection' => $collection,
                        ];
                    }else {
                        $arr = [
                            'status' => 1,
                            'contents' => $contents,
                            'collection' => [],
                        ];
                    }
                } else {
                    $arr = [
                        'status' => 1,
                        'contents' => [],
                        'collection' => [],
                    ];
                }
            }
        }else{
            $arr = [
                'status' => 0,
                'contents' => [],
                'collection' => [],
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //获取评论
    public function comments()
    {
        if (isset($_POST['id']) && isset($_POST['openid']) && isset($_POST['uid'])) {
            //获取当前文章的评论
            $comment = new Comments();
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $commentss = $comment->getComments($_POST['id'], $offset, $limit);
            //判断用户有没有对该评论点过赞
            if ($commentss) {
                foreach ($commentss as $v) {
                    $commentsid[] = $v->id;//评论的id
                }
                //获取评论过的文章的id
                $re = DB::table('commentsupport')
                    ->select('commentsid')
                    ->where('openid', '=', $_POST['openid'])
                    ->where('uid', '=', $_POST['uid'])
                    ->whereIn('commentsid', $commentsid);
                if($re->exists()){
                    $arr = [
                        'status' => 1,
                        'comments' => $commentss,
                        'issupport'=>$re->get()
                    ];
                }else{
                    $arr = [
                        'status' => 1,
                        'comments' => $commentss,
                        'issupport'=>[]
                    ];
                }
            } else {
                $arr = [
                    'status' => 1,
                    'comments' => [],
                    'issupport'=>[]
                ];
            }

        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //统计点赞
    public function support()
    {
        if (isset($_POST['id']) && isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['bopenid']) && isset($_POST['buid'])) {
            $model = new Content();
            $support = new Support();
            $userinfo=new Userinfo();

            //获取点赞表里面该用户有没有点过赞
            $isfirstsupport = DB::table('support')
                    ->where('uid', '=', $_POST['uid'])
                    ->get();
            //获取评论表里面该用户有没有评论
            $isfirstcomments = DB::table('support')
                ->where('uid', '=', $_POST['uid'])
                ->get();

            DB::beginTransaction();
            $supports = $support->addsupport($_POST);
            $models = $model->addsupport($_POST['id']);
            //统计用户被点赞次数
            $userinfos=$userinfo->addsupport($_POST);
            if ($models && $supports && $userinfos) {
                DB::commit();
                //修改用户表的状态为消息提醒
//                $user = DB::table('content')
//                    ->select('openid', 'uid')
//                    ->where('id', '=', $_POST['id'])
//                    ->first();
                DB::table('userinfo')
                    ->where('openid', '=', $_POST['bopenid'])
                    ->where('uid', '=', $_POST['buid'])
                    ->update([
                        'tix' => 1
                    ]);
                //获取用户的昵称
//                $userone = DB::table('userinfo')
//                    ->select('name', 'nickname')
//                    ->where('openid', '=', $_POST['openid'])
//                    ->first();
//                if($userone->name){
//                    //发送模板消息
//                    $send=new SendController();
//                    $send->send($_POST['bopenid'],$userone->name,$_POST['id']);
//                }else{
//                    //发送模板消息
//                    $send=new SendController();
//                    $send->send($_POST['bopenid'],$userone->nickname,$_POST['id']);
//                }
                //如果该用户第一次点赞或评论加20句豆
                if ($isfirstsupport->isEmpty() || $isfirstcomments->isEmpty()) {
                    DB::table('userinfo')
                        ->where('openid', '=', $_POST['openid'])
                        ->where('uid', '=', $_POST['uid'])
                        ->update([
                            'newbeans' => 20
                        ]);
                    $arr = [
                        'status' => 1,
                        'new' => 0,
                        'info' => '点赞成功'
                    ];
                }else{
                    $arr = [
                        'status' => 1,
                        'new' => 1,
                        'info' => '点赞成功'
                    ];
                }

            } else {
                DB::rollBack();
                $arr = [
                    'status' => 1,
                    'contents' => '点赞失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //拉新
    public function newfans()
    {
        $uid = '5cd02244bb62f';
        $openid = 'otV6H5A4WYGj_wUjENju8gtJa7TA';
        $fuid = '1557122526';
        $type = 1;
//        if (isset($_POST['contentid']) && isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['fuid']) && isset($_POST['fopenid'])) {
            $re = DB::table('user')
                ->where('uid', '=', $uid)
                ->where('openid', '=', $openid)
                ->first();

            $fid = $re->fuid;//获取该用户的父id
//            var_dump($fid);exit;
            DB::beginTransaction();
           if($fid == null){
               DB::commit();
               DB::table('user')
                   ->where('openid', '=', $openid)
                   ->where('uid', '=', $uid)
                   ->update([
                       'fuid' => $fuid,
                       'type' => $type
                   ]);
               //userinfo表fans字段自增1
               DB::table('userinfo')
                   ->where('uid','=',$fuid)
                   ->increment('fans');
//               var_dump($fans);exit;

               //查询用户详情表里面通过拉新获取的豆子
               $res = DB::table('userinfo')
                   ->where('uid', '=', $fuid)
                   ->first();
               //该父id拉新数量
               $fan = $res->fans;
               //该父id通过拉新获取到的已有句豆
               $bean = $res->beans;
               //记录该用户是第几个粉丝
               DB::table('user')
                   ->where('openid', '=', $openid)
                   ->where('uid', '=', $uid)
                   ->update([
                       'rank' => $fan
                   ]);
               //判断拉新数量给句豆
               if($fan <= 5){
                   $beans = 10;
               }elseif ($fan>5 && $fan<=10){
                   $beans = 15;
               }elseif ($fan>10 && $fan<=20){
                   $beans = 20;
               }elseif ($fan>20 && $fan<=50){
                   $beans = 25;
               }
               //计算总拉新句豆
               $bea = $bean+$beans;
//               var_dump($bea);exit;
               //更新句豆
               DB::table('userinfo')
                   ->where('uid', '=', $fuid)
                   ->update([
                       'beans' => $bea
                   ]);
               $arr = [
                   'status' => 1,
                   'contents' => '拉新成功'
               ];
           }else{
               DB::rollBack();
               $arr = [
                   'status' => 0,
                   'contents' => '拉新失败'
               ];
           }
            exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
//        }
    }

    //获取判断有没有name
    public function name()
    {
        $uid = $_POST['uid'];
//        $uid = '1557122526';
        $user = DB::table('userinfo')
            ->where('uid', '=', $uid)
            ->first();
        $name = $user->name;
        if($name == ''){
            $name = '';
        }else{
            $name = $user->name;
        }
        return $name;
//        var_dump($name);exit;
    }

    public function test()
    {
        $uid = '5ce2ce62638a2';


        $page=isset($_POST['page']) ? $_POST['page'] : 1;
        $limit=isset($_POST['len']) ? $_POST['len'] : 10;
        $offset=($page-1)*$limit;
        $user = DB::table('user')
            ->select('user.openid','user.uid','user.type','user.rank','user.fuid')
            ->where('user.fuid','=',$uid)
            ->get();

        foreach($user as $k=>$v){
            $uid = $v->uid;

            $userinfo = DB::table('userinfo')
                ->select('userinfo.openid','userinfo.uid','userinfo.photo','userinfo.name','userinfo.nickname','userinfo.avatarurl','userinfo.avatarurl')
                ->where('userinfo.uid','=',$uid)
                ->first();
//            var_dump($userinfo);exit;
            if($userinfo == null){
                $res[] = [
                    //'id'=>$vv->id,
                    'nickname' => '',
                    'avatarurl' => '',
                    'photo' => '',
                    'name' => '',
                    'type' => $v->type,
                    'rank' => $v->rank
                ];

            }else{
                $res[] = [
                    'nickname' => $userinfo->nickname,
                    'avatarurl' => $userinfo->avatarurl,
                    'photo' => $userinfo->photo,
                    'name' => $userinfo->name,
                    'type' => $v->type,
                    'rank' => $v->rank
                ];
            }
        }
        $count = count($res);
        $arr = [
            'status' => 1,
            'count' => $count,
            'info' => $res,
        ];

        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //查询(发现页)
    public function query()
    {
        $result = DB::table('userinfo')
            ->get();
        foreach ($result as $a=>$b){
            var_dump($b->uid);

            $isfirstsupport = DB::table('support')
                ->where('uid', '=', $b->uid)
                ->get();
            $isfirstcomments = DB::table('comments')
                ->where('uid', '=', $b->uid)
                ->get();
            //判断是否点过赞并且没有评论过
            if ($isfirstsupport->isEmpty() && $isfirstcomments->isEmpty()) {
                $arr = [
                    'status' => 0,
                    'info' => '未点过赞或评论'
                ];
            }else{
                DB::table('userinfo')
                    ->where('uid', '=', $b->uid)
                    ->update([
                        'newbeans' => 20+$b->newbeans,
                    ]);
                $datas = [
                    'uid' => $b->uid,
                    'source' => 2,
                    'time' => time(),
                    'date' => date('Y-m-d',time()),
                    'beans' => 20,
                ];
                DB::table('beansource')
                    ->insert($datas);
            }
        }exit;
//        var_dump($result);exit;
        if(isset($_POST['uid'])) {

            $isfirstsupport = DB::table('support')
                ->where('uid', '=', $_POST['uid'])
                ->get();
            $isfirstcomments = DB::table('comments')
                ->where('uid', '=', $_POST['uid'])
                ->get();
            //判断是否点过赞并且没有评论过
            if ($isfirstsupport->isEmpty() && $isfirstcomments->isEmpty()) {
                $arr = [
                    'status' => 0,
                    'info' => '未点过赞或评论'
                ];
            }else{
                DB::table('userinfo')
                    ->where('uid', '=', $uid)
                    ->update([
                        'newbeans' => 20,
                    ]);
            }
        }else{
            $arr = [
                'status' => 0,
                'beans' => '',
                'info' => '查询失败'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    public function querys(){
        if(isset($_POST['uid'])) {
            $uid = $_POST['uid'];
            $isfirstsupport = DB::table('support')
                ->where('uid', '=', $uid)
                ->get();
            $isfirstcomments = DB::table('comments')
                ->where('uid', '=', $uid)
                ->get();
            //判断是否点过赞并且没有评论过
            if ($isfirstsupport->isEmpty() && $isfirstcomments->isEmpty()) {
                $arr = [
                    'status' => 0,
                    'info' => '未点过赞或评论'
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'info' => '已完成'
                ];
            }
        }else{
            $arr = [
                'status' => 0,
                'beans' => '',
                'info' => '查询失败'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    public function tests(){
        $uid = '111';
        $a = 2;
        $b = 2;
        $uidredis = Rediss::get('uid');
        var_dump($uidr);
        if($uidredis){
            var_dump("正在进行签到操作，请勿重复操作！");
        }else{
            var_dump(2);
            if($a == 2){
                $uidre = Rediss::setex('uid',60,$uid);
                if($b == 2){
                    var_dump("签到成功");
                    //签到成功清除redis
                    Rediss::delete('uid');
                }
            }
        }
//        $uidredis = Rediss::setex('uid',60,$uid);
//        $uidredis = Rediss::setex('uid',60,$uid);
//        Rediss::delete('uid');
//        if (!$uidredis){
//            Rediss::delete('uid');
//        }else{
//            var_dump($uidredis);
//        }

    }

    public function newinfo(){
        if (isset($_POST['encryptedData']) && isset($_POST['iv']) && isset($_POST['seesion_key']) && isset($_POST['uid'])) {
            $user = new PublicController();
            $userinfo = $user->decryptData($_POST['encryptedData'], $_POST['iv'], $_POST['seesion_key']);
            var_dump($userinfo);exit;
            if ($userinfo) {
                // $user = new Userinfo();
                // $users = $user->userInfo($userinfo, $_POST['uid']);
                $re=$this
                ->where('openid', $userinfo['openId'])
                ->where('uid','=',$_POST['uid'])
                ->exists();
                if ($users) {
                    $data = array(
                        'status' => 1,
                        'info' => '获取成功'
                    );
                } else {
                    $data = array(
                        'status' => 0,
                        'info' => '请从新获取'
                    );
                }
            } else {
                $data = array(
                    'status' => 0,
                    'info' => '获取失败'
                );
            }
        } else {
            $data = array(
                'status' => 0,
                'info' => '参数错误'
            );
        }
        exit(json_encode($data, JSON_UNESCAPED_UNICODE));
    }
}
