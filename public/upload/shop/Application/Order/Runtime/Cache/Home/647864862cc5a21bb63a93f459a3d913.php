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
  <form action="" method="POST">
  <div class="guest-pay">
    <div class="container">
      <div class="room-reserve">
          <div class="reserve-stage clearfix">
            <div class="reserve-stage-box fl">
              <div class="reserve-stage-li">1</div><span>选择房型</span>
            </div>
            <div class="reserve-stage-box fl">
              <div class="reserve-stage-li">2</div><span>填写订单</span>
            </div>
            <div class="reserve-stage-box fl">
              <div class="reserve-stage-li">3</div><span>付款方式</span>
            </div>
            <div class="reserve-stage-box reserve-stage-box-on fl">
              <div class="reserve-stage-li reserve-stage-li-on">4</div><span>预订成功</span>
            </div>

          </div>
          <div class="reserve-detail clearfix">
            <div class="reserve-detail-left fl">
              <div class="order-form-item-total"><h3>订单信息</h3></div>
              <br />
              <div class="order-form-item-total-tips" style="font-weight:bold;">预订房型 ：<span><?php echo ($order['style']); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">入住日期 ：<span><?php echo ($btime); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">离店日期 ：<span><?php echo ($etime); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">房间数&nbsp;&nbsp;&nbsp; ：<span><?php echo ($order['nums']); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">预定手机 ：<span><?php echo ($order['mobile']); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">预订人&nbsp;&nbsp;&nbsp; ：<span><?php echo ($order['name']); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">备注&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;：<span><?php echo ($order['info']); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">总价格&nbsp;&nbsp;&nbsp; ：<span><?php echo ($order['sum_price']); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">订单号&nbsp;&nbsp;&nbsp; ：<span><?php echo ($order['confirmationid']); ?></span></div>
              <div class="order-form-item-total-tips" style="font-weight:bold;">支付方式 ：<span><?php echo ($paytype); ?></span></div>
            </div>
          </div>
      </div>
    </div>

  </div>
  </form>


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
  <script type="text/javascript">
  $('.spinner').spinner();
  </script>

</body>
</html>