<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Session;
class Admin extends Model
{
    //验证用户名和密码
    protected $table='admin';//指定表明
    protected $primarykey='id';//指定主键（可选）
    public $timestamps=false;
    //允许写入的字段（可选（create））
    protected $fillable=[
        'id',
        'username',
        'pwd',
    ];
    //验证用户名和密码
    public function auth($data){
        $model=$this
            ->where('username','=',$data['username'])
            ->where('pwd','=',md5($data['pwd']))
            ->first();
        if($model){
            Session::put('admin',$model);
            return $model;
        }else{
            return false;
        }
    }
}
