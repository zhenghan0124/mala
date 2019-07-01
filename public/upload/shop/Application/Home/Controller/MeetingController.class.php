<?php
namespace Home\Controller;
use Think\Controller;
class MeetingController extends GlobalController {
  public function index(){
    // $title = "index_logo";
    if(IS_POST){
      $post = I('post.');
      // var_dump($post);
      $data['name'] = $post['name'];
      $data['city'] = $post['city'];
      $data['mobile'] = $post['mobile'];
      $data['nums'] = $post['nums'];
      $data['date'] = $post['date'];
      $data['info'] = $post['info'];

      $result = M('Meeting_order') -> add($data);

      if($result){
        $this->success('提交成功');
      }else{
        $this->error('提交失败');
      }

    }else{
     //获取数据
    // $info = D('Block') -> get_item_by_title('about_logo');
    $about = D('Block') -> get_item_by_title('meeting_index');
    $data = json_decode($about['value'], true);
        
    //多语言支持
      if(cookie('think_language') == "en-us"){
        $data['content'] = html_entity_decode($data['content_en']);
        
      }else{
        $data['content'] = html_entity_decode($data['content']);
      }
      $num = intval(count($data['pic']));
      $data1 = $data['pic']['0'];
      $this->assign('nums',$num);
      $this->assign('data1',$data1);
    // var_dump($data);
    // $data = $about['pic'];
    // $data['content'] = html_entity_decode($data['content']);
    // var_dump($data);
    $this->assign('data',$data);
    $this -> display();
    }
  
  }

}
