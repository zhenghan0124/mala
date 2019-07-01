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
        $qcode = Image::make($data)
            ->save($path);
//            ->response('png');
//        dd($qcode);
       return $data;
    }

    //生成海报
    public function hbimg()
    {
        /*$fontface=字体名称 $i=预设宽度 $contentfontsize=字体的大小
     $str=输入的内容 $time=时间 $nickname=用户的昵称 $bgimg=背景图
     $contentimg=内容的图片,$contentw=内容图片的大小,$contenth=内容图片的大小,
     $contentbgimgw=内容图片的位置,$contentbgimgh=内容图片的位置,
    $photo=用户的头像, $userw=用户头像的大小, $userh=用户头像的大小,
    $codew=二维码的大小, $codeh二维码的大小,
    $qcode=图片的生成地址, $usercodew=用户生成的二维码位置, $usercodeh==用户生成的二维码位置,
    $nicknamecodew=昵称的位置,$nicknamecodeh=昵称的位置,
    $timew,$timeh

    */

        $qcode ='./upload/qcode/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg' ;
        $bgimg='./upload/backgroud.png';//背景图
        $contentimg='./upload/1.jpg';//内容的图片
        $mbimg='./upload/aiqing.png';
        $a=0;
        $b=0;
        $contentw=588;//内容图片的大小
        $contenth=485;
        $contentbgimgw=213;//内容图片的位置
        $contentbgimgh=65;
//        $photo='https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJ46xteOpTLqAD3fXGx2R1bz1H3RDjPhWckJBAV0PJ2tpZ9ysAcPgerMC7KSrUyMn3uF8QM2lrlxQ/132';
        $photos='https://duanju.58100.com/upload/userimg/1558597203.png';
        $photo=$this->getPhoto($photos);    //用户头像
        $userw=98;//用户头像的大小
        $userh=98;
        $codew=216;//二维码的大小
        $codeh=216;
        $radius=105;
        $usercodew=90;//用户生成的二维码位置
        $usercodeh=1000;
        $time=date('Y/m/d',time());
        $timew=336;
        $timeh=1150;
        $nickname='Henry';
        $nicknamecodew=336;
        $nicknamecodeh=1100;
        $strs='我国语言太博大精深了，比如你说“串儿”这个词，东北人想到的是“羊肉串”，四川人想到的是“串串香”，而北京人就更厉害了，有一半人想到的是“盘珠子”，另一半人想到的是杂交小狗。';
        $str=mb_substr($strs,0,48);
        $boxw=60;//内容的位置
        $boxh=650;
        $fontface=public_path("./font/simsun.ttc");//字体
        $i=16;//预设宽度
        $contentfontsize=0;
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

    //文字换行
    protected function autowrap($fontsize, $angle, $fontface, $string, $width) {
        // 参数分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
        $content = "";
        // 将字符串拆分成一个个单字 保存到数组 letter 中
        preg_match_all("/./u", $string, $arr);
        $letter = $arr[0];
        foreach($letter as $l) {
            $teststr = $content.$l;
            $testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
            if (($testbox[2] > $width) && ($content !== "")) {
                $content .= PHP_EOL;
            }
            $content .= $l;
        }
        return $content;
    }

    //生成圆形图片
    protected function circleImg($imgPath)
    {
        $src_img = imagecreatefromjpeg($imgPath);

        list($w, $h) = getimagesize($imgPath);
        $w = $h = min($w, $h);
        $img = imagecreatetruecolor($w, $h);
        imagesavealpha($img, true);

        // 拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);

        imagefill($img, 0, 0, $bg);
        $r = $w / 2; // 圆的半径
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (((($x - $r) * ($x - $r) + ($y - $r) * ($y - $r)) < ($r * $r)))
                    imagesetpixel($img, $x, $y, $rgbColor);
            }
        }
        imagedestroy($src_img);
        return $img;
    }

    //修圆角
    protected function radiusimg($newimg, $imgpath, $radius)
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
        imagepng($img, $newimg);
        return $newimg;

    }




}
