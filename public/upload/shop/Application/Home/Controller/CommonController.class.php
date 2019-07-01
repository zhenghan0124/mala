<?php
namespace Home\Controller;
use Think\Controller;
Class CommonController extends Controller{
    // public $_weid;
    // public $_hotelid;
    // Public function _initialize(){
    //     //移动设备浏览，则切换模板
    //     //if (ismobile()) {
    //         //设置默认默认主题为 Mobile
    //        // C('DEFAULT_THEME','Mobile');
    //     //}
    //     //
    //     $WebsiteColumn = D('WebsiteColumn');
    //     $WebsiteSetting = D('WebsiteSetting');
    //     $hotelModel = D('Hotel2');
    //     $host = $_SERVER['HTTP_HOST'];
    //     $setting = $WebsiteSetting->where(array('domain'=>$host))->find();
    //     if(!$setting){
    //         $this->error('域名错误');
    //     }
    //     $this->_weid = $setting['weid'];
    //     $lang = cookie('think_language');
    //     //顶部导航栏
    //     $map = array('weid' => $this->_weid,'lang'=>$lang,'pid'=>0,'position'=>0);
        
    //     $hotel = $hotelModel->where(array('weid' => $this->_weid))->find();
    //     $this->_hotelid = $hotel['id'];
    //     $navigation = $WebsiteColumn->where($map)->order('displayorder DESC,id ASC')->select();
    //     foreach($navigation AS &$nav){
    //         if($nav['url']!=''){
    //             if(strpos($nav['url'],'http')===false){
    //                 $nav['url'] = U($nav['url'].'?navid='.$nav['id']);
    //             }
    //         }
            
    //         //查询是否有子分类
    //         $subCol = $WebsiteColumn->where('pid='.$nav['id'])->order('displayorder DESC,id ASC')->select();
    //         if($subCol!==false){
    //             $nav['sub'] = $subCol;
    //         }
    //     }
    //     //底部栏目导航
    //     $map['position'] = 1;
    //     $navi_bottom = $WebsiteColumn->where($map)->order('displayorder DESC,id ASC')->select();
    //     $this->assign('setting',$setting);
    //     $this->assign('navigation',$navigation);
    //     $this->assign('navi_bottom',$navi_bottom);
    // }
    
    //修正图片路径
    public function fixImgpath($content){
        if(strpos($content,'src=') !== false){
            $content = str_replace('src="../attachment/','src="'.C('YH_ATTA'),$content);
        }
        if(strpos($content,'href=') !== false){
            $content = str_replace('href="../attachment/','href="'.C('YH_ATTA'),$content);
        }
        return $content;
    }
    
    //查询配置信息
    public function uni_setting($uniacid = 0, $fields = '*') {
        
        $uniacid = empty($uniacid) ? $this->_weid : $uniacid;
        
        static $unisettings;
        if(empty($unisettings)){
            $unisettings = array();
        }
        
        if(empty($unisettings[$uniacid])){
            $Model = D('uni_settings');
            $unisetting = $Model->where(array('uniacid'=>$uniacid))->find();
            if(!empty($unisetting)){
                $serialize = array('site_info', 'menuset', 'stat', 'oauth', 'passport', 'uc', 'notify', 'creditnames', 'default_message', 'creditbehaviors', 'shortcuts', 'quickmenu', 'payment', 'groupdata');
                foreach($unisetting as $key => &$row) {
                    if(in_array($key, $serialize)) {
                        $row = unserialize($row);
                    }
                }
            }
            $unisettings[$uniacid] = $unisetting;
        }
        if (is_array($fields)) {
            return array_elements($fields, $unisettings[$uniacid]);
        }
        return $unisettings[$uniacid];
    }

}