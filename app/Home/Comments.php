<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';//指定表明
    protected $primarykey = 'id';//指定主键（可选）
    public $timestamps = false;
    //允许写入的字段（可选（create））
    protected $fillable = [

    ];
    //获取评论
    public function getComments($contentid,$offset,$limit){
        $re=$this
            ->select('comments.id','comments.openid','comments.uid','comments.title','comments.support', 'userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name')
            ->leftjoin('userinfo', 'comments.openid', '=', 'userinfo.openid')
            ->where('comments.contentid','=',$contentid)
            ->orderBy('comments.time','desc')
            ->offset($offset)
            ->limit($limit);
        if($re->exists()){
            return $re->get();
        }else{
            return false;
        }
    }
    //获取谁评论了我（消息）
    public function message($data,$offset,$limit){
        $model=$this
            ->select('comments.contentid','comments.title','content.imgurl','userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name','userinfo.note')
            ->leftjoin('userinfo', 'comments.openid', '=', 'userinfo.openid')
            ->leftjoin('content','comments.contentid','=','content.id')
            //->where('content.fabutype', '=', 2)
            ->where('comments.bopenid','=',$data['openid'])
            ->where('comments.buid','=',$data['uid'])
            ->orderBy('comments.time','desc')
            ->offset($offset)
            ->limit($limit);
        if($model->exists()){
            return $model->get();
        }else{
            return [];
        }
    }


}
