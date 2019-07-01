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
class NewfansController extends Controller
{

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
        if ($_POST['typeid']) {
            $contents = $content->getContent($offset, $limit, $_POST['typeid']);
        } else {
            $contents = $content->getContents($offset, $limit);
        }
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

                $arr = [
                    'status' => 1,
                    'info' => '点赞成功'
                ];
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

    public function ()
    {
        
    }
}
