<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rediss;
class PublicController extends Controller
{

    //获取token
    public function getAccent_token()
    {
        $tokens=Rediss::get('access_token');
        if($tokens){
            return $tokens;
        }else{
            $appid = config('app.appid');
            $appsecret = config('app.appsecret');
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

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
            //echo $token;
//            $tokens=Rediss::setex('access_token',2*60*60,$token);
            Rediss::setex('access_token',2*60*60,$token);
            return $token;
        }
    }

    //获取用户openid的信息
    public function getUserInfo($code)
    {
        $appid = config('app.appid');
        $appsecret = config('app.appsecret');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$code&grant_type=authorization_code";
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
        $user = json_decode($data, true);
        //var_dump($user);exit;
        return $user;
    }
    //获取用户的openid
    public function getOpenID($code)
    {
        $userInfo = $this->getUserInfo($code);
        $openid = $userInfo['openid'];
        //var_dump($userInfo);exit;
        return $openid;
    }
    //用户授权
    public function decryptData($encryptedData, $iv, $seesion_key )
    {
        $aesKey=base64_decode($seesion_key);
        $aesIV=base64_decode($iv);
        $aesCipher=base64_decode($encryptedData);
        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        if($result){
            $dataObj=json_decode( $result,true);
            return $dataObj;
        }else{
            return false;
        }
    }
}
