<?php
namespace Order\Controller;
use Think\Controller;
class RoomController extends Controller {
  public function index(){
  	//连接微信数据库
    $bdate = date("Y-m-d");
    $edate = date("Y-m-d",strtotime("+1 day"));
    $id = 2;

    $User = M('hotel2');
    $hotel = $User->where('id='.$id)->find();
    // var_dump($hotel);
    if (!$hotel) {
      $this->error('未找到酒店信息 ');
    }

    //查询微信端房型
    $roomlist = M('hotel2_room')->where('hotelid='.$id.' AND status=1')->order('oprice ASC')->select();
    // var_dump($roomlist);

    //调用接口房型
    $params = array(
        'url' => $hotel['xr_url'],
        'username' => $hotel['xr_username'],
        'password' => $hotel['xr_pwd']
    );
    $days = 1;
    // var_dump($days);exit;
    import('Org.Util.xrapi');
    $xrapi = new \xrapi($params);
    // var_dump($xrapi);
    $ext=<<<XML
<RatePlans>
<RatePlan reservationActionType="CHANGE">
<ratePlanCode>RAC</ratePlanCode> //如果传入这个值,则openid对应的会员价不再生效
<TimeSpan timeUnitType="DAY">
<startTime>{$bdate}T00:00:00.000</startTime> //抵达时间
<numberOfTimeUnits>$days</numberOfTimeUnits>  //房晚
</TimeSpan>
<Rates>
<Rate reservationActionType="CHANGE" rateBasisTimeUnitType="DAY"></Rate>
</Rates>
<CusNo></CusNo>   //协议单位号
</RatePlan>
</RatePlans>
XML;
	//查询房价房量
    $xr_rate = $xrapi->RateQueryByCusNo($ext);
    // var_dump($xr_rate);exit;
    foreach ($xr_rate as $k => $v){
        foreach ($roomlist as $key => $value) {
          if($value['rmtype'] == $v['roomInventoryCode']){
            $roomlist[$key]['webprice'] = $v['ratelists']['ratelist']['roomrate'];
            $roomlist[$key]['surnum'] = $v['surnum'];
          }
        }
    }
    // var_dump($roomlist);exit;
    foreach ($roomlist as $a => $b) {
		for($i=0,$len=count($roomlist); $i<$len; $i++){
			    if(!isset($roomlist[$i]['webprice'])){
			        unset($roomlist[$i]);
			    }
		}
	}
    // var_dump($roomlist);exit;
    session_start();
    $_SESSION['room'] = $roomlist;
    $this -> assign('list', $roomlist);
    $this -> display();
  }

  public function reserve(){
  	$id = I('get.id');
  	// var_dump($id);
  	$room = M('hotel2_room')->where('id='.$id)->find();
    // var_dump($room);exit;
    // var_dump($_POST);
    $roomlist = $_SESSION['room'];
    // var_dump($roomlist);
    foreach ($roomlist as $k => $v) {
	  if($v['rmtype'] == $room['rmtype']){
	    $room['detail'] = $v;
	  }
	}
	// var_dump($room);exit;
	$bdate = I('post.bdate');
	$edate = I('post.edate');
	$num = I('post.num');
	$sex = I('post.sex');
	$surname = I('post.surname');
	$name = I('post.name');
	$mobile = I('post.mobile');
	$email = I('post.email');
	$info = I('post.info');
	if(!empty($num) || !empty($sex) || !empty($mobile) || !empty($name) || !empty($info)){
		//连接微信数据库
		$hotelid = 2;
		$User = M('hotel2');
		$hotel = $User->where('id='.$hotelid)->find();
		// var_dump($hotel);exit;
		if (!$hotel) {
		  $this->error('未找到酒店信息 !');
		}

		//调用接口房型房价房量
		$params = array(
		    'url' => $hotel['xr_url'],
		    'username' => $hotel['xr_username'],
		    'password' => $hotel['xr_pwd']
		);

		$days = round((strtotime($edate)-strtotime($bdate))/3600/24);
		import('Org.Util.xrapi');
		$xrapi = new \xrapi($params);
		$ext=<<<XML
		<RatePlans>
		<RatePlan reservationActionType="CHANGE">
		<ratePlanCode>RAC</ratePlanCode> //如果传入这个值,则openid对应的会员价不再生效
		<TimeSpan timeUnitType="DAY">
		<startTime>{$bdate}T00:00:00.000</startTime> //抵达时间
		<numberOfTimeUnits>$days</numberOfTimeUnits>  //房晚
		</TimeSpan>
		<Rates>
		<Rate reservationActionType="CHANGE" rateBasisTimeUnitType="DAY"></Rate>
		</Rates>
		<CusNo></CusNo>   //协议单位号
		</RatePlan>
		</RatePlans>
XML;
		//查询房价房量
		$rate = $xrapi->RateQueryByCusNo($ext);
		// var_dump($rate);exit;
		foreach ($rate as $k => $v) {
		  if($v['roomInventoryCode'] == $room['rmtype']){
		    $room['detail'] = $v;
		  }
		}
		// var_dump($room);exit;
		if($room['detail']['surnum']<$num){
			$this->error('此房型房量不足，请预订其它房型或者重新选择房间数！');
			}else{
			  $data = array();
			  $data['bdate'] = $bdate;
			  $data['edate'] = $edate;
			  $data['num'] = $num;
			  $data['sex'] = $sex;
			  $data['surname'] = $surname;
			  $data['name'] = $name;
			  $data['email'] = $email;
			  $data['mobile'] = $mobile;
			  $data['info'] = $info;

			  $room['data'] = $data;
			  // var_dump($room);exit;
			  $_SESSION['detail'] = $room;
			  $this->success('订单信息填写完成！',U('Room/pay'));die;
			}
		}
		$this -> assign('room', $room);
	    $this -> display();
    }

