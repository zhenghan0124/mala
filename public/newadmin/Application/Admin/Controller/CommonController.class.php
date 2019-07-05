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
 * 后台公共控制器
 * @author @janpun
 */
class CommonController extends Controller{
	/**
   * 初始化
   */
  protected function _initialize(){
    //判断是否已登录
  	$aid = session('aid');	
    if(empty($aid)){//不存在session
      //避免首页也跳转
      if(__SELF__ != "/"){
        //将登陆后需跳转的地址存入session
        $redirect = urlencode(__SELF__);
        cookie('redirect',$redirect);
      }
      redirect(U('Login/index'));
      exit();
    }else{//存在session

      //查找session中的aid对应的用户信息
      $user_info = M(('Admin')) -> find($aid);

      //判断session中的aid对应的用户信息是否存在
      if($user_info != NULL){
        $GLOBALS['user'] = $user_info;
      }else{
        session('aid',null);                            //删除session
        cookie('PHPSESSID',null);                       //删除Cookie中的session id
        $this->error('登录失效，请重新登录');
        exit();
      }
    }
  }


  /**
   * 通用分页列表数据集获取方法
   *
   *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
   *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
   *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
   *
   * @param string|Model  $model   模型名或模型实例
   * @param array    $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
   * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
   *                请求参数中如果指定了_order和_field则据此排序(优先级第二);
   *                否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
   *
   * @param array    $base  基本的查询条件
   * @param boolean    $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
   * @author 胡德胜 <402014769@qq.com>
   *
   * @return array|false
   * 返回数据集
   */
  protected function lists($model,$where=array(),$order='',$base='',$field=true){
    $options  =   array();
    $REQUEST  =   (array)I('request.');
    unset($REQUEST['PHPSESSID']);
    // dump($REQUEST);
    if(is_string($model)){
      $model  =   M($model);
    }

    $OPT    =   new \ReflectionProperty($model,'options');
    $OPT->setAccessible(true);

    $pk     =   $model->getPk();
    // dump($pk);
    if($order===null){
      //order置空
    }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
      $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
    }elseif( $order==='' && empty($options['order']) && !empty($pk) ){
      $options['order'] = $pk.' desc';
    }elseif($order){
      $options['order'] = $order;
    }
    unset($REQUEST['_order'],$REQUEST['_field']);

    $options['where'] = array_filter(array_merge( (array)$base, /*$REQUEST,*/ (array)$where ),function($val){
      if($val===''||$val===null){
        return false;
      }else{
        return true;
      }
    });
    if( empty($options['where'])){
      unset($options['where']);
    }
    $options    =   array_merge( (array)$OPT->getValue($model), $options );
    $total    =   $model->where($options['where'])->count();

    if( isset($REQUEST['r']) ){
      $listRows = (int)$REQUEST['r'];
    }else{
      $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
    }


    // $page = new \Think\Page($total, $listRows, $REQUEST);
    $page = new \Org\Bjy\Page($total, $listRows);

    // if($total>$listRows){
    $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
    // }

    $p =$page->show();

    $this->assign('_page', $p? $p: '');
    $this->assign('_total',$total);
    $options['limit'] = $page->firstRow.','.$page->listRows;

    $model->setProperty('options',$options);

    return $model->field($field)->select();
  }

}
