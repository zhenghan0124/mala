<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/Public/home/css/swiper-3.4.2.min.css">
  <link rel="stylesheet" href="/Public/home/css/bootstrap.css">
  <link rel="stylesheet" href="/Public/home/css/pages.css">
  <link rel="stylesheet" href="/Public/home/css/style.css">
  <title>酒店概况-客房图集</title>
</head>
<body>
<div class="album-all">
  <div class="album-header">
    <div class="albun-head-left fl clearfix">
      <div class="fl">
        <a href=""><img src="/Public/home/img/a-head.png" alt=""></a>
      </div>
      <h2>酒店相册</h2>
    </div>
    <div class="albun-head-right fr clearfix">
      <a href="">返回</a>
    </div>

  </div>
  <div class="container">
    <div class="slide-box">
      <div class="a-slide">
        <div class="a-bd">
          <ul>
            <li>
              <div class="/Public/home/imgs">
                <a href=""><img src="/Public/home/img/ss1.jpg" alt=""></a>
                <div class="asilde-bd-text">
                  <p>会议层套房</p>
                </div>
              </div>
            </li>
            <li>
              <div class="/Public/home/imgs">
                <a href=""><img src="/Public/home/img/ss2.jpg" alt=""></a>
                <div class="asilde-bd-text">
                  <p>会议层套房</p>
                </div>
              </div>
            </li>
            <li>
              <div class="/Public/home/imgs">
                <a href=""><img src="/Public/home/img/ss3.jpg" alt=""></a>
                <div class="asilde-bd-text">
                  <p>会议层套房</p>
                </div>
              </div>
            </li>
            <li>
              <div class="/Public/home/imgs">
                <a href=""><img src="/Public/home/img/ss2.jpg" alt=""></a>
                <div class="asilde-bd-text">
                  <p>会议层套房</p>
                </div>
              </div>
            </li>
            <li>
              <div class="/Public/home/imgs">
                <a href=""><img src="/Public/home/img/ss1.jpg" alt=""></a>
                <div class="asilde-bd-text">
                  <p>会议层套房</p>
                </div>
              </div>
            </li>
            <li>
              <div class="/Public/home/imgs">
                <a href=""><img src="/Public/home/img/ss1.jpg" alt=""></a>
                <div class="asilde-bd-text">
                  <p>会议层套房</p>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="hd-box">
          <div class="hd">
            <ul>
              <li><div class="slide-border"><img src="/Public/home/img/sa1.jpg" alt=""></div></li>
              <li><div class="slide-border"><img src="/Public/home/img/sa2.jpg" alt=""></div></li>
              <li><div class="slide-border"><img src="/Public/home/img/sa3.jpg" alt=""></div></li>
              <li><div class="slide-border"><img src="/Public/home/img/sa4.jpg" alt=""></div></li>
              <li><div class="slide-border"><img src="/Public/home/img/sa1.jpg" alt=""></div></li>
              <li><div class="slide-border"><img src="/Public/home/img/sa2.jpg" alt=""></div></li>

            </ul>
          </div>
        </div>
      </div>

      <div class="album-slide-text">
        <p>总共<span>21</span>张图片</p>
      </div>
    </div>
  </div>
  <script type="text/javascript" src="/Public/home/js/jquery.min.js"></script>
  <script type="text/javascript" src="/Public/home/js/jquery.SuperSlide.2.1.1.js"></script>
  <div class="album-footer">
    <p class="f-copy">Copyright 2016 杭州国际博览中心. All Rights Reserved 浙ICP备16030893号<i></i></p>
  </div>
</div>
<script type="text/javascript">
  jQuery(".a-slide").slide({mainCell:".a-bd ul"});
</script>
</body>
</html>