<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends GlobalController {
  public function index(){
//      $uid = uniqid();
      $limit = 5;
      //随机获取机器人
      $data=M('Userinfo')->limit(1)->where('type=3')->order('rand()')->find();
        var_dump($data);
      //随机获取文章
      $content = M('Content')->limit($limit)->where('typeid=10')->order('rand()')->select();
      var_dump($content);
      $nums = count($content);

      M()->startTrans();
//      M()->commit();
//      M()->rollback();
      if($content){
          if($nums == 1){
              $where = ['uid'=>$data['uid'], 'buid'=>$content[0]['uid'], 'contentid'=>$content[0]['id']];
              $support = M('Support') ->where($where) -> find();
              if($support){
                  var_dump('重复点赞');
              }else {
                  $map['bopenid'] = $content[0]['openid'];
                  $map['buid'] = $content[0]['uid'];
                  $map['uid'] = $data['uid'];
                  $map['openid'] = $data['openid'];
                  $map['time'] = time();
                  $map['dtime'] = date('Y-m-d H:i:s', time());
                  $map['contentid'] = $content[0]['id'];
                  $map['type'] = 1;
//          var_dump($map);exit;
//          $data=M('Userinfo')->limit(1)->order('rand()')->find();
                  $count = M('Support')->add($map);
                  if ($count > 0) {
                      $where = ['uid' => $content[0]['uid']];
                      $userinfo = M('Userinfo')->where($where)->find();
//                  echo M('Userinfo')->getLastSql();
//                  var_dump($userinfo);exit;
                      $mp['id'] = $userinfo['id'];
                      $mp['tix'] = 1;
                      $user = M('Userinfo')->save($mp);

                      var_dump($user);
                      M()->commit();
                      var_dump($count);
                  } else {
                      M()->rollback();
                      var_dump('失败');
                  }
              }
          }else{
              foreach ($content as $value) {

                  $where = ['uid'=>$data['uid'], 'buid'=>$value['uid'], 'contentid'=>$value['id']];
                  $support = M('Support') ->where($where) -> find();
                  if($support){
                      var_dump('重复点赞');
                  }else {
                      $map['bopenid'] = $value['openid'];
                      $map['buid'] = $value['uid'];
                      $map['uid'] = $data['uid'];
                      $map['openid'] = $data['openid'];
                      $map['time'] = time();
                      $map['dtime'] = date('Y-m-d H:i:s', time());
                      $map['contentid'] = $value['id'];
//          var_dump($map);exit;
//          $data=M('Userinfo')->limit(1)->order('rand()')->find();
                      $count = M('Support')->add($map);
                      if ($count > 0) {
                          $where = ['uid' => $value['uid']];
                          $userinfo = M('Userinfo')->where($where)->find();
//                  echo M('Userinfo')->getLastSql();
//                  var_dump($userinfo);exit;
                          $mp['id'] = $userinfo['id'];
                          $mp['tix'] = 1;
                          $user = M('Userinfo')->save($mp);
                          var_dump($user);
                          M()->commit();
                          var_dump($count);
                      } else {
                          M()->rollback();
                          var_dump('失败');
                      }
                  }
              }
          }
      }
  }

    //生成海报
    public function hb(){
        Header("Content-type: image/png");
        //白色背景
        $background_1 = imagecreatefrompng('./upload/img/background-1.png');

        //模板背景
        $background = imagecreatefrompng('./upload/img/1.png');
        //颜色
        $black = ImageColorAllocate($background, 117,120,156);
        $array_bg = getimagesize("./upload/img/1.png");
        $x_bg = $array_bg[0];//图片宽
        $y_bg = $array_bg[1];//图片高

        $text = "  河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天会消失，我就这一颗心，你看着伤吧！河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天，太阳总会下山，我的爱也有一天";

        //文字换行设置行高
        $pos = ['top'=>705,
            'fontsize'=>30,
            'width'=>738,
            'left'=>60,
            'hang_size'=>80,
            'color'=>[0=>117, 1=>120, 2=>156]
        ];
        $iswrite = true;
        $fontpath = public_path("/font/simhei.ttc");
        $nowHeight = 0;
        $second = ['left'=>60, 'width'=>738, 'maxline'=>4];
        // $text = textalign($background_1,$pos,$text,);
        $this->textalign($background, $pos, $text, $iswrite,$fontpath,$nowHeight,$second);


        //小程序二维码
        // $qcode_img = imagecreatefromjpeg('./img/mala.jpg');
        $array1 = getimagesize("./upload/img/mala.jpg");
        $x1 = $array1[0];//图片宽
        $y1 = $array1[1];//图片高
        $radius1 = $array1[0]/2;
        //切圆角
        $qcode_img = $this->radiusimg('./upload/img/mala.jpg', $radius1);

        //绘制小程序二维码
        imagecopyresampled($background, $qcode_img, 105, 1203, 0, 0, 162, 162,$x1,$y1);

        //用户头像
        $array2 = getimagesize("./upload/img/a.jpg");
        $x2 = $array2[0];//图片宽
        $y2 = $array2[1];//图片高
        $radius2 = $array2[0]/2;
        //切圆角
        $user_img = $this->radiusimg('./upload/img/a.jpg', $radius2);

        //绘制用户头像
        imagecopyresampled($background, $user_img, 150, 1248, 0, 0, 73, 73,$x2,$y2);


        //用户文章图片
        $wenzhangimg=imagecreatefrompng('./upload/img/1.jpg');
        $array = getimagesize("./upload/img/1.jpg");
        $x_wz = $array[0];//图片宽
        $y_wz = $array[1];//图片高

        //绘制姓名日期
        $text1 = "Henry";
        $date = date('Y/m/d');
        $text2 = "于".$date;
        ImageTTFText($background, 28, 0, 291, 1270, $black, "./upload/img/simhei.ttf", $text1);
        ImageTTFText($background, 24, 0, 291, 1320, $black, "./upload/img/simhei.ttf", $text2);

        //绘制用户文章背景
        imagecopyresampled($background_1,$wenzhangimg,0,102,0,0,855,510,$x_wz,$y_wz);

        //将绘制好的海报绘制在背景上
        imagecopyresampled($background_1,$background,0,0,0,0,855,1425,$x_bg,$y_bg);

        imagepng($background_1);
        ImageDestroy($background);
    }

    //生成带用户头像的二维码
    protected function thumb()
    {
//        //获取带参二维码
        $qcode = $this->qcode();
//        dd($qcode);exit;
    }

    //保存
    public function savehb(){
        if(isset($_POST['hbimg']) && isset($_POST['openid']) && isset($_POST['uid'])){
            //生成的海报地址
            $hbimg='./upload/hbimg/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
            Image::make('./upload/qcode/1559539753541.jpg')
                ->save($hbimg);
            //保存带数据库
        }
    }


    //获取用户的头像
    protected function getPhoto($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置是否输出header
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置是否输出结果
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置是否检查服务器端的证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        //使用curl_exec()将curl返回的结果转换成正常数据并保存到一个变量中
        $data = curl_exec($curl);
        //关闭会话
        curl_close($curl);
//        $user = json_decode($data, true);
//        var_dump($user);exit;
        return Image::make($data);
    }

    /* 文字自动换行
     * @param $card 画板
     * @param $pos 数组，top距离画板顶端的距离，fontsize文字的大小，width宽度，left距离左边的距离，hang_size行高
     * @param $str 要写的字符串
     * @param $iswrite  是否输出，ture，  花出文字，false只计算占用的高度
     * @param $nowHeight  已写入行数;
     * @param $second  数组 left  记录换行后据x坐标 ,width 记录换行后最大宽; , maxline 记录最大允许最大行数
     * @return $strdata  数组 tp:本次写入行数  nowHeight:一共写入行数  residueStr:截取未写完的字符串 height:最后一行据顶部的高度
     */
    protected function textalign($card, $pos, $str, $iswrite,$fontpath,$nowHeight,$second){
        $_str_h = $pos["top"];//文字在整个图片距离顶端的位置，也就是y轴的像素距离
        $fontsize = $pos["fontsize"];//文字的大小
        $width = $pos["width"];//设置文字换行的宽带，也就是多宽的距离，自动换行
        $margin_lift = $pos["left"];//文字在整个图片距离左边的位置，也就是X轴的像素距离
        $hang_size = $pos["hang_size"];// 这个是行高
        $temp_string = "";
        $secondCk = ""; //换号的标示,已换行true ,未换行false;
        $font_file =$fontpath;//字体文件，在我的同级目录的Fonts文件夹下面
        $tp = 0;
        $font_color = imagecolorallocate($card, $pos["color"][0], $pos["color"][1], $pos["color"][2]);
        for ($i = 0; $i < mb_strlen($str,'utf8'); $i++) {
            $box = imagettfbbox($fontsize, 0, $font_file, $temp_string);
            $_string_length = $box[2] - $box[0];
            $temptext = mb_substr($str, $i, 1,'utf-8');//拆分字符串
            $temp = imagettfbbox($fontsize, 0, $font_file, $temptext);//用来测量每个字的大小
            if($secondCk){//如果换行,进入判断赋值
                if(is_array($second)){//如果传入换行后参数,则使用.
                    $width = $second['width'];
                    $margin_lift = $second['left'];
                }
            }
            if($second['maxline']){
                //如果已经写入最大行数
                if($nowHeight == $second['maxline']){
                    //获取原字符串长度
                    $strlong = mb_strlen($str,'utf8');
                    //抓取剩余字符串
                    $residueStr ='';
                    $residueStr .= mb_substr($str, $i, $strlong - $i,'utf-8');
                    $cc = $strlong - $i;
                    break;
                }
            }
            if ($_string_length + $temp[2] - $temp[0] < $width) {
                $temp_string .= mb_substr($str, $i, 1,'utf-8');
                if ($i == mb_strlen($str,'utf8') - 1) {
                    $_str_h += $hang_size;
                    $tp++;//用来记录有多少行
                    $nowHeight++;//记录一共写入多少行
                    if ($iswrite) {//如果传入的参数是false，只做测量，不进行绘制输出
                        imagettftext($card, $fontsize, 0, $margin_lift, $_str_h, $font_color, $font_file, $temp_string);
                    }
                }
            } else {
                $texts = mb_substr($str, $i, 1,'utf-8');
                $isfuhao = preg_match("/[\\pP]/u", $texts) ? true : false;//用来判断最后一个字是不是符合，
                if ($isfuhao) {//如果是符号，我们就不换行，把符合添加到最后一个位置去
                    $temp_string .= $texts;
                    // $texts = $texts.'...';
                } else {
                    $i--;
                }
                $_str_h += $hang_size;
                $tp++;
                $nowHeight++;//记录一共写入多少行
                if($iswrite){
                    imagettftext($card, $fontsize, 0, $margin_lift, $_str_h, $font_color, $font_file, $temp_string);
                }
                $temp_string = "";
                $secondCk = true;//作为是否已换行的标志


            }


        }

        $strdata['tp'] = $tp ;
        // $strdata['residueStr'] = $residueStr ;
        $strdata['nowHeight'] = $nowHeight ;
        $strdata['height'] = $_str_h;
        return $strdata;
    }

    //修圆角
    protected function radiusimg($imgpath, $radius)
    {
        $ext = pathinfo($imgpath);
        $src_img = null;
        switch ($ext['extension']) {
            case 'jpg':
                $src_img = imagecreatefromjpeg($imgpath);
                break;
            case 'png':
                $src_img = imagecreatefrompng($imgpath);
                break;
        }
        $wh = getimagesize($imgpath);
        $w = $wh[0];
        $h = $wh[1];
        // $radius = $radius == 0 ? (min($w, $h) / 2) : $radius;
        $img = imagecreatetruecolor($w, $h);
        //这一句一定要有
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $bg);
        $r = $radius; //圆 角半径
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (($x >= $radius && $x <= ($w - $radius)) || ($y >= $radius && $y <= ($h - $radius))) {
                    //不在四角的范围内,直接画
                    imagesetpixel($img, $x, $y, $rgbColor);
                } else {
                    //在四角的范围内选择画
                    //上左
                    $y_x = $r; //圆心X坐标
                    $y_y = $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //上右
                    $y_x = $w - $r; //圆心X坐标
                    $y_y = $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //下左
                    $y_x = $r; //圆心X坐标
                    $y_y = $h - $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //下右
                    $y_x = $w - $r; //圆心X坐标
                    $y_y = $h - $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                }
            }
        }
        //header("content-type:image/png");
        //$radius = './upload/qcode/'. time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
        // imagepng($img, $newimg);
        return $img;

    }

    public function wxpay(){
        //微信支付
        $total_fee = $data['sum_price'];//测试
        $total_fee = 0.01;//测试
        $data['orderid'] = '1';
        $ordersn = '112233';
        $config = array(
          'appid' => 'wx0b214ca08babc1a3',
          'mch_id' => '1542149431',
          'pay_apikey' => '5eqZBU4Jr88u1IHMCqXCPC9ZlqtUxhmc',
        );
        $notify_url = 'https://duanju.58100.com/home/index/yibu';
        $wxpay = new \Org\Util\Wxpay($config);   //初始化类(同时传递参数)

        $wxdata = $wxpay->wxpay($count, $total_fee, "杭州国际博览中心北辰大酒店" . "-{$data['title']}-{$data['grouptitle']}", $ordersn, $notify_url); //微信支付
        dump($wxdata);die();
    }
}