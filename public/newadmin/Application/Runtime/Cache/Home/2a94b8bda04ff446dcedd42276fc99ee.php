<?php if (!defined('THINK_PATH')) exit();?>﻿
<!DOCTYPE html>
<html>

<head>
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
  <style>



               .gsjj p{
                line-height: 28px;
                text-indent: 43px;
                font-size: 20px;
                font-size: 17px;
                font-family: 宋体;
                /*color:#000;*/
               }
                .tempWrap {
                   /* background-color: rgba(255, 255, 255, 0.7411764705882353);*/
                    /*padding: 30px;*/
                    margin-top: 30px;
                }

                .swiper-container2 {
                    position: relative;
                    overflow: hidden;
                }

                .swiper-container2 .swiper-slide {
                    text-align: center;
                    font-size: 18px;
                    background: #fff;
                    /* Center slide text vertically */
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: -webkit-flex;
                    display: flex;
                    -webkit-box-pack: center;
                    -ms-flex-pack: center;
                    -webkit-justify-content: center;
                    justify-content: center;
                    -webkit-box-align: center;
                    -ms-flex-align: center;
                    -webkit-align-items: center;
                    align-items: center;
                }

              /*  .topImg {
                    padding: 0 16px;
                }*/

                .topImg .col-sm-4 {
                    padding: 0 5px 0 0;
                }

                .topImg img {
                    max-width: 100%;
                }

                .swiper-container2 .swiper-slide img {
                    max-width: 100%;
                    width: 100%;
                    height:473px;
                }

                .topImg {
                    margin-top: 21px;
                }

                .service-file ul li a {
                    display: block;
                    float: none;
                    overflow: hidden;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                }
              
        @media (min-width: 992px){

                .container {
                    width:90%;
                }
                .left-banner{
                    display: none;
                }
            }
         @media (min-width: 1200px){
               .container {
                    width:58% !important;
                    float: left;
                }
                .left-banner{
                    width:19%;
                    display: block !important;
                }
            }
            

              @media (min-width: 1400px){
               .container {
                    width:62% !important;
                    float: left;
                }
                .left-banner{
                    width:17%;
                     display: block !important;
                }
            }
           

             @media (min-width: 1550px){
               .container {
                    width:68% !important;
                    float: left;
                }
                .left-banner{
                    width:14%;
                     display: block !important;
                }
            }

              @media (min-width: 768px){

                .logo1{
                    height: 82px;
                }

                .new-title h3{
                    font-size: 14px;
                    color: #fff;
                    line-height: 16px
                }

                .ckgd{
                    position: absolute;
                    width: 90%;
                    left:5%;
                    height: 1.0rem;
                    line-height: 1.0rem;
                    bottom:0.5rem;
                    font-size: 13px;
                    color:#fff;

                }
                 .container {
                    width:90%;
                }
                .left-banner{
                    display: none;
                }

                .container{
                   
                    
                }
                 .gsjj{
                    padding-right:3%;
                   height:350px;
                   text-align: justify; 
                   overflow-y: scroll;
                }

                .gsjj::-webkit-scrollbar {/*滚动条整体样式*/
                    width: 4px;     /*高宽分别对应横竖滚动条的尺寸*/
                    height: 4px;
                }
                .gsjj::-webkit-scrollbar-thumb {/*滚动条里面小方块*/
                    border-radius: 5px;
                  
                    background:#fff ;
                }
                .gsjj::-webkit-scrollbar-track {/*滚动条里面轨道*/
                   
                    border-radius: 0;
                    background: #fff;
                }

                .xwbt{
                    text-align: justify;
                    
                    color:#fff;
                    font-size: 16px;
                    width: 100%;
                    position: absolute;
                    bottom:-176px;
                   background-color: #0d72bb;
                    opacity: 0.9;
                }
                .company-info{
                    width: 100%;
                    height: 3.0rem;
                    border-bottom: 2px solid #ccc;
                    line-height: 2.0rem;
                    margin-bottom: 0.5rem;
                }
                .gsjjwz{
                    width: 45%;
                    height: 2.0rem;
                    float: left;
                    line-height: 2.0rem;
                    font-size: 16px;
                    font-weight: 600;
                    color:#000;

                }
                .gsjjti{
                    width: 50%;
                    height: 2.0rem;
                    float: right;
                    line-height: 2.0rem;
                    text-align: right;
                }
                .icon-squee{
                    width: 0.8rem;
                    height: 0.8rem;
                    float: left;
                    margin-top: 0.6rem;
                    background: #000;
                    margin-right:1%;
                }
               .img{
                width: 100%;
                height: 100%;
                position: relative;
                overflow:hidden;
               }
               .new-title{
                width: 90%;
                height: 100px;
                margin-left:5%;
                margin-top: 20px;
                text-align: left;
               }
               .spdiv{
                width: 100%;height: 350px;
               }

               .left-banner{
           /*  width: 13%;*/
           
            /* position: fixed; */
            left: 0;
            margin-top: 77px;
            z-index: 999;
            float: left;
            margin-left: 1%;
            margin-right:1%;
               }
            }

              @media (max-width: 767px){
                body{
                    overflow-x:hidden;
                }
                .container{
                    width: 94%;
                    overflow-x:hidden;
                }
                 .gsjj{
                  
                   text-align: justify; 
                   margin-top: 1.0rem;
                  
                }

              

                .xwbt{
                    text-align: center;
                    
                    color:#fff;
                    font-size: 14px;
                    width: 100%;
                    background: #2680c2;
                }
                .company-info{
                    width: 100%;
                    height: 2.0rem;
                    border-bottom: 2px solid #ccc;
                    line-height: 2.0rem;
                    margin-bottom: 0.5rem;
                }
                .gsjjwz{
                    width: 45%;
                    height: 2.0rem;
                    float: left;
                    line-height: 2.0rem;

                }
                .gsjjti{
                    width: 50%;
                    height: 2.0rem;
                    float: right;
                    line-height: 2.0rem;
                    text-align: right;
                }
                .icon-squee{
                    width: 0.8rem;
                    height: 0.8rem;
                    float: left;
                    margin-top: 0.6rem;
                    background: #000;
                    margin-right:1%;
                }
               .img{
                width: 100%;
                height: 100%;
                position: relative;
                overflow:hidden;
                margin-top: 0.5rem;
               }
               .new-title{
            width: 90%;
            /* height: 2.0rem; */
            margin-left: 5%;
            margin-top: 5px;
            text-align: left;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
               }
               .spdiv{
                width: 100%;
                height: 250px;
               }

               .left-banner{
            width: 100%;
            /* position: fixed; */
            left: 0;
            margin-top: 60px;
            z-index: 999;
            /* float: left; */
           
           display: none;
            height: 200px;
               }

               .myCarousel{
                margin-bottom: 2.0rem;
               }

            .left-banner{
                margin-top:0 !important;
            }

            }
            </style>
