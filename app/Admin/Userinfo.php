<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected $table='userinfo';//指定表明
    protected $primarykey='id';//指定主键（可选）
    public $timestamps=false;
    //允许写入的字段（可选（create））
    protected $fillable=[
        'id',
        'openid',
        'uid',
        'nickname',
        'avatarurl',
        'type'
    ];

    //添加数据
    public function addfabur($data,$imgurl){
        $datas=[
            'openid'=>time(),
            'uid'=>time(),
            'nickname'=>$data['nickname'],
            'photo'=>$imgurl,
            'type'=>2
        ];
        $model=$this
            ->insert($datas);
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //修改数据
    public function updatefabur($id,$data){
        $model=$this
            ->where('id','=',$id)
            ->update(['nickname'=>$data['nickname']]);
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //修改数据
    public function updatefaburimg($id,$data,$avatarurl){
        $model=$this
            ->where('id','=',$id)
            ->update(
                ['nickname'=>$data['nickname'],
                  'photo'=>$avatarurl
            ]);
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //查询所有后台发布人员
    public function getFabur(){
        $model=$this
            ->where('type','=',2)
            ->get();
        if($model){
            return $model;
        }else{
            return false;
        }
    }
}
