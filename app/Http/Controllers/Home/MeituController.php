<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use DB;
use Input;
use Storage;
class MeituController extends Controller
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
            'scene' => '',
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
        $path = './upload/qcode/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
//        Image::make($data)
//            ->save($path);
        file_put_contents($path,$data,true);
        return $path;
//       return $data;
    }

    //生成海报
    public function index()
    {
        Header("Content-type: image/jpeg");
//            $uid = $_GET['uid'];
//            //图贴背景url
//            $posturl = $_GET['posterUrl'];
//            $contentimg = $_GET['imgurl'];
            $uid = '1557122526';
            $id = $_GET['id'];
            $contentimg = 'http://127.0.0.1/upload/3.jpg';
//             $userinfo = DB::table('userinfo')
//                 ->where('uid', '=', $uid)
//                 ->first();
// //            var_dump($userinfo);
//             if ($userinfo->photo) {
//                 $userimg = $userinfo->photo;
//             } else {
//                 $userimg = $userinfo->avatarurl;
//             }
//             $userimg = 'http://127.0.0.1' . $userimg;
            $muban = DB::table('muban')
            ->where('id', '=', $id)
            ->first();
            if($id == 37){
                $posturl = 'http://127.0.0.1/newadmin/Uploads/'.$muban->url;
            }else{
                $posturl = $muban->url;
            }
            
//            var_dump($userimg);exit;
//             $photo = $this->getPhoto($userimg);
//             $photo = ltrim($photo, ".");
//             $photo = 'http://127.0.0.1/' . $photo;
// //            imagecreatefromjpeg($photo);
//             if ($userinfo->name) {
//                 $name = $userinfo->name;
//             } else {
//                 $name = $userinfo->nickname;
//             }


            //获取发布图贴图片的url
            $wenzhangimg = imagecreatefromjpeg($contentimg);

            //白色背景
            $background_1 = imagecreatefrompng($muban->muban_background);

            //模板背景
            $background = imagecreatefrompng($posturl);
            //颜色
            $black = ImageColorAllocate($background, 255, 255, 255);
            //获取模板背景宽高
            $array_bg = getimagesize($posturl);
            $x_bg = $array_bg[0];//图片宽
            $y_bg = $array_bg[1];//图片高

// //            $text = $_GET['text'];
//             $text = "  河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天会消失，我就这一颗心，你看着伤吧！河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天，太阳总会下山，我的爱也有一天";
//             $text = trim($text); //清除字符串两边的空格
//             $text = preg_replace("/\t/", "", $text); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
//             $text = preg_replace("/\r\n/", "", $text);
//             $text = preg_replace("/\r/", "", $text);
//             $text = preg_replace("/\n/", "", $text);
//             $text = preg_replace("/ /", "", $text);
//             $text = preg_replace("/  /", "", $text);  //匹配html中的空格
// //        $text = "  河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天会消失，我就这一颗心，你看着伤吧！河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天，太阳总会下山，我的爱也有一天";

//             //文字换行设置行高
//             $pos = ['top' => $muban->text_y,
//                 'fontsize' => $muban->font_size,
//                 'width' => $muban->text_width,
//                 'left' => $muban->text_x,
//                 'hang_size' => $muban->hang_height,
//                 'color' => [0 => 255, 1 => 255, 2 => 255]
//             ];
//             $iswrite = true;
//             $fontpath = public_path("./font/simhei.ttf");
//             $nowHeight = 0;
//             $second = ['left' => $muban->text_x, 'width' => $muban->text_width, 'maxline' => 3];

//             $this->textalign($background, $pos, $text, $iswrite, $fontpath, $nowHeight, $second);


//             //小程序二维码
//              $qcode = $muban->qcode;
// //            $qcode = $this->qcode();
// //            $qcode = ltrim($qcode, ".");
// //            $qcode = 'https://duanju.58100.com' . $qcode;
// //            imagecreatefrompng($qcode);
//             $array1 = getimagesize($qcode);
//             $x1 = $array1[0];//图片宽
//             $y1 = $array1[1];//图片高
//             $radius1 = $array1[0] / 2;
//             //切圆角
//             $qcode_img = $this->radiusimg($qcode, $radius1);

// //            绘制小程序二维码
//             imagecopyresampled($background, $qcode_img, $muban->qcode_x, $muban->qcode_y, 0, 0, $muban->qcode_width, $muban->qcode_height, $x1, $y1);

//             //用户头像
//             $array2 = getimagesize($photo);
//             $x2 = $array2[0];//图片宽
//             $y2 = $array2[1];//图片高
//             $radius2 = $array2[0] / 2;
//             //切圆角
//             $user_img = $this->radiusimg($photo, $radius2);

// //            绘制用户头像
//             imagecopyresampled($background, $user_img, $muban->userimg_x, $muban->userimg_y, 0, 0, $muban->userimg_width, $muban->userimg_height, $x2, $y2);


            //用户文章图片
//        if($content->uid == '1557122526'){
//            $wenzhangimg=imagecreatefrompng($contentimg);
//        }else {
//            $wenzhangimg = imagecreatefromjpeg($contentimg);
//        }

            $array = getimagesize($contentimg);
            $x_wz = $array[0];//图片宽
            $y_wz = $array[1];//图片高

            // //绘制姓名日期
            // $text1 = $name;
            // $date = date('Y/m/d');
            // $text2 = "于" . $date;
            // ImageTTFText($background, $muban->username_size, 0, $muban->username_x, $muban->username_y, $black, public_path("./font/simhei.ttf"), $text1);
            // ImageTTFText($background, $muban->date_size, 0, $muban->date_x, $muban->date_y, $black, public_path("./font/simhei.ttf"), $text2);

            // //文章图片宽$x_wz，文章图片高$y_wz，绘制区域宽$muban->img_width，绘制区域高$muban->img_height;
            // if($x_wz > $y_wz){
            //     $bili = $muban->img_height;
            // }else{
            //     $bili = $muban->img_width;
            // }

            //绘制用户文章背景
            imagecopyresized ( $background_1 , $wenzhangimg , $muban->img_x , $muban->img_y , 0 , 0 , $muban->img_width , $muban->img_height , $x_wz , $y_wz );
//            imagecopyresampled($background_1, $wenzhangimg, $muban->img_x, $muban->img_y, 0, 0, $bili, $bili, $x_wz, $y_wz);
//            imagecopyresampled($background_1, $wenzhangimg, 0, 60, 0, 0, $a, $b, $x_wz, $y_wz);

            //底部图片
            $dibuurl = 'http://127.0.0.1/upload/dibu.png';
            $dibu = imagecreatefrompng($dibuurl);
            $array = getimagesize($dibuurl);
            $x_db = $array[0];//图片宽
            $y_db = $array[1];//图片高

            //绘制底部二维码
            imagecopyresampled($background, $dibu, 0, 1000, 0, 0, 750, 140, $x_db, $y_db);

            //将绘制好的海报绘制在背景上
            imagecopyresampled($background_1, $background, 0, 0, 0, 0, $x_bg, $y_bg, $x_bg, $y_bg);

            imagepng($background_1);
            $path = './upload/qcode/tutie' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
//            Imagepng($background_1, $path);
            $arr = [
                'status' => 1,
                'path' => $path
            ];
//            exit(json_encode($arr));
            ImageDestroy($background);
            ImageDestroy($background_1);

    }

    //修改海报文章图片
    public function uploadcontentimg(Request $request)
    {
        //查看是否有图片上传
        if ($request->hasFile('image')) {
            //dd($request->hasFile('image'));
            $rootpath = './upload/meituimg/';
            $filename = 'meituimg'.time().rand(1,9) . '.png';
            $request->file('image')->move($rootpath, $filename);
            $imgurl = 'https://duanju.58100.com'.trim($rootpath, '.') . $filename;
            $arr = [
                'status' => 1,
                'info' => '上传图片成功',
                'imgurl' => $imgurl
            ];
        } else {
            $arr = [
                'status' => 0,
                'info' => '参数错误'
            ];
        }
        exit(json_encode($arr));
    }

    //发布图贴
    public function savetutie(){
        if (isset($_POST['tutieurl']) && isset($_POST['uid'])) {
            $uid = $_POST['uid'];
            $tutieurl = $_POST['tutieurl'];
            $imgurl = $_POST['imgurl'];
            $posterurl = $_POST['posterurl'];
            $txt = $_POST['txt'];
            $userinfo = DB::table('userinfo')
                ->where('uid', '=', $uid)
                ->first();
            if ($userinfo->name) {
                $name = $userinfo->name;
            } else {
                $name = $userinfo->nickname;
            }
            if ($userinfo->photo) {
                $userimg = $userinfo->photo;
            } else {
                $userimg = $userinfo->avatarurl;
            }
            //保存图贴
            $datas = [
                'uid' => $uid,
                'name' => $name,
                'txt' => $txt,
                'photo' => $userimg,
                'tutieurl' => $tutieurl,
                'imgurl' => $imgurl,
                'posterurl' => $posterurl,
                'time' => time(),
                'date' => date('Y-m-d', time()),

            ];
            $res = DB::table('tutie')
                ->insert($datas);
            if($res){
                $arr = [
                    'status' => 1,
                    'info' => '发布成功',
                ];
            }else{
                $arr = [
                    'status' => 0,
                    'info' => '发布失败',
                ];
            }
        }else{
            $arr = [
                'status' => 0,
                'info' => '参数错误',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
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
        $path = './upload/userimgs/userimg' . time() . '.png';
        file_put_contents($path,$data,true);
        return $path;
    }

    //获取文章图片
    protected function getcontentPhoto($url){
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
        $path = './upload/qcode/content' . time() . '.jpg';
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

    //获取文字
    public function gettext(){
        $content = DB::table('content')
            ->where('uid','=','1557122526')
            ->inRandomOrder()
            ->first();
        if($content){
            $arr = [
                'status' => 1,
                'contents' => $content->title
            ];
        }else{
            $arr = [
                'status' => 0,
                'contents' => ''
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //美图首页
    public function photo(){
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['len']) ? $_POST['len'] : 10;
        $offset = ($page - 1) * $limit;
        $res = DB::table('tutie')
            ->select('tutieurl','imgurl','posterurl','txt','photo','name')
            ->orderBy('time','desc')
            ->offset($offset)
            ->limit($limit)
            ->get();
        if($res){
            $arr = [
                'status' => 1,
                'contents' => $res
            ];
        }else{
            $arr = [
                'status' => 0,
                'contents' => ''
            ];
        }

//        $arr = [
//            'status'=>1,
//            'contents' => [0=>['id'=>1,'uid'=>'1557122526','name'=>'小句','tutieurl'=>'http://duanju.58100.com/upload/qcode/hb1563242774578.jpg','time'=>time(),'date' => date('Y-m-d', time())],1=>['id'=>1,'uid'=>'1557122526','name'=>'小句','tutieurl'=>'http://duanju.58100.com/upload/qcode/hb1563242774578.jpg','time'=>time(),'date' => date('Y-m-d', time())]]
//        ];
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //美图详情页
    public function photodetail(){
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $res = DB::table('tutie')
                ->where('id', '=', $id)
                ->first();
            if ($res) {
                $arr = [
                    'status' => 1,
                    'contents' => $res
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'contents' => ''
                ];
            }
        }else{
            $arr = [
                'status' => 0,
                'contents' => '参数错误'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //获取模板
    public function muban(){
        $muban = DB::table('muban')
            ->get();
        $type = DB::table('mubanfenlei')
            ->get();
        foreach ($type as $key => $value) {
            $types[$key]['id'] = $value->id;
            $types[$key]['txt'] = $value->txt;
        }
        foreach ($muban as $key => $value) {
            $mubans[$key]['id'] = $value->id;
            $mubans[$key]['type'] = $value->type;
            $mubans[$key]['icon'] = $value->xiaotu_url;
            $mubans[$key]['posterAdress'] = $value->url;
        }
        $list = array();
        foreach ($types as $value){
            foreach ($mubans as $v){
                if($value['id'] == $v['type']){
                    $value['poster'][] = $v;
                }
            }
            $list[] = $value;
        }
//        var_dump($mubans);
//        var_dump($list);exit;
        if($type){
            $arr = [
                'status' => 1,
                'contents' => $list
            ];
        }else{
            $arr = [
                'status' => 0,
                'contents' => ''
            ];
        }

//        $arr = [
//            'status'=>1,
//            'contents' => [0=>['id'=>1,'uid'=>'1557122526','name'=>'小句','tutieurl'=>'http://duanju.58100.com/upload/qcode/hb1563242774578.jpg','time'=>time(),'date' => date('Y-m-d', time())],1=>['id'=>1,'uid'=>'1557122526','name'=>'小句','tutieurl'=>'http://duanju.58100.com/upload/qcode/hb1563242774578.jpg','time'=>time(),'date' => date('Y-m-d', time())]]
//        ];
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }
}
