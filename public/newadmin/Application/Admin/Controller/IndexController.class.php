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
class IndexController extends CommonController{

    /**
     * 后台用户管理
     */
    public function index() {
        $where = ['type'=>2]; //type:1用户 ，2后台用户
        $count = M('Userinfo')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Userinfo')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        $data = array();
        foreach ($list as $value){
            if ($value['name']) {
                $value['name'] = $value['name'];
            } else {
                $value['name'] = $value['nickname'];
            }
            if ($value['photo']) {
                $value['pic'] = $value['photo'];
            } else {
                $value['pic'] = $value['avatarurl'];
            }
            $data[] = $value;
        }
//        var_dump($data);exit;

        $this->assign('data', $data);
        $this->assign('pagenavi', $show);
        $this->display();
    }

  /**
   * 用户文章列表
   */
    public function usercontent() {
//    显示标题
            $page['title'] = "用户发布文章列表";
            $this->assign('page', $page);
            $aid = session('aid');
            $this->assign('aid', $aid);
            // var_dump($aid);exit;
//            $typeid = $_GET['typeid'];
            if($_GET['typeid']){
                $typeid = $_GET['typeid'];
            }
            if($_GET['audit']){
                $audit = $_GET['audit'];
            }
//            $audit = $_GET['audit'];
            if ($typeid) {
                $where = ['fabutype' => 1, 'status' => 1, 'typeid' => $typeid]; //fabutype:1用户发布 ，2后台发布  status:1未删除 ，2已删除
            } else {
                if($audit){
                    $where = ['fabutype' => 1, 'status' => 1, 'audit' => $audit]; //fabutype:1用户发布 ，2后台发布  status:1未删除 ，2已删除
                }else {
                    $where = ['fabutype' => 1, 'status' => 1]; //fabutype:1用户发布 ，2后台发布  status:1未删除 ，2已删除
                }
            }
//            var_dump($where);
//            var_dump($_GET['sort']);exit;
//        $where = ['fabutype'=>1,'status'=>1,'typeid'=>$typeid]; //fabutype:1用户发布 ，2后台发布  status:1未删除 ，2已删除
            $count = M('Content')->where($where)->count();
            $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
            $show = $Pages->show();// 分页显示输出
            if($_GET['sort']){
                $sort = $_GET['sort'];
                if($sort == '1'){
                    $list = M('Content')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('support asc')->select();
                }
                if($sort == '2'){
                    $list = M('Content')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('support desc')->select();
                }
            }else {
                $list = M('Content')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
            }
//        echo M('Content')->getLastSql();exit;
//            $list = M('Content')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
//    var_dump($data);
            $types = M('Type')->where('status=1')->select();
            $userinfo = M('Userinfo')->order('id desc')->select();
            $data = array();
            foreach ($list as $v) {
                foreach ($userinfo as $value) {
                    if ($value['uid'] == $v['uid']) {
                        $v['imgurl'] = explode(',', $v['imgurl']);
                        $type = M('Type')->where('id=' . $v['typeid'])->find();
                        if ($value['name']) {
                            $v['name'] = $value['name'];
                        } else {
                            $v['name'] = $value['nickname'];
                        }
                        if ($value['photo']) {
                            $v['pic'] = $value['photo'];
                        } else {
                            $v['pic'] = $value['avatarurl'];
                        }
                        $v['type'] = $type['title'];
                        $data[] = $v;
                    }
                }
            }
//        var_dump($result);exit;
            $this->assign('data', $data);
            $this->assign('types', $types);
            $this->assign('pagenavi', $show);

            $this->display();
    }

    //用户文章审核
    public function useraudit() {
            $post = I('get.');
            $map['id'] = $post['id'];
            $map['audit'] = $post['audit'];
            $typeid = $post['typeid'];
            if($map['audit'] == 1){
                $message = '审核成功';
            }else{
                $message = '取消审核成功';
            }
            $count = M('Content') -> save($map);
            if($count > 0){
                $this -> success($message, U('Index/usercontent',array('typeid' => $typeid)));
            }else{
                $this -> error("失败");
            }
    }

