<?php
namespace Home\Controller;
use Think\Controller;
class JobController extends GlobalController {
  public function index(){
  	$result_arr = M('Hr') -> order('rank desc,time desc,id desc') -> limit($Pages -> firstRow.','.$Pages -> listRows) -> select();

    $result = array();
    foreach ($result_arr as $value){

      //多语言支持
      if(cookie('think_language') == "en-us"){
        $value['title'] = $value['title_en'];
        $value['education'] = $value['education_en'];
        $value['place'] = $value['place_en'];
        $value['email'] = $value['email_en'];
      }
      $result[] = $value;
    }
    // var_dump($result);
    //获取数据
    // $info = D('Block') -> get_item_by_title('about_logo');
    $about = D('Block') -> get_item_by_title('Hr_index');
    $data = json_decode($about['value'], true);
    $num = intval(count($data['pic']));
    $data1 = $data['pic']['0'];
    $this->assign('nums',$num);
    $this->assign('data1',$data1);
    // var_dump($data);
    // $data = $about['pic'];
    // $data['content'] = html_entity_decode($data['content']);
    // var_dump($data);
    $this->assign('data',$data);

    $this -> assign('result', $result);
    $this -> display();
  }
}
