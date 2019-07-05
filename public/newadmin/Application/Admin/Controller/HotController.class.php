<?php
/*
*
*@copyright 2017 qianye.me
*@author Janpun
*@version 20170813
*
*/
namespace Admin\Controller;
use Think\Controller;

/**
 * 后台首页控制器
 * @author @janpun
 */
class HotController extends CommonController{

    /**
     * 热度文章列表
     */
    public function index() {
        $where = ['hot'=>1]; //hot:热度推荐1是0否
        $count = M('content')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('content')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        $userinfo = M('Userinfo') -> order('id desc') -> select();
//        var_dump($list);
        $data = array();
        foreach ($list as $v) {
            foreach ($userinfo as $value){
                if($value['uid'] == $v['uid']){
                    $v['imgurl'] = explode(',', $v['imgurl']);
                    $type = M('Type') -> where('id='.$v['typeid']) -> find();
                    if($value['name']){
                        $v['name'] = $value['name'];
                    }else{
                        $v['name'] = $value['nickname'];
                    }
                    if($value['photo']){
                        $v['pic'] = $value['photo'];
                    }else{
                        $v['pic'] = $value['avatarurl'];
                    }
                    $v['type'] = $type['title'];
                    $data[] = $v;
                }
            }
        }
//        var_dump($data);exit;
        $this->assign('data', $data);
        $this->assign('pagenavi', $show);
        $this->display();
    }

    /**
     * 查看热度文章
     */
    public function edit() {
        //显示标题
        $page['title'] = "文章信息";
        $this -> assign('page', $page);
        $aid = session('aid');
        $this -> assign('aid', $aid);
        // var_dump($aid);exit;

        $id = I('get.id');
        $data = M('Content') -> find($id);
        $data['imgurl'] = explode(',', $data['imgurl']);

        $type = M('Type') -> find($data['typeid']);
//        var_dump($type);exit;
        $uid = ['uid'=>$data['uid']];
        $userinfo = M('Userinfo') -> where($uid) -> select();
//      echo M('Userinfo')->getLastSql();
//      var_dump($userinfo);
        if(!empty($userinfo['name'])){
            $data['name'] = $userinfo[0]['name'];
        }else{
            $data['name'] = $userinfo[0]['nickname'];
        }
        if($userinfo['photo']){
            $data['pic'] = $userinfo[0]['photo'];
        }else{
            $data['pic'] = $userinfo[0]['avatarurl'];
        }
        $data['type'] = $type['title'];
//      $data['photo'] = $type['title'];

//        var_dump($data);exit;
        $this -> assign('data', $data);
        $this -> display();
    }

    public function test(){
        $data=M('Content')-> where('hot=0') ->limit(3)->order('rand()')->select();
//        $Form = M("Content");
//        $list = $Form->limit(10)->order('rand()')->select();
        var_dump($data);exit;
    }

}
