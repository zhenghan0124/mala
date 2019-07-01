<?php

namespace App\Http\Controllers\Home;

use App\Home\Comments;
use App\Home\Focus;
use App\Home\Support;
use App\Home\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use DB;

class UserController extends Controller
{
    public function uploadimg(Request $request)
    {
        if ($request->hasFile('photo')) {
            $rootpath = './upload/userimg/';
            $filename = time() . '.png';
            $file = $request->file('photo')->move($rootpath, $filename);
            $arr = [
                'status' => 1,
                'info' => '上传成功',
                'imgurl' => trim($rootpath . $filename, '.')
            ];
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr));
    }

    //编辑用户的信息
    public function editor()
    {

        if (isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['nickName']) && !empty($_POST['nickName']) && isset($_POST['photo'])) {
            $model = new Userinfo();
            $userinfo = $model->editor($_POST);//参数（openid,uid,photo,name,[note]）
            if ($userinfo) {
                $arr = [
                    'status' => 1,
                    'info' => '修改成功'
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'info' => '用户信息没有变化'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }

        exit(json_encode($arr));
    }

    //添加关注
    public function addfocus()
    {
        if (isset($_POST['bopenid']) && isset($_POST['buid']) && isset($_POST['openid']) && isset($_POST['uid'])) {
            $userinfo = new Userinfo();
            $focus = new Focus();
            DB::beginTransaction();
            $userinfofocus = $userinfo->addfocus($_POST);//用户表添加次数
            $userinfofocu = $userinfo->addfocu($_POST);//用户表添加次数
            $focusinfo = $focus->addfocus($_POST);//关注表添加信息
            if ($userinfofocus && $focusinfo && $userinfofocu) {
                DB::commit();
                //修改用户表的关注状态为消息提醒
                DB::table('userinfo')
                    ->where('openid', '=', $_POST['bopenid'])
                    ->where('uid', '=', $_POST['buid'])
                    ->update([
                        'guanzhu' => 1
                    ]);
                $arr = [
                    'status' => 1,
                    'info' => '关注成功'
                ];
            } else {
                DB::rollBack();
                $arr = [
                    'status' => 0,
                    'contents' => '关注失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //取消关注
    public function delfocus()
    {
        if (isset($_POST['bopenid']) && isset($_POST['buid']) && isset($_POST['openid']) && isset($_POST['uid'])) {
            DB::beginTransaction();
            $userinfo = DB::table('userinfo')
                ->where('openid', '=', $_POST['bopenid'])
                ->where('uid', '=', $_POST['buid'])
                ->decrement('focus');
            $userinfos = DB::table('userinfo')
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->decrement('focu');
            $focus= DB::table('focus')
                ->where('bopenid', '=', $_POST['bopenid'])
                ->where('buid', '=', $_POST['buid'])
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->delete();
            if($userinfo && $focus && $userinfos){
                DB::commit();
                $arr = [
                    'status' => 1,
                    'info' => '取消成功'
                ];
            }else{
                DB::rollBack();
                $arr = [
                    'status' => 0,
                    'info' => '取消失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //获取用户的信息（我的）
    public function getuserinfo()
    {
        if (isset($_POST['openid']) && isset($_POST['uid'])) {
            $model = new Userinfo();
            $userinfo = $model->getUserInfo($_POST);
            if ($userinfo) {
                $arr = [
                    'status' => 1,
                    'userinfo' => $userinfo
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'userinfo' => []
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }
    //获取用户关注人的信息(关注)
    public function focususer(){
        if(isset($_POST['uid']) && isset($_POST['uid'])){
            $model=new Focus();
            $page=isset($_POST['page']) ? $_POST['page'] : 1;
            $limit=isset($_POST['len']) ? $_POST['len'] : 10;
            $offset=($page-1)*$limit;
            $models=$model->getFocusUser($_POST,$offset,$limit);
            if($models){
                $arr = [
                    'status' => 1,
                    'focususer' => $models
                ];
            }else{
                $arr = [
                    'status' => 1,
                    'focususer' => []
                ];
            }
        }else{
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }
    //获取用户粉丝的信息(粉丝)
    public function fans(){
        if(isset($_POST['openid']) && isset($_POST['uid'])){
            $model=new Focus();
            $page=isset($_POST['page']) ? $_POST['page'] : 1;
            $limit=isset($_POST['len']) ? $_POST['len'] : 10;
            $offset=($page-1)*$limit;
            $models=$model->getFans($_POST,$offset,$limit);
            if($models){
                DB::table('userinfo')
                    ->where('openid', '=', $_POST['openid'])
                    ->where('uid', '=', $_POST['uid'])
                    ->update([
                        'guanzhu' => 0
                    ]);
                $arr = [
                    'status' => 1,
                    'fans' => $models
                ];
            }else{
                $arr = [
                    'status' => 1,
                    'fans' => []
                ];
            }
        }else{
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //获取消息（消息-谁评论了我）
    public function message(){
        if(isset($_POST['openid']) && isset($_POST['uid']) ){
            $page=isset($_POST['page']) ? $_POST['page'] : 1;
            $limit=isset($_POST['len']) ? $_POST['len'] : 10;
            $offset=($page-1)*$limit;
            //修改用户表的状态为消息取消提醒
            DB::table('userinfo')
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->update([
                    'tix' => 0
                ]);
            //获取谁评论了我
            $comment=new Comments();
            $comments=$comment->message($_POST,$offset,$limit);
            $arr = [
                'status' => 1,
                'comments'=>$comments,
            ];
        }else{
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //获取消息（消息-谁赞了我）
    public function support(){
        if(isset($_POST['openid']) && isset($_POST['uid']) ){
            $page=isset($_POST['page']) ? $_POST['page'] : 1;
            $limit=isset($_POST['len']) ? $_POST['len'] : 10;
            $offset=($page-1)*$limit;
            //修改用户表的状态为消息取消提醒
            DB::table('userinfo')
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->update([
                    'tix' => 0
                ]);
            //获取谁赞了我
            $support=new Support();
            $supports=$support->message($_POST,$offset,$limit);
            $arr = [
                'status' => 1,
                'supports'=>$supports,
            ];
        }else{
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

}
