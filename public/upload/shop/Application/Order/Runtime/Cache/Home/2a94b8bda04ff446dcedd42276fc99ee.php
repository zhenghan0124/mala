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





  <div class="index-slide">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <a href=""><img src="/gbh/Public/home/img/sd1.jpg" alt=""></a>
        </div>
        <div class="swiper-slide">
          <a href=""><img src="/gbh/Public/home/img/sd2.jpg" alt=""></a>
        </div>
        <div class="swiper-slide">
          <a href=""><img src="/gbh/Public/home/img/sd3.jpg" alt=""></a>
        </div>
      </div>
      <div class="swiper-pagination">
      </div>
    </div>
  </div>
  <div class="index-book">
    <div class="container">
      <div class="book-content clearfix">
        <div class="book-content-left fl clearfix">
          <div class="book-left-i fl">
            <i class="iconfont">&#xe62a;</i>
          </div>
          <div class="book-left-text fl">
            <p>即刻预订房间</p>
            <span>Reserve Now</span>
          </div>
        </div>
        <div class="book-content-right fl">
          <form action="<?php echo U('Room/index');?>">
            <div class="book-right-top clearfix">
              <div class="table-box fl">
                <select name="" id="">
                  <option value="">豪华大床房</option>
                  <option value="">标间</option>
                </select>
                <i class="iconfont">&#xe688;</i>
              </div>
              <div class="index-book-date fl clearfix">
                <div class="index-date-box">
                  <input type="text" class="form-control form-control-date" readonly="" value="2017-09-12"><i class="iconfont">&#xe618;</i>
                </div>
                <div class="date-spare fl"></div>
                <div class="index-date-box">
                  <input type="text" class="form-control form-control-date" readonly="" value="2017-09-12"><i class="iconfont">&#xe618;</i>
                </div>
              </div>
              <div class="index-num-book fl">
                <input type="text" class="form-control"><i class="iconfont">&#xe77a;</i>
              </div>
              <div class="index-sub-box fl">
                <input type="submit" class="form-control" value="">
              </div>
            </div>
          </form>
          <div class="book-right-bot">
            <a href="">庆国庆 黄金专享价85折</a>
            <a href="">查看最新活动专享价 >></a>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="index-conclusion">
    <div class="container">
      <h3>杭州国际博览中心北辰大酒店</h3>
      <p>是杭州国际博览中心的配套四星级酒店，坐落于钱塘江南岸，矗立于钱江世纪城核心区，俯瞰钱塘江之壮观美景，一览钱江世纪城之新风。酒店共19层，室内外均有连廊直通展厅和各会议室，262间时尚雅致的豪华客房中包括18间套房，房间面积44-165平方米，均配备了舒适完备的现代化设施，为您提供高档奢华的入住环境，尽享一线钱塘江美景。中西餐厅各具特色，提供世界各地美食，自助、零点、送餐多样形式尽享美味风尚。</p>
      <div class="service-intro">
        <ul>
          <li><i class="iconfont">&#xe607;</i>最优惠房价保证</li>
          <li><i class="iconfont">&#xe672;</i>免费 Wi-Fi 网络</li>
          <li><i class="iconfont">&#xe62f;</i>体贴入微的服务</li>
          <li><i class="iconfont">&#xe601;</i>温馨舒适的入住体验</li>
          <li><i class="iconfont">&#xe629;</i>便捷的立体交通网络</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="index-link-other">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="index-link-box">
            <a href=""><img src="/gbh/Public/home/img/indexl1.jpg" alt=""></a>
            <h4>餐饮美食</h4>
            <p>酒店拥有三间风格迥异的餐厅 - 印象西餐厅、中餐厅和大堂吧。印象西餐厅臻选世界各地美食元素，为宾客提供全天侯优质的餐饮体验。</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="index-link-box">
            <a href=""><img src="/gbh/Public/home/img/indexl2.jpg" alt=""></a>
            <h4>健身中心</h4>
            <p>健身中心位于酒店的3层，共分为心肺功能训练区、自由重量器械区和休闲运动区。宽阔的运动场地、舒适轻松的氛围，能让您缓解精神压力、提高睡眠质量……</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="index-link-box">
            <a href=""><img src="/gbh/Public/home/img/indexl3.jpg" alt=""></a>
            <h4>宴会会议</h4>
            <p>酒店配套750平米无柱式宴会厅（可分为5个不同规模会议室）和1间贵宾会议室。齐全先进的会议设施，全面覆盖的无线网络，精致典雅的设计风格……</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="index-room-slide">
    <div class="room-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide clearfix">
          <div class="r-swiper-left fl">
            <div class="room-text">
              <h3>高级(商务)大床房</h3>
              <p>套房配备了高档舒适的现代化设施，壮丽的钱塘江景和雅致的空中花园美景尽收眼底。</p>
              <p>房间设计风格源自于钱塘江的一线潮，将杭州“山美、水美、境幽史悠”的内涵融入其中。高级定制的床上用品、充足的室内空间，细致贴心的客房服务，让您尽情享受奢华商务品味。</p>
              <a href="">查看详细</a>
            </div>
          </div>
          <div class="r-swiper-right fl" style="background:url('/gbh/Public/home/img/rs1.jpg') center 0 no-repeat">
            <div class="bc-plus">
              <img src="/gbh/Public/home/img/tr.png" alt="">
            </div>
          </div>
        </div>
        <div class="swiper-slide clearfix">
          <div class="r-swiper-left fl">
            <div class="room-text">
              <h3>高级(商务)大床房</h3>
              <p>套房配备了高档舒适的现代化设施，壮丽的钱塘江景和雅致的空中花园美景尽收眼底。</p>
              <p>房间设计风格源自于钱塘江的一线潮，将杭州“山美、水美、境幽史悠”的内涵融入其中。高级定制的床上用品、充足的室内空间，细致贴心的客房服务，让您尽情享受奢华商务品味。</p>
              <a href="">查看详细</a>
            </div>
          </div>
          <div class="r-swiper-right fl" style="background:url('/gbh/Public/home/img/rs2.jpg') center 0 no-repeat">
            <div class="bc-plus">
              <img src="/gbh/Public/home/img/tr.png" alt="">
            </div>
          </div>
        </div>

      </div>
      <div class="swiper-pagination">
      </div>
      <div class="swiper-prev"><a href=""><i class="iconfont">&#xe72e;</i></a></div>
      <div class="swiper-next"><a href=""><i class="iconfont">&#xe686;</i></a></div>
    </div>
  </div>
  <div class="index-around">
    <div class="container">
      <h3>周边配套</h3>
      <p>杭州国际博览中心北辰大酒店是杭州国际博览中心的配套四星级酒店，坐落于钱塘江南岸，矗立于钱江世纪城核心区，交通便捷，距离萧山国际机场20分钟车程，杭州东站20分钟车程，杭州站，杭州南站均在15分钟以内，周边景区有钱江新城，钱塘江，奥体中心等……</p>
      <div class="index-a-pic clearfix">
        <div class="row">
          <div class="col-md-6">
            <div class="qy-pic">
              <img src="/gbh/Public/home/img/ip1.jpg" alt="">
            </div>
          </div>
          <div class="col-md-3">
            <div class="qy-pic">
              <img src="/gbh/Public/home/img/ip4.jpg" alt="">
            </div>
          </div>
          <div class="col-md-3">
            <div class="qy-pic">
              <img src="/gbh/Public/home/img/ip5.jpg" alt="">
            </div>
          </div>
          <div class="col-md-3">
            <div class="qy-pic">
              <img src="/gbh/Public/home/img/ip2.jpg" alt="">
            </div>
          </div>
          <div class="col-md-3">
            <div class="qy-pic">
              <img src="/gbh/Public/home/img/ip3.jpg" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="qy-pic">
              <img src="/gbh/Public/home/img/ip6.jpg" alt="">
            </div>
          </div>
        </div>

      </div>
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



  <script src="/gbh/Public/home/js/swiper-3.4.2.min.js"></script>
  <script src="/gbh/Public/home/js/bootstrap-datepicker.js"></script>
  <script src="/gbh/Public/home/js/bootstrap-datepicker.zh-CN.js"></script>
  <script>
    //swiper
    var mySwiper = new Swiper('.swiper-container', {
      loop: true,
      autoplay: 6000,
      pagination: '.swiper-pagination',
      paginationClickable :true
    })
  </script>
  <script>
    //swiper
    var mySwiper = new Swiper('.room-container', {
      loop: true,
      autoplay: 6000,
      pagination: '.swiper-pagination',
      paginationClickable :true,
      nextButton: '.swiper-next',
      prevButton: '.swiper-prev'
    })
    jQuery('.form-control-date').datepicker({
      language: 'zh-CN',
      autoclose: true,
      todayHighlight: true,
      format: 'yyyy-mm-dd'
    });
  </script>

</body>
</html>