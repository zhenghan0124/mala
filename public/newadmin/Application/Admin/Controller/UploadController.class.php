<?php
/*
*
*@copyright 2017 qianye.me
*@author Janpun
*@version 20170307
*
*/
namespace Admin\Controller;
use Think\Controller;

/**
 * 上传控制器
 * @author @Janpun
 */
class UploadController extends CommonController{
  /**
  * ajax上传后台端
  * @author @Janpun
  */

  public function index(){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     ''; // 设置附件上传（子）目录
    $upload->autoSub   = true;
    $upload->subName   = array('date','Ym');
    // 上传文件
    $info = $upload->upload();
    if(!$info) {// 上传错误提示错误信息
      $this->error($upload->getError());
    }else{// 上传成功
      foreach($info as $file){
        $fileinfo_arr = array(
          'name'=>$file['name'],
          'pic'=>$file['savename'],
          'path'=>$file['savepath'],
          'size'=>$file['size'],
          'status'=>1
        );

        //生成缩略图
        $width = I('get.width');
        $height = I('get.height');
        if(is_numeric($width) && $width > 0 && is_numeric($width) && $width > 0){
          $path= './Uploads/'.$file['savepath'];
          $image = new \Think\Image();
          $image->open($path.$file['savename']);
          $image->thumb($width, $height,\Think\Image::IMAGE_THUMB_CENTER)->save($path.'thumb_'.$file['savename']);
        }
      }

      header('Content-type:text/json');
      echo json_encode($fileinfo_arr); //输出json数据
    }
  }


  public function attachment(){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     20971520 ;// 设置附件上传大小
    $upload->exts      =     array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', '7z', 'pdf');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     ''; // 设置附件上传（子）目录
    $upload->autoSub   = true;
    $upload->subName   = array('date','Ym');
    // 上传文件
    $info = $upload->upload();
    if(!$info) {// 上传错误提示错误信息
      $this->error($upload->getError());
    }else{// 上传成功
      foreach($info as $file){
        $fileinfo_arr = array(
          'name'=>$file['name'],
          'pic'=>$file['savename'],
          'path'=>$file['savepath'],
          'size'=>$file['size'],
          'status'=>1
        );
      }

      header('Content-type:text/json');
      echo json_encode($fileinfo_arr); //输出json数据
    }
  }


  /**
	* wangEditor编辑器上传后端
	* @author @Janpun
	*/

	public function wangeditor(){
    $upload = new \Think\Upload();// 实例化上传类
    $upload->maxSize   =     3145728 ;// 设置附件上传大小
    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
    $upload->savePath  =     ''; // 设置附件上传（子）目录
    $upload->autoSub   = true;
    $upload->subName   = array('date','Ym');
    // 上传文件
    $info = $upload->upload();
    if(!$info) {// 上传错误提示错误信息
      $error = $upload->getError();
      echo "error|".$error;
    }else{// 上传成功
      foreach($info as $file){
        echo "/Uploads/".$file['savepath'].$file['savename'];
      }
    }
	}


  /**
   * 删除图片
   * @author @Janpun
   */

  public function del(){
    $post = I('post.');
    $pathname = $post['filename'];
    $thumb_name = thumb_name($pathname);
    echo $pathname;
    if(!empty($pathname)){
      unlink('Uploads/'.$pathname);
      unlink('Uploads/'.$thumb_name);
      echo '1';
    }else{
      echo '0';
    }
  }
}
