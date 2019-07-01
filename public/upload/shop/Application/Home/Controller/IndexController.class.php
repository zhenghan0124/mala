<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends GlobalController {
  public function index(){
    // $title = "index_logo";

  	//获取数据
  	$info = D('Block') -> get_item_by_title('index_logo');
    $data = json_decode($info['value'], true);
    // var_dump($data);
    $pic = D('Block') -> get_item_by_title('index_banner');
    $banner = json_decode($pic['value'], true);
    // var_dump($banner);
  	$about = D('Block') -> get_item_by_title('index_about');
  	$about = json_decode($about['value'], true);
    //岗位风采
    $Gwfc = M('Gwfc') -> order('id desc') -> limit(3) -> select();
    // var_dump($Gwfc);

    $count = M('Newslist') -> count();
    $Pages = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show = $Pages->show();// 分页显示输出
    $list = M('Newslist') -> order('id desc') -> limit($Pages -> firstRow.','.$Pages -> listRows) -> select();
    $this->assign('list',$list);
    $this -> assign('pagenavi', $show);

  	$this->assign('data',$data);
    $this->assign('banner',$banner);
  	$this->assign('about',$about);
    $this->assign('Gwfc',$Gwfc);

    $this -> display();
  }

  public function room(){
    $id = I('get.id');
    $data = M('RoomDescription') -> find($id);
    // var_dump($data);exit;
    if(cookie('think_language') == "en-us"){
      $data['title'] = ($data['title_en']);
      $data['description'] = $data['description_en'];
      $data['content'] = html_entity_decode($data['content_en']);
    }else{
      $data['title'] = $data['title'];
      $data['description'] = $data['description'];
      $data['content'] = html_entity_decode($data['content']);
    }
    // var_dump($data);
    $this -> assign('data', $data);

    $list = M('RoomDescription') -> order('id desc') -> select();
    $result = array();
    foreach ($list as $value){
      if(cookie('think_language') == "en-us"){
        $value['title'] = ($value['title_en']);
        // $value['description'] = $value['description_en'];
      }else{
        $value['title'] = $value['title'];
        // $value['description'] = $value['description'];
      }
      // $value['thumb_pic'] = thumb_name($value['pic']);

      $result[] = $value;
    }
    // var_dump($result);
    $nums = count($result);
    // var_dump($nums);
    // $num = intval(count($data['pic']));
    // var_dump($num);
    // $data['content'] = html_entity_decode($data['content']);
    // $data1 = $data['pic']['0'];
    // var_dump($data);
   //  var_dump($data1);
    // $this->assign('data',$data);
    $this->assign('list',$result);
    $this->assign('nums',$nums);
    $this -> display();
  }

  public function floor(){
    $id = I('get.id');
    $data = M('Floor') -> find($id);
    // var_dump($data);exit;
    if(cookie('think_language') == "en-us"){
      $data['title'] = ($data['title_en']);
      $data['description'] = $data['description_en'];
      $data['content'] = html_entity_decode($data['content_en']);
    }else{
      $data['title'] = $data['title'];
      $data['description'] = $data['description'];
      $data['content'] = html_entity_decode($data['content']);
    }
    // var_dump($data);
    $this -> assign('data', $data);

    $list = M('Floor') -> order('id desc') -> select();
    $result = array();
    foreach ($list as $value){
      if(cookie('think_language') == "en-us"){
        $value['title'] = ($value['title_en']);
        // $value['description'] = $value['description_en'];
      }else{
        $value['title'] = $value['title'];
        // $value['description'] = $value['description'];
      }
      // $value['thumb_pic'] = thumb_name($value['pic']);

      $result[] = $value;
    }
    // var_dump($result);
    $nums = count($result);
    // var_dump($nums);
    // $num = intval(count($data['pic']));
    // var_dump($num);
    // $data['content'] = html_entity_decode($data['content']);
    // $data1 = $data['pic']['0'];
    // var_dump($data);
   //  var_dump($data1);
    // $this->assign('data',$data);
    $this->assign('list',$result);
    $this->assign('nums',$nums);
    $this -> display();
  }  

  public function meeting(){
    $id = I('get.id');
    $data = M('Meeting') -> find($id);
    // var_dump($data);exit;
    if(cookie('think_language') == "en-us"){
      $data['title'] = ($data['title_en']);
      $data['description'] = $data['description_en'];
      $data['content'] = html_entity_decode($data['content_en']);
    }else{
      $data['title'] = $data['title'];
      $data['description'] = $data['description'];
      $data['content'] = html_entity_decode($data['content']);
    }
    // var_dump($data);
    $this -> assign('data', $data);

    $list = M('Meeting') -> order('id desc') -> select();
    $result = array();
    foreach ($list as $value){
      if(cookie('think_language') == "en-us"){
        $value['title'] = ($value['title_en']);
        // $value['description'] = $value['description_en'];
      }else{
        $value['title'] = $value['title'];
        // $value['description'] = $value['description'];
      }
      // $value['thumb_pic'] = thumb_name($value['pic']);

      $result[] = $value;
    }
    // var_dump($result);
    $nums = count($result);
    // var_dump($nums);
    // $num = intval(count($data['pic']));
    // var_dump($num);
    // $data['content'] = html_entity_decode($data['content']);
    // $data1 = $data['pic']['0'];
    // var_dump($data);
   //  var_dump($data1);
    // $this->assign('data',$data);
    $this->assign('list',$result);
    $this->assign('nums',$nums);
    $this -> display();
  }    
}