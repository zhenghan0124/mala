<?php
namespace Home\Controller;
use Think\Controller;
class GwjjController extends GlobalController {
  public function index(){
    $about = D('Block') -> get_item_by_title('index_about');
    $about = json_decode($about['value'], true);
    $about['content'] = html_entity_decode($about['content']);
    $about['content_en'] = html_entity_decode($about['content_en']);
    // var_dump($about);
    $pic = D('Block') -> get_item_by_title('index_banner');
    $banner = json_decode($pic['value'], true);
    $this->assign('about',$about);
    $this->assign('banner',$banner);
    $this -> display();
  }

  public function detail(){
    $id = I('get.id');
    if($id){
      $news_info = M('News') -> find($id);
      
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
