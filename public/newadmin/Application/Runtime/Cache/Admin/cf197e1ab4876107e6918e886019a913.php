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
  <link rel="apple-touch-icon" href="/newadmin/Public/admin/assets/images/logo.png">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="/newadmin/Public/admin/assets/images/logo.png">

  <!-- style -->
  <link rel="stylesheet" href="/newadmin/Public/admin/assets/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="/newadmin/Public/admin/assets/glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="/newadmin/Public/admin/assets/font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="/newadmin/Public/admin/assets/material-design-icons/material-design-icons.css" type="text/css" />

  <link rel="stylesheet" href="/newadmin/Public/admin/assets/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <!-- build:css /newadmin/Public/admin/assets/styles/app.min.css -->
  <link rel="stylesheet" href="/newadmin/Public/admin/assets/styles/app.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="/newadmin/Public/admin/assets/styles/font.css" type="text/css" />
  
  <link rel="stylesheet" href="/newadmin/Public/admin/assets/styles/style.css" type="text/css" />
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
        	<div ui-include="'/newadmin/Public/admin/assets/images/logo.svg'"></div>
        	<img src="/newadmin/Public/admin/assets/images/logo.png" alt="." class="hide">
        	<span class="hidden-folded inline">管理中心</span>
        </a>
        <!-- / brand -->
      </div>
      <div class="hide-scroll" data-flex>
        
