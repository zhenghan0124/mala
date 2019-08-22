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
class TestwxpayController extends Controller
{

    public function wxpay() {
        //统一下单接口
        $return = $this->weixinapp();
        return $return;
    }


    //统一下单接口
    private function unifiedorder() {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
		$jjc=$this->createNoncestr();
        $parameters = array(
            'appid' => 'wx0b214ca08babc1a3',
            'body' => '测试支付',
            'mch_id' => '1542149431',
            'nonce_str' => $jjc,
            'notify_url' => 'https://duanju.58100.com/home/index/yibu',
            'openid' => 'otV6H5A0YDS8XYdI6hQHKm5P6hEw', 
            'out_trade_no'=> '123456',
            'spbill_create_ip' => 'https://duanju.58100.com',//授权目录的ip地址
            'total_fee' => 100,
            'trade_type' => 'JSAPI'
        );
	$t="appid=wx0b214ca08babc1a3&body=测试支付&mch_id=1542149431&nonce_str=".$jjc."&notify_url=https://duanju.58100.com/home/index/yibu&openid=otV6H5A0YDS8XYdI6hQHKm5P6hEw&out_trade_no=123456&spbill_create_ip=https://duanju.58100.com&total_fee=100&trade_type=JSAPI"; 
    $t=$t."&key=5eqZBU4Jr88u1IHMCqXCPC9ZlqtUxhmc ";
	$sign=strtoupper(md5($t));
	$parameters['sign']=$sign;
        $xmlData = $this->arrayToXml($parameters);
        $return = $this->xmlToArray($this->postXmlCurl($xmlData, $url, 60));
        return $return;
    }


    private static function postXmlCurl($xml, $url, $second = 30) 
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);


        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        set_time_limit(0);


        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WxPayException("curl出错，错误码:$error");
        }
    }
    
    
    
    //数组转换成xml
    private function arrayToXml($arr) {
        $xml = "<root>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</root>";
        return $xml;
    }


    //xml转换成数组
    private function xmlToArray($xml) {


        //禁止引用外部xml实体 


        libxml_disable_entity_loader(true);


        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);


        $val = json_decode(json_encode($xmlstring), true);


        return $val;
    }


    //微信小程序接口
    private function weixinapp() {
        //统一下单接口
        $unifiedorder = $this->unifiedorder();
//        print_r($unifiedorder);
	$jjc=$this->createNoncestr();
        $parameters = array(
            'appid' => 'wx0b214ca08babc1a3',
	    	'nonceStr' => $jjc, //随机串
            'package' => 'prepay_id=' . $unifiedorder['prepay_id'], //数据包
            'signType' => 'MD5',//签名方式
            'timeStamp' => '' . time() . '' //时间戳
        );
        //签名
	$t="appId=wx0b214ca08babc1a3&nonceStr=".$jjc."&package=prepay_id=".$unifiedorder['prepay_id']."&signType=MD5&timeStamp=".time(); 
        $t=$t."&key=*************************";
	$sign=strtoupper(md5($t));
        $parameters['paySign'] = $sign;
        return $parameters;
    }


    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    //作用：生成签名
    private function getSign($Obj) {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $this->key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }


    ///作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

}
