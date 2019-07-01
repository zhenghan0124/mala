<?php
/*
* 西软微信协议接口
* by zhoulei 2015-06-07
*/
// namespace Org\Util;
ini_set('soap.wsdl_cache_enabled', 0); // disabling WSDL cache
ini_set('soap.wsdl_cache_ttl', 0);
ini_set('default_socket_timeout', 30);
libxml_disable_entity_loader(false);

class xrapi
{
    public $url = 'http://218.108.96.222:20002/PMSDataInterface/ReservationService/?wsdl';// 正式地址
//  public $memberUrl = 'http://218.108.96.222:20002/PMSDataInterface/MemberService/?wsdl';//正式地址
    public $client;
    public $openid;
    public $username;
    public $password;

    public function __construct($params = array())
    {
        global $_W;
        if (empty($params)) {
            die('初始化参数不能为空');
        }
        //接口地址
        if ($params['url'] != '') {
            $this->url = $params['url'];
        }
        //调用会员接口
        if ($params['member_model'] == 1) {
            $this->url = str_replace('ReservationService', 'MemberService', $this->url);
        }
        //检查接口地址连通性
        /*if($this->_httpcode($this->url)!=200){
            die('接口地址不可用，请联系管理员');
        }*/
        try {
            $this->openid = $params['openid'] ?: $_W['openid'];
            $this->username = $params['username'];
            $this->password = $params['password'];
            //测试帐号
            //$this->username = 'DFSdGoxv8aJ3kERUuZtAaQ==';
            //$this->password = 'zvfIj3+443BaMLFMiveGFA==';
            $this->client = new SOAPClient($this->url, array('trace' => 1, 'soap_version' => SOAP_1_1));

            $this->client->soap_defencoding = 'UTF-8';
            $this->client->xml_encoding = 'UTF-8';
        } catch (SOAPFault $e) {
            return false;
        }
        //print_r($this->client->__getFunctions());
        //print_r($this->client->__getTypes());
    }

    private function _httpcode($url)
    {
        $ch = curl_init();
        $timeout = 3;
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
        return $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    }

