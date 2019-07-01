<?php
namespace Home\Controller;
use Think\Controller;
class ContactController extends GlobalController {
  public function index(){
  	if(IS_POST){
      $post = I('post.');

      $data['name'] = $post['name'];
      // $data['email'] = $post['email'];
      $data['mobile'] = $post['mobile'];
      $data['info'] = $post['info'];

      $result = M('Contact') -> add($data);

      if($result){
        $this->success('提交成功');
      }else{
        $this->error('提交失败');
      }

    }else{
      $info = D('Block') -> get_item_by_title('Contact_banner');
      //$about = D('Block') -> get_item_by_title('Hr_index');
      $data = json_decode($info['value'], true);
      // $num = intval(count($data['pic']));
      // $data1 = $data['pic']['0'];
      // $this->assign('nums',$num);
      // $this->assign('data1',$data1);
      $this->assign('data',$data);
      // var_dump($result);
      // $this->assign('data',$result);
      // $this -> assign('pagenavi', $show);
      $this -> display();
    }
    
  }
}
