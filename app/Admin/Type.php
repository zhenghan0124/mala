<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table='type';//指定表明
    protected $primarykey='id';//指定主键（可选）
    public $timestamps=false;
    //允许写入的字段（可选（create））
    protected $fillable=[
        'id',
        'title',
    ];
    //将分类写入数据库
    public function addtype($data){
        $model=$this
            ->insert($data);
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //查询分类
    public function type(){
        $model=$this
            ->orderBy('location')
            ->get();
        if($model){
            return $model;
        }else{
            return false;
        }
    }
    //查询status=1的分类
    public function normaltype(){
        $model=$this
            ->where('status','=',1)
            ->get();
        if($model){
            return $model;
        }else{
            return false;
        }
    }
}
