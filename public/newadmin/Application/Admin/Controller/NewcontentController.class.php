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
class NewcontentController extends CommonController{

    /**
     * 分类列表
     */
    public function index() {
        $page['title'] = "分类列表";
        $this->assign('page', $page);
        $where = ['status'=>1]; //status:1 ，2删除
        $count = M('Type')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Newtype')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();

        $this->assign('data', $list);
        $this->assign('pagenavi', $show);
        $this->display();
    }

    /**
     * 添加分类
     */
    public function add() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['title'] = $post['title'];
            $map['location'] = $post['location'];
            $map['pic'] = $post['pic'];
            $map['status'] = 1;
            $count = M('Newtype') -> add($map);
            if($count > 0){
                $this -> success("添加成功", U('index'));
            }else{
                $this -> error("添加失败");
            }
        }else {
            //显示标题
            $page['title'] = "添加分类";
            $this->assign('page', $page);
            $this->display();
        }
    }

    /**
     * 编辑分类
     */
    public function edit() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['id'] = $post['id'];
            $map['title'] = $post['title'];
            $map['location'] = $post['location'];
            $map['pic'] = $post['pic'];
            $map['status'] = 1;
            $count = M('Newtype') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('index'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑分类";
            $id = I('get.id');
            $data = M('Newtype') -> find($id);
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

  /**
   * 删除分类
   */
  public function del() {
    $id = I('get.id');
    $map['id'] = $id;
    $map['status'] = 2;
    $count = M('Newtype') -> save($map);
//    $count = M('Content') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }

    /**
     * 美图列表
     */
    public function content() {
        $page['title'] = "美图列表";
        $this->assign('page', $page);
        $where = ['status'=>1]; //status:1 ，2删除
        $count = M('Newcontent')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Newcontent')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();

        $this->assign('data', $list);
        $this->assign('pagenavi', $show);
        $this->display();
    }

    /**
     * 添加美图
     */
    public function add_content() {
        if(IS_POST){
            $post = I('post.');
//            var_dump($post);exit;
            //整理提交数据
            $map['uid'] = '1557122526';
            $userinfo = M('Userinfo') ->where('uid='.$map['uid']) -> find();
            if($userinfo['name']){
                $map['name'] = $userinfo['name'];
            }else{
                $map['name'] = $userinfo['nickname'];
            }
            if($userinfo['photo']){
                $map['photo'] = $userinfo['photo'];
            }else{
                $map['photo'] = $userinfo['avatarurl'];
            }
            $map['title'] = $post['title'];
            $map['imgurl'] = $post['pic'];
            $map['typeid'] = $post['typeid'];
            $map['collection'] = $post['collection'];
            $map['download'] = $post['download'];
            $map['share'] = $post['share'];
            $map['fbtype'] = 2;
            $map['audit'] = 2;
            $map['status'] = 1;
            $map['time'] = time();
            $map['date'] = date('Y-m-d H:i:s');
            if($post['tj'] == 1){

            }else{
                $map['tjtime'] = date('Y-m-d H:i:s');
                $map['recommended'] = 2;
            }

            $count = M('Newcontent') -> add($map);
            if($count > 0){
                $this -> success("添加成功", U('content'));
            }else{
                $this -> error("添加失败");
            }
        }else {
            //显示标题
            $types = M('Newtype') -> where('status=1') -> select();
            $page['title'] = "添加美图";
            $this->assign('page', $page);
            $this->assign('types', $types);
            $this->display();
        }
    }

    /**
     * 编辑美图
     */
    public function edit_content() {
        if(IS_POST){
            $post = I('post.');
//            var_dump($post);exit;
            //整理提交数据
            $map['id'] = $post['id'];
            $map['title'] = $post['title'];
            $map['imgurl'] = $post['pic'];
            $map['typeid'] = $post['typeid'];
            $map['collection'] = $post['collection'];
            $map['download'] = $post['download'];
            $map['share'] = $post['share'];
            if($post['tj'] == 1){
                $map['recommended'] = 1;
            }else{
                $map['tjtime'] = date('Y-m-d H:i:s');
                $map['recommended'] = 2;
            }
            $count = M('Newcontent') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('content'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑美图";
            $id = I('get.id');
            $data = M('Newcontent') -> find($id);
//            var_dump($data);exit;
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

    /**
     * 删除美图
     */
    public function del_content() {
        $id = I('get.id');
        $map['id'] = $id;
        $map['status'] = 2;
        $count = M('Newcontent') -> save($map);
//    $count = M('Content') -> delete($id);
        if($count > 0){
            $this -> success("删除成功");
        }else{
            $this -> error("删除失败");
        }
    }

}
