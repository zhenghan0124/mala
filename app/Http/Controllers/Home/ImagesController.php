<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use DB;
use Input;
use Storage;
class ImagesController extends Controller
{
    //生成代参二维码
    public function qcode()
    {

        $index = new PublicController();
        $access_token = $index->getAccent_token();//获取token
//        $access_token = '22_d9a3e3HMnAl5A8kOkVOJUkFd3v27ccng1mJnxTJdtt_FvUXDxU4ig7Zoq99NOOTdWAgAISYLqIU2Rx0e4muYkGgwuTKnmo-tCFmXL6GdLc0mNmLafm8epwkfMpaJBunfnwn8fr2B2nnchrqDHLQcABALPU';
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=$access_token";
        $curl = curl_init();   //1.初始化

//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  //跳过证书检查
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  //从证书中检查SSL加密算法是否存在

        curl_setopt($curl, CURLOPT_URL, $url); //2.请求地址
        $datas = array(
            /*'path'=>'pages/index/index?openid='.$opneid.'&id='.$id,//是扫描二维码跳转的小程序路径，可以带参数
            'width'=> 150*/
            'page' => 'pages/index/index',
            'scene' => 'id=123',
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datas));//3.请求方式
        //设置是否输出header
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置是否输出结果
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置是否检查服务器端的证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $data = curl_exec($curl);
        //关闭会话
        curl_close($curl);
        $path = './upload/qcode/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg' ;;
//        $qcode = Image::make($data)
//            ->save($path);
////            ->response('png');
////        dd($qcode);
//        return $path;
        file_put_contents($path,$data,true);
        return $path;
    }


    //生成海报
    public function hbimg()
    {
        Header("Content-type: image/png");

        $uid = $_GET['uid'];
        $contentid = $_GET['contentid'];
        $userinfo = DB::table('userinfo')
            ->where('uid', '=', $uid)
            ->first();
        if($userinfo->photo){
            $userimg = $userinfo->photo;
        }else{
            $userimg = $userinfo->avatarurl;
        }
        //判断是否存在域名
        if(strpos($userimg, 'https') !==false){
            $userimg = $userimg;
        }else{
            $userimg = 'https://duanju.58100.com'.$userimg;
        }
        $photo = $this->getPhoto($userimg);
        $photo = ltrim($photo, ".");
        $photo = 'http://127.0.0.1'.$photo;
        if($userinfo->name){
            $name = $userinfo->name;
        }else{
            $name = $userinfo->nickname;
        }

        $content = DB::table('content')
            ->where('id', '=', $contentid)
            ->first();
//        var_dump($content);
        $contentimg = $content->imgurl;
        if($contentimg){
            $contentimg = explode(',', $contentimg);
            $contentimg = 'https://duanju.58100.com/'.$contentimg[0];
        }else{
            $contentimg = 'https://duanju.58100.com/upload/mala.png';
        }

        //白色背景
        $background_1 = imagecreatefrompng('http://127.0.0.1/upload/img/background-1.png');

        //模板背景
        $background = imagecreatefrompng('http://127.0.0.1/upload/img/6.png');
        //颜色
        $black = ImageColorAllocate($background, 40,40,40);
        $array_bg = getimagesize("http://127.0.0.1/upload/img/6.png");
        $x_bg = $array_bg[0];//图片宽
        $y_bg = $array_bg[1];//图片高

//        $text = "  河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天会消失，我就这一颗心，你看着伤吧！河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天，太阳总会下山，我的爱也有一天";
        $text = '  '.$content->title;
        //文字换行设置行高
        $pos = ['top'=>705,
            'fontsize'=>30,
            'width'=>738,
            'left'=>60,
            'hang_size'=>80,
            'color'=>[0=>40, 1=>40, 2=>40]
        ];
        $iswrite = true;
        $fontpath = 'C:\Windows\Fonts\simhei.ttf';
        $nowHeight = 0;
        $second = ['left'=>60, 'width'=>738, 'maxline'=>4];
        // $text = textalign($background_1,$pos,$text,);
        $this->textalign($background, $pos, $text, $iswrite,$fontpath,$nowHeight,$second);


        //小程序二维码
        // $qcode_img = imagecreatefromjpeg('./img/mala.jpg');
        $qcode = $this->qcode();
        $qcode = ltrim($qcode, ".");
        $qcode = 'http://127.0.0.1'.$qcode;
//        var_dump($qcode);exit;
        $array1 = getimagesize($qcode);
        $x1 = $array1[0];//图片宽
        $y1 = $array1[1];//图片高
        $radius1 = $array1[0]/2;
        //切圆角
        $qcode_img = $this->radiusimg($qcode, $radius1);

        //绘制小程序二维码
        imagecopyresampled($background, $qcode_img, 105, 1203, 0, 0, 162, 162,$x1,$y1);

        //用户头像
        $array2 = getimagesize($photo);
        $x2 = $array2[0];//图片宽
        $y2 = $array2[1];//图片高
        $radius2 = $array2[0]/2;
        //切圆角
        $user_img = $this->radiusimg($photo, $radius2);

        //绘制用户头像
        imagecopyresampled($background, $user_img, 150, 1248, 0, 0, 73, 73,$x2,$y2);


        //用户文章图片
        $wenzhangimg=imagecreatefrompng($contentimg);
        $array = getimagesize($contentimg);
        $x_wz = $array[0];//图片宽
        $y_wz = $array[1];//图片高

        //绘制姓名日期
        $text1 = $name;
        $date = date('Y/m/d');
        $text2 = "于".$date;
        ImageTTFText($background, 28, 0, 291, 1270, $black, 'C:\Windows\Fonts\simhei.ttf', $text1);
        ImageTTFText($background, 24, 0, 291, 1320, $black, 'C:\Windows\Fonts\simhei.ttf', $text2);

        //绘制用户文章背景
        imagecopyresampled($background_1,$wenzhangimg,0,40,0,0,855,580,$x_wz,$y_wz);

        //将绘制好的海报绘制在背景上
        imagecopyresampled($background_1,$background,0,0,0,0,855,1425,$x_bg,$y_bg);
        $path = './upload/qcode/hb' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
        Imagepng($background_1, $path);
        imagepng($background_1);
        ImageDestroy($background);
    }

    //生成带用户头像的二维码
    protected function thumb()
    {
        $uid = $_GET['uid'];
        $contentid = $_GET['contentid'];
        $userinfo = DB::table('userinfo')
            ->where('uid', '=', $uid)
            ->first();
        if($userinfo->photo){
            $userimg = $userinfo->photo;
        }else{
            $userimg = $userinfo->avatarurl;
        }
        //判断是否存在域名
        if(strpos($userimg, 'https') !==false){
            $userimg = $userimg;
        }else{
            $userimg = 'https://duanju.58100.com'.$userimg;
        }
//        $photo = $this->getPhoto($userimg);
//        $photo = ltrim($photo, ".");
//        $photo = 'http://127.0.0.1'.$photo;
////        var_dump($photo);
//        if($userinfo->name){
//            $name = $userinfo->name;
//        }else{
//            $name = $userinfo->nickname;
//        }
        $content = DB::table('content')
            ->where('id', '=', $contentid)
            ->first();
//        var_dump($content);
        $contentimg = $content->imgurl;
        if($contentimg){
            $contentimg = explode(',', $contentimg);
            $contentimg = 'https://duanju.58100.com/'.$contentimg[0];
        }else{
            $contentimg = 'https://duanju.58100.com/upload/mala.png';
        }
//        var_dump($contentimg);
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
//        return Image::make($data);
        $path = './upload/qcode/userimg' . time() . '.png';
        file_put_contents($path,$data,true);
        return $path;
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

}
