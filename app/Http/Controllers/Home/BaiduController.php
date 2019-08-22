<?php

namespace App\Http\Controllers\Home;

use App\Home\Comments;
use App\Home\Content;
use App\Home\Focus;
use App\Home\Support;
use App\Home\Type;
use App\Home\User;
use App\Home\Userinfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//使用门面
use Input;
use DB;
use Rediss;
class BaiduController extends Controller
{
    protected $table = 'user';//指定表明
    //用户登录接口
    public function dologin()
    {
//        $_POST['code'] = 'c41b09c7e22baba1b9ad92619330c81b';
        //echo $_POST['code'];exit;
//        if (Input::method() == 'POST') {
        if (isset($_POST)) {
            //解析code
//            var_dump($_POST);exit;
//            $public = new PublicController;
            $user = $this->UserInfo($_POST['code']);
//            var_dump($user);exit;
            $users = new User();
            $userone = $users->getuserone($user['openid']);
            //dd($userone);
            if ($userone) {
                $userinfo = array(
                    'status' => 1,
                    'openid' => $userone['openid'],
                    'session_key' => $user['session_key'],
                    'uid' => $userone['uid'],
                );
            } else {
                $uid = uniqid();
                $userinfos = $users->adduser($user['openid'], $uid);
                if ($userinfos) {
                    $userinfo = array(
                        'status' => 1,
                        'openid' => $userinfos['openid'],
                        'session_key' => $user['session_key'],
                        'uid' => $userinfos['uid'],
                    );
                } else {
                    $userinfo = array(
                        'status' => 0,
                        'info' => '获取用户信息失败'
                    );
                }
            }

        } else {
            //参数错误
            $userinfo = array(
                'status' => 0,
                'info' => '参数错误'
            );
        }
        exit(json_encode($userinfo, JSON_UNESCAPED_UNICODE));
    }

    //获取用户openid的信息
    public function UserInfo($code)
    {
        $appkey = 'LiUwpQnHnOdw5QZEbwNIKdUZawUCkWqh';
        $appsecret = 'BsecQWTaXuX2UPDB1tHtvreaLfGTjSIB';
        $post = ['code'=>$code,'client_id'=>$appkey,'sk'=>$appsecret];
        $url = "https://spapi.baidu.com/oauth/jscode2sessionkey";
//        $url = "https://spapi.baidu.com/oauth/jscode2sessionkey?code=$code&client_id=$appkey&sk=$appsecret&grant_type=authorization_code";
//        $curl = curl_init();
//
//        curl_setopt($curl, CURLOPT_URL, $url);
//        //设置是否输出header
//        curl_setopt($curl, CURLOPT_HEADER, 0);
//        //设置是否输出结果
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        //设置post方式提交
//        curl_setopt($curl, CURLOPT_POST, 1);
//        //设置是否检查服务器端的证书
////        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
//
//        if(curl_exec($curl) === false){
//            echo 'Curl error: ' . curl_error($curl);
//        }
//        //使用curl_exec()将curl返回的结果转换成正常数据并保存到一个变量中
//        $data = curl_exec($curl);
//        //关闭会话
//        curl_close($curl);
//        $user = json_decode($data, true);
//
//        return $data;
//        var_dump($user);exit;
//        return $user;

        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $res = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        $user = json_decode($res, true);
        return $user; // 返回数据，json格式
    }

