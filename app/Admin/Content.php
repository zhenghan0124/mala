<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table='content';//指定表明
    protected $primarykey='id';//指定主键（可选）
    public $timestamps=false;
    //允许写入的字段（可选（create））
    protected $fillable=[
        'id',
        'openid',
        'uid',
        'typeid',
        'title',
        'imgurl',
        'support',
        'status',
        'selected',
        'fabutype',
    ];
    //添加数据
    public function addcontent($data,$imgurl){
        $datas=[
            'openid'=>explode(',',$data['openid'])[0],
            'uid'=>explode(',',$data['openid'])[1],
            'typeid'=>$data['typeid'],
            'title'=>$data['title'],
            'imgurl'=>$imgurl,
            'support'=>$data['support'],
            'selected'=>$data['selected'],
            'fabutype'=>2,
            'dtime'=>time()
        ];
        $model=$this
            ->insert($datas);
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //查询后台发布的
    public function content($typeid,$limit){
        $model=$this
            ->select('content.*','userinfo.nickname','userinfo.avatarurl','type.title as typename')
            ->join('userinfo',function($join){
                $join->on('content.openid','=','userinfo.openid');
            })
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            ->where('content.fabutype','=',2)
            ->where('content.status','=',1)
            ->where('content.typeid','=',$typeid)
            ->orderBy('time', 'desc')
            ->simplePaginate($limit);
        if($model){
            return $model;
        }else{
            return false;
        }
    }

    //查询用户发布的（已审核的）
    public function usercontent($typeid,$limit){
        $model=$this
            ->select('content.*','userinfo.nickname','userinfo.avatarurl','type.title as typename')
            ->join('userinfo',function($join){
                $join->on('content.openid','=','userinfo.openid');
            })
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            ->where('content.fabutype','=',1)
            ->where('content.status','=',1)
            ->where('content.audit','=',1)
            ->where('content.typeid','=',$typeid)
            ->orderBy('time', 'desc')
            ->simplePaginate($limit);
        if($model){
            return $model;
        }else{
            return false;
        }
    }

    //查询用户发布的个数(已审核)
    public function usercontentcount($typeid){
        $model=$this
            ->where('fabutype','=',1)
            ->where('content.status','=',1)
            ->where('content.audit','=',1)
            ->where('typeid','=',$typeid)
            ->count();
        if($model){
            return $model;
        }else{
            return 0;
        }
    }

    //查询用户发布的（待审核的）
    public function usercontents($limit){
        $model=$this
            ->select('content.*','userinfo.nickname','userinfo.avatarurl','type.title as typename')
            ->join('userinfo',function($join){
                $join->on('content.openid','=','userinfo.openid');
            })
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            ->where('content.fabutype','=',1)
            ->where('content.status','=',1)
            ->where('content.audit','=',2)
            ->orderBy('time', 'desc')
            ->simplePaginate($limit);
        if($model){
            return $model;
        }else{
            return false;
        }
    }

    //查询用户发布的个数(待审核)
    public function usercontentcounts(){
        $model=$this
            ->where('fabutype','=',1)
            ->where('content.status','=',1)
            ->where('content.audit','=',2)
            ->count();
        if($model){
            return $model;
        }else{
            return 0;
        }
    }


    //查询后台发布的个数
    public function contentcount($typeid){
        $model=$this
            ->where('fabutype','=',2)
            ->where('content.status','=',1)
            ->where('typeid','=',$typeid)
            ->count();
        if($model){
            return $model;
        }else{
            return 0;
        }
    }
    //一周精选
    public function getSelected($limit){
        $model=$this
            ->select('content.*','userinfo.nickname','userinfo.avatarurl')
            ->join('userinfo',function($join){
                $join->on('content.openid','=','userinfo.openid');
            })
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            //->where('content.fabutype','=',2)
            ->where('content.status','=',1)
            ->where('content.selected','=',2)
            ->orderBy('time', 'desc')
            ->simplePaginate($limit);
        if($model){
            return $model;
        }else{
            return false;
        }
    }
    //查询一周精选的个数
    public function selectedcount(){
        $model=$this
            //->where('fabutype','=',2)
            ->where('content.status','=',1)
            ->where('selected','=',2)
            ->count();
        if($model){
            return $model;
        }else{
            return 0;
        }
    }

    //推荐
    public function getRecommended($limit){
        $model=$this
            ->select('content.*','userinfo.nickname','userinfo.avatarurl')
            ->join('userinfo',function($join){
                $join->on('content.openid','=','userinfo.openid');
            })
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            //->where('content.fabutype','=',2)
            ->where('content.status','=',1)
            ->where('content.recommended','=',2)
            ->orderBy('tjtime', 'desc')
            ->simplePaginate($limit);
        if($model){
            return $model;
        }else{
            return false;
        }
    }
    //查询推荐的个数
    public function recommendedcount(){
        $model=$this
            //->where('fabutype','=',2)
            ->where('content.status','=',1)
            ->where('recommended','=',2)
            ->count();
        if($model){
            return $model;
        }else{
            return 0;
        }
    }

    //通过id获取当前文章
    public function getContentOne($id){
        $model=$this
            ->select('content.id','title','imgurl','userinfo.photo')
            ->join('userinfo',function($join){
                $join->on('content.openid','=','userinfo.openid');
            })
            ->where('content.id','=',$id)
            ->first();
        if($model){
            return $model;
        }else{
            return false;
        }
    }

}
