<?php
return array(
  //'配置项'=>'配置值'
  'URL_CASE_INSENSITIVE' =>true,      //开启不区分大小写
  // 'SHOW_PAGE_TRACE' => true,       //开启页面trace
  'URL_MODEL' => '2',
  'URL_HTML_SUFFIX'=>'',	//伪静态后缀
  'COOKIE_PATH' => '/',				//设置cookie目录

  'DB_TYPE'   => 'mysqli', // 数据库类型
  'DB_HOST'   => 'localhost', // 服务器地址
  'DB_NAME'   => 'mala', // 数据库名
  'DB_USER'   => 'root', // 用户名
  'DB_PWD'    => 'root',  // 密码
  'DB_PORT'   => '3306', // 端口
  'DB_PREFIX' => '', // 数据库表前缀

  //模块
  'MODULE_ALLOW_LIST'  => array('Home','Admin'),
  'DEFAULT_MODULE'       =>    'Admin',


);