    //授权之后获取用户信息
    public function getuserinfo()
    {
//        $_POST['encryptedData'] = 'yya9qajzgZpogJ6nN7I91tF/prCC4Dfiyg0gRqX0wv1BcS6gmJvWOzjKUF4R1QFXHUMRuv8c5SJdWKHj8ASbarnZGMbfTuXevOHEZNzy2g4i27ANXz5il1n6x2qrH63gXw5esMAxADIhU5JP3pOIiOt31LcUvuBXn/rAut0lKubKJWqnLIq/QjwcSaqAHRB8fhb1xfJW49YtZalD0LPkP/OfWyac6pkhLGBa7rpD1UKu87+aQBQJ6ukHBY80VQ5SplsjfcrT//Ifc7htlrldE6u5cgZHrdpJOP2D14CLbfR5T0ti7vSnnmeVwRYaMDsOthB8hPJxW9mSENQE8lrFfs8yitfSMbpufcG4L5MJDLk=';
//        $_POST['iv'] = '7f5b11305262e75740881w==';
//        $_POST['seesion_key'] = '7f5b11305262e757408815e1b4fd9099';
//        $_POST['uid'] = '5d491452e5d0e';
        if (isset($_POST['encryptedData']) && isset($_POST['iv']) && isset($_POST['seesion_key']) && isset($_POST['uid'])) {
            $userinfo = $this->decrypt($_POST['encryptedData'], $_POST['iv'], $_POST['seesion_key']);
            if ($userinfo) {
                $users = $this->baiduuserInfo($userinfo, $_POST['uid']);
                if ($users) {
                    $data = array(
                        'status' => 1,
                        'info' => '获取成功'
                    );
                } else {
                    $data = array(
                        'status' => 0,
                        'info' => '请从新获取'
                    );
                }
            } else {
                $data = array(
                    'status' => 0,
                    'info' => '获取失败'
                );
            }
        } else {
            $data = array(
                'status' => 0,
                'info' => '参数错误'
            );
        }
        exit(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    //授权获取用户的信息
    public function baiduuserInfo($data,$uid){
        $re=DB::table('userinfo')
            ->where('openid', $data['openid'])
            ->where('uid','=',$uid)
            ->exists();
        if($re){
            DB::table('userinfo')
                ->where('openid','=',$data['openid'])
                ->where('uid','=',$uid)
                ->update(
                    [
                        'nickname'=>$data['nickname'],
                        'gender' => $data['sex'],
                        'avatarurl' => $data['headimgurl'],
                        'usersorce' => 2,
                    ]
                );
            return true;
        }else{
            $datas = array(
                'openid' => $data['openid'],
                'uid' => $uid,
                'nickname'=>$data['nickname'],
                'gender' => $data['sex'],
                'avatarurl' => $data['headimgurl'],
                'usersorce' => 2,

            );
            $model = DB::table('userinfo')
                ->insert($datas);
            if($model){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * 数据解密：低版本使用mcrypt库（PHP < 5.3.0），高版本使用openssl库（PHP >= 5.3.0）。
     *
     * @param string $ciphertext    待解密数据，返回的内容中的data字段
     * @param string $iv            加密向量，返回的内容中的iv字段
     * @param string $app_key       创建小程序时生成的app_key
     * @param string $session_key   登录的code换得的
     * @return string | false
     */
    public function decrypt($ciphertext, $iv, $session_key) {
        $session_key = base64_decode($session_key);
        $iv = base64_decode($iv);
        $ciphertext = base64_decode($ciphertext);

        $plaintext = openssl_decrypt($ciphertext, "AES-192-CBC", $session_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

//        var_dump($plaintext);
        if($plaintext){
            // trim pkcs#7 padding
            $pad = ord(substr($plaintext, -1));
            $pad = ($pad < 1 || $pad > 32) ? 0 : $pad;
            $plaintext = substr($plaintext, 0, strlen($plaintext) - $pad);

            // trim header
            $plaintext = substr($plaintext, 16);
            // get content length
            $unpack = unpack("Nlen/", substr($plaintext, 0, 4));
            // get content
            $content = substr($plaintext, 4, $unpack['len']);
            // get app_key
            $app_key_decode = substr($plaintext, $unpack['len'] + 4);

            $dataObj=$app_key_decode ? $content : false;
            $dataObj=json_decode( $dataObj,true);
//            var_dump($plaintext);
            return $dataObj;
        }else{
            return false;
        }
    }


        //分类接口
    public function dotype()
    {
        //获取分类
        $type = new Type();
        $types = $type->getType();
        if ($types) {
            $arr = [
                'status' => 1,
                'type' => $types,
            ];
        } else {
            $arr = [
                'status' => 1,
                'type' => [],
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));

    }

    //首页获取
    public function doindex()
    {

        //获取内容
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['len']) ? $_POST['len'] : 10;
        $offset = ($page - 1) * $limit;
//        $_POST['uid'] = '1557122526';
        if ($_POST['typeid'] != '') {
            $type=DB::table('newtype')
                ->where('status','=','1')
                ->inRandomOrder()
                ->first();
            $type->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$type->pic;
//            $contents = $content->getContent($offset, $limit, $_POST['typeid']);
            $contents = DB::table('newcontent')
                //过滤掉已经禁用的类型文章
//                ->join('newtype', function ($join) {
//                    $join->on('newcontent.typeid', '=', 'type.id')
//                        ->where('newtype.status', '=', 1);
//                })
                ->where('typeid','=',$_POST['typeid'])
//                ->where('recommended','=',2)
                ->where('status','=',1)
                ->where('audit','=',2)
                ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
        } else {
            $type=DB::table('newtype')
                ->where('status','=','1')
                ->inRandomOrder()
                ->first();
            $type->pic = 'https://duanju.58100.com/newadmin/Uploads/'.$type->pic;
//            $contents = $content->getContents($offset, $limit);
            $contents = DB::table('newcontent')
                //过滤掉已经禁用的类型文章
//                ->join('newtype', function ($join) {
//                    $join->on('newcontent.typeid', '=', 'type.id')
//                        ->where('newtype.status', '=', 1);
//                })
//                ->where('recommended','=',2)
                ->where('status','=',1)
                ->where('audit','=',2)
                ->orderBy('download','desc')
                ->orderBy('newcontent.tjtime','desc')
                ->orderBy('newcontent.date','desc')
                ->offset($offset)
                ->limit($limit)
                ->get();
        }
//        var_dump($contents);exit;
        if (!$contents->isEmpty()) {
            foreach($contents as $value){
                //判断是否存在域名
                if(strpos($value->photo, 'https') !== false){
                    $value->photo = $value->photo;
                }else{
                    $value->photo = 'https://duanju.58100.com'.$value->photo;
                }
//                    $value->photo = 'https://duanju.58100.com/'.$value->photo;
                $value->imgurl = 'https://duanju.58100.com/newadmin/Uploads/'.$value->imgurl;
            }
            foreach ($contents as $v) {
                $contentid[] = $v->id;
            }
            if($contentid){
                $collection = DB::table('newcollection')
                    ->where('uid', '=', $_POST['uid'])
                    ->whereIn('contentid', $contentid)
                    ->get();
            }else{
                $collection = [];
            }
            if ($collection) {
                $arr = [
                    'status' => 1,
                    'contents' => $contents,
                    'collection' => $collection,
                    'type' => $type
                ];
            }else {
                $arr = [
                    'status' => 1,
                    'contents' => $contents,
                    'collection' => [],
                    'type' => $type
                ];
            }
        } else {
            $arr = [
                'status' => 1,
                'contents' => [],
//                'collection' => [],
                'type' => []
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }


    //发现（一周精选）
    public function selected()
    {
        $page = isset($_POST['page']) ? $_POST['page'] : 1;
        $limit = isset($_POST['len']) ? $_POST['len'] : 1;
        $offset = ($page - 1) * $limit;
        $model = new Content();
        $models = $model->getSelected($offset, $limit, $selected = 2);

        if ($models) {
            $support = new Support();
            foreach ($models as $v) {
                $contentid[] = $v->id;
            }
            $supports = $support->getContent($contentid, $_POST['openid'], $_POST['uid']);
            if ($supports) {
                $arr = [
                    'status' => 1,
                    'contents' => $models,
                    'supports' => $supports
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'contents' => $models,
                    'supports' => []
                ];
            }
        } else {
            $arr = [
                'status' => 1,
                'contents' => [],
                'supports' => []
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //发现（关注）
    public function focus()
    {
//        $_POST['openid']='otV6H5A0YDS8XYdI6hQHKm5P6hEw';
//        $_POST['uid']='5cd022665293d';
//        $_POST['page']=1;
        if (isset($_POST['openid']) && isset($_POST['uid'])) {
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $model = new Focus();
            $focus = $model->getFocusContent($_POST, $offset, $limit);
            if ($focus) {
                $content = new Content();
                //$contentss=[];
                $pages = 1;
                $limits = 5;
                $offsets = ($pages - 1) * $limit;
                foreach ($focus as $v) {
                    //$bopenid[]=$v->bopenid;//被关注人的openid
                    $contents = $content->getUserContentOne($v->bopenid, $v->buid, $offsets, $limits);
                    if ($contents) {
                        //$contentid[]=$v->id;
                        foreach ($contents as $kk => $vv) {
                            $support = new Support();
                            $supports = $support->isSupport($vv->id, $_POST['openid'], $_POST['uid']);
                            if ($supports) {
                                $issupport = 1;
                            } else {
                                $issupport = 0;
                            }
                            $contentss[] = [
                                //'id'=>$vv->id,
                                'nickname' => $v->nickname,
                                'avatarurl' => $v->avatarurl,
                                'photo' => $v->photo,
                                'name' => $v->name,
                                'note' => $v->note,
                                'issupport' => $issupport,
                                //'comments'=>$vv->comments,
                                'contents' => $vv,
                            ];
                        }
                    }
                }
                $arr = [
                    'status' => 1,
                    'contents' => $contentss,
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'contents' => [],
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr));
    }

    //通过id获取当前文章
    public function contentone()
    {
        if (isset($_POST['id']) && isset($_POST['openid']) && isset($_POST['uid'])) {
            $model = new Content();
            $models = $model->getContentOne($_POST['id']);
            $supports = DB::table('support')
                ->where('contentid', '=', $_POST['id'])
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->first();
            if ($supports) {
                $support = 1;
            } else {
                $support = 0;
            }
            $collections = DB::table('collection')
                ->where('contentid', '=', $_POST['id'])
                ->where('openid', '=', $_POST['openid'])
                ->where('uid', '=', $_POST['uid'])
                ->first();
            if ($collections) {
                $collection = 1;
            } else {
                $collection = 0;
            }
            if ($models) {
                $arr = [
                    'status' => 1,
                    'content' => $models,
                    'dianji' => $support,
                    'collection' => $collection,
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'content' => [],
                    'dianji' => $support,
                    'collection' => $collection,
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //获取评论
    public function comments()
    {
        if (isset($_POST['id']) && isset($_POST['openid']) && isset($_POST['uid'])) {
            //获取当前文章的评论
            $comment = new Comments();
            $page = isset($_POST['page']) ? $_POST['page'] : 1;
            $limit = isset($_POST['len']) ? $_POST['len'] : 10;
            $offset = ($page - 1) * $limit;
            $commentss = $comment->getComments($_POST['id'], $offset, $limit);
            //判断用户有没有对该评论点过赞
            if ($commentss) {
                foreach ($commentss as $v) {
                    $commentsid[] = $v->id;//评论的id
                }
                //获取评论过的文章的id
                $re = DB::table('commentsupport')
                    ->select('commentsid')
                    ->where('openid', '=', $_POST['openid'])
                    ->where('uid', '=', $_POST['uid'])
                    ->whereIn('commentsid', $commentsid);
                if($re->exists()){
                    $arr = [
                        'status' => 1,
                        'comments' => $commentss,
                        'issupport'=>$re->get()
                    ];
                }else{
                    $arr = [
                        'status' => 1,
                        'comments' => $commentss,
                        'issupport'=>[]
                    ];
                }
            } else {
                $arr = [
                    'status' => 1,
                    'comments' => [],
                    'issupport'=>[]
                ];
            }

        } else {
            $arr = [
                'status' => 0,
                'info' => '缺少参数',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //统计点赞
    public function support()
    {
        if (isset($_POST['id']) && isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['bopenid']) && isset($_POST['buid'])) {
            $model = new Content();
            $support = new Support();
            $userinfo=new Userinfo();

            //获取点赞表里面该用户有没有点过赞
            $isfirstsupport = DB::table('support')
                    ->where('uid', '=', $_POST['uid'])
                    ->get();
            //获取评论表里面该用户有没有评论
            $isfirstcomments = DB::table('support')
                ->where('uid', '=', $_POST['uid'])
                ->get();

            DB::beginTransaction();
            $supports = $support->addsupport($_POST);
            $models = $model->addsupport($_POST['id']);
            //统计用户被点赞次数
            $userinfos=$userinfo->addsupport($_POST);
            if ($models && $supports && $userinfos) {
                DB::commit();
                //修改用户表的状态为消息提醒
//                $user = DB::table('content')
//                    ->select('openid', 'uid')
//                    ->where('id', '=', $_POST['id'])
//                    ->first();
                DB::table('userinfo')
                    ->where('openid', '=', $_POST['bopenid'])
                    ->where('uid', '=', $_POST['buid'])
                    ->update([
                        'tix' => 1
                    ]);
                //获取用户的昵称
//                $userone = DB::table('userinfo')
//                    ->select('name', 'nickname')
//                    ->where('openid', '=', $_POST['openid'])
//                    ->first();
//                if($userone->name){
//                    //发送模板消息
//                    $send=new SendController();
//                    $send->send($_POST['bopenid'],$userone->name,$_POST['id']);
//                }else{
//                    //发送模板消息
//                    $send=new SendController();
//                    $send->send($_POST['bopenid'],$userone->nickname,$_POST['id']);
//                }
                //如果该用户第一次点赞或评论加20句豆
                if ($isfirstsupport->isEmpty() || $isfirstcomments->isEmpty()) {
                    DB::table('userinfo')
                        ->where('openid', '=', $_POST['openid'])
                        ->where('uid', '=', $_POST['uid'])
                        ->update([
                            'newbeans' => 20
                        ]);
                    $arr = [
                        'status' => 1,
                        'new' => 0,
                        'info' => '点赞成功'
                    ];
                }else{
                    $arr = [
                        'status' => 1,
                        'new' => 1,
                        'info' => '点赞成功'
                    ];
                }

            } else {
                DB::rollBack();
                $arr = [
                    'status' => 1,
                    'contents' => '点赞失败'
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

    //拉新
    public function newfans()
    {
        $uid = '5cd02244bb62f';
        $openid = 'otV6H5A4WYGj_wUjENju8gtJa7TA';
        $fuid = '1557122526';
        $type = 1;
//        if (isset($_POST['contentid']) && isset($_POST['openid']) && isset($_POST['uid']) && isset($_POST['fuid']) && isset($_POST['fopenid'])) {
            $re = DB::table('user')
                ->where('uid', '=', $uid)
                ->where('openid', '=', $openid)
                ->first();

            $fid = $re->fuid;//获取该用户的父id
//            var_dump($fid);exit;
            DB::beginTransaction();
           if($fid == null){
               DB::commit();
               DB::table('user')
                   ->where('openid', '=', $openid)
                   ->where('uid', '=', $uid)
                   ->update([
                       'fuid' => $fuid,
                       'type' => $type
                   ]);
               //userinfo表fans字段自增1
               DB::table('userinfo')
                   ->where('uid','=',$fuid)
                   ->increment('fans');
//               var_dump($fans);exit;

               //查询用户详情表里面通过拉新获取的豆子
               $res = DB::table('userinfo')
                   ->where('uid', '=', $fuid)
                   ->first();
               //该父id拉新数量
               $fan = $res->fans;
               //该父id通过拉新获取到的已有句豆
               $bean = $res->beans;
               //记录该用户是第几个粉丝
               DB::table('user')
                   ->where('openid', '=', $openid)
                   ->where('uid', '=', $uid)
                   ->update([
                       'rank' => $fan
                   ]);
               //判断拉新数量给句豆
               if($fan <= 5){
                   $beans = 10;
               }elseif ($fan>5 && $fan<=10){
                   $beans = 15;
               }elseif ($fan>10 && $fan<=20){
                   $beans = 20;
               }elseif ($fan>20 && $fan<=50){
                   $beans = 25;
               }
               //计算总拉新句豆
               $bea = $bean+$beans;
//               var_dump($bea);exit;
               //更新句豆
               DB::table('userinfo')
                   ->where('uid', '=', $fuid)
                   ->update([
                       'beans' => $bea
                   ]);
               $arr = [
                   'status' => 1,
                   'contents' => '拉新成功'
               ];
           }else{
               DB::rollBack();
               $arr = [
                   'status' => 0,
                   'contents' => '拉新失败'
               ];
           }
            exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
//        }
    }

    //获取判断有没有name
    public function name()
    {
        $uid = $_POST['uid'];
//        $uid = '1557122526';
        $user = DB::table('userinfo')
            ->where('uid', '=', $uid)
            ->first();
        $name = $user->name;
        if($name == ''){
            $name = '';
        }else{
            $name = $user->name;
        }
        return $name;
//        var_dump($name);exit;
    }

    public function test()
    {
        $uid = '5ce2ce62638a2';


        $page=isset($_POST['page']) ? $_POST['page'] : 1;
        $limit=isset($_POST['len']) ? $_POST['len'] : 10;
        $offset=($page-1)*$limit;
        $user = DB::table('user')
            ->select('user.openid','user.uid','user.type','user.rank','user.fuid')
            ->where('user.fuid','=',$uid)
            ->get();

        foreach($user as $k=>$v){
            $uid = $v->uid;

            $userinfo = DB::table('userinfo')
                ->select('userinfo.openid','userinfo.uid','userinfo.photo','userinfo.name','userinfo.nickname','userinfo.avatarurl','userinfo.avatarurl')
                ->where('userinfo.uid','=',$uid)
                ->first();
//            var_dump($userinfo);exit;
            if($userinfo == null){
                $res[] = [
                    //'id'=>$vv->id,
                    'nickname' => '',
                    'avatarurl' => '',
                    'photo' => '',
                    'name' => '',
                    'type' => $v->type,
                    'rank' => $v->rank
                ];

            }else{
                $res[] = [
                    'nickname' => $userinfo->nickname,
                    'avatarurl' => $userinfo->avatarurl,
                    'photo' => $userinfo->photo,
                    'name' => $userinfo->name,
                    'type' => $v->type,
                    'rank' => $v->rank
                ];
            }
        }
        $count = count($res);
        $arr = [
            'status' => 1,
            'count' => $count,
            'info' => $res,
        ];

        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //查询(发现页)
    public function query()
    {
        $result = DB::table('userinfo')
            ->get();
        foreach ($result as $a=>$b){
            var_dump($b->uid);

            $isfirstsupport = DB::table('support')
                ->where('uid', '=', $b->uid)
                ->get();
            $isfirstcomments = DB::table('comments')
                ->where('uid', '=', $b->uid)
                ->get();
            //判断是否点过赞并且没有评论过
            if ($isfirstsupport->isEmpty() && $isfirstcomments->isEmpty()) {
                $arr = [
                    'status' => 0,
                    'info' => '未点过赞或评论'
                ];
            }else{
                DB::table('userinfo')
                    ->where('uid', '=', $b->uid)
                    ->update([
                        'newbeans' => 20+$b->newbeans,
                    ]);
                $datas = [
                    'uid' => $b->uid,
                    'source' => 2,
                    'time' => time(),
                    'date' => date('Y-m-d',time()),
                    'beans' => 20,
                ];
                DB::table('beansource')
                    ->insert($datas);
            }
        }exit;
//        var_dump($result);exit;
        if(isset($_POST['uid'])) {

            $isfirstsupport = DB::table('support')
                ->where('uid', '=', $_POST['uid'])
                ->get();
            $isfirstcomments = DB::table('comments')
                ->where('uid', '=', $_POST['uid'])
                ->get();
            //判断是否点过赞并且没有评论过
            if ($isfirstsupport->isEmpty() && $isfirstcomments->isEmpty()) {
                $arr = [
                    'status' => 0,
                    'info' => '未点过赞或评论'
                ];
            }else{
                DB::table('userinfo')
                    ->where('uid', '=', $uid)
                    ->update([
                        'newbeans' => 20,
                    ]);
            }
        }else{
            $arr = [
                'status' => 0,
                'beans' => '',
                'info' => '查询失败'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    public function querys(){
        if(isset($_POST['uid'])) {
            $uid = $_POST['uid'];
            $isfirstsupport = DB::table('support')
                ->where('uid', '=', $uid)
                ->get();
            $isfirstcomments = DB::table('comments')
                ->where('uid', '=', $uid)
                ->get();
            //判断是否点过赞并且没有评论过
            if ($isfirstsupport->isEmpty() && $isfirstcomments->isEmpty()) {
                $arr = [
                    'status' => 0,
                    'info' => '未点过赞或评论'
                ];
            } else {
                $arr = [
                    'status' => 1,
                    'info' => '已完成'
                ];
            }
        }else{
            $arr = [
                'status' => 0,
                'beans' => '',
                'info' => '查询失败'
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    public function tests(){
        $uid = '111';
        $a = 2;
        $b = 2;
        $uidredis = Rediss::get('uid');
        var_dump($uidr);
        if($uidredis){
            var_dump("正在进行签到操作，请勿重复操作！");
        }else{
            var_dump(2);
            if($a == 2){
                $uidre = Rediss::setex('uid',60,$uid);
                if($b == 2){
                    var_dump("签到成功");
                    //签到成功清除redis
                    Rediss::delete('uid');
                }
            }
        }
//        $uidredis = Rediss::setex('uid',60,$uid);
//        $uidredis = Rediss::setex('uid',60,$uid);
//        Rediss::delete('uid');
//        if (!$uidredis){
//            Rediss::delete('uid');
//        }else{
//            var_dump($uidredis);
//        }

    }
}
