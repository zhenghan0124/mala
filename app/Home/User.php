<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;
use DB;
class User extends Model
{
    //添加用户的openid和uid添加到数据库
    protected $table = 'user';//指定表明
    protected $primarykey = 'openid';//指定主键（可选）
    public $timestamps = false;
    //允许写入的字段（可选（create））
    protected $fillable = [
        'openid',
        'uid',
    ];
    //查询当前用户
    public function getuserone($openid){
        $model=$this
            ->where('openid','=',$openid)
            ->first();
        if($model){
            return json_decode($model,true);
        }else{
            return false;
        }
    }

    //写入用户的信息
    public function adduser($openid, $uid)
    {
        $datas = [
            'openid' => $openid,
            'uid' => $uid
        ];
        $model = $this
            ->insert($datas);
        if ($model) {
            return $datas;
        } else {
            return false;
        }
    }
}
