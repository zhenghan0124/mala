<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/gbh/Public/home/css/swiper-3.4.2.min.css">
  <link rel="stylesheet" href="/gbh/Public/home/css/bootstrap.css">
  <link rel="stylesheet" href="/gbh/Public/home/css/pages.css">
  <link rel="stylesheet" href="/gbh/Public/home/css/style.css">
  <link rel="stylesheet" href="/gbh/Public/home/css/datepicker.css">
  <title>国博中心酒店</title>
</head>
<body>
<div class="header-all clearfix">
  <div class="header-mid">
    <a href="<?php echo U('Index/index');?>"><img src="/gbh/Public/home/img/h-logo.jpg" alt=""></a>
    <ul class="clearfix">
      <li><a href="<?php echo U('Room/index');?>">客房中心</a></li>
      <li><a href="<?php echo U('Hotel/index');?>">酒店概况</a></li>
      <li><a href="<?php echo U('Meeting/meeting');?>">宴会会议</a></li>
      <li><a href="<?php echo U('Expo/center');?>">会展会议</a></li>
      <li class="header-li-last"><a href="<?php echo U('About/contact');?>">联系我们</a></li>
    </ul>
  </div>
  <div class="header-left">
    <a href="<?php echo U('Room/index');?>"><i class="iconfont">&#xe611;</i>酒店预定</a>
  </div>
  <div class="header-right">
    <a href="http://guobo.demo.igori.cn/"><img src="/gbh/Public/home/img/togb.png" alt=""></a><a href="" class="color-black">CN</a><span>|</span><a href="" class="color-gray">EN</a>
  </div>
