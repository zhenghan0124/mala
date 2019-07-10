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
class RobotController extends CommonController{

    /**
     * 后台用户管理
     */
    public function index() {
        $page['title'] = "机器人列表";
        $this->assign('page', $page);
        $where = ['type'=>3]; //type:1用户 ，2后台用户，3机器人
        $count = M('Userinfo')->where($where)->count();
        $Pages = new \Think\Page($count, 25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Pages->show();// 分页显示输出
        $list = M('Userinfo')->where($where)->limit($Pages->firstRow . ',' . $Pages->listRows)->order('id desc')->select();
        $data = array();

        foreach ($list as $value){
            $type = M('Type')->where('id=' . $value['fenlei'])->find();
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
            $value['types'] = $type['title'];
            $data[] = $value;
        }
//        var_dump($data);exit;

        $this->assign('data', $data);
        $this->assign('pagenavi', $show);
        $this->display();
    }
    /**
     * 新增机器人
     */
    public function add(){
        if(IS_POST){
            var_dump($_POST);exit;
            $post = I('post.');
            $map['nickname'] = $post['nickname'];
            $map['name'] = $post['nickname'];
            $map['openid'] = time();
            $map['uid'] = time();
            $map['type'] = 3;
            $map['fenlei'] = $post['fenlei'];
            $map['photo'] = '/newadmin/Uploads/'.$_POST['pic'];
            $map['avatarurl'] = '/newadmin/Uploads/'.$_POST['pic'];
            $count = M('Userinfo') -> add($map);
            if($count > 0){
                $this -> success("添加成功", U('index'));
            }else{
                $this -> error("添加失败");
            }
        }else{
            $page['title'] = "添加机器人";
            $this->assign('page', $page);
            $types = M('Type')->where('status=1')->select();
            $this->assign('data', $types);
            $this->display();
        }
    }
  /**
   * 删除文章
   */
  public function del() {
    $id = I('get.id');
    $map['id'] = $id;
    $map['status'] = 2;
    $count = M('Content') -> save($map);
//    $count = M('Content') -> delete($id);
    if($count > 0){
      $this -> success("删除成功");
    }else{
      $this -> error("删除失败");
    }
  }


    /**
     * 机器人点赞
     */
    public function support()
    {
        if (IS_POST) {
            header("Content-Type: text/html;charset=utf-8");
            $post = I('post.');
//            var_dump($post);exit;
            $limit = $post['limit'];
            $type = $post['type'];
            $whl = ['fenlei'=>$type,'type'=>3];
            //随机获取机器人
            $data = M('Userinfo')->limit(1)->where($whl)->order('rand()')->find();
            $wh = ['typeid'=>$type];
            //随机获取文章
            $content = M('Content')->limit($limit)->where($wh)->order('rand()')->select();
//            var_dump($content);exit;
            $nums = count($content);
            //开启事务
            M()->startTrans();
            if ($content) {
                if ($nums == 1) {
                    //判断该机器人是否给该篇文章点过赞
                    $where = ['uid' => $data['uid'], 'buid' => $content[0]['uid'], 'contentid' => $content[0]['id']];
                    $support = M('Support')->where($where)->find();
                    if ($support) {
//                        var_dump('重复点赞');
                        $this -> error("重复点赞", u('support'));
//                        $arr=[
//                            'status'=>0,
//                            'info'=>'重复点赞',
//                            'supportid'=>''
//                        ];
                    } else {
                        $map['bopenid'] = $content[0]['openid'];
                        $map['buid'] = $content[0]['uid'];
                        $map['uid'] = $data['uid'];
                        $map['openid'] = $data['openid'];
                        $map['time'] = time();
                        $map['dtime'] = date('Y-m-d H:i:s', time());
                        $map['contentid'] = $content[0]['id'];
                        $map['type'] = 1;

                        $count = M('Support')->add($map);
                        if ($count > 0) {

                            //获取文章点赞数
                            $wh = ['id'=>$content[0]['id']];
                            $contents = M('Content')->where($wh)->find();
                            $maps['id'] = $content[0]['id'];
                            $maps['support'] = $contents['support']+1;
                            //给文章加点赞数
                            $counts = M('Content')->save($maps);

                            //获取该文章的用户id
                            $where = ['uid' => $content[0]['uid']];
                            $userinfo = M('Userinfo')->where($where)->find();
                            //发送点赞提醒
                            $mp['id'] = $userinfo['id'];
                            $mp['tix'] = 1;
                            $user = M('Userinfo')->save($mp);
                            M()->commit();
                            $this -> success("点赞成功", u('support'));
//                            $arr=[
//                                'status'=>1,
//                                'info'=>'点赞成功',
//                                'supportid'=>$count
//                            ];
//                            var_dump($count);
                        } else {
                            M()->rollback();
                            $this -> error("点赞失败", u('support'));
//                            $arr=[
//                                'status'=>0,
//                                'info'=>'点赞失败',
//                                'supportid'=>''
//                            ];
//                            var_dump('失败');
                        }
                    }
                } else {
                    foreach ($content as $value) {
                        //判断之前该机器人是否给该篇文章点过赞
                        $where = ['uid' => $data['uid'], 'buid' => $value['uid'], 'contentid' => $value['id']];
                        $support = M('Support')->where($where)->find();
                        if ($support) {
//                            $this -> error("重复点赞", u('support'));
//                            $arr=[
//                                'status'=>0,
//                                'info'=>'重复点赞',
//                                'supportid'=>''
//                            ];
//                            var_dump('重复点赞');
                        } else {
                            $map['bopenid'] = $value['openid'];
                            $map['buid'] = $value['uid'];
                            $map['uid'] = $data['uid'];
                            $map['openid'] = $data['openid'];
                            $map['time'] = time();
                            $map['dtime'] = date('Y-m-d H:i:s', time());
                            $map['contentid'] = $value['id'];
                            $map['type'] = 1;
                            $count[] = M('Support')->add($map);

                            if ($count > 0) {
                                //获取文章点赞数
                                $wh = ['id'=>$value['id']];
                                $contents = M('Content')->where($wh)->find();
                                $maps['id'] = $value['id'];
                                $maps['support'] = $contents['support']+1;
                                //给文章加点赞数
                                $counts = M('Content')->save($maps);

                                //获取该文章的用户id
                                $where = ['uid' => $value['uid']];
                                //查询用户
                                $userinfo = M('Userinfo')->where($where)->find();
                                $mp['id'] = $userinfo['id'];
                                $mp['tix'] = 1;
                                $user = M('Userinfo')->save($mp);

                                M()->commit();
                                $this -> success("点赞成功", u('support'));
//                                $arr=[
//                                    'status'=>1,
//                                    'info'=>'点赞成功',
//                                    'supportid'=>$count
//                                ];
//                                var_dump($count);
                            } else {
                                M()->rollback();
                                $this -> error("点赞失败", u('support'));
//                                $arr=[
//                                    'status'=>0,
//                                    'info'=>'点赞失败',
//                                    'supportid'=>''
//                                ];
//                                var_dump('失败');
                            }
                        }
                    }
                }
            }else{
                $this -> error("点赞失败", u('support'));
//                $arr=[
//                    'status'=>0,
//                    'info'=>'点赞失败',
//                    'supportid'=>''
//                ];
            }
//            exit(json_encode($arr));
        }else{
            $page['title'] = "机器人点赞";
            $this->assign('page', $page);
            $types = M('Type')->where('status=1')->select();
            $this->assign('data', $types);
            $this -> display();
        }
    }

}
