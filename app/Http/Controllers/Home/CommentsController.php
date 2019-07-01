<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class CommentsController extends Controller
{
    //收集评论信息
    public function addComments(){
        if(isset($_POST['contentid']) && isset($_POST['title']) && isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['bopenid']) && isset($_POST['buid'])){
            DB::beginTransaction();
            //添加评论内容
            $comments=DB::table('comments')
                ->insert([
                    'contentid'=>$_POST['contentid'],
                    'title'=>$_POST['title'],
                    'bopenid'=>$_POST['bopenid'],
                    'buid'=>$_POST['buid'],
                    'openid'=>$_POST['openid'],
                    'uid'=>$_POST['uid'],
                    'time'=>time()
                ]);
            //统计评论的条数
            $content=DB::table('content')
                ->where('id','=',$_POST['contentid'])
                ->increment('comments');
            if($comments && $content){
                DB::commit();
                //修改用户的消息提醒
                DB::table('userinfo')
                    ->where('openid', '=', $_POST['bopenid'])
                    ->where('uid', '=', $_POST['buid'])
                    ->update([
                        'tix' => 1
                    ]);
                //获取用户的昵称
                $userone = DB::table('userinfo')
                    ->select('name', 'nickname')
                    ->where('openid', '=', $_POST['openid'])
                    ->first();
                if($userone->name){
                    //发送模板消息
                    $send=new SendController();
                    $send->send($_POST['bopenid'],$userone->name,$_POST['contentid']);
                }else{
                    //发送模板消息
                    $send=new SendController();
                    $send->send($_POST['bopenid'],$userone->nickname,$_POST['contentid']);
                }
                //获取点赞表里面该用户有没有点过赞
                $isfirstsupport = DB::table('support')
                    ->where('uid', '=', $_POST['uid'])
                    ->get();
                //获取评论表里面该用户有没有评论
                $isfirstcomments = DB::table('comments')
                    ->where('uid', '=', $_POST['uid'])
                    ->get();

                //如果该用户第一次点赞或评论加20句豆
                if ($isfirstsupport->isEmpty() && $isfirstcomments->isEmpty()) {
                    $newbeans = DB::table('userinfo')
                        ->where('uid', '=', $_POST['uid'])
                        ->first();
                    //获取第一次点赞评论句豆
                    $beans = $newbeans->newbeans;
                    $new = DB::table('userinfo')
                        ->where('openid', '=', $_POST['openid'])
                        ->where('uid', '=', $_POST['uid'])
                        ->update([
                            'newbeans' => $beans+20
                        ]);
                    //记录句豆来源
                    if($new){
                        $datas = [
                            'uid' => $_POST['uid'],
                            'source' => 2,
                            'time' => time(),
                            'date' => date('Y-m-d',time()),
                            'beans' => 20,
                        ];
                        DB::table('beansource')
                            ->insert($datas);
                    }
                    $arr = [
                        'status' => 1,
                        'new' => 0,
                        'info' => '评论成功'
                    ];
                }else {
                    $arr = [
                        'status' => 1,
                        'new' => 1,
                        'info' => '评论成功'
                    ];
                }
            }else{
                DB::rollBack();
                $arr = [
                    'status' => 0,
                    'info' => '评论失败'
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
    //收集评论的点赞次数
    public function addSupport(){
        if(isset($_POST['commentsid']) &&isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['bopenid']) && isset($_POST['buid'])){
            DB::beginTransaction();
            $re=DB::table('comments')
                ->where('id','=',$_POST['commentsid'])
                ->increment('support');
            $support=DB::table('commentsupport')
                ->insert($_POST);
            if($re && $support){
                DB::commit();
                $arr = [
                    'status' => 1,
                    'info' => '点赞成功'
                ];
            }else{
                DB::rollBack();
                $arr = [
                    'status' => 0,
                    'info' => '点赞失败'
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

}
