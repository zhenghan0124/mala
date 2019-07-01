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
    <div class="container">
      <h3>酒店客房预订</h3>
      <div class="line-blue">

      </div>
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="list-box clearfix">
        <div class="list-pic fl">
          <img src="/gbh/Public/home/img/gr1.jpg" alt="">
        </div>
        <div class="list-text fl clearfix">
          <div class="list-text-left fl">
            <h4><?php echo ($vo["title"]); ?></h4>
            <p>面积：54 - 59平方米（581 - 635平方尺）</p>
            <p>景观：迷人市景</p>
            <p>床型：特大双床房</p>
            <a href="<?php echo U('Room/detail',array('id'=>$vo['id']));?>">查看更多房间信息 >></a>
          </div>
          <div class="list-text-right fr clearfix">
            <div class="list-price fl">
              <span><i>￥</i><?php echo ($vo["webprice"]); ?></span>
            </div>
            <div class="list-book fl">
              <a href="<?php echo U('Room/reserve',array('id'=>$vo['id']));?>">立即预定<i class="iconfont">&#xe735;</i></a>
            </div>
          </div>
        </div>
      </div><?php endforeach; endif; else: echo "" ;endif; ?>
      <!-- <div class="list-box clearfix">
        <div class="list-pic fl">
          <img src="/gbh/Public/home/img/gr2.jpg" alt="">
        </div>
        <div class="list-text fl clearfix">
          <div class="list-text-left fl">
            <h4>豪华(商务)双床房</h4>
            <p>面积：54 - 59平方米（581 - 635平方尺）</p>
            <p>景观：迷人市景</p>
            <p>床型：特大双床房</p>
            <a href="">查看更多房间信息 >></a>
          </div>
          <div class="list-text-right fr clearfix">
            <div class="list-price fl">
              <span><i>￥</i>980</span>
            </div>
            <div class="list-book fl">
              <a href="">立即预定<i class="iconfont">&#xe735;</i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="list-box clearfix">
        <div class="list-pic fl">
          <img src="/gbh/Public/home/img/gr3.jpg" alt="">
        </div>
        <div class="list-text fl clearfix">
          <div class="list-text-left fl">
            <h4>高级大床房</h4>
            <p>面积：54 - 59平方米（581 - 635平方尺）</p>
            <p>景观：迷人市景</p>
            <p>床型：特大双床房</p>
            <a href="">查看更多房间信息 >></a>
          </div>
          <div class="list-text-right fr clearfix">
            <div class="list-price fl">
              <span><i>￥</i>1580</span>
            </div>
            <div class="list-book fl">
              <a href="">立即预定<i class="iconfont">&#xe735;</i></a>
            </div>
          </div>
        </div>
      </div>
      <div class="list-box clearfix">
        <div class="list-pic fl">
          <img src="/gbh/Public/home/img/gr4.jpg" alt="">
        </div>
        <div class="list-text fl clearfix">
          <div class="list-text-left fl">
            <h4>行政大床房</h4>
            <p>面积：54 - 59平方米（581 - 635平方尺）</p>
            <p>景观：迷人市景</p>
            <p>床型：特大双床房</p>
            <a href="">查看更多房间信息 >></a>
          </div>
          <div class="list-text-right fr clearfix">
            <div class="list-price fl">
              <span><i>￥</i>1880</span>
            </div>
            <div class="list-book fl">
              <a href="">立即预定<i class="iconfont">&#xe735;</i></a>
            </div>
          </div>
        </div>
      </div> -->
    </div>
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



</body>
</html>