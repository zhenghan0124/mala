<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;
use DB;
class Userinfo extends Model
{
    //添加用户的信息到数据库
    protected $table = 'userinfo';//指定表明
    protected $primarykey = 'id';//指定主键（可选）
    public $timestamps = false;
    //允许写入的字段（可选（create））
    protected $fillable = [

    ];
    //授权获取用户的信息
    public function userInfo($data,$uid){
        $re=$this
            ->where('openid', $data['openId'])
            ->where('uid','=',$uid)
            ->exists();
        if($re){
            $model = $this
                ->where('openid','=',$data['openId'])
                ->where('uid','=',$uid)
                ->update(
                    [
                        'nickname'=>$data['nickName'],
                        'gender' => $data['gender'],
                        'gender' => $data['gender'],
                        'province' => $data['province'],
                        'city' => $data['city'],
                        'country' => $data['country'],
                        'avatarurl' => $data['avatarUrl'],
                    ]
                );
            return true;
        }else{
            $datas = array(
                'openid' => $data['openId'],
                'uid' => $uid,
                'nickname' => $data['nickName'],
                'gender' => $data['gender'],
                'province' => $data['province'],
                'city' => $data['city'],
                'country' => $data['country'],
                'avatarurl' => $data['avatarUrl'],
            );
            $model = $this
                ->insert($datas);
            if($model){
                return true;
            }else{
                return false;
            }
        }
    }
    //用户编辑个人信息
    public function editor($data){
        $model = $this
            ->where('openid','=',$data['openid'])
            ->where('uid','=',$data['uid'])
            ->update(
                [
                    'name'=>$data['nickName'],
                    'photo'=>$data['photo'],
                    'note' => isset($data['note']) ? $data['note'] : '',
                ]
            );
        if($model){
            return true;
        }else{
            return false;
        }
    }

    //收集用户被关注次数
    public function addfocus($data){
        $model = $this
            ->where('openid','=',$data['bopenid'])
            ->where('uid','=',$data['buid'])
            ->increment('focus');
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //收集用户关注次数
    public function addfocu($data){
        $model = $this
            ->where('openid','=',$data['openid'])
            ->where('uid','=',$data['uid'])
            ->increment('focu');
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //统计点赞
    public function addsupport($data){
        $model = $this
            ->where('openid','=',$data['bopenid'])
            ->where('uid','=',$data['buid'])
            ->increment('support');
        if($model){
            return true;
        }else{
            return false;
        }
    }

    //获取用户的个人信息以及关注，点赞
    public function getUserInfo($data){
        $model=$this
            //->select('userinfo.*',DB::raw('sum(content.support) as support'))
            ->select('userinfo.*')
//            ->join('content', function ($join) {
//                $join->on('content.openid', '=', 'userinfo.openid')
//                    ->where('type.status', '=', 1);
//            })
            ->leftjoin('content', 'content.openid', '=', 'userinfo.openid')
            ->where('userinfo.openid','=',$data['openid'])
            ->where('userinfo.uid','=',$data['uid']);
           // ->groupBy('userinfo.id');
        if($model->exists()){
            return $model->first();
        }else{
            return false;
        }
    }
}