  public function pay(){
  	// var_dump($_SESSION['detail']);
  	$room = $_SESSION['detail'];
    // var_dump($room);
  	$days = round((strtotime($room['data']['edate'])-strtotime($room['data']['bdate']))/3600/24);
    // var_dump($days);
  	$num = intval($room['data']['num']);
  	// var_dump($num);
  	$rate = intval($room['detail']['ratelists']['ratelist']['roomrate']);
    // $rate = intval($room['detail']['webprice']);
  	// var_dump($rate);
  	$sum = $days*$num*$rate;
  	// var_dump($sum);
  	$this -> assign('sum', $sum);
  	$act=I('post.act');
    if($act == 1){
      $id = 2;
      $hotel = M('hotel2');
      $hotel = $hotel->where('id='.$id)->find();
      $xr_ext = json_decode($hotel['xr_ext'], true);
      // var_dump($xr_ext);exit;

      $data = $_SESSION['detail']['data'];
      // var_dump($data);
      // var_dump($room['detail']['ratelists']['ratelist']);exit;
      // $days = round((strtotime($data['edate'])-strtotime($data['bdate']))/3600/24);
      // var_dump($days);exit;
      
      //调用预定接口
      $params = array(
          'url' => $hotel['xr_url'],
          'username' => $hotel['xr_username'],
          'password' => $hotel['xr_pwd']
      );

      import('Org.Util.xrapi');
      $xrapi = new \xrapi($params);

      $ext = "<RoomRate><stay>{$data['bdate']}T00:00:00</stay><type>{$room['rmtype']}</type><day>{$days}</day><ratecode>{$xr_ext['ratecode']}</ratecode></RoomRate>";
      $roomRate = $xrapi->GetRmRate($ext);
      // var_dump($roomrate);
      if($days == 1){
        $ratecode = $roomRate['ratecode'];
      }else{
        $ratecode = $roomRate[0]['ratecode'];
      }
      // var_dump($ratecode);exit;
      $ext = <<<XML
                <Reservation mfShareAction="NA" mfReservationAction="ADD"> 
                    <reservationOriginatorCode>{$xr_ext['reservationOriginatorCode']}</reservationOriginatorCode>
                    <protocol></protocol>//协议单位
                    <ResComments>   //订单备注
                        <ResComment reservationActionType="CHANGE">
                            <comment>{$data['info']}</comment>//特许要求
                        </ResComment>
                      </ResComments>
                          <ResProfiles> 
                            <ResProfile> 
                              <Profile profileType="GUEST" gender="MALE"> 
                                <IndividualName> 
                                  <namePrefix/>  //根据性别来确定Mr,Ms
                                  <nameFirst>{$data['surname']}</nameFirst>  //姓
                                  <nameSur>{$data['name']}</nameSur>      //名
                                  <nameTitle/>
                                </IndividualName>
                                <Document>
                                  <nationality>CN</nationality>
                                </Document>
                                <PostalAddresses>
                                   <PostalAddress addressType="HOME">
                                    <countryCode>CN</countryCode>
                                   </PostalAddress>
                                </PostalAddresses>
                                <primaryLanguageID>C</primaryLanguageID> 
                              </Profile>
                            </ResProfile> 
                          </ResProfiles>  
                          <RoomStays> 
                            <RoomStay mfShareAction="NA" mfReservationAction="ADD" reservationActionType="CHANGE" reservationStatusType="RESERVED"> 
                              <roomStayRPH/>  
                              <roomInventoryCode>{$room['rmtype']}</roomInventoryCode>  
                              <TimeSpan timeUnitType="DAY"> 
                                <startTime>{$data['bdate']}</startTime>  //到店时间
                                <numberOfTimeUnits>{$days}</numberOfTimeUnits>  //房晚
                                <arrtime>18:00</arrtime>   //最晚到店时间
                              </TimeSpan>
                              <GuestCounts>
                                <GuestCount>
                                  <ageQualifyingCode>ADULT</ageQualifyingCode>
                                  <mfCount>1</mfCount>
                                </GuestCount>
                                <GuestCount>
                                  <ageQualifyingCode>CHILD</ageQualifyingCode>
                                  <mfCount>0</mfCount> 
                                </GuestCount>
                              </GuestCounts>
                              <RatePlans> 
                                <RatePlan reservationActionType="CHANGE"> 
                                    <ratePlanCode>{$ratecode}</ratePlanCode>  //ELITE-RAC 为之前查询到的房价信息中的rateLists中的rateCode
                                    <mfsourceCode>{$xr_ext['mfsourceCode']}</mfsourceCode>  //在微网站增加来源码的设置页面
                                    <mfMarketCode>{$xr_ext['mfMarketCode']}</mfMarketCode> //在微网站增加市场码的设置页面
                                  <numRooms>{$data['num']}</numRooms> //房间数
                                </RatePlan>
                              </RatePlans>
                                <mfchannelCode>{$xr_ext['mfchannelCode']}</mfchannelCode> //在微网站增加渠道码的设置页面
                            </RoomStay>
                          </RoomStays>
                          <resCommentRPHs></resCommentRPHs>
                          <resProfileRPHs>{$data['mobile']}</resProfileRPHs>
                        </Reservation>
XML;
      // print($ext);exit;
      $resp = $xrapi->Reservation($ext);
      // var_dump($resp);exit;
      if($resp['confirmationID']){
        $weid = $room['weid'];
        $id = 2;
        $roomid = $room['id'];
        $style = $room['title'];
        $name = $room['data']['surname'].$room['data']['name'];
        $mobile = $room['data']['mobile'];
        $nums = $room['data']['num'];
        $bdate = $room['data']['bdate'];
        $edate = $room['data']['edate'];
        $info = $room['data']['info'];
        $sum_price = $room['detail']['ratelists']['ratelist']['roomrate']*intval($nums)*$days;
        $mprice = $room['detail']['roomrate'];
        $day = round((strtotime($edate)-strtotime($bdate))/3600/24);
        $ordersn = 'WEB'.date( 'ymd' ) . rand(1000, 9999);
        // var_dump($resp);exit;
        $data = array(
                  'weid'=>$weid,
                  'hotelid'=>$id,
                  'roomid'=>$roomid,
                  'style'=>$style,
                  'name'=>$name,
                  'contact_name'=>$name,
                  'mobile'=>$mobile,
                  'nums'=> $nums ,
                  'btime'=> strtotime($bdate),
                  'etime'=> strtotime($edate),
                  'paytype'=> 3,
                  'info' => $info,
                  // 'checkin_info' => $checkin_info,
                  'time' => time(),
                  'sum_price' => $sum_price,
                  'mprice' => $mprice,
                  'day' =>  $day,
                  'ordersn' => $ordersn,
                  'confirmationid' => $resp['confirmationID'],
              );
        // var_dump($data);exit;
        $insert = M('hotel2_order')->add($data);
        if($insert){

          //发送邮件提醒到酒店
          if($hotel['email_tx']!=''){
              $notify = C('signature');
              $mail_content = '尊贵的'.$hotel['title'].'用户 ，您有新的订单，请登录管理平台进行维护！'.htmlspecialchars_decode($notify);
              $emails = explode(',',$hotel['email_tx']);
              foreach($emails AS $email){
                  sendMail($email,'新订单提醒',$mail_content );
              }
          }
          //发送邮件提醒到预订人邮箱
          $days = round((strtotime($edate)-strtotime($bdate))/3600/24);
          // var_dump($days);exit;
          $email = $room['data']['email'];
          $mail_content = '恭喜，您已成功预订“'.$hotel['title'].'”'.'<br>'.'房型：'.'<br>'.$room['title'].'<br>'.'订单金额：'.$room['detail']['ratelists']['ratelist']['roomrate']*$room['data']['num']*$days.'<br>'.'入住人：'.$room['data']['surname'].$room['data']['name'].'<br>'.'联系电话：'.$room['data']['mobile'].'<br>'.'入住日期：'.$room['data']['bdate'].'<br>'.'共'.$days.'天'.'<br>'.'酒店联系电话：'.$hotel['phone'];
          // var_dump($mail_content);exit;
          sendMail($email,'新订单提醒',$mail_content );
          // session_destroy();
          $this->success('预定成功',U('Room/chengong',array('id'=>$insert)));die;
        }else{
          $this->error('预定失败');
        }
      }
      
      
    }


    $this -> display();
  }

  // 房间详情
  public function detail(){
    $id = intval(I('get.id'));
    // var_dump($id);
    header("content-type:text/html; charset=utf-8");
    //获取订单信息
    $room = M('hotel2_room');
    $room = $room->where('id='.$id)->find();
    var_dump($room);

    $this->display();
  }

  // 预定成功
  public function chengong(){
    $id = intval(I('get.id'));
    // var_dump($id);
    header("content-type:text/html; charset=utf-8");
    //获取订单信息
    $order = M('hotel2_order');
    $order = $order->where('id='.$id)->find();
    // var_dump($order);
    if($order['paytype'] == 3){
      $paytype = '到店支付';
    }elseif ($order['paytype'] == 22) {
      $paytype = '支付宝支付';
    }

    $btime = date("Y-m-d",$order['btime']);
    $etime = date("Y-m-d",$order['etime']);
    $this->assign('btime',$btime);
    $this->assign('etime',$etime);
    $this->assign('paytype',$paytype);
    $this->assign('order',$order);
    $this->display();
  }
}