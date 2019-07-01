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
 *  新闻控制器
 * @author @janpun
 */
class GwfcController extends CommonController{

  public function banner() {
    $title = "gwfc_banner";

    if(IS_POST){
      $post = I('post.');

      //特殊数据处理
      $post['content'] = str_replace(PHP_EOL, '', $post['content']);

      //整理提交数据
      $data['value'] = json_encode($post);  //内容转json存储
      $result = D('Block') -> deal_with_item($title, $data);

      if($result){
        $this->success('修改成功！');
      }else{
        $this->error('修改失败！');
      }

    }else{
      //显示标题
      $page['title'] = "顶部图片";
      $this -> assign('page', $page);
      $aid = session('aid');
      $this -> assign('aid', $aid);
      // var_dump($aid);exit;
      
      //获取数据
      $info = D('Block') -> get_item_by_title($title);
      $data = json_decode($info['value'], true);
      $data['content'] = html_entity_decode($data['content']);
      $this->assign('data',$data);

      $this->display();
    }
  }

  /**
   * 新闻列表
   */
  public function index() {
    //显示标题
    $page['title'] = "酒店新闻";
    $this -> assign('page', $page);
      $aid = session('aid');
      $this -> assign('aid', $aid);
      // var_dump($aid);exit;

    $count = M('Gwfc') -> count();
    $Pages = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show = $Pages->show();// 分页显示输出
    $data = M('Gwfc') -> order('rank desc,time desc,id desc') -> limit($Pages -> firstRow.','.$Pages -> listRows) -> select();

    $this->assign('data',$data);
    $this -> assign('pagenavi', $show);

    $this -> display();
  }


  /**
   * 新增新闻
   */
  public function add_news() {
    if(IS_POST){
      $post = I('post.');

      //整理提交数据
      $map['title'] = $post['title'];
      $map['title_en'] = $post['title_en'];
      $map['pic'] = $post['pic'];
      $map['content'] = str_replace(PHP_EOL, '', $post['content']);
      $map['content_en'] = str_replace(PHP_EOL, '', $post['content_en']);
      $map['description'] = $post['description'];
      $map['description_en'] = $post['description_en'];
      $map['time'] = strtotime($post['time']);

      $count = M('Gwfc') -> add($map);

      if($count > 0){
        $this -> success("添加成功", U('index'));
      }else{
        $this -> error("添加失败");
      }
    }else{
      //显示标题
      $page['title'] = "新增新闻";
      $this -> assign('page', $page);
      $aid = session('aid');
      $this -> assign('aid', $aid);
      // var_dump($aid);exit;

      $this -> display();
    }
  }


  /**
   * 编辑新闻
   */
  public function edit_news() {
    if(IS_POST){
      $post = I('post.');

      //整理提交数据
      $map['id'] = $post['id'];

      $map['title'] = $post['title'];
      $map['title_en'] = $post['title_en'];
      $map['pic'] = $post['pic'];
      $map['content'] = str_replace(PHP_EOL, '', $post['content']);
      $map['content_en'] = str_replace(PHP_EOL, '', $post['content_en']);
      $map['description'] = $post['description'];
      $map['description_en'] = $post['description_en'];
      $map['time'] = strtotime($post['time']);

      $count = M('Gwfc') -> save($map);

      if($count > 0){
        $this -> success("编辑成功", u('index'));
      }else{
        $this -> error("编辑失败");
      }
    }else{
      //显示标题
      $page['title'] = "编辑新闻";
      $this -> assign('page', $page);
      $aid = session('aid');
      $this -> assign('aid', $aid);
      // var_dump($aid);exit;
      
      $id = I('get.id');
      $data = M('Gwfc') -> find($id);
      $data['content'] = html_entity_decode($data['content']);
      $data['content_en'] = html_entity_decode($data['content_en']);
      $this -> assign('data', $data);

      $this -> display();
    }
  }


  /**
   * 删除新闻
   */
  public function del_news() {
    $id = I('get.id');
    $count = M('Gwfc') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }
}
