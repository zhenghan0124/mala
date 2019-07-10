<?php
/*
*
*@copyright 2017 qianye.me
*@author Janpun
*@version 20170813
*
*/
namespace Home\Controller;
use Think\Controller;

/**
 * 公共控制器
 * @author @janpun
 */
class GlobalController extends CommonController{
  /**
   * 初始化
   */
  protected function _initialize(){
    if(strpos($_SERVER['REQUEST_URI'],'?') !== false){
      $slug = "&";
    }else{
      $slug = "?";
    }
    $this -> assign('slug', $slug);
  }
}