    //用户文章推荐
    public function userrecommended() {
            $post = I('get.');
            $map['id'] = $post['id'];
            $map['recommended'] = $post['recommended'];
            $map['tjtime'] = time();
            $typeid = $post['typeid'];
            if($map['recommended'] == 2){
                $message = '推荐成功';
            }else{
                $message = '取消推荐成功';
            }
            $count = M('Content') -> save($map);
            if($count > 0){
                $this -> success($message, U('Index/usercontent',array('typeid' => $typeid)));
            }else{
                $this -> error("推荐失败");
            }
    }

    //用户文章热度推荐
    public function userhot() {
        $post = I('get.');
        $map['id'] = $post['id'];
        $map['hot'] = $post['hot'];
        if($map['hot'] == 1){
            $message = '热度推荐成功';
        }else{
            $message = '取消热度推荐成功';
        }
        $count = M('Content') -> save($map);
        if($count > 0){
            $this -> success($message, U('Index/usercontent'));
        }else{
            $this -> error("热度推荐失败");
        }
    }

    /**
     * 后台文章列表
     */
    public function admincontent() {
//    显示标题
        $page['title'] = "后台发布文章列表";
        $this -> assign('page', $page);
        $aid = session('aid');
        $this -> assign('aid', $aid);
        // var_dump($aid);exit;
        if($_GET['typeid']){
            $typeid = $_GET['typeid'];
        }

//        $typeid = $_GET['typeid'];
        if($typeid){
            $where = ['fabutype'=>2,'status'=>1,'typeid'=>$typeid]; //fabutype:1用户发布 ，2后台发布  status:1未删除 ，2已删除
        }else{
            $where = ['fabutype'=>2,'status'=>1]; //fabutype:1用户发布 ，2后台发布  status:1未删除 ，2已删除
        }
        $count = M('Content')-> where($where) -> count();
        $Pages = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        if($_GET['sort']){
            $sort = $_GET['sort'];
            if($sort == 1){
                $list = M('Content')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('support asc')->select();
            }
            if($sort == 2){
                $list = M('Content')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('support desc')->select();
            }
        }else {
            $list = M('Content')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        }
//    var_dump($data);
        $types = M('Type') -> where('status=1') -> select();
        $userinfo = M('Userinfo') -> order('id desc') -> select();
        $data = array();
        foreach ($list as $v) {
            foreach ($userinfo as $value){
                if($value['uid'] == $v['uid']){
                    $v['imgurl'] = explode(',', $v['imgurl']);
                    $type = M('Type') -> where('id='.$v['typeid']) -> find();
                    if($value['name']){
                        $v['name'] = $value['name'];
                    }else{
                        $v['name'] = $value['nickname'];
                    }
                    if($value['photo']){
                        $v['pic'] = $value['photo'];
                    }else{
                        $v['pic'] = $value['avatarurl'];
                    }
                    $v['type'] = $type['title'];
                    $data[] = $v;
                }
            }
        }
//        var_dump($result);exit;
        $this->assign('data',$data);
        $this->assign('types',$types);
        $this -> assign('pagenavi', $show);

        $this -> display();
    }

    //后台文章审核
    public function adminaudit() {
        $post = I('get.');
        $map['id'] = $post['id'];
        $map['audit'] = $post['audit'];
        $typeid = $post['typeid'];
        if($map['audit'] == 1){
            $message = '审核成功';
        }else{
            $message = '取消审核成功';
        }
        $count = M('Content') -> save($map);
        if($count > 0){
            $this -> success($message, U('Index/admincontent',array('typeid' => $typeid)));
        }else{
            $this -> error("失败");
        }
    }

    //后台文章推荐
    public function adminrecommended() {
        $post = I('get.');
        $map['id'] = $post['id'];
        $map['recommended'] = $post['recommended'];
        $map['tjtime'] = time();
        if($map['recommended'] == 2){
            $message = '推荐成功';
        }else{
            $message = '取消推荐成功';
        }
        $count = M('Content') -> save($map);
        if($count > 0){
            $this -> success($message, u('Index/admincontent'));
        }else{
            $this -> error("推荐失败");
        }
    }

