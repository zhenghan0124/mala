<?php
namespace Admin\Model;
use Think\Model;
class BlockModel extends Model {

  /**
   * 更新或创建数据条目（自动判断）
   * @param  string $title 待创建的字段名,array $data待创建的数据
   * @return boolean true成功 false失败
   * @author @janpun
   */
  public function deal_with_item($title, $data){
    //判断记录是否已存在
    if($this -> is_exist($title)){
      $result = $this -> update_data($title, $data);  //更新记录
    }else{
      $result = $this -> add_data($title, $data);   //新增记录
    }

    if($result > 0){
      return true;
    }else{
      return false;
    }
  }


  /**
   * 通过字段名获取对应的条目
   * @param  string $title 字段名
   * @return array 条目信息，未获取到结果则为NULL
   * @author @janpun
   */
  public function get_item_by_title($title){
    $info = $this -> where("title = '$title'") -> find();
    return $info;
  }


  /**
   * 判断条目是否存在
   * @param  string $title 字段名
   * @return boolean true存在 false不存在
   * @author @janpun
   */
  private function is_exist($title){
    $count = $this -> where("title = '$title'") -> count();
    if($count > 0){
      return true;
    }else{
      return false;
    }
  }

  /**
   * 创建条目
   * @param  string $title 待创建的字段名,array $data待创建的数据
   * @return int 新增的id号或0
   * @author @janpun
   */
  private function add_data($title, $data){
    $data['title'] = $title;
    $data['time'] = time();
    $count = $this -> add($data);
    return $count;
  }

  /**
   * 更新条目
   * @param  string $title 待创建的字段名,array $data待更新的数据
   * @return int 受影响的行数
   * @author @janpun
   */
  private function update_data($title, $data){
    $data['time'] = time();
    $count = $this -> where("title = '$title'") -> save($data);
    return $count;
  }
}
