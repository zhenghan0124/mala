<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/Public/home/css/swiper-3.4.2.min.css">
  <link rel="stylesheet" href="/Public/home/css/bootstrap.css">
  <link rel="stylesheet" href="/Public/home/css/pages.css">
  <link rel="stylesheet" href="/Public/home/css/style.css">
  <link rel="stylesheet" href="/Public/home/css/datepicker.css">
  <title>国博中心酒店</title>
</head>
<body>
<div class="header-all clearfix">
  <div class="header-mid">
    <a href="/"><img src="/Public/home/img/h-logo.jpg" alt=""></a>
    <ul class="clearfix">
      <li><a href="<?php echo U('Room/index');?>">客房中心</a></li>
      <li><a href="<?php echo U('Hotel/index');?>">酒店概况</a></li>
      <li><a href="<?php echo U('Meeting/meeting');?>">宴会会议</a></li>
      <li><a href="<?php echo U('Expo/center');?>">会展会议</a></li>
      <li class="header-li-last"><a href="<?php echo U('About/contact');?>">联系我们</a></li>
    </ul>
  </div>
  <div class="header-left">
    <a href=""><i class="iconfont">&#xe611;</i>酒店预定</a>
  </div>
  <div class="header-right">
    <a href="" class="color-black">CN</a><span>|</span><a href="" class="color-gray">EN</a>
  </div>
</div>




  <div class="contact-top">
    <div class="top-link">
      <div class="container clearfix">
        <div class="link-home fl">
          <a href=""><i class="iconfont">&#xe603;</i></a>
        </div>
        <div class="link-list fl">
          <p>您当前的位置：<a href="">首页</a> > <a href="">联系我们</a></p>
        </div>
      </div>
    </div>
  </div>
  <div class="contact-content">
    <div class="container">
      <h3>联系我们</h3>
      <div class="line-blue">

      </div>
      <div class="contact-wrap clearfix">
        <div class="contact-left fl">
          <h4><i class="iconfont">&#xe604;</i>+86（571）8290 8866</h4>
          <div class="contact-left-box">
            <p><i class="iconfont contact-i1">&#xe71d;</i>杭州市萧山区钱江世纪城奔竞大道353号</p>
            <p><i class="iconfont contact-i2">&#xe670;</i>+86 (571)8387 0667</p>
            <p><i class="iconfont">&#xe696;</i>sales@hiechangzhou.com</p>
            <p><i class="iconfont">&#xe61a;</i>http://www.hiechangzhou.com</p>
            <div class="contact-evm">
              <div class="contact-web fl">
                <img src="/Public/home/img/2wm.jpg" alt="">
                <p>关注官方公众号</p>
              </div>
              <div class="fl">
                <img src="/Public/home/img/wechat.jpg" alt="">
                <p>关注官方手机站</p>
              </div>
            </div>
          </div>
        </div>
        <div class="contact-right fl">
          <p>尊敬的阁下:</p>
          <p>如果您对我们有什么建议或意见，请在此写下您的宝贵意见，我们将在收到信息三个工作日内回复您。谢谢！</p>
          <div class="name-num clearfix">
            <div class="wd45 fl">
              <input type="text" placeholder="您的称呼" class="form-control">
            </div>
            <div class="wd45 fr">
              <input type="text" placeholder="联系方式" class="form-control">
            </div>
          </div>
          <div class="say-something">
            <textarea name="#" class="form-control" id="#" placeholder="留言内容"></textarea>
          </div>
          <div class="contact-sub">
            <input type="submit" class="btn" value="提交">
          </div>
        </div>
      </div>

    </div>
    <div class="contact-map">
      <img src="/Public/home/img/map.jpg" alt="">
    </div>

  </div>


<div class="footer-all clearfix">
  <div class="container">
    <div class="footer-top clearfix">
      <div class="f-logo fl">
        <img src="/Public/home/img/f-logo.png" alt="">
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
        <img src="/Public/home/img/2wm.jpg" alt="">
        <img src="/Public/home/img/wechat.jpg" alt="">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="/Public/home/js/jquery.min.js"></script>


  <script src="/Public/home/js/swiper-3.4.2.min.js"></script>
  <script>
    //swiper
    var mySwiper = new Swiper('.swiper-container', {
      loop: true,
      autoplay: 6000,
      nextButton: '.swiper-next',
      prevButton: '.swiper-prev'
    })
  </script>

</body>
</html>