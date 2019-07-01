<?php
namespace Home\Controller;
use Think\Controller;
class GwcxController extends GlobalController {
  public function index(){
    $count = M('Gwcx') -> where($map) -> count();
    $Pages = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    $show = $Pages->show();// 分页显示输出
    $result_arr = M('Gwcx') -> where($map) -> order('rank desc,time desc,id desc') -> limit($Pages -> firstRow.','.$Pages -> listRows) -> select();
    // var_dump($result_arr);exit;
    // echo M('News')->getLastSql();exit;

    // $result = array();
    // foreach ($result_arr as $value){
    //   $value['thumb_pic'] = thumb_name($value['pic']);

    //   $result[] = $value;
    // }

    $result = array();
    foreach ($result_arr as $value){
      if(cookie('think_language') == "en-us"){
        $value['title'] = ($value['title_en']);
        $value['description'] = $value['description_en'];
      }else{
        $value['title'] = $value['title'];
        $value['description'] = $value['description'];
      }
      $value['thumb_pic'] = thumb_name($value['pic']);

      $result[] = $value;
    }

    //轮播图
   //  $info = D('Block') -> get_item_by_title('index_logo');
   //  $data = json_decode($info['value'], true);
   //  $num = intval(count($data['pic']));
   //  // var_dump($num);
   //  // $data['content'] = html_entity_decode($data['content']);
   //  $data1 = $data['pic']['0'];
   //  // var_dump($data);
   // //  var_dump($data1);
   //  $this->assign('data',$data);
   //  $this->assign('nums',$num);
   //  $this->assign('data1',$data1);
    $pic = D('Block') -> get_item_by_title('gwcx_banner');
    $banner = json_decode($pic['value'], true);
    $this -> assign('banner', $banner);

    $this -> assign('result', $result);
    $this -> assign('pagenavi', $show);
    $this -> display();
  }

  public function detail(){
    $id = I('get.id');
    if($id){
      $news_info = M('Gwcx') -> find($id);
      
      $news_info['content'] = html_entity_decode($news_info['content']);
      $news_info['content_en'] = html_entity_decode($news_info['content_en']);
      // var_dump($news_info);
      if($news_info){
        //多语言支持
        if(cookie('think_language') == "en-us"){
          $news_info['title'] = $news_info['title_en'];
          $news_info['description'] = $news_info['description_en'];
          $news_info['content'] = html_entity_decode($news_info['content_en']);
        }else{
          $news_info['title'] = $news_info['title'];
          $news_info['description'] = $news_info['description'];
          $news_info['content'] = html_entity_decode($news_info['content']);
        }

        //轮播图
        $info = D('Block') -> get_item_by_title('index_logo');
        $data = json_decode($info['value'], true);
        $num = intval(count($data['pic']));
        // var_dump($num);
        // $data['content'] = html_entity_decode($data['content']);
        $data1 = $data['pic']['0'];
        // var_dump($data);
       //  var_dump($data1);
        $this->assign('data',$data);
        $this->assign('nums',$num);
        $this->assign('data1',$data1);
        // if(cookie('think_language') == "en-us"){
        //   $news_info['title'] = $news_info['title_en'];
        //   $news_info['description'] = $news_info['description_en'];
        //   $news_info['content'] = $news_info['content_en'];
        // }else{
        //   $news_info['title'] = $news_info['title'];
        //   $news_info['description'] = $news_info['description'];
        //   $news_info['content'] = $news_info['content_en'];
        // }
        $pic = D('Block') -> get_item_by_title('gwcx_banner');
    $banner = json_decode($pic['value'], true);
    $this -> assign('banner', $banner);
        $this -> assign('news_info', $news_info);
        $this -> display();
      }else{
        $this -> error("不存在");
      }
    }else{
      $this -> error("不存在");
    }
  }
}