</div>





  <div class="guest-top">
    <div class="top-link">
      <div class="container clearfix">
        <div class="link-home fl">
          <a href=""><i class="iconfont">&#xe603;</i></a>
        </div>
        <div class="link-list fl">
          <p>您当前的位置：<a href="">首页</a> > <a href="">客房中心</a> > <a href="">客房列表</a></p>
        </div>
      </div>
    </div>
  </div>
  <div class="guest-list">
    <form action="" method="POST">
      <div class="container">
        <h3>客房预订</h3>
        <div class="line-blue">

        </div>
        <div class="reserve-stage clearfix">
  				<div class="reserve-stage-box fl">
  					<div class="reserve-stage-li">1</div><span>选择房型</span>
  				</div>
  				<div class="reserve-stage-box reserve-stage-box-on fl">
  					<div class="reserve-stage-li  reserve-stage-li-on">2</div><span>填写订单</span>
  				</div>
  				<div class="reserve-stage-box fl">
  					<div class="reserve-stage-li">3</div><span>付款方式</span>
  				</div>
  				<div class="reserve-stage-box fl">
  					<div class="reserve-stage-li">4</div><span>预订成功</span>
  				</div>

  			</div>
  			<div class="ticket-reserve">
  				<h3 class="text-left">预定人信息</h3>
  				<div class="reserve-info">
  					<p><label for="">预定人姓名</label><input type="text" name="surname" class="form-control reserve-for-name" style="width:102px" placeholder="姓氏"><input type="text" style="width:102px" name="name" class="form-control reserve-for-name" placeholder="名字"><select name="sex" id="" class="form-control"><option value="1">先生 Mr.</option><option value="2">女士 Mis.</option></select><span><i>*</i>请按实际入住人填写，所填写姓名需要与入住时所持证件一致</span></p>
  					<p><label for="">预定人手机</label><input type="text" name="mobile" class="form-control reserve-for-tel"><span><i>*</i></span></p>
  				</div>

  				<div class="ticket-info">
  					<h3 class="text-left">预定酒店</h3>
  					<div class="ticket-info-box clearfix">
  						<div class="info-box-left fl">
  							<img src="/gbh/Public/home/img/rr.png" alt="">
  						</div>
  						<div class="info-box-right fl">
  							<h4><?php echo ($room['title']); ?></h4>
                <p>大床房共116间，面积52平方米，格调雅致，舒适宽敞，落地景观窗的设计让您饱览绝妙的杭城美景。无线及有线高速网络、大屏幕液晶电视、行政办公桌、迷你吧等现代设施一应俱全。尊贵舒适的床上用品及优质高档的洗浴设备将给您带来非凡怡人的下榻体验。</p>
  							<div class="ticket-detail clearfix">
  								<div class="ticket-detail-box fl">
                    <p>到店日期</p>
  									<input type="text" placeholder="请选择日期" onchange="change()" id="bdate" name="bdate" class="form-control form-control-date" readonly="" value="<?php echo date("Y-m-d") ?>"><i class="iconfont date-i ticket-date">&#xe60b;</i>
  								</div>
  								<div class="ticket-detail-box fl">
  										<p>退房日期</p>
  										<input type="text" placeholder="请选择日期" id="edate" name="edate" class="form-control form-control-date" readonly="" value="<?php echo date("Y-m-d",strtotime("+1 day")) ?>"><i class="iconfont date-i ticket-date">&#xe60b;</i>
  								</div>
                  <script>
                    function change(){
                      var bdate = document.getElementById("bdate").value;
                      var bdate = new Date(bdate);
                      // alert(bdate);
                      bdate.setDate(bdate.getDate()+1);
                      // alert(bdate.getDate());
                      var year = bdate.getFullYear();
                      var month = bdate.getMonth()+1;
                      if(month < 10){
                        month = '0'+month;
                      }
                      var date = bdate.getDate();
                      document.getElementById("edate").value = year+'-'+month+'-'+date;
                    }
                  </script>
  								<div class="ticket-detail-box fl">
  									<p>房间数量</p>
                    <!-- <input type="text" name="num" class="spinner"> -->
                    <select name="num" id="num" style="width:75px; height:25px; border:1px solid rgba(0, 0, 0, 0.07)"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option></select>
                    <!-- <select name="num" id="num" onchange="javascript:senddata(this);" style="width:75px; height:25px; border:1px solid rgba(0, 0, 0, 0.07)"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option></select> -->
  								</div>
                  <div class="ticket-detail-box fr">
                    <p class="ticket-detail-price"><span>￥<i><span id="outdiv2"><?php echo ($room['detail']['webprice']); ?></span></i>/晚</span><!-- <em>￥2888</em> --></p>
                  </div>
  							</div>
  						</div>
  					</div>
  				</div>

  			</div>
  			<div class="reserve-detail-info">
  				<div class="r-info-box">
  					<label for="">邮箱</label><input type="text" name="email" class="form-control "><span>订单完成后会给您发送邮箱提醒</span>
  				</div>
  				<div class="">
  					<label for="" class="label-aera">备注信息</label><textarea name="info" rows="8" cols="80" class="form-control"></textarea>
  				</div>
  			</div>
  			<div class="r-attention">
  				<h4>温馨提示</h4>
  				<p>1、门票当日一次有效，不能重复使用；</p>
  				<p>2、如您有相关优惠证件请现场凭证购买（具体请查看门票预订须知）；</p>
  				<p>3、游玩当天凭预订成功短信中的二维码或二代身份证至东西栅景区游客服务中心检票口扫码检票入园；</p>
  				<p>4、若您为乌镇旅游股份有限公司旗下酒店入住客人，建议在入住当天至景区指定前台购买东西栅联票（入住期间二日内一次有效）；</p>
  				<p>5、退改规则：如需退票，请在出游前一天的12：00前通过http://www.hiechangzhou.com/网站提交申请, 逾期不接受退票。</p>
  			</div>
      </div>
      <div class="submit-area">
  			<div class="container clearfix">
  				<div class="area-text fl">
  					<p>应付金额 : <span><i>￥</i><span id="outdiv"><?php echo ($room['detail']['webprice']); ?></span><i>/晚</i></span></p>
  				</div>
  				<div class="area-content">
  					<input type="submit" value="提交订单">
  				</div>
  			</div>
  		</div>
    </form>
  </div>


