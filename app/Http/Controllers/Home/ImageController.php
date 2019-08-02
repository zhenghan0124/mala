<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use DB;
use Input;
use Storage;
class ImageController extends Controller
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

//        if ($_GET['contentid']!='' && $_GET['uid']!='') {
            $datas = array(
                /*'path'=>'pages/index/index?openid='.$opneid.'&id='.$id,//是扫描二维码跳转的小程序路径，可以带参数
                'width'=> 150*/
                'page' => 'pages/index/index',
//                'scene' => $_GET['contentid'].'&'.$_GET['uid'],    //用户uid,openid,文章id
                'scene' => '5cd022665293d&2057',
            );
//        }

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

//        Image::make($data)
//            ->save('./upload/qcode/1.jpg');
////           ->response('png');
//        return './upload/qcode/1.jpg';
        return $data;
    }

    //分享生成代参二维码
    public function share()
    {

        $index = new PublicController();
        $access_token = $index->getAccent_token();//获取token
//        $access_token = '22_d9a3e3HMnAl5A8kOkVOJUkFd3v27ccng1mJnxTJdtt_FvUXDxU4ig7Zoq99NOOTdWAgAISYLqIU2Rx0e4muYkGgwuTKnmo-tCFmXL6GdLc0mNmLafm8epwkfMpaJBunfnwn8fr2B2nnchrqDHLQcABALPU';
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=$access_token";
        $curl = curl_init();   //1.初始化

//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  //跳过证书检查
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  //从证书中检查SSL加密算法是否存在

        curl_setopt($curl, CURLOPT_URL, $url); //2.请求地址

//        if ($_GET['contentid']!='' && $_GET['uid']!='') {
        $_GET['uid'] = '5cd02244bb62f';

        $content = DB::table('content')
            ->where('uid','=',$_GET['uid'])
            ->where('status','=',1)
            ->where('audit','=',1)
            ->orderBy('time','desc')
            ->first();
        var_dump($content);exit;
        if($content == null){
            $contentid = 0;
        }else{
            $contentid = $content->id;
        }
//        var_dump($content);exit;
//        $contentid = $content->id;
//        var_dump($contentid);exit;
        $datas = array(
            /*'path'=>'pages/index/index?openid='.$opneid.'&id='.$id,//是扫描二维码跳转的小程序路径，可以带参数
            'width'=> 150*/
            'page' => 'pages/index/index',
            'scene' => $contentid.'&'.$_GET['uid'],    //用户uid,openid,文章id
//                'scene' => '123&456',
        );
//        }

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
//        Image::make($data)
//            ->save('./upload/qcode/1.jpg');
////           ->response('png');
//        return './upload/qcode/1.jpg';
        return $data;
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

    //生成缩率图
    protected function photothumb($qcode, $imgurl, $w, $h)
    {
        Image::make($imgurl)
            ->resize($w, $h)
            ->save($qcode);
//        dd($qcode);exit;
        return $qcode;
    }

    //生成带用户头像的二维码
    protected function thumb($radius,$photo, $userw, $userh, $codew, $codeh, $qcode)
    {
        //生成缩率
        //$qcode='./upload/qcode/'. time().rand(1,9) .rand(1,9).rand(1,9).'.jpg';
        $qcodes = $this->photothumb($qcode, $photo, $userw, $userh);
        //把图片裁剪成圆形
        $imgs = $this->circleImg($qcodes);
        //水印

//        $qcode = imagecopyresampled($this->qcode(),$imgs,0,0,0,0,1005,600,$x,$y);

        Image::make($this->qcode())
            ->resize($codew, $codeh)
            ->insert($imgs, 'center')
            ->save($qcode);
        $imagesss = $this->radiusimg($qcode, $qcode, $radius);
        return $imagesss;
    }

    //将用户文章的图片缩率
    protected function contentimg($contentimg,$contentimgw,$contentimgh){
        $hbimg = Image::make($contentimg)
            ->resize($contentimgw, $contentimgh);
        return $hbimg;
    }
    //将用户文章的图片水印到背景上 心形背景
    protected function contentbgimg($bgimg,$contentimg,$contentw,$contenth,$contentbgimgw,$contentbgimgh){
        $hbimg = Image::make($bgimg)
            ->insert($this->contentimg($contentimg,$contentw,$contenth),'top-left',$contentbgimgw,$contentbgimgh);
        return $hbimg;
    }

    //生成带用户头像的二维码(水印)
    protected function usercode($radius,$mbimg,$photo, $userw, $userh, $codew, $codeh, $qcode, $usercodew, $usercodeh)
    {
        $hbimg = Image::make($mbimg)
            ->insert($this->savehb($radius,$photo, $userw, $userh, $codew, $codeh, $qcode),'top-left', $usercodew, $usercodeh);

        //$hbimg = Image::make($mbimg)
           // ->insert($this->thumb($radius,$photo, $userw, $userh, $codew, $codeh, $qcode), 'top-left', $usercodew, $usercodeh);
        return $hbimg;
    }
    //时间的水印位置
    protected function timecodes($radius,$time,$mbimg,$photo, $userw, $userh, $codew, $codeh, $qcode, $usercodew, $usercodeh,$timew,$timeh){
        $img=Image::make($this->usercode($radius,$mbimg,$photo, $userw, $userh, $codew, $codeh, $qcode, $usercodew, $usercodeh))
            ->text($time, $timew, $timeh, function ($font) {
                $font->file(public_path('./font/simsun.ttc'));
                $font->size(36);
                $font->color('#BC284F');
            });
        return $img;
    }

    //昵称时间的水印位置
    protected function nicknamecode($radius,$time,$nickname,$mbimg,$photo, $userw, $userh, $codew, $codeh, $qcode, $usercodew, $usercodeh,$nicknamecodew,$nicknamecodeh,$timew,$timeh){
        $img=Image::make($this->timecodes($radius,$time,$mbimg,$photo, $userw, $userh, $codew, $codeh, $qcode, $usercodew, $usercodeh,$timew,$timeh))
//            ->text($nickname,$nicknamecodew,$nicknamecodeh, function ($font) use ($color) {
            ->text($nickname,$nicknamecodew,$nicknamecodeh, function ($font) {
                $font->file(public_path('./font/simhei.ttf'));
                $font->size(48);
                $font->color('#DC284F');
            });

        return $img;
    }


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

    //内容的水印(生成海报)
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


    public function text($radius,$boxw,$boxh,$fontface,$i,$contentfontsize,$str,$time,$nickname,$mbimg,$photo, $userw, $userh, $codew, $codeh, $qcode, $usercodew, $usercodeh,$nicknamecodew,$nicknamecodeh,$timew,$timeh)
    {
        //$hbimg = './upload/hbimg/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
        //获取内容的长度并截取
        //$str=mb_substr($str,0,50);
        $box = $this->autowrap($contentfontsize, 0, $fontface, $str, $i);
        $img = Image::make($this->nicknamecode($radius,$time,$nickname,$mbimg,$photo, $userw, $userh, $codew, $codeh, $qcode, $usercodew, $usercodeh,$nicknamecodew,$nicknamecodeh,$timew,$timeh))
            ->text($box,$boxw,$boxh,function($font) {
                $font->file(public_path('./font/simsun.ttc'));
                $font->size(54);
                $font->color('#DC284F');
            });
        return $img;
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
        //$user = json_decode($data, true);
        //var_dump($user);exit;
        return Image::make($data);
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
        //$mbs = $_GET['type'];
        $mbs= 3;//模板id
        if($mbs == 1){
            $mbimg='./upload/aiqing.png';//爱情模板水印图片
            $contentw=588;//内容图片的大小
            $contenth=485;
            $contentbgimgw=213;//内容图片的位置
            $contentbgimgh=55;
            $boxw=60;//内容的位置
            $boxh=650;
            $i=16;//预设宽度
        }elseif($mbs == 2){
            $mbimg='./upload/wenyi.png';//文艺模板水印图片
            $contentw=1005;//内容图片的大小
            $contenth=600;
            $contentbgimgw=0;//内容图片的位置
            $contentbgimgh=0;
            $boxw=70;//内容的位置
            $boxh=650;
            $i=16;//预设宽度
        }elseif($mbs == 3){
            $mbimg='./upload/zhufu.png';//祝福模板水印图片
            $contentw=963;//内容图片的大小
            $contenth=500;
            $contentbgimgw=21;//内容图片的位置
            $contentbgimgh=0;
            $boxw=60;//内容的位置
            $boxh=650;
            $i=16;//预设宽度
        }elseif($mbs == 4){
            $mbimg='./upload/heka.png';//贺卡水印图片
            $contentw=888;//内容图片的大小
            $contenth=624;
            $contentbgimgw=60;//内容图片的位置
            $contentbgimgh=0;
            $boxw=60;//内容的位置
            $boxh=700;
            $i=16;//预设宽度
        }else{
            $mbimg='./upload/xinzhi.png';//贺卡水印图片
            $contentw=300;//内容图片的大小
            $contenth=384;
            $contentbgimgw=603;//内容图片的位置
            $contentbgimgh=60;
            $boxw=60;//内容的位置
            $boxh=150;
            $i=9;//预设宽度
        }
        // $mbimg='./upload/aiqing.png';//水印图片
        $a=0;
        $b=0;
        //$contentw=588;//内容图片的大小
        // $contenth=485;
        //$contentbgimgw=213;//内容图片的位置
        //$contentbgimgh=55;
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
        //$boxw=60;//内容的位置
        //$boxh=650;
        $fontface=public_path("./font/simsun.ttc");//字体
        //$i=16;//预设宽度
        $contentfontsize=0;
//        $color = '#FFFFFF';
        $img = Image::make($this->contentbgimg($bgimg,$contentimg,$contentw,$contenth,$contentbgimgw,$contentbgimgh))
            ->insert($this->text($radius,$boxw,$boxh,$fontface,$i,$contentfontsize,$str,$time,$nickname,$mbimg,$photo, $userw, $userh, $codew, $codeh, $qcode, $usercodew, $usercodeh,$nicknamecodew,$nicknamecodeh,$timew,$timeh), 'top-left', $a, $b);
        //生成临时海报的地址
        //$lhbimg='./upload/lhbimg/'. time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
        //$re=$img->save($lhbimg);\
        return $img->response('png');
//        if($re){
//            return $img->response('png');
//        }else{
//
//        }
    }

    //保存
    public function savehb(){
//        if(isset($_POST['hbimg']) && isset($_POST['openid']) && isset($_POST['uid'])){
//            //生成的海报地址
//            $hbimg='./upload/hbimg/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
//            Image::make('./upload/qcode/1559539753541.jpg')
//                ->save($hbimg);
//            //保存带数据库
//        }
        $qcode ='./upload/qcode/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg' ;
        $photos='https://duanju.58100.com/upload/userimg/1558597203.png';
        $photo=$this->getPhoto($photos);    //用户头像
        $userw=98;//用户头像的大小
        $userh=98;
        $codew=216;//二维码的大小
        $codeh=216;
        $radius=105;
        $a=$this->thumb($radius,$photo, $userw, $userh, $codew, $codeh, $qcode);
        return $a;
    }

    public function user(){
//        if(isset($_POST['hbimg']) && isset($_POST['openid']) && isset($_POST['uid'])){
//            //生成的海报地址
//            $hbimg='./upload/hbimg/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
//            Image::make('./upload/qcode/1559539753541.jpg')
//                ->save($hbimg);
//            //保存带数据库
//        }
        $qcode ='./upload/qcode/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg' ;
        $photos='https://duanju.58100.com/upload/userimg/1558597203.png';
        $photo=$this->getPhoto($photos);    //用户头像
        $userw=98;//用户头像的大小
        $userh=98;
        $codew=216;//二维码的大小
        $codeh=216;
        $radius=105;
        $this->thumb($radius,$photo, $userw, $userh, $codew, $codeh, $qcode);
//        return Image::make($qcode)
//            ->response('png');
        return $qcode;
    }


    public function test(Request $request){
        //文件上传(视频)
//        if(Input::method()=='POST'){
//            if($request->hasFile('text') && $request->file('text')->isValid()){
//                $rootpath = './upload/ship/';//上传的临时路径
//                $extension = $request->file('text')->extension();
//                $filename = time() . '.'.$extension;
//                $b=$request->file('text')->move($rootpath,$filename);
//                if($b){
//                    $disk =Storage::disk('my');
//                    $a=$disk->move( trim($rootpath.$filename),'./upload/my/'.$filename);//保存后的路径
//                    if($a){
//                        $arr=[
//                            'ship'=>'/upload/my/'.$filename
//                        ];
//                    }else{
//                        return 0;
//                    }
//                }else{
//                    return 0;
//                }
//            }else{
//                exit('未获取到上传文件或上传过程出错');
//            }
//        }else{
//            $arr=[
//                'ship'=>''
//            ];
//        }
//        return view('home/index/index',$arr);
    }

}
