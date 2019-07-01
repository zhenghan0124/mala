<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8" />
  <title>管理中心</title>
  <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="/upload/shop/Public/admin/assets/images/logo.png">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="/upload/shop/Public/admin/assets/images/logo.png">

  <!-- style -->
  <link rel="stylesheet" href="/upload/shop/Public/admin/assets/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="/upload/shop/Public/admin/assets/glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="/upload/shop/Public/admin/assets/font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="/upload/shop/Public/admin/assets/material-design-icons/material-design-icons.css" type="text/css" />

  <link rel="stylesheet" href="/upload/shop/Public/admin/assets/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <!-- build:css /upload/shop/Public/admin/assets/styles/app.min.css -->
  <link rel="stylesheet" href="/upload/shop/Public/admin/assets/styles/app.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="/upload/shop/Public/admin/assets/styles/font.css" type="text/css" />
  
  <!-- datepicker -->
  <link rel="stylesheet" type="text/css" href="/upload/shop/Public/admin/libs/jquery/bootstrap-datepicker/css/datepicker.css">

  <link rel="stylesheet" href="/upload/shop/Public/admin/assets/styles/style.css" type="text/css" />
</head>
<body>
  <div class="app" id="app">

<!-- ############ LAYOUT START-->

  <!-- aside -->
  <div id="aside" class="app-aside modal nav-dropdown">
  	<!-- fluid app aside -->
    <div class="left navside dark dk" data-layout="column">
  	  <div class="navbar no-radius">
        <!-- brand -->
        <a class="navbar-brand">
        	<div ui-include="'/upload/shop/Public/admin/assets/images/logo.svg'"></div>
        	<img src="/upload/shop/Public/admin/assets/images/logo.png" alt="." class="hide">
        	<span class="hidden-folded inline">管理中心</span>
        </a>
        <!-- / brand -->
      </div>
      <div class="hide-scroll" data-flex>
        
