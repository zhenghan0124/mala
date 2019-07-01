<?php
namespace Home\Controller;
use Think\Controller;
class AboutController extends GlobalController {
  public function index(){
    // $title = "index_logo";

	//获取数据
	// $info = D('Block') -> get_item_by_title('about_logo');
	$about = D('Block') -> get_item_by_title('about_index');
	$data = json_decode($about['value'], true);
  // var_dump($data);exit;
      
	//多语言支持
    if(cookie('think_language') == "en-us"){
      $data['content'] = html_entity_decode($data['content_en']);
      
    }else{
      $data['content'] = html_entity_decode($data['content']);
    }
    // $num = intval(count($data['pic']));
    // $data1 = $data['pic']['0'];
    // $this->assign('nums',$num);
    // $this->assign('data1',$data1);
	// var_dump($data);
	// $data = $about['pic'];
	// $data['content'] = html_entity_decode($data['content']);
	// var_dump($data);
	$this->assign('data',$data);
    $this -> display();
  }
}