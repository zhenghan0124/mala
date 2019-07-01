<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\Type;
use App\Admin\Content;
use DB;
class indexController extends Controller
{
    //文章管理
    public function content()
    {
        //获取分类（status=1）
        $model = new Type();
        $models = $model->normaltype();
        //获取该分类下的文章
        $content = new Content();
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        if (isset($_GET['id'])) {
            //获取该分类下的用户发布的文章
            $contents = $content->usercontent($_GET['id'], $limit);
            //dd($contents[0]);
            $count = $content->usercontentcount($_GET['id']);
            $arr = [
                'type' => $models,
                'content' => $contents,
                'count' => $count,
                'page' => $page,
                'id' => $_GET['id'],
            ];
        } else {
            //获取该分类下的用户发布的文章
            $contents = $content->usercontents( $limit);
            //dd($contents[0]);
            $count = $content->usercontentcounts();
            $arr = [
                'type' => $models,
                'content' => $contents,
                'count' => $count,
                'page' => $page,
            ];
        }
        return view('admin/index/content', $arr);
    }
    //获取当前文章的详情
    public function details(){
        if(isset($_GET['id'])){
            $content = new Content();
            $details=$content->getContentOne($_GET['id']);
            if($details){
                $arr=[
                    'content'=>$details
                ];
            }else{
                $arr=[
                    'content'=>[]
                ];
            }
        }else{
            $arr=[
                'content'=>[]
            ];
        }
        return view('admin/index/details',$arr);
    }
    //修改点前文章(审核通过)
    public function updatecontentone(){
        //dd($_POST);
        if(isset($_POST)){
            $re=DB::table('content')
                ->where('id','=',$_POST['id'])
                ->update([
                    'audit'=>1,
                    'selected'=>$_POST['selected'],
                    'recommended'=>$_POST['recommended'],
                    'tjtime'=>time()
                ]);
            if($re){
                $arr=[
                    'status'=>1,
                    'info'=>'修改成功'
                ];
            }else{
                $arr=[
                    'status'=>0,
                    'info'=>'修改失败'
                ];
            }
        }else{
            $arr=[
                'status'=>0,
                'info'=>'修改失败'
            ];
        }
        exit(json_encode($arr));
    }
}