    //房型列表  1017
    public function SearchRoomType()
    {
        try {
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1017);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('SearchRoomType', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->SearchRoomTypeResult);
            return $respArr['Body']['ResponseBodyRmtype']['Rmtype'];
        } catch (SOAPFault $e) {
            //var_dump($this->client->__getLastRequest());
            echo $e->getMessage();
        }
    }

    //房价查询 无协议价 1014
    public function GetRmRate($ext)
    {
        try {
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1014, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('GetRmRate', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->GetRmrateResult);
            if ($respArr['Head']['retcode'] != 0) {
                // load()->func('logging');
                // logging_run('GetRmRate:'.$ext.' resp:'.var_export( $respArr,true ), 'error', 'xr');
                return false;
            }
            return $respArr['Body']['ResponseBodyRmrate']['Rmrate'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //预订  1009
    public function Reservation($ext)
    {
        try {
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1009, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('Reservation', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->ReservationResult);
            if ($respArr['Body']['ReservationResponse']['Reservation'] == '') {
                return $respArr;
            }
            return $respArr['Body']['ReservationResponse']['Reservation'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //预订查询 1011
    public function GetReservationDetail($ext, $openid = '')
    {
        try {
            if ($openid) {
                $this->openid = $openid;
            }
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1011, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('GetReservationDetail', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->GetReservationDetailResult);
//             var_dump($respArr);
            return $respArr['Body']['ReservationResponses']['ReservationResponse'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //客人订单查询 1043
    public function GuestOrderQuery($ext, $openid = '')
    {
        try {
            if ($openid) {
                $this->openid = $openid;
            }
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1043, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('GuestOrderQuery', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->GetReservationDetailResult);
//             var_dump($respArr);
            return $respArr['Body']['Reservations']['Reservation'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //微信支付确认 1031
    public function ReservationCashment($ext)
    {
        try {
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1031, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('ReservationCashment', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->ReservationCashmentResult);
            if (!$respArr) {
                return $response;
            }
            return $respArr;
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //房价信息查询(旧版本,不带协议单位查询的用这个协议) 1008
    public function RateQuery($ext)
    {
        try {
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1008, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('RateQuery', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->RateQueryResult);
            if (!$respArr) {
                return $response;
            }
            return $respArr['Body']['record'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //协议信息校验 1018
    public function CheckCusNo($ext)
    {
        try {
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1018, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('CheckCusNo', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->CheckCusNoResult);
            if (!$respArr['Head']) {
                return $response;
            }
            return $respArr['Head'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //房价信息查询 协议价 1020
    public function RateQueryByCusNo($ext)
    {
        try {
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1020, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('RateQueryByCusNo', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->RateQueryByCusNoResult);
            if (!$respArr) {
                return $response;
            }
            return $respArr['Body']['record'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //取消预订 1010
    public function ResCancel($ext)
    {
        try {
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1010, $ext);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('ResCancel', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->ResCancelResult);
            if (!$respArr) {
                return $response;
            }
            //["Code"]=> string(5) "00001" ["Descript"]=> string(12) "取消成功"
            return $respArr['Body']['Result']['ResultObject'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //选定房号 1055
    public function SelectRoomno($ext)
    {
        try {
            $ext_xml = <<<XML
	<confirmationID>{$ext['confirmationid']}</confirmationID>
    <room>{$ext['room_no']}</room>
XML;
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1055, $ext_xml);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('SelectRoomno', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->SelectRoomnoResult);
            if (!$respArr) {
                return $response;
            }
            return $respArr['Head'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //根据房价号&证件信息 校验客人是否为住店客人  1067
    public function CheckGuestLegal($ext)
    {
        try {
            $ext_xml = <<<XML
	<RequestBody>
		<roomno>{$ext['roomno']}</roomno>		//房间号
		<ident>{$ext['ident']}</ident>  //身份证号的后N位
	</RequestBody>
XML;
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1067, $ext_xml);//创建服务端要求传递的对象
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            $response = $this->client->__soapCall('CheckGuestLegal', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            $respArr = $this->simplest_xml_to_array($response->CheckGuestLegalResult);
            if (!$respArr) {
                return $response;
            }
            return $respArr['Head'];
        } catch (SOAPFault $e) {
            echo $e->getMessage();
        }
    }

    //会员信息查询
    public function GetMemberInfo($params)
    {
        $ext_xml = <<<XML
			 <MemberQuery>
<AccountID>{$params['card']}</AccountID>//没有openid，则取AccountID的值  卡号
</MemberQuery>
XML;
        $struct = new SoapStruct($this->username, $this->password, $this->openid, 1003, $ext_xml);//创建服务端要求传递的对象
        $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
        $response = $this->client->__soapCall('GetMemberInfo', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法

        $respArr = $this->simplest_xml_to_array($response->GetMemberInfoResult);
        if (!$respArr) {
            return $response;
        }
        return $respArr;
    }

    //会员注册
    public function Register($params)
    {
        global $_W;
        // if (preg_match("/[\x7f-\xff]/", $params['realname'])) {
        //     //中文
        //     $name = xingshi($params['realname']);//拆分姓名
        //     $lastName = $name[0];
        //     $firstName = $name[1];
        // } else {
        //     //英文名
        //     $name = explode(' ', $params['realname']);
        //     $firstName = $name[0];
        //     $lastName = $name[1];
        // }
        $gender = $params['gender'] == 1 ? 'MALE' : 'FEMALE';
        $genderTitle = $params['gender'] == 1 ? 'Mr' : 'Ms';
        $countryCode = in_array($_W['uniacid'], [11, 62, 142, 274]) ? 'CN' : 'CNH';//国家代码 歌德特殊处理
        $ext_xml = <<<XML
			<Profile profileType="GUEST" gender="{$gender}">//性别 男性MALE、女性FEMALE
      <IndividualName>
        <!-- 会员姓名信息-->
        <nameTitle>{$genderTitle}</nameTitle>  //根据性别来确定Mr,Ms
        <nameFirst>{$params['surname']}</nameFirst>  //姓
        <nameSur>{$params['name']}</nameSur>    //名
      </IndividualName>	 
      <primaryLanguageID>C</primaryLanguageID>
      <Memberships>
        <Membership>
          <programCode>{$params['programCode']}</programCode> //根据微信网站设置的卡类型值
          <VipTag>N</VipTag>
          <programType>{$params['programType']}</programType> //根据微信网站设置的卡等级值
          <password>{$params['password']}</password>//注册会员密码
        </Membership>
      </Memberships>
      <PhoneNumbers>
        <PhoneNumber phoneNumberType="HOME">
          <phoneNumber>{$params['mobile']}</phoneNumber>  //手机号码
          <mfPrimaryYN>Y</mfPrimaryYN>//固定值为Y
        </PhoneNumber>
      </PhoneNumbers>
      <ElectronicAddresses>//EMAIL 地址
        <ElectronicAddress electronicAddressType="EMAIL">
          <eAddress>{$params['email']}</eAddress>
        </ElectronicAddress>
      </ElectronicAddresses>
</Profile>
XML;

// print_r($ext_xml);exit;
        $struct = new SoapStruct($this->username, $this->password, $this->openid, 1002, $ext_xml);//创建服务端要求传递的对象
        $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
        $response = $this->client->__soapCall('Register', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
//        var_dump($response);
        $respArr = $this->simplest_xml_to_array($response->RegisterResult);
        if (!$respArr) {
            return $response;
        }
        return $respArr;
    }

    //会员卡登录
    public function UserLogin($params)
    {
        try {
            $ext_xml = <<<XML
<LoginObject>
<ID>K000011</ID>                          //卡号
<Password>123456</Password>               //密码
<Logintype>LOG_CARD</Logintype>   //登录方式 LOG_CARD(卡号)
<Cardtype>1</Cardtype>                //卡类别
</LoginObject>
XML;

// var_dump($ext_xml);exit;
            $xmlName = 'loginXml';
            $struct = new SoapStruct($this->username, $this->password, $this->openid, 1001, $ext_xml, $xmlName);//创建服务端要求传递的对象
            // var_dump($struct);exit;
            $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
            // var_dump($struct);exit;
            $response = $this->client->__soapCall('UserLogin', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
            // var_dump($response);exit;
            $respArr = $this->simplest_xml_to_array($response->UserLoginResult);
            if (!$respArr) {
                return $response;
            }
            return $respArr;
        } catch (SOAPFault $e) {
            print_r($this->client->__getLastRequest());
            echo $e->getMessage();
        }
    }

    //会员积分消费记录查询
    public function GetPointInfo($params)
    {
        $curday = date('Y-m-d');
        $ext_xml = <<<XML
			<QueryConsume>
      <ProgramCode>{$params['programCode']}</ProgramCode>  //微信网站设置,卡类型值
      <AccountID></AccountID>
      <begin>2014-1-1</begin>	//积分记录查询的开始时间
      <end>{$curday}</end>    //积分记录查询的结束时间
    </QueryConsume>
XML;
        $struct = new SoapStruct($this->username, $this->password, $this->openid, 1005, $ext_xml);//创建服务端要求传递的对象
        $struct->xml = new SoapVar($struct->xml, XSD_ANYXML);
        $response = $this->client->__soapCall('GetPointInfo', array(new SoapVar($struct, SOAP_ENC_OBJECT))); // 间接调用server方法
//            var_dump($response);
        $respArr = $this->simplest_xml_to_array($response->GetPointInfoResult);
        if (!$respArr) {
            return $response;
        }
        return $respArr;
    }

    //错误提示
    private function __msgErr($respArr)
    {
        if (!in_array($respArr['Head']['retcode'], array(0, '00001'))) {
            die('接口获取失败，错误信息：' . $respArr['Head']['retmsg']);
        }
    }

    /**
     * XML转数组
     * @param string $xmlstring XML字符串
     * @return array XML数组
     */
    private function simplest_xml_to_array($xmlstring)
    {
        $data = json_decode(json_encode((array)simplexml_load_string($xmlstring)), true);
        return $data;
    }

}

//奇葩的类结构，为了传递数据
class SoapStruct
{
    function SoapStruct($username, $password, $openid, $systype, $ext = '', $xmlName = 'xml')
    {
        $this->xml = "<ns1:{$xmlName}><![CDATA[<?xml version=\"1.0\" encoding=\"UTF-8\"?><Request><Head><transcode>10</transcode><reqtime>" . date('Y-m-d') . "T" . date('H:i:s') . "</reqtime><systype>{$systype}</systype><username>{$username}</username><password>{$password}</password></Head><Body>{$ext}</Body></Request>]]></ns1:{$xmlName}>";
    }
}