<?php
return array(
  //'配置项'=>'配置值'
  'LANG_SWITCH_ON' => true,   // 开启语言包功能
  'LANG_AUTO_DETECT' => true, // 自动侦测语言 开启多语言功能后有效
  'LANG_LIST'        => 'zh-cn,en-us', // 允许切换的语言列表 用逗号分隔
  'DEFAULT_LANG'         =>     'zh-cn', // 默认语言
  'VAR_LANGUAGE'     => 'lang', // 默认语言切换变量

  //微信支付配置参数
  'appid'   => 'wx2334215ac9047ef7',
  'mch_id'    => '1476058102',//商户号
  'pay_apikey'  => 'mpV91gl0yEyXpzyZflafFAkHa7xReSA8',//支付密钥
  
  //邮件配置
  'THINK_EMAIL' => array(
    'SMTP_HOST'   => 'smtp.126.com', //SMTP服务器
    'SMTP_PORT'   => '465', //SMTP服务器端口
    'SMTP_USER'   => 'yhbox_server@126.com', //SMTP服务器用户名
    'SMTP_PASS'   => 'yhbox888', //SMTP服务器密码
    'FROM_EMAIL'  => 'yhbox_server@126.com', //发件人EMAIL
    'FROM_NAME'   => '杭州国际博览中心', //发件人名称
    'REPLY_EMAIL' => '', //回复EMAIL（留空则为发件人EMAIL）
    'REPLY_NAME'  => '', //回复名称（留空则为发件人名称）
    'RECEIVE_EMAIL'  => 'janpun@vip.qq.com', //收件人EMAIL
    ),
	'AUTOLOAD_NAMESPACE' => array(
        'Lib'     => APP_PATH.'Home/Lib',
    ),
);
