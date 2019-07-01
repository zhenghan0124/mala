<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;

class Focus extends Model
{
    protected $table = 'focus';//指定表明
    protected $primarykey = 'id';//指定主键（可选）
    public $timestamps = false;
    //允许写入的字段（可选（create））
    protected $fillable = [

    ];
    //收集关注信息
    public function addfocus($data){
//        $re=$this
//            ->where('bopenid','=',$data['bopenid'])
//            ->where('buid','=',$data['buid'])
//            ->where('openid','=',$data['openid'])
//            ->where('uid','=',$data['uid'])
//            ->exists();
        $datas=[
            'bopenid'=>$data['bopenid'],
            'buid'=>$data['buid'],
            'openid'=>$data['openid'],
            'uid'=>$data['uid'],
            'time'=>time(),
        ];
        $model=$this
            ->insert($datas);
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //获取该用户是否关注
    public function isfocus($data){
        $model=$this
            ->where('bopenid','=',$data['bopenid'])
            ->where('buid','=',$data['buid'])
            ->where('openid','=',$data['openid'])
            ->where('uid','=',$data['uid'])
            ->exists('bopenid','=',$data['bopenid']);
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //获取用户关注人的信息
    public function getFocusUser($data,$offset,$limit){
        $model=$this
            ->select('userinfo.openid','userinfo.uid','userinfo.photo','userinfo.name','userinfo.nickname','userinfo.avatarurl','userinfo.avatarurl')
            ->leftjoin('userinfo', 'userinfo.openid', '=', 'focus.bopenid')
            ->where('focus.openid','=',$data['openid'])
            ->where('focus.uid','=',$data['uid'])
            ->orderBy('focus.dtime','desc')
            ->offset($offset)
            ->limit($limit);
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }
    //获取用户粉丝的信息
    public function getFans($data,$offset,$limit){
        $model=$this
            ->select('userinfo.openid','userinfo.uid','userinfo.photo','userinfo.name','userinfo.nickname','userinfo.avatarurl','userinfo.note')
            ->leftjoin('userinfo', 'userinfo.openid', '=', 'focus.openid')
            ->where('focus.bopenid','=',$data['openid'])
            ->where('focus.buid','=',$data['uid'])
            ->orderBy('focus.dtime','desc')
            ->offset($offset)
            ->limit($limit);
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }
    //发现（关注）
    public function getFocusContent($data,$offset,$limit){
        $model=$this
            ->select('focus.bopenid as bopenid','focus.buid as buid','userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name','userinfo.note')
            ->leftjoin('userinfo', 'focus.bopenid', '=', 'userinfo.openid')
            //->where('content.fabutype', '=', 2)
            ->where('focus.openid','=',$data['openid'])
            ->where('focus.uid','=',$data['uid'])
            ->orderBy('focus.dtime','desc')
            ->offset($offset)
            ->limit($limit);
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }


}
