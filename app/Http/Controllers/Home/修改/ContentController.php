<?php

namespace App\Http\Controllers\Home;

use App\Home\Content;
use App\Home\Focus;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Home\Support;
use DB;

class ContentController extends Controller
{
    //获取该用户的信息和文章(他们主页)
    public function getusercontent()
    {
        if (isset($_POST['bopenid']) && isset($_POST['buid']) && isset($_POST['uid']) && isset($_POST['openid'])) {
            $focus = new Focus();
            $content = new Content();
            $isfocus = $focus->isfocus($_POST);//是否有关注
            if ($isfocus) {
                $guanzhu = 1;
            } else {
                $guanzhu = 0;
            }
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $contents = $content->getUserContents($_POST, $offset, $limit);
            if ($contents) {
                $support = new Support();
                foreach ($contents as $v) {
                    $contentid[] = $v->id;
                }
                $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
                if ($supports) {
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'focus' => $guanzhu,
                        'support' => $supports
                    ];
                } else {
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'focus' => $guanzhu,
                        'support' => []
                    ];
                }
            } else {
                $arr = [
                    'status' => 1,
                    'contents' => [],
                    'focus' => $guanzhu
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

    //获取用户的所有文章（动态）
    public function getusercontents(){
        if(isset($_POST['openid']) && isset($_POST['uid']) ){
            $model=new Content();
            $page=isset($_POST['page']) ? $_POST['page'] : 1;
            $limit=isset($_POST['len']) ? $_POST['len'] : 20;
            $offset=($page-1)*$limit;
            $contents=$model->getUserContentss($_POST['openid'],$_POST['uid'],$offset,$limit);
            if($contents){
                //获取该用户的点赞文章id
                $support = new Support();
                foreach ($contents as $v) {
                    $contentid[] = $v->id;
                }
                $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
                if($supports){
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'support' => $supports
                    ];
                }else{
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'support' => []
                    ];
                }
            }else{
                $arr = [
                    'status' => 1,
                    'contents' => [],
                    'support' => []
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

    //收藏文章(点击收藏)
    public function collection()
    {
        if (isset($_POST['contentid']) && isset($_POST['openid']) && isset($_POST['uid'])) {
            $re = DB::table('collection')
                ->insert($_POST);
            if ($re) {
                $arr = [
                    'status' => 1,
                    'info' => '收藏成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '收藏失败'
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

    //取消收藏文章(取消收藏)
    public function delcollection()
    {
        if (isset($_POST['contentid']) && isset($_POST['openid']) && isset($_POST['uid'])) {
            $re = DB::table('collection')
                ->where('contentid', '=', $_POST['contentid'])
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->delete();
            if ($re) {
                $arr = [
                    'status' => 1,
                    'info' => '取消成功'
                ];
            } else {
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

    //我的收藏
    public function mycollection()
    {
        if (isset($_POST['openid']) && isset($_POST['uid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $re = DB::table('collection')
                ->select('contentid')
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->orderBy('time', 'desc')
                ->offset($offset)
                ->limit($limit);
            if ($re->exists()) {
                foreach ($re->get() as $v) {
                    $contentid[] = $v->contentid;
                }
                $model = new Content();
                $mycollection = $model->getMycollection($contentid);
                if ($mycollection) {
                    $support = new Support();
                    $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
                    if ($supports) {
                        $arr = [
                            'status' => 1,
                            'mycollection' => $mycollection,
                            'support' => $supports
                        ];
                    } else {
                        $arr = [
                            'status' => 1,
                            'mycollection' => $mycollection,
                            'support' => []
                        ];
                    }
                } else {
                    $arr = [
                        'status' => 1,
                        'mycollection' => [],
                        'support' => []
                    ];
                }
            } else {
                $arr = [
                    'status' => 1,
                    'mycollection' => []
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

    //用户发布文章（发布）上传图片
    public function uploadimg(Request $request)
    {
        //查看是否有图片上传
        if ($request->hasFile('image')) {
            //dd($request->hasFile('image'));
            $rootpath = './upload/usercontent/';
            $filename = time().rand(1,9).rand(1,9).rand(1,9) . '.png';
            $request->file('image')->move($rootpath, $filename);
            $imgurl = trim($rootpath, '.') . $filename;
            $arr = [
                'status' => 1,
                'info' => '上传图片成功',
                'imgurl' => $imgurl
            ];
        } else {
            $arr = [
                'status' => 0,
                'info' => '参数错误'
            ];
        }
        exit(json_encode($arr));
    }


    //用户发布文章（发布）(fabutype=1)
    public function userrelease()
    {
        if (isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['typeid']) && isset($_POST['title'])) {
            //提交发布
            $model = new Content();
            $content = $model->addcontent($_POST);
            if ($content) {
                //查询该用户是否是第一次发布文章
                $isfirstcontent = DB::table('content')
                    ->where('uid', '=', $_POST['uid'])
                    ->get();
                if ($isfirstcontent->isEmpty()) {
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
                            'source' => 4,
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
                        'contentid'=>$content,
                        'info' => '发布成功'
                    ];
                }else{
                    $beansource = DB::table('beansource')
                        ->where('uid', '=', $_POST['uid'])
                        ->where('source', '=', 4)
                        ->first();
                    //判断是否记录过第一次发布短句获取句豆
                    if(!$beansource){
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
                                'source' => 4,
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
                            'contentid'=>$content,
                            'info' => '发布成功'
                        ];
                    }else {
                        $arr = [
                            'status' => 1,
                            'new' => 1,
                            'contentid' => $content,
                            'info' => '发布成功'
                        ];
                    }
                }
//                $arr = [
//                    'status' => 1,
//                    'contentid'=>$content,
//                    'info' => '发布成功'
//                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '发布失败'
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
    //删除当前文章（status修改为2）
    public function delcontent(){
        if(isset($_POST['contentid'])){
            $model = new Content();
            $re=$model->delContent($_POST);
            if($re){
                $arr = [
                    'status' => 1,
                    'info' => '删除成功'
                ];
            }else{
                $arr = [
                    'status' => 0,
                    'info' => '删除失败'
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