<div class="footer-all clearfix">
  <div class="container">
    <div class="footer-top clearfix">
      <div class="f-logo fl">
        <img src="/gbh/Public/home/img/f-logo.png" alt="">
      </div>
      <div class="f-list fl">
        <ul class="clearfix">
          <li class="f-list-item fl">
            <p>客房中心</p>
            <ul>
              <li><a href="<?php echo U('Room/detail');?>">高级(商务)双床房</a></li>
              <li><a href="<?php echo U('Room/detail');?>">高级(商务)双床房</a></li>
              <li><a href="<?php echo U('Room/detail');?>">行政大床房</a></li>
              <li><a href="<?php echo U('Room/detail');?>">行政套房</a></li>
              <li><a href="<?php echo U('Room/detail');?>">豪华套房</a></li>
              <li><a href="<?php echo U('Room/detail');?>">总统套房</a></li>
            </ul>
          </li>
          <li class="f-list-item fl">
            <p>餐饮美食</p>
            <ul>
              <li><a href="<?php echo U('Hotel/food');?>">印象西餐厅</a></li>
              <li><a href="<?php echo U('Hotel/food');?>">中餐厅包厢</a></li>
              <li><a href="<?php echo U('Hotel/album');?>">美食相册</a></li>
            </ul>
          </li>
          <li class="f-list-item fl">
            <p>健身中心</p>
            <ul>
              <li><a href="<?php echo U('Hotel/gym');?>">心肺功能训练区</a></li>
              <li><a href="<?php echo U('Hotel/gym');?>">自由重量器械区</a></li>
              <li><a href="<?php echo U('Hotel/gym');?>">休闲运动区</a></li>
              <li><a href="<?php echo U('Hotel/gymalbum');?>">健身相册</a></li>
            </ul>
          </li>
          <li class="f-list-item fl">
            <p>宴会会议</p>
            <ul>
              <li><a href="<?php echo U('Meeting/ballroom');?>">宴会厅</a></li>
              <li><a href="<?php echo U('Meeting/meeting');?>">会议室</a></li>
              <li><a href="<?php echo U('Meeting/album');?>">宴会相册</a></li>
            </ul>
          </li>
          <li class="f-list-item fl">
            <p>酒店概况</p>
            <ul>
              <li><a href="<?php echo U('Hotel/index');?>">酒店概况</a></li>
              <li><a href="<?php echo U('Hotel/index');?>">客房介绍</a></li>
            </ul>
          </li>
          <li class="f-list-item fl">
            <p>会展会议</p>
            <ul>
              <li><a href="<?php echo U('Expo/center');?>">国博会议中心</a></li>
              <li><a href="<?php echo U('Expo/garden');?>">空中花园</a></li>
              <li><a href="<?php echo U('Expo/g20');?>">G20峰会体验馆</a></li>
            </ul>
          </li>
          <li class="f-list-item fl">
            <p>联系我们</p>
            <ul>
              <li><a href="<?php echo U('About/contact');?>">联系方式</a></li>
              <li><a href="<?php echo U('About/contact');?>">在线反馈</a></li>
              <li><a href="<?php echo U('About/contact');?>">来店线路</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer-bot">
      <div class="footer-bot-left fl">
        <p>友情链接 <em>|</em> 法律声明<a href=""><i class="iconfont f-qq">&#xe60d;</i></a><a href=""><i class="iconfont">&#xe61c;</i></a><a href=""><i class="iconfont">&#xe7e5;</i></a></p>
        <p class="f-add">地址 : 杭州市萧山区钱江世纪城奔竞大道353号    电话：+ 86 (571) 8290 8888  传真：+ 86 (571) 8290 8819</p>
        <p class="f-copy">Copyright 2016 杭州国际博览中心. All Rights Reserved 浙ICP备16030893号<i></i></p>
      </div>
      <div class="footer-bot-right fr">
        <img src="/gbh/Public/home/img/2wm.jpg" alt="">
        <img src="/gbh/Public/home/img/wechat.jpg" alt="">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="/gbh/Public/home/js/jquery.min.js"></script>



	<script type="text/javascript" src="/gbh/Public/home/js/jquery.spinner.js"></script>
  <script src="/gbh/Public/home/js/bootstrap-datepicker.js"></script>
  <script src="/gbh/Public/home/js/bootstrap-datepicker.zh-CN.js"></script>
	<script type="text/javascript">
	$('.spinner').spinner();
	</script>
  <script>
    switch ('<<?php echo (cookie('think_language')); ?>>')
    {
    case "zh-cn":
      language = "zh-CN";
      break;
    case "en-us":
      language = "en-US";
      break;
    default:
      language = "zh-CN";
    }
    jQuery('.form-control-date').datepicker({
      language: language,
      autoclose: true,
      todayHighlight: true,
      format: 'yyyy-mm-dd',
      startDate: new Date()
    });
  </script>
  <script>
  // function senddata(inputobj){
  // var obj;
  // obj=document.getElementById("outdiv");
  // obj2=document.getElementById("outdiv2");
  // obj.innerHTML=inputobj.value*<?php echo ($room['detail']['webprice']); ?>;
  // obj2.innerHTML=inputobj.value*<?php echo ($room['detail']['webprice']); ?>;
  // }
  </script>

</body>
</html>