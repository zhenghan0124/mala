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
class TemplateController extends CommonController{
  /**
   * 模板分类列表
   */
    public function index() {
//    显示标题
            $page['title'] = "模板分类列表";
            $this->assign('page', $page);

            $count = M('Mubanfenlei')->count();
            $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
            $show = $Pages->show();// 分页显示输出
            $list = M('Mubanfenlei')->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
            $this->assign('data', $list);
            $this->assign('pagenavi', $show);

            $this->display();
    }

    /**
     * 添加分类
     */
    public function add_type() {
        if(IS_POST){
            $post = I('post.');

            //整理提交数据

            $map['txt'] = $post['txt'];


            $count = M('Mubanfenlei') -> add($map);

            if($count > 0){
                $this -> success("添加成功", u('index'));
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
  public function edit_type() {
      if(IS_POST){
          $post = I('post.');
          //整理提交数据
          $map['id'] = $post['id'];
          $map['txt'] = $post['txt'];
          $count = M('Mubanfenlei') -> save($map);

          if($count > 0){
              $this -> success("编辑成功", u('index'));
          }else{
              $this -> error("编辑失败");
          }
      }else {
          //显示标题
          $page['title'] = "编辑分类";
          $this -> assign('page', $page);
          $id = I('get.id');
          $data = M('Mubanfenlei') -> find($id);
          $this -> assign('data', $data);

          $this -> display();
      }
  }

  /**
   * 删除分类
   */
  public function del_type() {
    $id = I('get.id');
    $count = M('Mubanfenlei') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }

    /**
     * 模板列表
     */
    public function template() {
//    显示标题
        $page['title'] = "模板列表";
        $this->assign('page', $page);

        $count = M('Muban')->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Muban')->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        $this->assign('data', $list);
        $this->assign('pagenavi', $show);

        $this->display();
    }

    /**
     * 添加分类
     */
    public function add_template() {
        if(IS_POST){
            $post = I('post.');

            //整理提交数据
            $map['url'] = $post['pic'];
            $map['img_x'] = $post['img_x'];
            $map['img_y'] = $post['img_y'];
            $map['img_width'] = $post['img_width'];
            $map['img_height'] = $post['img_height'];
            $map['text_x'] = $post['text_x'];
            $map['text_y'] = $post['text_y'];
            $map['text_width'] = $post['text_width'];
            $map['muban_background'] = $post['muban_background'];
            $map['hang_height'] = $post['hang_height'];
            $map['font_size'] = $post['font_size'];
            $map['xiaotu_url'] = $post['img'];
            $map['type'] = $post['type'];
            $map['qcode'] = $post['qcode'];
            $map['qcode_x'] = $post['qcode_x'];
            $map['qcode_y'] = $post['qcode_y'];
            $map['qcode_width'] = $post['qcode_width'];
            $map['qcode_height'] = $post['qcode_height'];
            $map['userimg_x'] = $post['userimg_x'];
            $map['userimg_y'] = $post['userimg_y'];
            $map['userimg_width'] = $post['userimg_width'];
            $map['userimg_height'] = $post['userimg_height'];
            $map['username_x'] = $post['username_x'];
            $map['username_y'] = $post['username_y'];
            $map['username_size'] = $post['username_size'];
            $map['date_x'] = $post['date_x'];
            $map['date_y'] = $post['date_y'];
            $map['date_size'] = $post['date_size'];

            $count = M('Muban') -> add($map);

            if($count > 0){
                $this -> success("添加成功", u('template'));
            }else{
                $this -> error("添加失败");
            }
        }else {
            //显示标题
            $page['title'] = "添加";
            $type = M('Mubanfenlei')->select();
            $this->assign('page', $page);
            $this->assign('types', $type);
            $this->display();
        }
    }

    /**
     * 编辑分类
     */
    public function edit_template() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['id'] = $post['id'];
            $map['url'] = $post['pic'];
            $map['img_x'] = $post['img_x'];
            $map['img_y'] = $post['img_y'];
            $map['img_width'] = $post['img_width'];
            $map['img_height'] = $post['img_height'];
            $map['text_x'] = $post['text_x'];
            $map['text_y'] = $post['text_y'];
            $map['text_width'] = $post['text_width'];
            $map['muban_background'] = $post['muban_background'];
            $map['hang_height'] = $post['hang_height'];
            $map['font_size'] = $post['font_size'];
            $map['xiaotu_url'] = $post['img'];
            $map['type'] = $post['type'];
            $map['qcode'] = $post['qcode'];
            $map['qcode_x'] = $post['qcode_x'];
            $map['qcode_y'] = $post['qcode_y'];
            $map['qcode_width'] = $post['qcode_width'];
            $map['qcode_height'] = $post['qcode_height'];
            $map['userimg_x'] = $post['userimg_x'];
            $map['userimg_y'] = $post['userimg_y'];
            $map['userimg_width'] = $post['userimg_width'];
            $map['userimg_height'] = $post['userimg_height'];
            $map['username_x'] = $post['username_x'];
            $map['username_y'] = $post['username_y'];
            $map['username_size'] = $post['username_size'];
            $map['date_x'] = $post['date_x'];
            $map['date_y'] = $post['date_y'];
            $map['date_size'] = $post['date_size'];
            $count = M('Muban') -> save($map);

            if($count > 0){
                $this -> success("编辑成功", u('template'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑分类";
            $this -> assign('page', $page);
            $id = I('get.id');
            $data = M('Muban') -> find($id);
            $this -> assign('data', $data);

            $this -> display();
        }
    }

    /**
     * 删除分类
     */
    public function del_template() {
        $id = I('get.id');
        $count = M('Muban') -> delete($id);
        if($count > 0){
            $this -> success("删除成功");
        }else{
            $this -> error("删除失败");
        }
    }

}
