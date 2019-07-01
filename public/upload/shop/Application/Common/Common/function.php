<?php
/**
 * 返回缩略图名
 * @param  string $pathname 原图片名
 * @author @janpun
 */
function thumb_name($pathname){
  $str_place = strripos($pathname,"/");
  $str_length = strlen($pathname);
  $filename = substr($pathname,0,$str_place+1);
  $extname = substr($pathname,$str_place - $str_length+1);
  return $filename.'thumb_'.$extname;
}

//0升序 1降序
if(!function_exists('array_sort')) {
    function array_sort($arr, $keys, $type = 0)
    {
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) {
            $keysvalue[$k] = $v[$keys];
        }
        if ($type == 0) {
            asort($keysvalue);
        } else {
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
}

/**
 * 邮件发送函数
 */
function sendMail($to, $title, $content) {

    Vendor('PHPMailer.PHPMailerAutoload');
    $mail = new PHPMailer(); //实例化
    if (C('MAIL_SSL') == true) {
        if (!extension_loaded('openssl')) {
            die('请开启 php_openssl 扩展！');
        }
    }
    // var_dump($to);
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称
    $mail->Port = C('MAIL_PORT');
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //你的邮箱名
    $mail->Password = C('MAIL_PASSWORD') ; //邮箱密码
    $mail->From = C('MAIL_FROM'); //发件人地址
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"尊敬的客户");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject =$title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = "为了查看该邮件，请您切换到支持HTML的邮件客户端"; //邮件正文不支持HTML的备用显示
    if (C('MAIL_SSL') == true) {
        $mail->SMTPSecure = 'ssl';
    }
    if ($mail->Send()) {
        return true;
    } else {
        die($mail->ErrorInfo);
    }        
}

/**
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $content    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function think_send_mail($to, $name, $subject = '', $content = '', $attachment = null){
  $body = $content;

  $config = C('THINK_EMAIL');
  vendor('PHPMailer.class#smtp'); //从PHPMailer目录导class.smtp.php类文件
  vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
  $mail             = new \PHPMailer(); //PHPMailer对象
  $mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
  $mail->IsSMTP();  // 设定使用SMTP服务
  $mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
  // 1 = errors and messages
  // 2 = messages only
  $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
  $mail->SMTPSecure = 'ssl';                 // 使用安全协议
  $mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
  $mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
  $mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
  $mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
  $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
  $replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
  $replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
  $mail->AddReplyTo($replyEmail, $replyName);
  $mail->Subject    = $subject;
  $mail->MsgHTML($body);
  $mail->AddAddress($to, $name);
  if(is_array($attachment)){ // 添加附件
    foreach ($attachment as $file){
      is_file($file) && $mail->AddAttachment($file);
    }
  }
  return $mail->Send() ? true : $mail->ErrorInfo;
}
