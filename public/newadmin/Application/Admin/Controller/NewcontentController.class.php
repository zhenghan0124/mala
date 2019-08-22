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
class NewcontentController extends CommonController{

    /**
     * 分类列表
     */
    public function index() {
        $page['title'] = "分类列表";
        $this->assign('page', $page);
        $where = ['status'=>1]; //status:1 ，2删除
        $count = M('Newtype')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Newtype')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();

        $this->assign('data', $list);
        $this->assign('pagenavi', $show);
        $this->display();
    }

    /**
     * 添加分类
     */
    public function add() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['title'] = $post['title'];
            $map['location'] = $post['location'];
            $map['pic'] = $post['pic'];
            $map['status'] = 1;
            $count = M('Newtype') -> add($map);
            if($count > 0){
                $this -> success("添加成功", U('index'));
            }else{
                $this -> error("添加失败");
            }
        }else {
            //显示标题
            $page['title'] = "添加分类";
            $this->assign('page', $page);
            $this->display();
        }
    }

    /**
     * 编辑分类
     */
    public function edit() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['id'] = $post['id'];
            $map['title'] = $post['title'];
            $map['location'] = $post['location'];
            $map['pic'] = $post['pic'];
            $map['status'] = 1;
            $count = M('Newtype') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('index'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑分类";
            $id = I('get.id');
            $data = M('Newtype') -> find($id);
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

/**
   * 删除
   */
  public function del() {
    $id = I('get.id');
    $map['id'] = $id;
    $map['status'] = 2;
    $count = M('Newtype') -> save($map);
//    $count = M('Content') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }


    /**
     * 前端图片管理
     */
    public function picture() {
        $page['title'] = "前端图片管理";
        $this->assign('page', $page);
        $where = ['status'=>1]; //status:1 ，2删除
        $count = M('Picture')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Picture')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        $types = M('Newtype') -> where('status=1') -> select();
        $data = array();
        foreach ($list as $value){
            foreach ($types as $v){
                if($value['typeid'] == $v['id']){
                    $value['typetitle'] = $v['title'];
                }
            }
            $data[] = $value;
        }
        $this->assign('data', $data);
        $this->assign('pagenavi', $show);
        $this->display();
    }

    /**
     * 添加
     */
    public function add_picture() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['typeid'] = $post['typeid'];
            $map['pic'] = $post['pic'];
            $map['status'] = 1;
            $count = M('Picture') -> add($map);
            if($count > 0){
                $this -> success("添加成功", U('picture'));
            }else{
                $this -> error("添加失败");
            }
        }else {
            //显示标题
            $page['title'] = "添加";
            $types = M('Newtype') -> where('status=1') -> select();
            $this->assign('types', $types);
            $this->assign('page', $page);
            $this->display();
        }
    }

    /**
     * 编辑
     */
    public function edit_picture() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['id'] = $post['id'];
            $map['typeid'] = $post['typeid'];
            $map['pic'] = $post['pic'];
            $map['status'] = 1;
            $count = M('Picture') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('picture'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑";
            $id = I('get.id');
            $data = M('Picture') -> find($id);
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

  /**
   * 删除
   */
  public function del_picture() {
    $id = I('get.id');
    $map['id'] = $id;
    $map['status'] = 2;
    $count = M('Picture') -> save($map);
//    $count = M('Content') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }


    /**
     * 日签
     */
    public function daily() {
        $page['title'] = "日签";
        $this->assign('page', $page);
        $where = ['status'=>1]; //status:1 ，2删除
        $count = M('riqian')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('riqian')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();

        $this->assign('data', $list);
        $this->assign('pagenavi', $show);
        $this->display();
    }

    // /**
    //  * 添加
    //  */
    // public function add_picture() {
    //     if(IS_POST){
    //         $post = I('post.');
    //         //整理提交数据
    //         $map['typeid'] = $post['typeid'];
    //         $map['pic'] = $post['pic'];
    //         $map['status'] = 1;
    //         $count = M('Picture') -> add($map);
    //         if($count > 0){
    //             $this -> success("添加成功", U('index'));
    //         }else{
    //             $this -> error("添加失败");
    //         }
    //     }else {
    //         //显示标题
    //         $page['title'] = "添加";
    //         $this->assign('page', $page);
    //         $this->display();
    //     }
    // }

    /**
     * 编辑
     */
    public function edit_daily() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['id'] = $post['id'];
            $map['typeid'] = $post['typeid'];
            $map['pic'] = $post['pic'];
            $map['status'] = 1;
            $count = M('riqian') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('daily'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑";
            $id = I('get.id');
            $data = M('riqian') -> find($id);
            if($data['week'] == 1){
                $data['weeks'] = '周一';
            }elseif($data['week'] == 2){
                $data['weeks'] = '周二';
            }elseif($data['week'] == 3){
                $data['weeks'] = '周三';
            }elseif($data['week'] == 4){
                $data['weeks'] = '周四';
            }elseif($data['week'] == 5){
                $data['weeks'] = '周五';
            }elseif($data['week'] == 6){
                $data['weeks'] = '周六';
            }elseif($data['week'] == 7){
                $data['weeks'] = '周日';
            }
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

//   /**
//    * 删除
//    */
//   public function del_picture() {
//     $id = I('get.id');
//     $map['id'] = $id;
//     $map['status'] = 2;
//     $count = M('Picture') -> save($map);
// //    $count = M('Content') -> delete($id);
//     if($count > 0){
//       $this -> success("删除成功");
//     }else{
//       $this -> error("删除失败");
//     }
//   }


    /**
     * 日签
     */
    public function month() {
        $page['title'] = "月份";
        $this->assign('page', $page);

        $count = M('Yuefen')->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Yuefen')->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();

        $this->assign('data', $list);
        $this->assign('pagenavi', $show);
        $this->display();
    }


    /**
     * 编辑
     */
    public function edit_month() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['id'] = $post['id'];
            $map['month'] = $post['month'];
            $map['pic'] = $post['pic'];
            $count = M('Yuefen') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('month'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑";
            $id = I('get.id');
            $data = M('Yuefen') -> find($id);
            if($data['month'] == 1){
                $data['months'] = '一月';
            }elseif($data['month'] == 2){
                $data['months'] = '二月';
            }elseif($data['month'] == 3){
                $data['months'] = '三月';
            }elseif($data['month'] == 4){
                $data['months'] = '四月';
            }elseif($data['month'] == 5){
                $data['months'] = '五月';
            }elseif($data['month'] == 6){
                $data['months'] = '六月';
            }elseif($data['month'] == 7){
                $data['months'] = '七月';
            }elseif($data['month'] == 8){
                $data['months'] = '八月';
            }elseif($data['month'] == 9){
                $data['months'] = '九月';
            }elseif($data['month'] == 10){
                $data['months'] = '十月';
            }elseif($data['month'] == 11){
                $data['months'] = '十一月';
            }elseif($data['month'] == 12){
                $data['months'] = '十二月';
            }
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

        /**
     * 推荐短句
     */
    public function short() {
        $page['title'] = "分类列表";
        $this->assign('page', $page);
        $where = ['status'=>1]; //status:1 ，2删除
        $count = M('Short')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Short')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        $types = M('Newtype') -> where('status=1') -> select();
        $data = array();
        foreach ($list as $value){
            foreach ($types as $v){
                if($value['typeid'] == $v['id']){
                    $value['typetitle'] = $v['title'];
                }
            }
            $data[] = $value;
        }
        $this->assign('data', $data);
        $this->assign('pagenavi', $show);
        $this->display();
    }

    /**
     * 添加
     */
    public function add_short() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['title'] = $post['title'];
            $map['typeid'] = $post['typeid'];
            $map['status'] = 1;
            $count = M('Short') -> add($map);
            if($count > 0){
                $this -> success("添加成功", U('index'));
            }else{
                $this -> error("添加失败");
            }
        }else {
            //显示标题
            $page['title'] = "添加分类";
            $types = M('Newtype') -> where('status=1') -> select();
            $this->assign('types', $types);
            $this->assign('page', $page);
            $this->display();
        }
    }

    /**
     * 编辑分类
     */
    public function edit_short() {
        if(IS_POST){
            $post = I('post.');
            //整理提交数据
            $map['id'] = $post['id'];
            $map['title'] = $post['title'];
            $map['typeid'] = $post['typeid'];
            $map['status'] = 1;
            $count = M('Short') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('index'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑分类";
            $id = I('get.id');
            $data = M('Short') -> find($id);
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

/**
   * 删除
   */
  public function del_short() {
    $id = I('get.id');
    $map['id'] = $id;
    $map['status'] = 2;
    $count = M('Short') -> save($map);
//    $count = M('Content') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }


    /**
     * 美图列表
     */
    public function content() {
        $page['title'] = "美图列表";
        $this->assign('page', $page);
        $where = ['status'=>1,'fabutype'=>2]; //status:1 ，2删除
        $count = M('Newcontent')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Newcontent')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        $types = M('Newtype') -> where('status=1') -> select();
        $data = array();
        foreach ($list as $value){
            foreach ($types as $v){
                if($value['typeid'] == $v['id']){
                    $value['typetitle'] = $v['title'];
                }
            }
            $data[] = $value;
        }
        $this->assign('data', $data);
        $this->assign('pagenavi', $show);
        $this->display();
    }

    /**
     * 添加美图
     */
    public function add_content() {
        if(IS_POST){
            $post = I('post.');
//            var_dump($post);exit;
            //整理提交数据
            $map['uid'] = '1557122526';
            $map['openid'] = '1557122526';
            $userinfo = M('Userinfo') ->where('uid='.$map['uid']) -> find();
            if($userinfo['name']){
                $map['name'] = $userinfo['name'];
            }else{
                $map['name'] = $userinfo['nickname'];
            }
            if($userinfo['photo']){
                $map['photo'] = $userinfo['photo'];
            }else{
                $map['photo'] = $userinfo['avatarurl'];
            }
            $map['title'] = $post['title'];
            $map['imgurl'] = $post['pic'];
            $map['typeid'] = $post['typeid'];
            $map['collection'] = $post['collection'];
            $map['download'] = $post['download'];
            $map['share'] = $post['share'];
            $map['videourl'] = $post['videourl'];
            $map['type'] = $post['type'];
            $map['fabutype'] = 2;
            $map['audit'] = 2;
            $map['status'] = 1;
            $map['time'] = time();
            $map['date'] = date('Y-m-d H:i:s');
            if($post['tj'] == 1){

            }else{
                $map['tjtime'] = date('Y-m-d H:i:s');
                $map['recommended'] = 2;
            }

            $count = M('Newcontent') -> add($map);
            if($count > 0){
                $this -> success("添加成功", U('content'));
            }else{
                $this -> error("添加失败");
            }
        }else {
            //显示标题
            $types = M('Newtype') -> where('status=1') -> select();
            $page['title'] = "添加美图";
            $this->assign('page', $page);
            $this->assign('types', $types);
            $this->display();
        }
    }

    /**
     * 编辑美图
     */
    public function edit_content() {
        if(IS_POST){
            $post = I('post.');
//            var_dump($post);exit;
            //整理提交数据
            $map['id'] = $post['id'];
            $map['title'] = $post['title'];
            $map['imgurl'] = $post['pic'];
            $map['typeid'] = $post['typeid'];
            $map['collection'] = $post['collection'];
            $map['download'] = $post['download'];
            $map['share'] = $post['share'];
            $map['videourl'] = $post['videourl'];
            $map['type'] = $post['type'];
            if($post['tj'] == 1){
                $map['recommended'] = 1;
            }else{
                $map['tjtime'] = date('Y-m-d H:i:s');
                $map['recommended'] = 2;
            }
            $count = M('Newcontent') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('content'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑美图";
            $id = I('get.id');
            $data = M('Newcontent') -> find($id);
//            var_dump($data);exit;
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

    /**
     * 删除美图
     */
    public function del_content() {
        $id = I('get.id');
        $map['id'] = $id;
        $map['status'] = 2;
        $count = M('Newcontent') -> save($map);
//    $count = M('Content') -> delete($id);
        if($count > 0){
            $this -> success("删除成功");
        }else{
            $this -> error("删除失败");
        }
    }

    /**
     * 用户发布
     */
    public function usercontent() {
        $page['title'] = "用户发布列表";
        $this->assign('page', $page);
        $where = ['status'=>1,'fabutype'=>1]; //status:1 ，2删除
        $count = M('Newcontent')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Newcontent')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        $types = M('Newtype') -> where('status=1') -> select();
        $data = array();
        foreach ($list as $value){
            foreach ($types as $v){
                if($value['typeid'] == $v['id']){
                    $value['typetitle'] = $v['title'];
                }
            }
            $data[] = $value;
        }
        $this->assign('data', $data);
        $this->assign('types', $types);
        $this->assign('pagenavi', $show);
        $this->display();
    }


    /**
     * 编辑美图
     */
    public function edit_usercontent() {
        if(IS_POST){
            $post = I('post.');
//            var_dump($post);exit;
            //整理提交数据
            $map['id'] = $post['id'];
            $map['title'] = $post['title'];
            $map['imgurl'] = $post['pic'];
            $map['typeid'] = $post['typeid'];
            $map['collection'] = $post['collection'];
            $map['download'] = $post['download'];
            $map['share'] = $post['share'];
            $map['videourl'] = $post['videourl'];
            $map['type'] = $post['type'];
            if($post['tj'] == 1){
                $map['recommended'] = 1;
            }else{
                $map['tjtime'] = date('Y-m-d H:i:s');
                $map['recommended'] = 2;
            }
            $count = M('Newcontent') -> save($map);
            if($count > 0){
                $this -> success("编辑成功", U('content'));
            }else{
                $this -> error("编辑失败");
            }
        }else {
            //显示标题
            $page['title'] = "编辑美图";
            $id = I('get.id');
            $data = M('Newcontent') -> find($id);
//            var_dump($data);exit;
            $this->assign('data', $data);
            $this->assign('page', $page);
            $this->display();
        }
    }

    /**
     * 删除美图
     */
    public function del_usercontent() {
        $id = I('get.id');
        $map['id'] = $id;
        $map['status'] = 2;
        $count = M('Newcontent') -> save($map);
//    $count = M('Content') -> delete($id);
        if($count > 0){
            $this -> success("删除成功");
        }else{
            $this -> error("删除失败");
        }
    }

}
