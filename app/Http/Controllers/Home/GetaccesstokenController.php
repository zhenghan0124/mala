<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rediss;
class GetaccesstokenController extends Controller
{
    //信息流资源
    public function information()
    {
        //获取token
        $access_token = $this->getAccent_token();
//        var_dump($access_token);
        $appid = '16958636';
        $title = '麻辣短句,说到心坎的句子';
        $body = '麻辣短句给你温暖人心的句子；麻辣短句可以将短句合成在精美图片上；并提供各种类型的美图；比如早安，日签，祝福等；来麻辣短句寻找那些触及心灵的句子和美图吧！';
        $path = 'pages/index/index';
        $images = ['https://duanju.58100.com/newadmin/Uploads/201908/5d4a6e1536dfa.png', 'https://duanju.58100.com/newadmin/Uploads/201908/5d4a6e045e35f.png'];
        $mapp_type = '1000';
        $mapp_sub_type = '1001';
        $feed_type = '情感';
        $feed_sub_type = '恋爱、正能量、鸡汤、情感故事、励志、人际关系';
        $tags = '麻辣短句给你温暖人心的句子；麻辣短句可以将短句合成在精美图片上；并提供各种类型的美图；比如早安，日签，祝福等；来麻辣短句寻找那些触及心灵的句子和美图吧！';
        $ext = '{"publish_time": "2019年8月8日"}';

        $datas = array(
            'app_id'=>$appid,
            'title'=>$title,
            'body'=>$body,
            'path'=>$path,
            'images'=>$images,
            'mapp_type'=>$mapp_type,
            'mapp_sub_type'=>$mapp_sub_type,
            'feed_type'=>$feed_type,
            'feed_sub_type'=>$feed_sub_type,
            'tags'=>$tags,
            'ext'=>$ext
        );
        var_dump($datas);
        $url = "https://openapi.baidu.com/rest/2.0/smartapp/access/submitresource?access_token=$access_token";
        var_dump($url);
        $curl = curl_init(); // 启动一个CURL会话

//        curl_setopt($curl, CURLOPT_URL, $url); //2.请求地址
//
//        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datas));//3.请求方式
//        //设置是否输出header
//        curl_setopt($curl, CURLOPT_HEADER, 0);
//        //设置是否输出结果
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        //设置是否检查服务器端的证书
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
//        $data = curl_exec($curl);
//        //关闭会话
//        curl_close($curl);
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($datas)); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $res = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
//        curl_close($curl); // 关闭CURL会话
//        $result = json_decode($data, true);
        header("Content-type: text/html; charset=utf-8");
        return $res; // 返回数据，json格式
    }

    //获取token
    public function getAccent_token()
    {
//        $tokens=Rediss::get('baidu_access_token');
//        if($tokens){
//            return $tokens;
//        }else{
            $appkey = 'LiUwpQnHnOdw5QZEbwNIKdUZawUCkWqh';
            $appsecret = 'BsecQWTaXuX2UPDB1tHtvreaLfGTjSIB';
            $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=$appkey&client_secret=$appsecret";

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
            $accens_token = json_decode($data, true);
            $token = $accens_token['access_token'];
//            echo $token;
//            $tokens=Rediss::setex('access_token',2*60*60,$token);
//            Rediss::setex('baidu_access_token',1,$token);
            return $token;
//        }
    }
}
