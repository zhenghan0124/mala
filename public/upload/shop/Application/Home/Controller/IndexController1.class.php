<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends GlobalController {
  public function index(){
    $this -> display();
  }

  public function roomlist(){
    // var_dump($_POST);
    $start = $_POST['start'] ?: $_SESSION['sdate'];
    $stop = $_POST['stop'] ?: $_SESSION['edate'];
    $people = $_POST['people'] ?: $_SESSION['people'];
    $roomnum = $_POST['room'] ?: 1;

    $day = (strtotime(I('stop') ?: $_SESSION['edate']) - strtotime(I('start') ?: $_SESSION['sdate'])) / 86400;
    $this->assign('day', $day);
    $this->assign('roomnum', $roomnum);
    $this->assign('people', $people);
    $startDate = $start;
    if ($startDate) {
        $_SESSION = [
            'sdate' => I('start') ?: $_SESSION['sdate'], 
            'edate' => I('stop') ?: $_SESSION['edate'],
            'people' => I('people') ?: $_SESSION['people'],
            'day' => $day,
            'roomnum' => $roomnum,
        ];
    }
    // $count = M('Room') -> count();
    // $Pages = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    // $show = $Pages->show();// 分页显示输出
    $room = M('Room') -> order('time desc,id desc') -> select();
    // dump($room);exit;
    // $count = M('Roomtype') -> count();
    // $Pages = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    // $show = $Pages->show();// 分页显示输出
    $list = array();
    foreach ($room as $value) {
      // var_dump($value);
      //多语言支持
      if(cookie('think_language') == "en-us"){
          $value['title'] = $value['title_en'];
          $value['description'] = $value['description_en'];
      }else{
          $value['title'] = $value['title'];
          $value['description'] = $value['description'];
      }
      $roomtype = M('Roomtype') ->where('roomid='.$value['id']) -> order('id desc') -> select();
      // $value['min_price'] = $value['min_price'] < $roomtype['price'] ? $value['min_price'] : $roomtype['price'];
      $value['roomtype'] = $roomtype;

      $list[] = $value;
      
    }
    // dump($list[0]['roomtype']);exit;
    // $list = array_sort($list , 'min_price');
    // var_dump($list);
    // $roomtype = M('Roomtype') ->where('roomid='.$id) -> order('id desc') -> limit($Page -> firstRow.','.$Page -> listRows) -> select();
    $this -> assign('list', $list);
    $this -> display();
  }

  public function order(){
  	if(IS_POST){
  		// var_dump($_POST);exit;
      $roomId = intval(I('roomid'));//房型id
      $id = intval(I('pmid')); // 促销活动id
  		$data['name'] = I('fname') . I('lname');
  		$data['sdate'] = $_SESSION['sdate'] ?: date('Y-m-d');
  		$data['edate'] = $_SESSION['edate'] ?: date('Y-m-d', strtotime('+1 day'));
  		$data['people'] = $_SESSION['people'];
  		$data['nums'] = $_SESSION['roomnum'];
  		$data['mobile'] = I('post.phone');
  		$data['email'] = I('post.email');
  		$data['info'] = I('post.info');
  		// $data['title'] = I('post.title');
      $data['title'] = I('post.title');
      $data['pmtitle'] = I('post.pmtitle');
      $data['pmid'] = intval($id);
      $data['roomid'] = intval($roomId);
      cookie('mobile', I('phone'));
      // $paytype = 22;
      // $order['ordersn'] = 'G20hand'.date( 'ymd' ) . rand(1000, 9999);
      //   if($paytype == 22){
      //         $_SESSION['oid'] = $count;
      //         $order['sumprice'] = 0.01;//测试
      //         //支付宝支付
      //         // $setting = $this->uni_setting($weid,array('payment'));
      //         // $alipay = $setting['payment']['alipay'];
              
      //         // if(empty($alipay['switch'])) {
      //         //     $this->error('未开启支付宝支付');
      //         // }
      //         //写入支付记录
      //         // $corePaylog = M('core_paylog','ims_','DB_WE7');                
      //         // $paylog = array(
      //         //     'type'=> 'alipay',
      //         //     'uniacid'=> $weid,
      //         //     'tid' => $insert,
      //         //     'fee'=> $sum_price,
      //         //     'status'=> 0,
      //         //     'module'=> 'website',
      //         // );
      //         // $logRes = $corePaylog->add($paylog);
      //         // if($logRes == false){
      //         //     $this->error('支付记录生成失败');
      //         // }
              
      //         require_once ($_SERVER['DOCUMENT_ROOT'].'/alipay/alipayapi.php');
      //         $pay_params['seller_email'] = "hangbo@hiechangzhou.com";
      //         $pay_params['partner']    = "2088621461083834";
      //         $pay_params['key']      = "qruu2c71ooj1jntahwawnehns4di4qko";
      //         $pay_params ['call_back_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/index.php?s='. U('Room/checkOrder');
      //         $pay_params ['order_code'] = $order['ordersn'];
      //         $pay_params ['total_fee'] =  $order['sumprice'];
      //         $pay_params ['subject'] =  "国博手办订单";
      //         //$pay_params ['show_url'] = '';//商品展示
        
      //         pay ( $pay_params, $alipay_config );
      //         die;
      //     }
      // $id = I('post.id');
      // var_dump($data);exit;
      $roomtype = M('Roomtype') ->where('id='.$id) -> find();
      // var_dump($roomtype);exit;
      $num = M('order') ->where("roomid={$roomId} AND pmid={$id} AND sdate<='{$data['sdate']}' AND edate>='{$data['sdate']}'") -> count();
      // $num = M('order') ->where("pmid={$data['pmid']} AND sdate<='{$data['sdate']}' AND edate>='{$data['sdate']}'") -> count();
      // var_dump($num);exit;

      $startDate = $_SESSION['sdate'] ?: date('Y-m-d');
      $endDate = $_SESSION['edate'] ?: date('Y-m-d', strtotime('+1 day'));
      $days = round((strtotime($endDate)-strtotime($startDate))/3600/24);
      // var_dump($days);exit;
      
      $data['sum_price'] = intval($roomtype['price'])*intval($data['nums'])*intval($days);
      // var_dump($data);exit;
      if((intval($num)+intval($data['nums'])) > intval($roomtype['num'])){
        $this -> error("此房型房量不足，请重新选择其他房型或日期！");
      }
     
  		// $data['pmtitle'] = I('post.pmtitle');
  		// $data['pmid'] = intval(I('post.pmid'));
  		// $data['roomid'] = intval(I('post.roomid'));

  		$count = M('Order') -> add($data);
  		if($count > 0){
          //发送邮件提醒到预订人邮箱
          $days = round((strtotime($data['edate'])-strtotime($data['sdate']))/3600/24);
          // var_dump($days);exit;
          $email = $data['email'];
          // $mail_content = '尊敬的 '.$data['name'].' 先生/女士，您已成功预订“奉化华侨豪生大酒店”'.'<br>'.'预订房型：'.$data['title'].$data['pmtitle'].'<br>'.'订单金额：'.$data['sum_price'].'<br>'.'客人姓名'.$data['name'].'<br>'.'联系电话：'.$data['mobile'].'<br>'.'入住日期：'.$data['sdate'].'共'.$days.'天'.'<br>'.'支付方式：到店支付'.'<br>'.'备注信息：'.$data['info'].'<br>'.'限时取消：订单确认后，客人可在入住日期当天18:00前免费取消或者修改，若需继续保留，请与酒店预订部协商。'.'<br>'.'酒店电话：'.$hotel['phone'].'<br>'.'酒店地址：中国上海漕宝路509号';
          // var_dump($mail_content);exit;
          $mail_content = '<table width="760" border="0" align="center" cellpadding="0" cellspacing="0" class="contenttable">
<tbody>
<tr>
<td>
<table width="760" border="0" cellspacing="0" cellpadding="3" class="col-full">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">尊敬的 Mr Liu,</font> <br  />
<br  />
<font face="verdana" color="#666" size="2">如下预订已经取消。
</font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>预订确认号：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">144984552</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>预订取消号码：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">144983512</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" style="margin:10px 0;" class="col-header">
<tbody>
<tr>
<td style="background:#999; border-top:2px solid #ccc;"><font face="verdana" color="#FFF" size="3"><b>预订详情</b></font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>目的地：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><a target="_blank"></a><a href="http://www.shangri-la.com/cn/beijing/chinaworldsummitwing">北京国贸大酒店</a></font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>入住/退房日期：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">2018年8月31日 - 2018年9月1日</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>住宿天数：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">1</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>人数：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">1位成人 1位12岁以下儿童</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>客房类型：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">1 行&#x653F;客房 (大床) <br  />
</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" style="margin:10px 0;" class="col-header">
<tbody>
<tr>
<td style="background:#999; border-top:2px solid #ccc;"><font face="verdana" color="#FFF" size="3"><b>价格详情</b></font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>所选价格：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">京城夏季悦享之旅</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>每晚房价：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">RMB 1,600.00</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>房费：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">RMB 1,600.00<b></b></font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>&#x670D;务费与税费：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">RMB 265.60</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>全部费用 (含&#x670D;务费及税费)：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">RMB 1,865.60</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>房价包括：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">
<p></p>
<ul>
<li>每晚人民币200元餐饮与水疗消费额度。</li><li>国贸79自助早餐（至多双人）。</li><li>高速宽带及无线网络&#x670D;务。</li><li>健身房运动器械及无边泳池。</li></ul>
<p></p>
</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" style="margin:10px 0;" class="col-header">
<tbody>
<tr>
<td style="background:#999; border-top:2px solid #ccc;"><font face="verdana" color="#FFF" size="3"><b>保证资料</b></font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" class="col-full">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">担保预订。提供担保的信用卡号：xxxxxxxxxxxx7662，有效期至xxx6年1月。 如于抵达当日16:00前24小时内（酒店当地时间）取消已担保预订，则需支付一晚房费。</font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" style="margin:10px 0;" class="col-header">
<tbody>
<tr>
<td style="background:#999; border-top:2px solid #ccc;"><font face="verdana" color="#FFF" size="3"><b>客人资料</b></font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>客人姓名：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">Qin Liu</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>贵宾金环会会籍号码：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">不适用</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>电邮地址：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><a href="mailto:18801182131@126.com">18801182131@126.com</a></font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>电话号码：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">18801182131</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" style="margin:10px 0;" class="col-header">
<tbody>
<tr>
<td style="background:#999; border-top:2px solid #ccc;"><font face="verdana" color="#FFF" size="3"><b>酒店资料</b></font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>地址：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">北京建国门外大街1号 100004 中国</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>联络号码：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">电话： (86 10) 6505 2299 / 传真： (86 10) 6505 8811</font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="0" class="group">
<tbody>
<tr>
<td>
<table width="230" border="0" cellspacing="0" cellpadding="3" align="left" class="col-left">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><b>电邮地址：</b></font></td>
</tr>
</tbody>
</table>
<table width="470" border="0" cellspacing="0" cellpadding="3" class="col-right">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"><a href="mailto:reservations.cwsw@shangri-la.com">reservations.cwsw@shangri-la.com</a></font></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" class="col-full">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2"></font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" class="col-full">
<tbody>
<tr>
<td><font face="verdana" color="#666" size="2">房费均可以用当地货币支付(除非另有说明)。 <br  />
<br  />
</font></td>
</tr>
</tbody>
</table>
<table width="760" border="0" cellspacing="0" cellpadding="3" class="col-full">
<tbody>
<tr>
<td><a href="http://b.loyaltyis.com/email/sc/emailbannerlink_sc/" target="_blank"><img src="http://b.loyaltyis.com/email/sc/dynamic_emailbanner_sc.jpg" border="0"  /></a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>';
          sendMail($email,'新订单提醒',$mail_content );

	        $this->success('订单提交成功', U('Index/chenggong?id=' . $count), 3);
	      }else{
	        $this -> error("提交失败");
	      }
  	}else{
      $roomId = intval(I('roomid'));//房类id
      $id = intval(I('id')); // 房型id
      $this->assign('roomId', $roomId);
      $this->assign('pmid', $id);
      $day = (strtotime($_SESSION['edate']) - strtotime($_SESSION['sdate'])) / 86400;
      $people = $_SESSION['people'];
      $roomnum = $_SESSION['roomnum'];

      $this->assign('day', $day);
      $this->assign('people', $people);
      $this->assign('roomnum', $roomnum);

      $action = I('post.action');
      if (!$roomId) {
          $this->error('房型不存在');
      }
  		// $id = I('get.id');
  		$roomtype = M('Roomtype') ->where('id='.$id) -> find();
      // var_dump($roomtype);
  		//多语言支持
	    if(cookie('think_language') == "en-us"){
	      	$roomtype['title'] = $roomtype['title_en'];
	      	$roomtype['description'] = $roomtype['description_en'];
	    }else{
	      	$roomtype['title'] = $roomtype['title'];
	      	$roomtype['description'] = $roomtype['description'];
	    }
  		// var_dump($roomtype);
  		$room = M('Room') ->where('id='.$roomtype['roomid']) -> find();
      // var_dump($room);
  		//多语言支持
	    if(cookie('think_language') == "en-us"){
	      	$room['title'] = $room['title_en'];
	    }else{
	      	$room['title'] = $room['title'];
	    }
      $sum_price = intval($roomtype['price'])*intval($roomnum)*intval($day);
      // var_dump($sum_price);exit;
      // //banner图
      // $info = D('Block') -> get_item_by_title('Room_banner');
      // //$about = D('Block') -> get_item_by_title('Hr_index');
      // $data = json_decode($info['value'], true);
      // $num = intval(count($data['pic']));
      // // $data['content'] = html_entity_decode($data['content']);
      // // $data['content_en'] = html_entity_decode($data['content_en']);
      // //多语言支持
      //   if(cookie('think_language') == "en-us"){
      //       $data['content'] = html_entity_decode($data['content_en']);
      //   }else{
      //       $data['content'] = html_entity_decode($data['content']);
      //   }
      // $data1 = $data['pic']['0'];
      // $this->assign('nums',$num);
      // $this->assign('data1',$data1);
      // $this->assign('data',$data);

	    $this -> assign('room', $room);
      $this -> assign('sum_price', $sum_price);
  		$this -> assign('list', $roomtype);
  		$this -> display();
  	}
  }
  public function chenggong(){
    $orderId = I('id', 0, intval);
    if (!$orderId){
        $this->error('参数错误');
    }     
    $hotelOrder = M('Order');
    $map['id'] = I('get.id');
    $data = $hotelOrder->where($map)->find();
    // var_dump($data);
    // $data['startDate'] = $startDate = date('Y-m-d', $data['sdate']);
    // $data['endDate'] = $endDate = date('Y-m-d', $data['edate']);
    // $data['checkin_info'] = unserialize($data['checkin_info']);
    // var_dump($data);exit;
    if (empty($data)) {
        $this->error('未查询到订单或无查看权限');
    }
    $this->assign('data', $data);
    $this -> display();
  }


    //支付确认
  public function checkOrder(){
      require_once($_SERVER['DOCUMENT_ROOT']."/alipay/alipay.config.php");
      require_once($_SERVER['DOCUMENT_ROOT']."/alipay/lib/alipay_notify.class.php");
      //计算得出通知验证结果

      // $alipay_config['partner']   = '2088721092443123';
      // $alipay_config['seller_email']  = '2199099@lujiang-mega.com';
      // $alipay_config['key']     = 'ykace507cwq09s5nufxl8za0ba7ls2nl';
      $post = I('get.');
      // var_dump($post);exit;
      $alipay_config['partner']   = '2088621461083834';
      $alipay_config['seller_email']  = 'hangbo@hiechangzhou.com';
      $alipay_config['key']     = 'qruu2c71ooj1jntahwawnehns4di4qko';
      // var_dump($alipay_config);
      $alipayNotify = new \AlipayNotify($alipay_config);
      $verify_result = $alipayNotify->verifyReturn();
      // var_dump($verify_result);exit;
      if($verify_result) {//验证成功
          $oid = $_SESSION['oid'];
          //商户订单号
          $out_trade_no = I('out_trade_no');
          //支付宝交易号
          $trade_no = I('trade_no');
          // var_dump($trade_no);exit;
          //交易状态
          $trade_status = I('trade_status');

          if(!strcmp($trade_status,'TRADE_FINISHED') || !strcmp($trade_status ,'TRADE_SUCCESS')) {
              //判断该笔订单是否在商户网站中已经做过处理
              //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
              //如果有做过处理，不执行商户的业务程序
              $hotelOrder = M('G20Handorder');
              $order = $hotelOrder->where(array('ordersn'=>$out_trade_no,'oid'=>$oid ,'paystatu'=>0))->find();
              if(empty($order)){
                  $this->error('未查询到订单或订单已处理');
              }
              $res = $hotelOrder->where(array('oid'=>$oid))->save(array('paystatu'=>1,'transaction_id'=>$trade_no));
              if($res === false){
                  $this->error('订单更新失败');
              }
              // $tag = I('get.');
              // $corePaylog = M('core_paylog','ims_','DB_WE7');
              // $res = $corePaylog->where(array('tid'=>$order['id'],'uniacid'=>$weid))->save(array('status'=>1, 'tag'=>serialize($tag)));
              // if($res === false){
              //     $this->error('支付记录更新失败');
              // }
              $this->success('支付成功', U('G20/hand_order?id='.$order['oid']),3);                
          }else {
              $this->error('状态异常:'.$_GET['trade_status']);
          }
      }else{            
          $this->error('支付宝安全验证失败');
      }         
  }   
}