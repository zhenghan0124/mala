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
 * 登录控制器
 * @author @janpun
 */
class LoginController extends Controller{
	/**
   * 登录
   */
  public function index(){
		if(IS_POST){
			//获取输入值
			$post = I('post.');
			$username = $post['username'];
			$password = $post['password'];
			if(!empty($username) && !empty($password)){
				$login_verify = D('Admin') -> login_verify($username, $password);
				if($login_verify){
					//登录成功
					login($login_verify);
					$aid = session('aid');
      
      				if($aid == 1){
      					//成功后跳转到原网址
          				redirect(U('Index/news'));
      				}else{
      					redirect(U('G20/hand'));
      				}
      

          exit();
				}else{
					$this -> error("用户名或密码不正确");
				}
			}else{
				$this -> error("用户名或密码不得为空");
			}
		}else{
			$this -> display();
		}
  }

  public function loginout(){
    session('aid',null);                            //删除session
    redirect(U('Login/index'));
    exit();
  }
}