<nav class="scroll nav-light">

    <ul class="nav" ui-nav>
      <li class="nav-header hidden-folded">
        <small class="text-muted">首页</small>
      </li>

      <li <?php if((CONTROLLER_NAME) == "Index"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/upload/shop/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">首页</span>
      </a>
      <ul class="nav-sub">
        <!-- <li>
          <a href="<?php echo U('Index/index');?>">
            <span class="nav-text">顶部图片</span>
          </a>
        </li> -->
        <li>
          <a href="<?php echo U('Index/news');?>">
            <span class="nav-text">新闻</span>
          </a>
        </li>
        <li>
        <li>
          <a href="<?php echo U('Index/banner');?>">
            <span class="nav-text">岗位简介顶部图片</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('Index/about');?>">
            <span class="nav-text">岗位简介</span>
          </a>
        </li>
        
      </ul>
      </li>

      <li <?php if((CONTROLLER_NAME) == "News"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/upload/shop/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">新闻动态</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('News/banner');?>">
            <span class="nav-text">新闻动态顶部图片</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('News/index');?>">
            <span class="nav-text">新闻动态</span>
          </a>
        </li>
      </ul>
      </li>

      <li <?php if((CONTROLLER_NAME) == "Gwjg"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/upload/shop/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">岗位建功</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Gwjg/banner');?>">
            <span class="nav-text">岗位建功顶部图片</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('Gwjg/index');?>">
            <span class="nav-text">岗位建功</span>
          </a>
        </li>
      </ul>
      </li>

      <!-- <li <?php if((CONTROLLER_NAME) == "Gwfc"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/upload/shop/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">岗位风采</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Gwfc/index');?>">
            <span class="nav-text">岗位风采</span>
          </a>
        </li>
      </ul>
      </li> -->

      <li <?php if((CONTROLLER_NAME) == "Gwfx"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/upload/shop/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">服务社会</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Gwfx/banner');?>">
            <span class="nav-text">服务社会顶部图片</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('Gwfx/index');?>">
            <span class="nav-text">服务社会</span>
          </a>
        </li>
      </ul>
      </li>

      <li <?php if((CONTROLLER_NAME) == "Gwcx"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/upload/shop/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">岗位成效</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Gwcx/banner');?>">
            <span class="nav-text">岗位成效顶部图片</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('Gwcx/index');?>">
            <span class="nav-text">岗位成效</span>
          </a>
        </li>
      </ul>
      </li>

      <li <?php if((CONTROLLER_NAME) == "Zchd"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/upload/shop/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">争创活动</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Zchd/banner');?>">
            <span class="nav-text">争创活动顶部图片</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('Zchd/index');?>">
            <span class="nav-text">争创活动</span>
          </a>
        </li>
      </ul>
      </li>

      <li <?php if((CONTROLLER_NAME) == "Gwlb"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/upload/shop/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">岗位练兵</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Gwlb/banner');?>">
            <span class="nav-text">岗位练兵顶部图片</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('Gwlb/index');?>">
            <span class="nav-text">岗位练兵</span>
          </a>
        </li>
      </ul>
      </li>

</nav>
</eq>
      </div>
      <div class="b-t">
        <div class="nav-fold">
          <span class="pull-left">
            <img src="/upload/shop/Public/admin/assets/images/a0.jpg" alt="..." class="w-40 img-circle">
          </span>
          <?php if(($aid) == "1"): ?><span class="clear hidden-folded p-x">
            <span class="block _500">admin</span> <a href="<?php echo U('Account/password');?>"><small class="block text-muted">修改密码</small></a>
            <a href="<?php echo U('Login/loginout');?>"><small class="block text-muted">退出</small></a>
          </span>
          <?php else: ?>
          <span class="clear hidden-folded p-x">
            <span class="block _500">guobo</span><!--  <a href="<?php echo U('Account/password');?>"><small class="block text-muted">修改密码</small></a> -->
            <a href="<?php echo U('Login/loginout');?>"><small class="block text-muted">退出</small></a>
          </span><?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- / -->

  <!-- content -->
  <div id="content" class="app-content box-shadow-z0" role="main">
    <div class="app-header white box-shadow">
        <div class="navbar navbar-toggleable-sm flex-row align-items-center">
            <!-- Open side - Naviation on mobile -->
            <a data-toggle="modal" data-target="#aside" class="hidden-lg-up mr-3">
              <i class="material-icons">&#xe5d2;</i>
            </a>
            <!-- / -->

            <!-- Page title - Bind to $state's title -->
            <div class="mb-0 h5 no-wrap" ng-bind="$state.current.data.title" id="pageTitle"></div>


            <!-- navbar right -->
            <ul class="nav navbar-nav ml-auto flex-row">
              <li class="nav-item dropdown">
                <a class="nav-link p-0 clear" href="#" data-toggle="dropdown">
                  <span class="avatar w-32">
                    <img src="/upload/shop/Public/admin/assets/images/a0.jpg" alt="...">
                    <i class="on b-white bottom"></i>
                  </span>
                </a>
                <!-- <div ui-include="'../views/blocks/dropdown.user.html'"></div> -->
              </li>
              <li class="nav-item hidden-md-up">
                <a class="nav-link pl-2" data-toggle="collapse" data-target="#collapse">
                  <i class="material-icons">&#xe5d4;</i>
                </a>
              </li>
            </ul>
            <!-- / navbar right -->
        </div>
    </div>
    <div class="app-footer">
  <div class="p-2 text-xs">
    <div class="pull-right text-muted py-1">
      Copyright &copy; <?php echo date('Y') ?> All Rights Reserved.
    </div>
  </div>
</div>

    <div ui-view class="app-body" id="view">

<!-- ############ PAGE START-->
<div class="padding">
  <h5 class="_300 margin">
  <?php echo ($page["title"]); ?>
</h5>

  
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-divider m-0"></div>
        <div class="box-body">
          <form role="form" class="validate" action="/upload/shop/index.php/Admin/Index/add_news" method="post">
            <div class="form-group">
              <label>标题</label>
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="title" class="form-control">
                </div>
              </div>
            </div>
            <!-- <div class="form-group">
              <label>标题（EN）</label>
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="title_en" class="form-control">
                </div>
              </div>
            </div> -->
            <!-- <div class="form-group">
              <label>分类</label>
              <div class="row">
                <div class="col-md-6">
                  <select name="category" class="form-control">
                    <option value="1">热点新闻</option>
                    <option value="2">媒体报道</option>
                    <option value="3">公告信息</option>
                  </select>
                </div>
              </div>
            </div> -->
            <div class="form-group">
              <label>图片</label>
              <div class="row">
                <div class="col-md-12">
                  <div class="qy-upload upload-pic">
                    <ul>
                      <li class="upload-pic-wrap">
                        <i class="fa fa-plus"></i>
                        <input type="file" class="upload-pic-button" name="qy_upload">
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>链接</label>
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="url" class="form-control">
                </div>
              </div>
            </div>
            <!-- <div class="form-group">
              <label>内容</label>
              <div class="row">
                <div class="col-md-12">
                  <script id="editor" name="content" type="text/plain" style="width:100%;height:500px;"></script>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>内容（EN）</label>
              <div class="row">
                <div class="col-md-12">
                  <script id="editor_en" name="content_en" type="text/plain" style="width:100%;height:500px;"></script>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>摘要</label>
              <div class="row">
                <div class="col-md-6">
                  <textarea name="description" cols="30" rows="10" class="form-control" placeholder="选填，默认截取内容的前50个字"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>摘要（EN）</label>
              <div class="row">
                <div class="col-md-6">
                  <textarea name="description_en" cols="30" rows="10" class="form-control" placeholder="选填，默认截取内容的前50个字"></textarea>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>日期</label>
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="time" class="form-control form-control-datepicker" value="<?php echo date('Y-m-d') ?>" readonly>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>排序</label>
              <div class="row">
                <div class="col-md-6">
                  <input type="text" name="rank" class="form-control" value="99">
                </div>
              </div>
            </div> -->
            <button type="submit" class="btn primary m-b">提交</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- ############ PAGE END-->

    </div>
  </div>
  <!-- / -->

  <!-- theme switcher -->
  <div id="switcher">
    <div class="switcher box-color dark-white text-color" id="sw-theme">
      <a href ui-toggle-class="active" target="#sw-theme" class="box-color dark-white text-color sw-btn">
        <i class="fa fa-gear"></i>
      </a>
      <div class="box-header">
        <h2>主题切换</h2>
      </div>
      <div class="box-divider"></div>
      <div class="box-body">
        <p class="hidden-md-down">
          <label class="md-check m-y-xs"  data-target="folded">
            <input type="checkbox">
            <i class="green"></i>
            <span class="hidden-folded">侧边栏</span>
          </label>
          <br/>
          <label class="md-check m-y-xs" data-target="boxed">
            <input type="checkbox">
            <i class="green"></i>
            <span class="hidden-folded">居中排版</span>
          </label>
          <br/>
          <label class="m-y-xs pointer" ui-fullscreen>
            <span class="fa fa-expand fa-fw m-r-xs"></span>
            <span>全屏模式</span>
          </label>
        </p>
        <p>颜色:</p>
        <p data-target="themeID">
          <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'primary', accent:'accent', warn:'warn'}">
            <input type="radio" name="color" value="1">
            <i class="primary"></i>
          </label>
          <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'accent', accent:'cyan', warn:'warn'}">
            <input type="radio" name="color" value="2">
            <i class="accent"></i>
          </label>
          <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'warn', accent:'light-blue', warn:'warning'}">
            <input type="radio" name="color" value="3">
            <i class="warn"></i>
          </label>
          <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'success', accent:'teal', warn:'lime'}">
            <input type="radio" name="color" value="4">
            <i class="success"></i>
          </label>
          <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'info', accent:'light-blue', warn:'success'}">
            <input type="radio" name="color" value="5">
            <i class="info"></i>
          </label>
          <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'blue', accent:'indigo', warn:'primary'}">
            <input type="radio" name="color" value="6">
            <i class="blue"></i>
          </label>
          <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'warning', accent:'grey-100', warn:'success'}">
            <input type="radio" name="color" value="7">
            <i class="warning"></i>
          </label>
          <label class="radio radio-inline m-0 ui-check ui-check-color ui-check-md" data-value="{primary:'danger', accent:'grey-100', warn:'grey-300'}">
            <input type="radio" name="color" value="8">
            <i class="danger"></i>
          </label>
        </p>
        <p>主题:</p>
        <div data-target="bg" class="row no-gutter text-u-c text-center _600 clearfix">
          <label class="p-a col-sm-6 light pointer m-0">
            <input type="radio" name="theme" value="" hidden>
            白色
          </label>
          <label class="p-a col-sm-6 grey pointer m-0">
            <input type="radio" name="theme" value="grey" hidden>
            灰色
          </label>
          <label class="p-a col-sm-6 dark pointer m-0">
            <input type="radio" name="theme" value="dark" hidden>
            暗色
          </label>
          <label class="p-a col-sm-6 black pointer m-0">
            <input type="radio" name="theme" value="black" hidden>
            黑色
          </label>
        </div>
      </div>
    </div>
  </div>
  <!-- / -->

<!-- ############ LAYOUT END-->

  </div>
<!-- build:js /upload/shop/Public/admin/scripts/app.html.js -->
<!-- jQuery -->
  <script src="/upload/shop/Public/admin/libs/jquery/jquery/dist/jquery.js"></script>

<!-- Bootstrap -->
  <script src="/upload/shop/Public/admin/libs/jquery/tether/dist/js/tether.min.js"></script>
  <script src="/upload/shop/Public/admin/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
  <script src="/upload/shop/Public/admin/libs/jquery/underscore/underscore-min.js"></script>
  <script src="/upload/shop/Public/admin/libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="/upload/shop/Public/admin/libs/jquery/PACE/pace.min.js"></script>

  <script src="/upload/shop/Public/admin/scripts/config.lazyload.js"></script>

  <script src="/upload/shop/Public/admin/scripts/palette.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-load.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-jp.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-include.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-device.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-form.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-nav.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-screenfull.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-scroll-to.js"></script>
  <script src="/upload/shop/Public/admin/scripts/ui-toggle-class.js"></script>

  <script src="/upload/shop/Public/admin/scripts/app.js"></script>

  
  <!-- qy-upload -->
  <script src="/upload/shop/Public/admin/libs/jquery/jquery-form/jquery.form.min.js"></script>
  <script src="/upload/shop/Public/admin/scripts/qy-upload.js"></script>
  <script type="text/javascript">
    $('.qy-upload').qy_upload("/upload/shop/index.php/Admin/upload/?width=450&height=300","pic",0);
  </script>

  <script type="text/javascript" src="/upload/shop/Public/admin/libs/jquery/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/upload/shop/Public/admin/libs/jquery/bootstrap-datepicker/js/locales/bootstrap-datepicker.zh-CN.js"></script>
  <script>
    $('.form-control-datepicker').datepicker({
      language: "zh-CN",
      format: "yyyy-mm-dd",
      autoclose: true
    });
  </script>

  <script type="text/javascript" charset="utf-8" src="/upload/shop/Public/admin/libs/js/ueditor/ueditor.config.js"></script>
  <script type="text/javascript" charset="utf-8" src="/upload/shop/Public/admin/libs/js/ueditor/ueditor.all.min.js"> </script>
  <script type="text/javascript" charset="utf-8" src="/upload/shop/Public/admin/libs/js/ueditor/lang/zh-cn/zh-cn.js"></script>
  <script>
    var ue = UE.getEditor('editor');
    var ue_en = UE.getEditor('editor_en');
  </script>


  <!-- ajax -->
  <!--<script src="/upload/shop/Public/admin/libs/jquery/jquery-pjax/jquery.pjax.js"></script>-->
  <!--<script src="/upload/shop/Public/admin/scripts/ajax.js"></script>-->
<!-- endbuild -->
</body>
</html>