<body>

    <div class="header-all clearfix">
        <div class="header-left fl">
            <a href="/">
                <img src="http://www.hiechangzhou.com/Public/home/img/h-logo.png" alt="">
                <img src="/shop/Public/home/images/logo1.jpg" alt="" class="logo1">

            </a>
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
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="nav-button"><i class="iconfont">&#xe6b9;</i></div>
            <div class="nav-mobile">
                <div class="nav-mobile-close">
                    <i class="iconfont">&#xe618;</i>
                </div>
                <ul>
                    <li><a href="/About/index">关于我们</a></li>
                    <li><a href="/News/index">杭博新闻</a></li>
                    <li><a href="/Service/index">服务指南</a></li>
                    <li><a href="/Hr/index">人才招聘</a></li>
                    <li><a href="http://www.hiechangzhou.com/?lang=en-us">EN</a></li>
                </ul>
            </div>

        </div>
    </div>




    <div class="index-content" style="background:#c9e9f8 ">

    <!--左边banner-->
    <div class="left-banner"><img src="/shop/Public/home/images/l-ba.jpg" alt="" style="float: left;"></div>


        <div class="container" style="">
             
          
            <div class="tempWrap">
            <div class="company-info">
                
                <div class="gsjjwz"><h3 style="font-size: 20px;color: #1a1a1a;">公司简介</h3></div>
                <div class="gsjjti"></div>
            </div>
                <div class="middle">
                    <div class="row">
                        <div class="col-sm-7">
                        <script type="text/javascript" src="/shop/Public/ckplayer/ckplayer.min.js"></script>
                        <div class="spdiv" style="">
                        	<video style="width:100%;height:100%;object-fit:fill;" id="video1" class="video-bf" src="http://static.yhbox.cn/videos/25/2018/11/aXgQuuV11pT1FO7818tfQ8N8GrfX8P.mp4" autoplay ></video>                          
                        </div>
                        <script type="text/javascript">
						    var videoObject = {
							container: '.spdiv',//“#”代表容器的ID，“.”或“”代表容器的class
							variable: 'player',//该属性必需设置，值等于下面的new chplayer()的对象
							poster:'',
							mobileCkControls:false,//是否在移动端（包括ios）环境中显示控制栏
							mobileAutoFull:false,//在移动端播放后是否按系统设置的全屏播放
							h5container:'#video1',//h5环境中使用自定义容器
							video:'http://static.yhbox.cn/videos/25/2018/11/aXgQuuV11pT1FO7818tfQ8N8GrfX8P.mp4'//视频地址
						    };
						    var player=new ckplayer(videoObject);
						</script>
                    </div>
                        <div class="col-sm-5">
                            <div class="gsjj">
                                <p>  杭州国际博览中心“高级礼仪接待组”主要工作是为杭博宾客提供“一站式”的礼仪、引领、会议、餐饮等接待服务工作。“一站式”服务不仅提高了服务效率，更让服务具备全面性和连贯性，带给宾客优质的服务体验。

                                班组现有岗员12名，均毕业于空乘服务或酒店管理等相关专业，平均身高170CM，且全部为女性，“90后”15名，占总人数的100%，平均年龄为22岁，是一个典型的以女性为工作主体的充满朝气的团队。在“巾帼文明岗”创建活动中，岗员们团结一心，逐步形成了极具特色的“杭博小蓝”的品牌文化，得到了社会各界的广泛赞誉，并被被授予浙江省“巾帼文明岗”称号。
                                </p>
                                <p>  杭博小蓝：

                                蓝色，代表优雅、雍容、睿智，象征小蓝的服务纯粹优雅、收放自如、恰到好处；

                                引入唐代诗人白居易《忆江南》中“春来江水绿如蓝，能不忆江南？”的西湖蓝，象征小蓝极具江南特色的细致服务；

                                蓝与兰花的“兰”同音，展现出团队“气若幽兰、贵若牡丹”的高贵品质，代表了杭博的服务标准、代表了浙江的服务精神。
                                </p>

                                <p>  杭州国际博览中心“高级礼仪接待组”主要工作是为杭博宾客提供“一站式”的礼仪、引领、会议、餐饮等接待服务工作。“一站式”服务不仅提高了服务效率，更让服务具备全面性和连贯性，带给宾客优质的服务体验。

                               
                                </p>                              
                            </div>
                        </div>
                    </div>
                </div>



                <!--底部图片-->
                 <div class="company-info" style="margin-top: 2.0rem;">
                    
                    <div class="gsjjwz"><h3 style="font-size: 20px;color: #1a1a1a;">新闻报道</h3></div>
                    <div class="gsjjti"></div>
                </div>
                
                <div class="topImg">
                
                    <div class="row">

                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo ($vo["url"]); ?>">
                            <div class="col-sm-3">
                                <div class="img">
                                    <img src="/Uploads/<?php echo ($vo["pic"]); ?>">
                                     <div class="xwbt"><div class="new-title"><h3><?php echo ($vo["title"]); ?></h3></div></div>
                                     <a href="<?php echo ($vo["url"]); ?>"><p class="ckgd"> 查看详情 <span><i class="iconfont"></i></span></p></a>
                                </div>
                               
                            </div> 
                             </a><?php endforeach; endif; else: echo "" ;endif; ?>
                      
                    </div>
                </div>

                <div class="row myCarousel" style="text-align: center;margin-top: 1.0rem"><?php echo ($pagenavi); ?></div>



            </div>


        </div>

         <!--右边banner-->
    <div class="left-banner"><img src="/shop/Public/home/images/r-ba.jpg" alt="" style="float: right;"></div>
    </div>


    <div class="footer-all clearfix">
        <div class="footer-left fl">
            <div class="foot-nav">
                <ul class="clearfix">
                    <li><a href="http://www.hiechangzhou.com">杭州国际博览中心</a></li>
                <li><a href="/">杭博巾帼文明岗</a></li>
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
        $(".nav-button").click(function () {
            $(".nav-mobile").show();
        });
        $(".nav-mobile-close").click(function () {
            $(".nav-mobile").hide();
        });
    </script>
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://"); document.write(unescape("%3Cspan id='cnzz_stat_icon_1274537638'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s22.cnzz.com/z_stat.php%3Fid%3D1274537638%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));
    </script>  

    <script>
      $(".img").mouseover(function (){  
            $(this).find('.xwbt').animate({top:"30%"});
            // $(this).find('.ckgd').css("color","#fff")
        }).mouseleave(function (){  
             $(this).find('.xwbt').animate({top:"100%"}); 
             // $(this).find('.ckgd').css("color","#000")
        }); 
    </script>
</body>
</html>