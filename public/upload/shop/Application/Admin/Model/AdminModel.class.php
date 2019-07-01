<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model {

  /**
   * 获取管理员账户信息（通过id）
   * @param  integer $aid 用户id
   * @return array 管理员账户信息，未获取到结果则为NULL
   * @author @janpun
   */
  public function get_admin_info($aid){
    if(isset($aid) && is_numeric($aid) && $aid > 0){
      $admin_info = $this -> find($aid);
      return $admin_info;
    }else{
      return NULL;
    }
  }


  /**
   * 获取管理员账户信息（通过用户名）
   * @param  string $username 用户名
   * @return array 管理员账户信息，未获取到结果则为NULL
   * @author @janpun
   */
  public function get_admin_info_by_username($username){
    if(isset($username)){
      $admin_info = $this -> where("username = '$username'") -> find();
      return $admin_info;
    }else{
      return NULL;
    }
  }


  /**
   * 登录验证
   * @param  string $username 用户名，string $password 密码
   * @return array 管理员账户信息，未获取到结果则为NULL
   * @author @janpun
   */
  public function login_verify($username, $password){
    $admin_info = $this -> get_admin_info_by_username($username);
    if($admin_info){
      if(md5($password) == $admin_info['password']){
        return $admin_info['id'];
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
}
