<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'type';//指定表明
    protected $primarykey = 'id';//指定主键（可选）
    public $timestamps = false;
    //允许写入的字段（可选（create））
    protected $fillable = [
        'title',
    ];
    //获取分类
    public function getType(){
        $model=$this
            ->where('status','=','1')
            ->orderBy('location')
            ->get();
        if($model){
            return $model;
        }else{
            return false;
        }
    }

}
