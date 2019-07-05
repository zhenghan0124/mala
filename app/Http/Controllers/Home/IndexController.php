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
class IndexController extends Controller
{
    protected $table = 'user';//指定表明
    //用户登录接口
    public function dologin()
    {
        //echo $_POST['code'];exit;
        if (Input::method() == 'POST') {
            //解析code
            $public = new PublicController;
            $user = $public->getUserInfo($_POST['code']);
            $users = new User();
            $userone = $users->getuserone($user['openid']);
            //dd($userone);
            if ($userone) {
                $userinfo = array(
                    'status' => 1,
                    'openid' => $userone['openid'],
                    'session_key' => $user['session_key'],
                    'uid' => $userone['uid'],
                );
            } else {
                $uid = uniqid();
                $userinfos = $users->adduser($user['openid'], $uid);
                if ($userinfos) {
                    $userinfo = array(
                        'status' => 1,
                        'openid' => $userinfos['openid'],
                        'session_key' => $user['session_key'],
                        'uid' => $userinfos['uid'],
                    );
                } else {
                    $userinfo = array(
                        'status' => 0,
                        'info' => '获取用户信息失败'
                    );
                }
            }

        } else {
            //参数错误
            $userinfo = array(
                'status' => 0,
                'info' => '参数错误'
            );
        }
        exit(json_encode($userinfo, JSON_UNESCAPED_UNICODE));
    }

    //授权之后获取用户信息
    public function getuserinfo()
    {

        if (isset($_POST['encryptedData']) && isset($_POST['iv']) && isset($_POST['seesion_key']) && isset($_POST['uid'])) {
            $user = new PublicController();
            $userinfo = $user->decryptData($_POST['encryptedData'], $_POST['iv'], $_POST['seesion_key']);
            if ($userinfo) {
                $user = new Userinfo();
                $users = $user->userInfo($userinfo, $_POST['uid']);
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

    //分类接口
    public function dotype()
    {
        //获取分类
        $type = new Type();
        $types = $type->getType();
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

    //首页
    public function doindex()
    {

        //获取内容
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['len']) ? $_POST['len'] : 10;
        $offset = ($page - 1) * $limit;
        $content = new Content();
//        $_POST['typeid'] = 11;
        $_POST['openid'] = '1557122526';
        $_POST['uid'] = '1557122526';
//        var_dump($_POST['typeid']);exit;
        if ($_POST['typeid']) {
            $contents = $content->getContent($offset, $limit, $_POST['typeid']);
        } else {

            $contents = $content->getContents($offset, $limit);
        }
//            var_dump($contents);
            $type = DB::table('type')
                ->get();
//            var_dump($type);exit;
            foreach ($contents as $value){
                foreach ($type as $v){
                    if($value->typeid == $v->id){
                        $value->typetitle = $v->title;
                    }
                }
            }
//        }
//        var_dump($contents);exit;
//        exit;
        if ($contents) {
            $support = new Support();
            foreach ($contents as $v) {
                $contentid[] = $v->id;
            }
            $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
            if ($supports) {
//                foreach($contents as $k=>$v){
//                    foreach($supports as $vv){
//                        if($v['id']==$vv['contentid'] && $vv['openid']==$_POST['openid'] && $vv['uid']==$_POST['uid']){
//                            $contents[$k]['dianji']=1;
//                        }else{
//                            $contents[$k]['dianji']='';
//                        }
//                    }
//                }
//            }
                $arr = [
                    'status' => 1,
                    'contents' => $contents,
                    'supports' => $supports
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'contents' => $contents,
                    'supports' => []
                ];
            }

        } else {
            $arr = [
                'status' => 1,
                'contents' => [],
                'supports' => []
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //发现（一周精选）
    public function selected()
    {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['len']) ? $_POST['len'] : 1;
        $offset = ($page - 1) * $limit;
        $model = new Content();
        $models = $model->getSelected($offset, $limit, $selected = 2);

        if ($models) {
            $support = new Support();
            foreach ($models as $v) {
                $contentid[] = $v->id;
            }
            $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
            if ($supports) {
                $arr = [
                    'status' => 1,
                    'contents' => $models,
                    'supports' => $supports
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'contents' => $models,
                    'supports' => []
                ];
            }
        } else {
            $arr = [
                'status' => 1,
                'contents' => [],
                'supports' => []
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //发现（关注）
    public function focus()
    {
//        $_POST['openid']='otV6H5A0YDS8XYdI6hQHKm5P6hEw';
//        $_POST['uid']='5cd022665293d';
//        $_POST['page']=1;
        if (isset($_POST['openid']) && isset($_POST['uid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $model = new Focus();
            $focus = $model->getFocusContent($_POST, $offset, $limit);
            if ($focus) {
                $content = new Content();
                //$contentss=[];
                $pages = 1;
                $limits = 5;
                $offsets = ($pages - 1) * $limit;
                foreach ($focus as $v) {
                    //$bopenid[]=$v->bopenid;//被关注人的openid
                    $contents = $content->getUserContentOne($v->bopenid, $v->buid, $offsets, $limits);
                    if ($contents) {
                        //$contentid[]=$v->id;
                        foreach ($contents as $kk => $vv) {
                            $support = new Support();
                            $supports = $support->isSupport($vv->id, $_POST['openid'], $_POST['uid']);
                            if ($supports) {
                                $issupport = 1;
                            } else {
                                $issupport = 0;
                            }
                            $contentss[] = [
                                //'id'=>$vv->id,
                                'nickname' => $v->nickname,
                                'avatarurl' => $v->avatarurl,
                                'photo' => $v->photo,
                                'name' => $v->name,
                                'note' => $v->note,
                                'issupport' => $issupport,
                                //'comments'=>$vv->comments,
                                'contents' => $vv,
                            ];
                        }
                    }
                }
                $arr = [
                    'status' => 1,
                    'contents' => $contentss,
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'contents' => [],
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr));
    }

    //通过id获取当前文章
    public function contentone()
    {
        if (isset($_POST['id']) && isset($_POST['openid']) && isset($_POST['uid'])) {
            $model = new Content();
            $models = $model->getContentOne($_POST['id']);
            $supports = DB::table('support')
                ->where('contentid', '=', $_POST['id'])
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->first();
            if ($supports) {
                $support = 1;
            } else {
                $support = 0;
            }
            $collections = DB::table('collection')
                ->where('contentid', '=', $_POST['id'])
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->first();
            if ($collections) {
                $collection = 1;
            } else {
                $collection = 0;
            }
            if ($models) {
                $arr = [
                    'status' => 1,
                    'content' => $models,
                    'dianji' => $support,
                    'collection' => $collection,
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'content' => [],
                    'dianji' => $support,
                    'collection' => $collection,
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
}
