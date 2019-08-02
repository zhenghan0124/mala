<?php

namespace App\Http\Controllers\Home;

use App\Home\Content;
use App\Home\Focus;
use DemeterChain\C;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Home\Support;
use DB;

class NewcontentController extends Controller
{
    //获取该用户的信息和文章(他们主页)
    public function getusercontent()
    {
        if (isset($_POST['bopenid']) && isset($_POST['buid']) && isset($_POST['uid']) && isset($_POST['openid'])) {
            $focus = new Focus();
            $content = new Content();
            $isfocus = $focus->isfocus($_POST);//是否有关注
            if ($isfocus) {
                $guanzhu = 1;
            } else {
                $guanzhu = 0;
            }
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $contents = $content->getUserContents($_POST, $offset, $limit);
            if ($contents) {
                $support = new Support();
                foreach ($contents as $v) {
                    $contentid[] = $v->id;
                }
                $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
                if ($supports) {
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'focus' => $guanzhu,
                        'support' => $supports
                    ];
                } else {
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'focus' => $guanzhu,
                        'support' => []
                    ];
                }
            } else {
                $arr = [
                    'status' => 1,
                    'contents' => [],
                    'focus' => $guanzhu
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //获取用户的所有文章（动态）
    public function getusercontents(){
        if(isset($_POST['openid']) && isset($_POST['uid']) ){
            $model=new Content();
            $page=isset($_POST['page']) ? $_POST['page'] : 1;
            $limit=isset($_POST['len']) ? $_POST['len'] : 20;
            $offset=($page-1)*$limit;
            $contents=$model->getUserContentss($_POST['openid'],$_POST['uid'],$offset,$limit);
            if($contents){
                //获取该用户的点赞文章id
                $support = new Support();
                foreach ($contents as $v) {
                    $contentid[] = $v->id;
                }
                $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
                if($supports){
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'support' => $supports
                    ];
                }else{
                    $arr = [
                        'status' => 1,
                        'contents' => $contents,
                        'support' => []
                    ];
                }
            }else{
                $arr = [
                    'status' => 1,
                    'contents' => [],
                    'support' => []
                ];
            }
        }else{
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //收藏文章(点击收藏)
    public function collection()
    {
        if (isset($_POST['contentid']) && isset($_POST['uid'])) {
            $re = DB::table('newcollection')
                ->insert($_POST);
            if ($re) {
                DB::table('newcontent')
                    ->where('id', '=', $_POST['contentid'])
                    ->increment('collection');
                $arr = [
                    'status' => 1,
                    'info' => '收藏成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '收藏失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //取消收藏文章(取消收藏)
    public function delcollection()
    {
        if (isset($_POST['contentid']) && isset($_POST['uid'])) {
            $re = DB::table('newcollection')
                ->where('contentid', '=', $_POST['contentid'])
                ->where('uid', '=', $_POST['uid'])
                ->delete();
            if ($re) {
                $arr = [
                    'status' => 1,
                    'info' => '取消成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '取消失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //我的收藏
    public function mycollection()
    {
        if (isset($_POST['openid']) && isset($_POST['uid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $re = DB::table('collection')
                ->select('contentid')
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->orderBy('time', 'desc')
                ->offset($offset)
                ->limit($limit);
            if ($re->exists()) {
                foreach ($re->get() as $v) {
                    $contentid[] = $v->contentid;
                }
                $model = new Content();
                $mycollection = $model->getMycollection($contentid);
                if ($mycollection) {
                    $support = new Support();
                    $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
                    if ($supports) {
                        $arr = [
                            'status' => 1,
                            'mycollection' => $mycollection,
                            'support' => $supports
                        ];
                    } else {
                        $arr = [
                            'status' => 1,
                            'mycollection' => $mycollection,
                            'support' => []
                        ];
                    }
                } else {
                    $arr = [
                        'status' => 1,
                        'mycollection' => [],
                        'support' => []
                    ];
                }
            } else {
                $arr = [
                    'status' => 1,
                    'mycollection' => []
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //用户发布文章（发布）上传图片
    public function uploadimg(Request $request)
    {
        //查看是否有图片上传
        if ($request->hasFile('image')) {
            //dd($request->hasFile('image'));
            $rootpath = './newadmin/Uploads/usercontent/';
            $filename = time().rand(1,9).rand(1,9).rand(1,9) . '.png';
            $request->file('image')->move($rootpath, $filename);
            $imgurl = trim($rootpath, '.') . $filename;
            $imgurl = str_replace('/newadmin/Uploads/','',$imgurl);
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


    //用户发布文章（发布）(fabutype=1)
    public function userrelease()
    {
//        $_POST['openid'] =  '1557122526';
//        $_POST['uid'] = '1557122526';
//        $_POST['typeid'] = 1;
//        $_POST['imgurl'] = 'http://127.0.0.1/upload/11.png';
//        $_POST['title'] = '河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天会消失，我就这一颗心，你看着伤吧！河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天，太阳总会下山，我的爱也有一天';
        if (isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['typeid']) && isset($_POST['title'])) {
            //提交发布
            $userinfo = DB::table('userinfo')
                ->where('uid', '=', $_POST['uid'])
                ->first();
            if($userinfo->name){
                $name = $userinfo->name;
            }else{
                $name = $userinfo->nickname;
            }

//            //判断是否存在域名
//            if(strpos($userinfo->pic, 'https') !== false){
//                $pic = $userinfo->pic;
//            }else{
//                $pic = 'https://duanju.58100.com'.$userinfo->pic;
//            }

            if($userinfo->photo){
                $photo = $userinfo->photo;
            }else{
                $photo = $userinfo->avatarurl;
            }
            $imgurl = $this->shengcheng($_POST['title'],$_POST['imgurl']);
            $datas=[
                'openid'=>$_POST['openid'],
                'uid'=>$_POST['uid'],
                'name'=>$name,
                'photo'=>$photo,
                'typeid'=>$_POST['typeid'],
                'title'=>$_POST['title'],
                'imgurl'=>isset($imgurl) ? $imgurl : '',
                'audit'=>2,//审核
                'fabutype'=>1,//用户发布的
                'recommended' => 1, //默认未推荐
                'time'=>time(),
                'date'=>date('Y-m-d H:i:s'),
            ];
            $content = DB::table('newcontent')
                    ->insertGetId($datas);
            if ($content) {
//                //查询该用户是否是第一次发布文章
//                $isfirstcontent = DB::table('content')
//                    ->where('uid', '=', $_POST['uid'])
//                    ->get();
//                if ($isfirstcontent->isEmpty()) {
//                    $newbeans = DB::table('userinfo')
//                        ->where('uid', '=', $_POST['uid'])
//                        ->first();
//                    //获取第一次点赞评论句豆
//                    $beans = $newbeans->newbeans;
//                    $new = DB::table('userinfo')
//                        ->where('openid', '=', $_POST['openid'])
//                        ->where('uid', '=', $_POST['uid'])
//                        ->update([
//                            'newbeans' => $beans+20
//                        ]);
//                    //记录句豆来源
//                    if($new){
//                        $datas = [
//                            'uid' => $_POST['uid'],
//                            'source' => 4,
//                            'time' => time(),
//                            'date' => date('Y-m-d',time()),
//                            'beans' => 20,
//                        ];
//                        DB::table('beansource')
//                            ->insert($datas);
//                    }
//                    $arr = [
//                        'status' => 1,
//                        'new' => 0,
//                        'contentid'=>$content,
//                        'info' => '发布成功'
//                    ];
//                }else{
//                    $beansource = DB::table('beansource')
//                        ->where('uid', '=', $_POST['uid'])
//                        ->where('source', '=', 4)
//                        ->first();
//                    //判断是否记录过第一次发布短句获取句豆
//                    if(!$beansource){
//                        $newbeans = DB::table('userinfo')
//                            ->where('uid', '=', $_POST['uid'])
//                            ->first();
//                        //获取第一次点赞评论句豆
//                        $beans = $newbeans->newbeans;
//                        $new = DB::table('userinfo')
//                            ->where('openid', '=', $_POST['openid'])
//                            ->where('uid', '=', $_POST['uid'])
//                            ->update([
//                                'newbeans' => $beans+20
//                            ]);
//                        //记录句豆来源
//                        if($new){
//                            $datas = [
//                                'uid' => $_POST['uid'],
//                                'source' => 4,
//                                'time' => time(),
//                                'date' => date('Y-m-d',time()),
//                                'beans' => 20,
//                            ];
//                            DB::table('beansource')
//                                ->insert($datas);
//                        }
//                        $arr = [
//                            'status' => 1,
//                            'new' => 0,
//                            'contentid'=>$content,
//                            'info' => '发布成功'
//                        ];
//                    }else {
//                        $arr = [
//                            'status' => 1,
//                            'new' => 1,
//                            'contentid' => $content,
//                            'info' => '发布成功'
//                        ];
//                    }
//                }
                $arr = [
                    'status' => 1,
                    'contentid'=>$content,
                    'imgurl' => $imgurl,
                    'typeid' => $_POST['typeid'],
                    'info' => '发布成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '发布失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //获取固定图片
    public function fixedpicture(){
        $picture = DB::table('picture')
            ->where('status', '=', 1)
            ->get();
        if($picture){
            $arr = [
                'status' => 1,
                'picture' => $picture
            ];
        }else{
            $arr = [
                'status' => 1,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //获取固定文字
    public function fixedtext(){
        $text = DB::table('short')
            ->where('status', '=', 1)
            ->get();
        if($text){
            $arr = [
                'status' => 1,
                'text' => $text
            ];
        }else{
            $arr = [
                'status' => 1,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //删除当前文章（status修改为2）
    public function delcontent(){
        if(isset($_POST['contentid'])){
            $model = new Content();
            $re=$model->delContent($_POST);
            if($re){
                $arr = [
                    'status' => 1,
                    'info' => '删除成功'
                ];
            }else{
                $arr = [
                    'status' => 0,
                    'info' => '删除失败'
                ];
            }
        }else{
            $arr = [
                'status' => 0,
                'info' => '缺少参数'
            ];
        }
        exit(json_encode($arr));
    }

    //生成海报
    public function shengcheng($text,$contentimg)
    {
//        Header("Content-type: image/png");
        //创建画布
        $background = imagecreatetruecolor(375,375);

        $contentimgs = 'https://duanju.58100.com/newadmin/Uploads/'.$contentimg;
//        $contentimgs = 'http://127.0.0.1/upload/11.png';
        $ext = getimagesize($contentimgs);
        $exname=explode('/',$ext['mime']);
        $exnames=$exname[1];
        switch ($exnames) {
            case 'jpg':
                $contentimg = imagecreatefromjpeg($contentimgs);
                break;
            case 'jpeg':
                $contentimg = imagecreatefromjpeg($contentimgs);
                break;
            case 'png':
                $contentimg = imagecreatefrompng($contentimgs);
                break;
        }

        //文章图片
        $array = getimagesize($contentimgs);
        $x_wz = $array[0];//图片宽
        $y_wz = $array[1];//图片高

        //绘制用户文章背景
        imagecopyresampled($background,$contentimg,0,0,0,0,375,375,$x_wz,$y_wz);


//        $text = "河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天会消失，我就这一颗心，你看着伤吧！河流总会干涸，树叶总会落尽，太阳总会下山，我的爱也有一天，太阳总会下山，我的爱也有一天";
        $text = $text;
        $text=mb_substr($text,0,50);
        $text = trim($text); //清除字符串两边的空格
        $text = preg_replace("/\t/","",$text); //使用正则表达式替换内容，如：空格，换行，并将替换为空。
        $text = preg_replace("/\r\n/","",$text);
        $text = preg_replace("/\r/","",$text);
        $text = preg_replace("/\n/","",$text);
        $text = preg_replace("/ /","",$text);
        $text = preg_replace("/  /","",$text);  //匹配html中的空格

        //文字换行设置行高
        $pos = ['top'=>128,
            'fontsize'=>20,
            'width'=>358,
            'left'=>10,
            'hang_size'=>40,
            'color'=>[0=>255, 1=>255, 2=>255]
        ];
        $iswrite = true;
        $fontpath = public_path("./font/simhei.ttf");
        $nowHeight = 0;
        $second = ['left'=>10, 'width'=>358, 'maxline'=>5];
        // $text = textalign($background_1,$pos,$text,);
        $this->textalign($background, $pos, $text, $iswrite,$fontpath,$nowHeight,$second);

//        imagepng($background);
        $path = './newadmin/Uploads/userfabu/' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
        Imagepng($background, $path);
        ImageDestroy($background);
        $imgurl = ltrim($path, '.');
        $imgurl = str_replace('/newadmin/Uploads/','',$imgurl);
//        $arr = [
//            'status' => 1,
//            'path' => $path,
//        ];
        return $imgurl;
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
}
