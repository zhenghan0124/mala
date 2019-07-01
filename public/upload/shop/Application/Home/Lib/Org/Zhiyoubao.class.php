<?php
/**
 * 智游宝接口
 * Created by PhpStorm.
 * User: leijuly
 * Date: 2017/10/26
 * Time: 9:19
 */
namespace  Lib\Org;

class Zhiyoubao
{
    private $url = 'boss.zhiyoubao.com/boss/service/code.htm';
    //private $url = 'http://zyb-zff.sendinfo.com.cn/boss/service/code.htm';
    public $corpCode;//企业码
    public $userName; //用户名
    public $sKey;//企业私钥

    public function __construct($params)
    {
        if ($params['corpCode']) {
            $this->corpCode = $params['corpCode'];
        }
        if ($params['userName']) {
            $this->userName = $params['userName'];
        }
        if ($params['sKey']) {
            $this->skey = $params['sKey'];
        }
    }

    /*
     * 签名
     */
    private function makeSign($xml)
    {
        return md5('xmlMsg=' . $xml . $this->skey);
    }
    //校验签名
    public function verifySign($data)
    {
        $sign = $data['sign'];
        unset($data['sign']);
        foreach ($data AS $k => $v) {
            $string = $k . '=' . $v;
        }
        if ($sign != md5($string . $this->skey)) {
            die('签名错误');
        }
        return true;
    }

    public function http_post($post)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno:' . curl_error($ch);
            die;
        }
        curl_close($ch);
        $result = json_decode(json_encode(simplexml_load_string($response)), true);
        return $result;
    }

    public function call($params)
    {
        $reqtime = date('Y-m-d');
        $xml_ext = array2xml($params);
        $data['xmlMsg'] = <<<XML
<PWBRequest>
    <transactionName>{$params['transactionName']}</transactionName>
    <header>
        <application>SendCode</application>
        <requestTime>{$reqtime}</requestTime>
    </header>
    <identityInfo>
        <corpCode>{$this->corpCode}</corpCode>
        <userName>{$this->userName}</userName>
    </identityInfo>
    <orderRequest>
        <order>
            {$xml_ext}
        </order>
    </orderRequest>
</PWBRequest>
XML;
        $data['sign'] = $this->makeSign($data['xmlMsg']);
        $resp = $this->http_post($data);
        
        return $resp;
    }
}

if (!function_exists('array2xml')) {
//数组转XML
    function array2xml($arr, $level = 1)
    {
        $s = '';
        foreach ($arr as $tagname => $value) {
            if ($tagname == 'transactionName') {
                continue;
            }
            if (is_numeric($tagname)) {
                $tagname = $value['TagName'];
                unset($value['TagName']);
            }
            if (!is_array($value)) {
                $s .= "<{$tagname}>" . $value . "</{$tagname}>";
            } else {
                $s .= "<{$tagname}>" . array2xml($value, $level + 1) . "</{$tagname}>";
            }
        }
        $s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
        return $s;
    }
}
/*
$config = ['corpCode' => 'sdzfxgjbl', 'userName' => 'gjbl', 'sKey' => '33558871ABA445D5A50A6FC0BF828088'];
$config = ['corpCode' => 'TESTFX', 'userName' => 'whbz', 'sKey' => 'TESTFX'];
$zhiyoubao = new Zhiyoubao($config);
$orderCode = date('YmdHis') . rand(1000, 9999);
$occDate = date('Y-m-d');
$credentials = ['credential' => ['name' => '王卯卯', 'id' => '330182198804273139']];
$credentials = '';
$goodscode = 'PST20170803015684';
$goodscode = 'PST20171102016389';
$params = ['transactionName' => 'SEND_CODE_REQ', 'certificateNo' => '330182198804273139', 'linkName' => '接口测试', 'linkMobile' => '13625814109', 'orderCode' => $orderCode, 'orderPrice' => 200.00, 'groupNo' => '', 'payMethod' => 'vm', 'ticketOrders' => ['ticketOrder' => ['orderCode' => $orderCode, 'credentials' => $credentials, 'price' => 200.00, 'quantity' => 1, 'totalPrice' => 200.00, 'occDate' => $occDate, 'goodsCode' => $goodscode, 'goodsName' => '测试', 'remark' => '']]];
//var_dump(json_encode($params, JSON_UNESCAPED_UNICODE));
$resp = $zhiyoubao->call($params);
var_dump($resp);*/