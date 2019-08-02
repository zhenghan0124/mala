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
class MeituController extends CommonController{
  /**
   * 用户文章列表
   */
    public function index() {
//    显示标题
            $page['title'] = "美图列表";
            $this->assign('page', $page);

            if($_GET['shenhe']){
                $shenhe = $_GET['shenhe'];
            }

            if ($shenhe) {
                $where = ['status' => 2, 'shenhe' => $shenhe];
            } else {
                $where = ['status' => 2];
            }
            $count = M('Tutie')->where($where)->count();
            $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
            $show = $Pages->show();// 分页显示输出
            $list = M('Tutie')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
//            $userinfo = M('Userinfo')->order('id desc')->select();
//            $data = array();
//            foreach ($list as $v) {
//                foreach ($userinfo as $value) {
//                    if ($value['uid'] == $v['uid']) {
////                        $v['imgurl'] = explode(',', $v['imgurl']);
//                        if ($value['name']) {
//                            $v['name'] = $value['name'];
//                        } else {
//                            $v['name'] = $value['nickname'];
//                        }
//                        if ($value['photo']) {
//                            $v['pic'] = $value['photo'];
//                        } else {
//                            $v['pic'] = $value['avatarurl'];
//                        }
//                        $data[] = $v;
//                    }
//                }
//            }
//            var_dump($list);exit;
            $this->assign('data', $list);
            $this->assign('pagenavi', $show);

            $this->display();
    }

    //美图审核
    public function audit() {
        $post = I('post.');
        $map['id'] = $post['id'];
        $map['shenhe'] = $post['shenhe'];
//        $typeid = $post['typeid'];
        if($map['shenhe'] == 1){
            $message = '取消审核成功';
        }else{
            $message = '审核成功';
        }
        $count = M('Tutie') -> save($map);
        if($count > 0){
            $arr=[
                'status'=>1,
                'info'=>$message
            ];
//            $this -> success($message, U('Index/admincontent',array('typeid' => $typeid)));
        }else{
            $arr=[
                'status'=>0,
                'info'=>'审核失败'
            ];
//            $this -> error("失败");
        }
        exit(json_encode($arr));
    }

  /**
   * 编辑用户发布文章
   */
  public function edit() {
      //显示标题
      $page['title'] = "文章信息";
      $this -> assign('page', $page);
      $aid = session('aid');
      $this -> assign('aid', $aid);
      // var_dump($aid);exit;

      $id = I('get.id');
      $data = M('Tutie') -> find($id);
      $this -> assign('data', $data);
      $this -> display();
  }

  /**
   * 删除文章
   */
  public function del() {
    $id = I('get.id');
    $map['id'] = $id;
    $map['status'] = 1;
    $count = M('Tutie') -> save($map);
//    $count = M('Content') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }


}