<nav class="scroll nav-light">
    <ul class="nav" ui-nav>
      <li class="nav-header hidden-folded">
        <small class="text-muted">管理</small>
      </li>

      <li <?php if((CONTROLLER_NAME) == "Index"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/newadmin/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">文章管理</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Index/index');?>">
            <span class="nav-text">后台用户管理</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('Index/admincontent');?>">
            <span class="nav-text">后台文章管理</span>
          </a>
        </li>
        <li>
          <a href="<?php echo U('Index/usercontent');?>">
            <span class="nav-text">用户文章管理</span>
          </a>
        </li>
      </ul>

      <li <?php if((CONTROLLER_NAME) == "Hot"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/newadmin/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">热度管理</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Hot/index');?>">
            <span class="nav-text">热度文章列表</span>
          </a>
        </li>
      </ul>

      <li <?php if((CONTROLLER_NAME) == "Type"): ?>class="active"<?php endif; ?>>
      <a>
          <span class="nav-caret">
            <i class="fa fa-caret-down"></i>
          </span>
        <span class="nav-icon">
            <i class="material-icons">&#xe3fc;
              <span ui-include="'/newadmin/Public/admin/assets/images/i_0.svg'"></span>
            </i>
          </span>
        <span class="nav-text">分类管理</span>
      </a>
      <ul class="nav-sub">
        <li>
          <a href="<?php echo U('Type/index');?>">
            <span class="nav-text">分类列表</span>
          </a>
        </li>
      </ul>
    </ul>

</nav>
      </div>
      <div class="b-t">
        <div class="nav-fold">
          <span class="pull-left">
            <img src="/newadmin/Public/admin/assets/images/a0.jpg" alt="..." class="w-40 img-circle">
          </span>
          <?php if(($aid) == "1"): ?><span class="clear hidden-folded p-x">
            <span class="block _500">admin</span> <a href="<?php echo U('Account/password');?>"><small class="block text-muted">修改密码</small></a>
            <a href="<?php echo U('Login/loginout');?>"><small class="block text-muted">退出</small></a>
          </span>
          <?php else: ?>
          <span class="clear hidden-folded p-x">
            <span class="block _500">admin</span><!--  <a href="<?php echo U('Account/password');?>"><small class="block text-muted">修改密码</small></a> -->
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
                    <img src="/newadmin/Public/admin/assets/images/a0.jpg" alt="...">
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

  
  <a href="<?php echo U('Index/admincontent');?>" class="btn btn-fw primary m-b" style="margin-left:10px;">全部</a>
  <?php if(is_array($types)): $i = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Index/admincontent',array('typeid' => $type['id']));?>" class="btn btn-fw primary m-b" style="margin-left:10px;"><?php echo ($type["title"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
  <div class="row">
    <div class="col-sm-12">
      <div class="box">
        <table class="table table-striped b-t">
          <thead>
          <tr>
            <th>#</th>
            <th>标题</th>
            <th>文章图片</th>
            <th>用户昵称</th>
            <th>用户头像</th>
            <th>分类</th>
            <th>审核</th>
            <th>推荐</th>
            <th>点赞数|<a href="<?php echo U('Index/admincontent',array('sort' => 2));?>" style="color:grey">倒序</a>|<a href="<?php echo U('Index/admincontent',array('sort' => 1));?>" style="color:grey">顺序</a></th>
            <!--&lt;!&ndash;             <th>日期</th>-->
            <th>发布时间</th>
            <th>热度推荐</th>
            <th>操作</th>
          </tr>
          </thead>
          <tbody>
          <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
              <td><?php echo ($data["id"]); ?></td>
              <td><textarea><?php echo ($data["title"]); ?></textarea></td>
              <td><img src="<?php echo ($data["imgurl"]["0"]); ?>" width="80"></td>
              <td><?php echo ($data["name"]); ?></td>
              <td><img src="<?php echo ($data["pic"]); ?>" width="80"></td>
              <td><?php echo ($data["type"]); ?></td>
              <?php if(($data["audit"]) == "1"): ?><td><a href="<?php echo U('Index/adminaudit',array('id' => $data['id'],'audit' => 2,'typeid'=> $data['typeid']));?>" style="color:green">已审核</a></td><?php else: ?><td><a href="<?php echo U('Index/adminaudit',array('id' => $data['id'],'audit' => 1,'typeid'=> $data['typeid']));?>" style="color:red">待审核</a></td><?php endif; ?>
              <?php if(($data["recommended"]) == "1"): ?><td><a href="<?php echo U('Index/adminrecommended',array('id' => $data['id'],'recommended' => 2,'typeid'=> $data['typeid']));?>" style="color:red">未推荐</a></td><?php else: ?><td><a href="<?php echo U('Index/adminrecommended',array('id' => $data['id'],'recommended' => 1,'typeid'=> $data['typeid']));?>" style="color:green">已推荐</a></td><?php endif; ?>
              <td><?php echo ($data["support"]); ?></td>
              <td><?php echo ($data["time"]); ?></td>
              <?php if(($data["hot"]) == "1"): ?><td><a href="<?php echo U('Index/adminhot',array('id' => $data['id'],'hot' => 0));?>" style="color:green">是</a></td><?php else: ?><td><a href="<?php echo U('Index/adminhot',array('id' => $data['id'],'hot' => 1));?>" style="color:red">否</a></td><?php endif; ?>
              <td><a href="<?php echo U('edit_admincontent',array('id' => $data['id']));?>">查看</a> <a href="<?php echo U('del',array('id'=>$data['id']));?>" class="text-danger" onclick="return confirm('确认要删除吗，删除后无法恢复？')">删除</a></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
          </tbody>
        </table>
      </div>
      <div class="pagenavi">
        <?php echo ($pagenavi); ?>
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
<!-- build:js /newadmin/Public/admin/scripts/app.html.js -->
<!-- jQuery -->
  <script src="/newadmin/Public/admin/libs/jquery/jquery/dist/jquery.js"></script>

<!-- Bootstrap -->
  <script src="/newadmin/Public/admin/libs/jquery/tether/dist/js/tether.min.js"></script>
  <script src="/newadmin/Public/admin/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
  <script src="/newadmin/Public/admin/libs/jquery/underscore/underscore-min.js"></script>
  <script src="/newadmin/Public/admin/libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="/newadmin/Public/admin/libs/jquery/PACE/pace.min.js"></script>

  <script src="/newadmin/Public/admin/scripts/config.lazyload.js"></script>

  <script src="/newadmin/Public/admin/scripts/palette.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-load.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-jp.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-include.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-device.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-form.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-nav.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-screenfull.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-scroll-to.js"></script>
  <script src="/newadmin/Public/admin/scripts/ui-toggle-class.js"></script>

  <script src="/newadmin/Public/admin/scripts/app.js"></script>

  

  <!-- ajax -->
  <!--<script src="/newadmin/Public/admin/libs/jquery/jquery-pjax/jquery.pjax.js"></script>-->
  <!--<script src="/newadmin/Public/admin/scripts/ajax.js"></script>-->
<!-- endbuild -->
</body>
</html>