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
class TypeController extends CommonController{

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
        $list = M('Type')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();

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
            $map['status'] = 1;
            $count = M('Type') -> add($map);
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
            $map['status'] = 1;
            $count = M('Type') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('index'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑分类";
            $id = I('get.id');
            $data = M('Type') -> find($id);
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
    $count = M('Type') -> save($map);
//    $count = M('Content') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }


}
