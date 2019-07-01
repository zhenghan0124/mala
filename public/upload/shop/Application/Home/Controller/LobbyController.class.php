<?php
namespace Home\Controller;
use Think\Controller;
class LobbyController extends GlobalController {
  public function index(){
    // $title = "index_logo";

  	//获取数据
  	$info = D('Block') -> get_item_by_title('Lobby_index');
  	// $about = D('Block') -> get_item_by_title('index_about');
  	// $about = json_decode($about['value'], true);
        
  	//多语言支持
    // if(cookie('think_language') == "en-us"){
    //   $about['description'] = ($about['description_en']);
    // }else{
    //   $about['description'] = ($about['description']);
    // }
  	// var_dump($about);
  	$data = json_decode($info['value'], true);
    //多语言支持
    if(cookie('think_language') == "en-us"){
      $data['content'] = html_entity_decode($data['content_en']);
    }else{
      $data['content'] = html_entity_decode($data['content']);
    }
    // var_dump($data);exit;
    $list = M('Lobby') -> order('id desc') -> select();
    $result = array();
    foreach ($list as $value){
      if(cookie('think_language') == "en-us"){
        $value['title'] = ($value['title_en']);
        // $value['description'] = $value['description_en'];
      }else{
        $value['title'] = $value['title'];
        // $value['description'] = $value['description'];
      }
      $value['thumb_pic'] = thumb_name($value['pic']);

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
  	$this->assign('data',$data);
    $this->assign('list',$result);
    $this->assign('nums',$nums);
   //  $this->assign('nums',$num);
   //  $this->assign('data1',$data1);
  	// $this->assign('about',$about);


    //房型
    // $room = M('Roomtype') -> order('id desc') -> limit(3) -> select();
    // // var_dump($room);
    // $list = array();
    // foreach ($room as $value){
    //   if(cookie('think_language') == "en-us"){
    //     $value['title'] = ($value['title_en']);
    //     $value['description'] = $value['description_en'];
    //   }else{
    //     $value['title'] = $value['title'];
    //     $value['description'] = $value['description'];
    //   }
    //   $value['thumb_pic'] = thumb_name($value['pic']);

    //   $list[] = $value;
    // }
    // $this -> assign('list', $list);
    
    //新闻
    // $count = M('News') -> where($map) -> count();
    // $Pages = new \Think\Page($count,12);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    // $show = $Pages->show();// 分页显示输出
    // $result_arr = M('News') -> where($map) -> order('rank desc,time desc,id desc') -> limit($Pages -> firstRow.','.$Pages -> listRows) -> select();
    // $result_arr = M('News') -> order('id desc') -> limit(4) -> select();
    // // var_dump($result_arr);
    // $result = array();
    // foreach ($result_arr as $value){
    //   if(cookie('think_language') == "en-us"){
    //     $value['title'] = ($value['title_en']);
    //     $value['description'] = $value['description_en'];
    //   }else{
    //     $value['title'] = $value['title'];
    //     $value['description'] = $value['description'];
    //   }
    //   $value['thumb_pic'] = thumb_name($value['pic']);

    //   $result[] = $value;
    // }
    // $this -> assign('result', $result);
    // var_dump($result);
    $this -> display();
  }
}