<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support';//指定表明
    protected $primarykey = 'id';//指定主键（可选）
    public $timestamps = false;
    //允许写入的字段（可选（create））
    protected $fillable = [

    ];
    public function addsupport($data){
        $datas=[
          'contentid'=>$data['id'],
          'openid'=>$data['openid'],
          'uid'=>$data['uid'],
          'bopenid'=>$data['bopenid'],
          'buid'=>$data['buid'],
          'time'=>time()
        ];
        $models=$this
            ->insert($datas);
        if($models){
            return true;
        }else{
            return false;
        }
    }
    public function getContent($contentid,$openid,$uid){
        $model = $this
            ->where('openid', '=', $openid)
            ->where('uid', '=', $uid)
            ->whereIn('contentid', $contentid);
            //->get();
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }
    public function isSupport($contentid,$openid,$uid){
        $model = $this
            ->where('openid', '=', $openid)
            ->where('uid', '=', $uid)
            ->where('contentid', '=',$contentid)
            ->exists();
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //获取谁赞了我（消息）
    public function message($data,$offset,$limit){
        $model=$this
            ->select('support.contentid','content.imgurl','userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name','userinfo.note')
            ->leftjoin('userinfo', 'support.openid', '=', 'userinfo.openid')
            //->where('content.fabutype', '=', 2)
            ->leftjoin('content','support.contentid','=','content.id')
            ->where('support.bopenid','=',$data['openid'])
            ->where('support.buid','=',$data['uid'])
            ->orderBy('support.time','desc')
            ->offset($offset)
            ->limit($limit);
        if($model->exists()){
            return $model->get();
        }else{
            return [];
        }
    }

}
