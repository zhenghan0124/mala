<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;

class Formid extends Model
{
    protected $table = 'formid';//指定表明
    protected $primarykey = 'formid';//指定主键（可选）
    public $timestamps = false;
    //允许写入的字段（可选（create））
    protected $fillable = [

    ];
    //收集formid
    public function addFormid($data){
        $datas=[
          'formid'=>$data['formid'],
          'openid'=>$data['openid'],
          'uid'=>$data['uid'],
          'datas'=>date('Y-m-d',time()),
          'dtime'=>time()
        ];
        $re=$this
            ->insert($datas);
        if($re){
            return true;
        }else{
            return false;
        }
    }
    //获取formid
    public function getFormid($openid){
        $formid=$this
            ->where('openid','=',$openid)
            ->whereBetween('dtime', [time()-(6*24*60*60),time()]);
        if($formid->exists()){
            return $formid->first();
        }else{
            return false;
        }
    }
    //删除当前的formid
    public function delformid($formid){
        $re=$this
            ->where('formid','=',$formid)
            ->delete();
        if($re){
            return true;
        }else{
            return false;
        }
    }
}