    //后台文章热度推荐
    public function adminhot() {
        $post = I('get.');
        $map['id'] = $post['id'];
        $map['hot'] = $post['hot'];
        if($map['hot'] == 1){
            $message = '热度推荐成功';
        }else{
            $message = '取消热度推荐成功';
        }
        $count = M('Content') -> save($map);
        if($count > 0){
            $this -> success($message, U('Index/admincontent'));
        }else{
            $this -> error("热度推荐失败");
        }
    }

    /**
   * 后台新增文章
   */
  public function add_content() {
    if(IS_POST){
      $post = I('post.');

      //整理提交数据
      $map['title'] = $post['title'];
      // $map['title_en'] = $post['title_en'];
      $map['pic'] = $post['pic'];
      $map['url'] = $post['url'];
      // $map['content'] = str_replace(PHP_EOL, '', $post['content']);
      // $map['content_en'] = str_replace(PHP_EOL, '', $post['content_en']);
      // $map['description'] = $post['description'];
      // $map['description_en'] = $post['description_en'];
      // $map['time'] = strtotime($post['time']);

      $count = M('Content') -> add($map);

      if($count > 0){
        $this -> success("添加成功", U('News'));
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
   * 编辑用户发布文章
   */
  public function edit_usercontent() {
      //显示标题
      $page['title'] = "文章信息";
      $this -> assign('page', $page);
      $aid = session('aid');
      $this -> assign('aid', $aid);
      // var_dump($aid);exit;

      $id = I('get.id');
      $data = M('Content') -> find($id);
      $data['imgurl'] = explode(',', $data['imgurl']);
//      var_dump($data['uid']);
      $type = M('Type') -> find($data['typeid']);
//      var_dump($type);
      $uid = ['uid'=>$data['uid']];
      $userinfo = M('Userinfo') -> where($uid) -> select();
//      echo M('Userinfo')->getLastSql();
//      var_dump($userinfo);
      if(!empty($userinfo['name'])){
          $data['name'] = $userinfo[0]['name'];
      }else{
          $data['name'] = $userinfo[0]['nickname'];
      }
      if($userinfo['photo']){
          $data['pic'] = $userinfo[0]['photo'];
      }else{
          $data['pic'] = $userinfo[0]['avatarurl'];
      }
      $data['type'] = $type['title'];
//      $data['photo'] = $type['title'];

//        var_dump($data);exit;
      $this -> assign('data', $data);
      $this -> display();
  }

    /**
     * 编辑后台发布文章
     */
    public function edit_admincontent() {
            //显示标题
            $page['title'] = "文章信息";
            $this -> assign('page', $page);
            $aid = session('aid');
            $this -> assign('aid', $aid);
            // var_dump($aid);exit;

        $id = I('get.id');
        $data = M('Content') -> find($id);
        $data['imgurl'] = explode(',', $data['imgurl']);
//      var_dump($data['uid']);
        $type = M('Type') -> find($data['typeid']);
//      var_dump($type);
        $uid = ['uid'=>$data['uid']];
        $userinfo = M('Userinfo') -> where($uid) -> select();
//      echo M('Userinfo')->getLastSql();
//      var_dump($userinfo);
        if(!empty($userinfo['name'])){
            $data['name'] = $userinfo[0]['name'];
        }else{
            $data['name'] = $userinfo[0]['nickname'];
        }
        if($userinfo['photo']){
            $data['pic'] = $userinfo[0]['photo'];
        }else{
            $data['pic'] = $userinfo[0]['avatarurl'];
        }
        $data['type'] = $type['title'];
//      $data['photo'] = $type['title'];

//        var_dump($data);exit;
        $this -> assign('data', $data);
        $this -> display();
    }

  /**
   * 删除文章
   */
  public function del() {
    $id = I('get.id');
    $map['id'] = $id;
    $map['status'] = 2;
    $map =
    $count = M('Content') -> save($map);
//    $count = M('Content') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }


}
