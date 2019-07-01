<?php

namespace App\Http\Controllers\Home;

use App\Home\Formid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class FormidController extends Controller
{
    //收集formid
    public function formid()
    {
        if(isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['formid'])){
            $model=new Formid();
            $re=$model->addFormid($_POST);
            if($re){
                $arr=[
                    'status'=>1,
                    'info'=>'收集成功'
                ];
            }else{
                $arr=[
                    'status'=>0,
                    'info'=>'收集失败'
                ];
            }
        }else{
            $arr=[
                'status'=>0,
                'info'=>'缺少参数'
            ];
        }
        exit(json_encode($arr));
    }
}
