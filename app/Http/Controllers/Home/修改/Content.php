<?php

namespace App\Home;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'content';//指定表明
    protected $primarykey = 'id';//指定主键（可选）
    public $timestamps = false;
    //允许写入的字段（可选（create））
    protected $fillable = [

    ];

    //获取文章(推荐)
    public function getContents($offset, $limit)
    {
        $model = $this
            ->select('content.*', 'userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name','userinfo.note')
            //->leftjoin('support', 'content.id', '=', 'support.contentid')
            //过滤掉已经禁用的类型文章
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            ->leftjoin('userinfo', 'content.openid', '=', 'userinfo.openid')
            //->where('content.fabutype', '=', 2)
            ->where('recommended','=',2)
            ->where('content.status','=',1)
            ->where('content.audit','=',1)
            ->orderBy('content.zhiding','desc')
            ->orderBy('content.tjtime','desc')
            ->offset($offset)
            ->limit($limit);
            //->get();
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }

    //获取该用户的文章
    public function getUserContents($data,$offset, $limit){
        $model = $this
            //->select('content.*', 'userinfo.nickname', 'userinfo.avatarurl')
            ->select('content.*')
            //->leftjoin('support', 'content.id', '=', 'support.contentid')
            //过滤掉已经禁用的类型文章
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            //->leftjoin('userinfo', 'content.openid', '=', 'userinfo.openid')
            //->where('content.fabutype', '=', 1)
            ->where('content.openid','=',$data['bopenid'])
            ->where('content.uid','=',$data['buid'])
            ->where('content.status','=',1)
            ->where('content.audit','=',1)
            ->orderBy('content.time','desc')
            ->offset($offset)
            ->limit($limit);
            //->get();
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }
    //获取该用户的最新文章
    public function getUserContentOne($openid,$uid,$offset,$limit){
        $model = $this
            //->select('content.*', 'userinfo.nickname', 'userinfo.avatarurl')
            ->select('content.*')
            //->leftjoin('support', 'content.id', '=', 'support.contentid')
            //过滤掉已经禁用的类型文章
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            //->leftjoin('userinfo', 'content.openid', '=', 'userinfo.openid')
            //->where('content.fabutype', '=', 1)
            ->where('content.openid','=',$openid)
            ->where('content.uid','=',$uid)
            ->where('content.status','=',1)
            ->where('content.audit','=',1)
            ->orderBy('content.time','desc')
            ->offset($offset)
            ->limit($limit);
        //->get();
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }

    //获取该用户的文章（动态-包括未审核的）
    public function getUserContentss($openid,$uid,$offset,$limit){
        $model = $this
            //->select('content.*', 'userinfo.nickname', 'userinfo.avatarurl')
            ->select('content.*')
            //->leftjoin('support', 'content.id', '=', 'support.contentid')
            //过滤掉已经禁用的类型文章
//            ->join('type', function ($join) {
//                $join->on('content.typeid', '=', 'type.id')
//                    ->where('type.status', '=', 1);
//            })
            //->leftjoin('userinfo', 'content.openid', '=', 'userinfo.openid')
            //->where('content.fabutype', '=', 1)
            ->where('content.openid','=',$openid)
            ->where('content.uid','=',$uid)
            ->where('content.status','=',1)
            //->where('content.audit','=',1)
            ->orderBy('content.time','desc')
            ->offset($offset)
            ->limit($limit);
        //->get();
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }

    //获取文章(按分类)
    public function getContent($offset, $limit, $typeid)
    {
            $model = $this
                ->select('content.*', 'userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name','userinfo.note')
                //->leftjoin('support', 'content.id', '=', 'support.contentid')
                ->leftjoin('userinfo', 'content.openid', '=', 'userinfo.openid')
                //->where('content.fabutype', '=', 2)
                ->where('content.typeid', '=', $typeid)
                ->where('content.status','=',1)
                ->where('content.audit','=',1)
                ->orderBy('content.zhiding','desc')
                ->orderBy('content.time','desc')
                ->offset($offset)
                ->limit($limit);
                //->get();
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }
    //获取一周精选
    public function getSelected($offset,$limit,$selected){
        $model=$this
            ->select('content.*', 'userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name','userinfo.note')
            //->leftjoin('support', 'content.id', '=', 'support.contentid')
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            ->leftjoin('userinfo', 'content.openid', '=', 'userinfo.openid')
            //->where('content.fabutype', '=', 2)
            ->where('content.selected','=',$selected)
            ->where('content.status','=',1)
            ->where('content.audit','=',1)
            ->orderBy('content.support','desc')
            ->offset($offset)
            ->limit($limit);
            //->get();
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }

    //通过id获取当前文章
    public function getContentOne($id){
        $model=$this
            ->select('content.*', 'userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name','userinfo.note')
            ->leftjoin('userinfo', 'content.openid', '=', 'userinfo.openid')
            ->where('content.id','=',$id)
            ->first();
        if($model){
            return $model;
        }else{
            return false;
        }
    }
    //统计点赞
    public function addsupport($id){
        $model=$this
            ->where('id','=',$id)
            ->increment('support');
        if($model){
            return true;
        }else{
            return false;
        }
    }
    //获取我的收藏
    public function getMycollection($contentid){
        $model = $this
            ->select('content.*', 'userinfo.nickname', 'userinfo.avatarurl','userinfo.photo','userinfo.name','userinfo.note')
            //->leftjoin('support', 'content.id', '=', 'support.contentid')
            //过滤掉已经禁用的类型文章
            ->join('type', function ($join) {
                $join->on('content.typeid', '=', 'type.id')
                    ->where('type.status', '=', 1);
            })
            ->leftjoin('userinfo', 'content.openid', '=', 'userinfo.openid')
            //->where('content.fabutype', '=', 2)
            ->where('content.status','=',1)
            ->whereIn('content.id', $contentid)
            ->orderBy('content.time','desc');
        if($model->exists()){
            return $model->get();
        }else{
            return false;
        }
    }

    //用户添加文章
    public function addcontent($data){
        $datas=[
            'openid'=>$data['openid'],
            'uid'=>$data['uid'],
            'typeid'=>$data['typeid'],
            'title'=>$data['title'],
            'imgurl'=>isset($data['imgurl']) ? $data['imgurl'] : '',
            'audit'=>2,//待审核
            'fabutype'=>1,//用户发布的
            'dtime'=>time()
        ];
        $model=$this
            ->insertGetId($datas);
        if($model){
            return $model;
        }else{
            return false;
        }
    }
    //删除文章（修改文章的状态为status=2）
    public function delContent($data){
        $model=$this
            ->where('id','=',$data['contentid'])
            ->update([
                'status'=>2
            ]);
        if($model){
            return true;
        }else{
            return false;
        }
    }


}
