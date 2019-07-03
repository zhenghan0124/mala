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
class PayController extends Controller
{
//企业付款到微信零钱，PHP接口调用方法
//define("APPID", "wxde3234454354"); // 商户账号appid
//define("MCHID", "1542149431"); 		// 商户号
//define("SECRECT_KEY", "145535866885");  //支付密钥签名
//define("IP", "127.0.0.1");   //IP

    //创建长字符串
    function createNoncestr($length =32)
    {

        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";

        $str ="";

        for ( $i = 0; $i < $length; $i++ )  {

            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);

        }
        return $str;
    }


    function unicode() {
        $str = uniqid(mt_rand(),1);
        $str=sha1($str);
        return md5($str);
    }

    function arraytoxml($data){
        $str='<xml>';
        foreach($data as $k=>$v) {
            $str.='<'.$k.'>'.$v.'</'.$k.'>';
        }
        $str.='</xml>';
        return $str;
    }
    function xmltoarray($xml) {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $val = json_decode(json_encode($xmlstring),true);
        return $val;
    }

    function curl($param="",$url) {

        $postUrl = $url;
        $curlPost = $param;
        $ch = curl_init();                                      //初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);           // 增加 HTTP Header（头）里的字段
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_SSLCERT,app_path().'/cert/apiclient_cert.pem'); //这个是证书的位置绝对路径
        curl_setopt($ch,CURLOPT_SSLKEY,app_path().'/cert/apiclient_key.pem'); //这个也是证书的位置绝对路径
        $data = curl_exec($ch);                                 //运行curl
        curl_close($ch);
        return $data;
    }

    /*
    $amount 发送的金额（分）目前发送金额不能少于1元
    $re_openid, 发送人的 openid
    $desc  //  企业付款描述信息 (必填)
    $check_name    收款用户姓名 (选填)
    */
    function sendMoney($params,$desc='句豆兑换成功',$check_name=''){

        $total_amount = (100) * $params['amount'];

        $data=array(
            'mch_appid'=>'wx0b214ca08babc1a3',//商户账号appid
            'mchid'=> '1542149431',//商户号
            'nonce_str'=>$this->createNoncestr(),//随机字符串
            'partner_trade_no'=> date('YmdHis').rand(1000, 9999),//商户订单号
            'openid'=> $params['openid'],//用户openid
            'check_name'=>'NO_CHECK',//校验用户姓名选项,
            're_user_name'=> $check_name,//收款用户姓名
            'amount'=>$total_amount,//金额
            'desc'=> $desc,//企业付款描述信息
            'spbill_create_ip'=> '122.224.6.6',//Ip地址
        );
        $secrect_key='hrik2WU5kC8MA4mCTSO033zHIRmH5YEB';///这个就是个API密码。MD5 32位。
        $data=array_filter($data);
        ksort($data);
        $str='';
        foreach($data as $k=>$v) {
           $str.=$k.'='.$v.'&';
        }
        $str.='key='.$secrect_key;
        $data['sign']=md5($str);
        $xml=$this->arraytoxml($data);

        $url='https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers'; //调用接口
        $res=$this->curl($xml,$url);
        $return=$this->xmltoarray($res);


//        print_r($return);
        //返回来的结果
        // [return_code] => SUCCESS [return_msg] => Array ( ) [mch_appid] => wxd44b890e61f72c63 [mchid] => 1493475512 [nonce_str] => 616615516 [result_code] => SUCCESS [partner_trade_no] => 20186505080216815
        // [payment_no] => 1000018361251805057502564679 [payment_time] => 2018-05-15 15:29:50


//        $responseObj = simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
//        echo $res= $responseObj->return_code;  //SUCCESS  如果返回来SUCCESS,则发生成功，处理自己的逻辑

//        return $res;
        return $return;
    }

    public function pay(){

        $uid = $_POST['uid'];
        $id = $_POST['id'];
        $start = date('Y-m-01'); //当月第一天
        $end = date('Y-m-t');   //当月最后一天

        //统计该用户当月兑换了多少次
        $count = DB::table('order')
            ->where('uid', '=', $uid)
//            ->where('goodsid', '= ', 1)
            ->whereDate('date','>= ',$start)
            ->whereDate('date','<= ',$end)
            ->count();
        //查询商品
        $mall = DB::table('mall')
            ->where('id', '=', $id)
            ->first();

        $price = $mall->beans;

        //获取该用户的总句豆
        $res = DB::table('userinfo')
            ->where('uid', '=', $uid)
            ->first();
        //点赞获取的句豆
        $supportbean = $res->support;
        //拉新获取的句豆
        $beans = $res->beans;
        //第一次点赞或评论获取到的句豆
        $newbeans = $res->newbeans;
        //签到获取到的句豆
        $signbeans = $res->signbeans;
        //总句豆
        $bean = $supportbean*2+$beans+$newbeans+$signbeans;
        DB::beginTransaction();
        if(intval($count) > 8){
            $arr = [
                'status' => 1,
                'contents' => '当月兑换次数已超限',
            ];
        }else {
            if (intval($bean) < intval($price)) {
                $arr = [
                    'status' => 0,
                    'contents' => '句豆不足',
                ];
            } else {
//            DB::commit();
                //当签到获取的句豆小于100
                if (intval($signbeans) < intval($price)) {
//                DB::commit();
                    $surplus = $price - $signbeans;
                    //将签到句豆归0
                    $signbeans = DB::table('userinfo')
                        ->where('uid', '=', $uid)
                        ->first();
                    if($signbeans->signbeans == 0){
                        $changesignbeans = 1;
                    }else{
                        $changesignbeans = DB::table('userinfo')
                            ->where('uid', '=', $uid)
                            ->update([
                                'signbeans' => 0,
                            ]);
                    }
//                    $changesignbeans = DB::table('userinfo')
//                        ->where('uid', '=', $uid)
//                        ->update([
//                            'signbeans' => 0,
//                        ]);
                    if ($changesignbeans) {
                        //当拉新获取到的句豆小于签到获取到的句豆和商品所需句豆的差时
                        if (intval($beans) < intval($surplus)) {
                            $sur = $surplus - $beans;
                            //将拉新句豆归0
                            $beans = DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->first();
                            if($beans->beans == 0){
                                $changebeans = 1;
                            }else{
                                $changebeans = DB::table('userinfo')
                                    ->where('uid', '=', $uid)
                                    ->update([
                                        'beans' => 0,
                                    ]);
                            }
//                            $changebeans = DB::table('userinfo')
//                                ->where('uid', '=', $uid)
//                                ->update([
//                                    'beans' => 0,
//                                ]);
                            if ($changebeans) {
                                //当第一次点赞或评论获取到的句豆小于所需句豆的差时
                                if (intval($newbeans) < intval($sur)) {
                                    $surp = $sur - $newbeans;
                                    //将第一次点赞或评论获取到的句豆归0
                                    $newbeans = DB::table('userinfo')
                                        ->where('uid', '=', $uid)
                                        ->first();
                                    if($newbeans->newbeans == 0){
                                        $changenewbeans = 1;
                                    }else{
                                        $changenewbeans = DB::table('userinfo')
                                            ->where('uid', '=', $uid)
                                            ->update([
                                                'newbeans' => 0,
                                            ]);
                                    }
//                                    $changenewbeans = DB::table('userinfo')
//                                        ->where('uid', '=', $uid)
//                                        ->update([
//                                            'newbeans' => 0,
//                                        ]);
                                    if ($changenewbeans) {
                                        //当点赞获取到的句豆小于所需差值
                                        if (intval($supportbean * 2) < intval($surp)) {
                                            DB::rollBack();
                                            $arr = [
                                                'status' => 0,
                                                'contents' => '句豆不足',
                                            ];
                                        } else {
//                                        DB::commit();
                                            //点赞剩余句豆
                                            $surpl = $supportbean * 2 - $surp;
                                            //更改点赞句豆为剩余差值
                                            $changesupport = DB::table('userinfo')
                                                ->where('uid', '=', $uid)
                                                ->update([
                                                    'support' => $surpl / 2,
                                                ]);
                                            if ($changesupport) {
                                                //执行付款
                                                $params['amount'] = 3;
                                                $params['openid'] = $res->openid;
                                                $result = $this->sendMoney($params);
//                                            return $result;
                                                $result_code = $result['result_code'];
                                                $return_code = $result['return_code'];
//                                                $errormsg = $result['err_code_des'];
                                                if ($result_code == 'SUCCESS' && $return_code == 'SUCCESS') {
                                                    //更新order表
                                                    $datas = [
                                                        'uid' => $uid,
                                                        'goodsid' => $id,
                                                        'title' => $mall->title,
                                                        'beans' => $price,
                                                        'time' => time(),
                                                        'date' => date('Y-m-d', time()),

                                                    ];
                                                    DB::table('order')
                                                        ->insert($datas);

                                                    DB::commit();
                                                    $arr = [
                                                        'status' => 1,
                                                        'contents' => '兑换成功',
                                                    ];
                                                } else {
                                                    if ($result['err_code'] == 'SENDNUM_LIMIT') {
                                                        DB::rollBack();
                                                        $arr = [
                                                            'status' => 0,
                                                            'contents' => '今日兑换次数超限',
                                                            'errormsg' => $result['err_code'],
                                                        ];
                                                    } elseif ($result['err_code'] == 'NO_AUTH') {
                                                        DB::rollBack();
                                                        $arr = [
                                                            'status' => 0,
                                                            'contents' => '兑换失败',
                                                            'errormsg' => $result['err_code'],
                                                        ];
                                                    } elseif ($result['err_code'] == 'AMOUNT_LIMIT') {
                                                        DB::rollBack();
                                                        $arr = [
                                                            'status' => 0,
                                                            'contents' => '金额超限',
                                                            'errormsg' => $result['err_code'],
                                                        ];
                                                    } elseif ($result['err_code'] == 'NOTENOUGH') {
                                                        DB::rollBack();
                                                        $arr = [
                                                            'status' => 0,
                                                            'contents' => '余额不足',
                                                            'errormsg' => $result['err_code'],
                                                        ];
                                                    } elseif ($result['err_code'] == 'SYSTEMERROR') {
                                                        DB::rollBack();
                                                        $arr = [
                                                            'status' => 0,
                                                            'contents' => '系统繁忙，请稍后再试',
                                                            'errormsg' => $result['err_code'],
                                                        ];
                                                    } else {
                                                        DB::rollBack();
                                                        $arr = [
                                                            'status' => 0,
                                                            'contents' => '兑换失败',
                                                            'errormsg' => '',
                                                        ];
                                                    }

                                                }
//                                            $arr = [
//                                                'status' => 1,
//                                                'contents' => '数据库操作成功',
//                                            ];
                                            } else {
                                                DB::rollBack();
                                                $arr = [
                                                    'status' => 0,
                                                    'contents' => '兑换失败',
                                                ];
                                            }
                                        }
                                    }
                                } else {
//                                DB::commit();
                                    //拉新剩余句豆
                                    $surp = $newbeans - $sur;
                                    //更改第一次点赞或评论获取到的句豆为剩余差值
                                    $changenewbeans = DB::table('userinfo')
                                        ->where('uid', '=', $uid)
                                        ->update([
                                            'newbeans' => $surp,
                                        ]);
                                    if ($changenewbeans) {
                                        //执行付款
                                        $params['amount'] = 3;
                                        $params['openid'] = $res->openid;
                                        $result = $this->sendMoney($params);
                                        $result_code = $result['result_code'];
                                        $return_code = $result['return_code'];
//                                        $errormsg = $result['err_code_des'];
                                        if ($result_code == 'SUCCESS' && $return_code == 'SUCCESS') {
                                            //更新order表
                                            $datas = [
                                                'uid' => $uid,
                                                'goodsid' => $id,
                                                'title' => $mall->title,
                                                'beans' => $price,
                                                'time' => time(),
                                                'date' => date('Y-m-d', time()),

                                            ];
                                            DB::table('order')
                                                ->insert($datas);

                                            DB::commit();
                                            $arr = [
                                                'status' => 1,
                                                'contents' => '兑换成功',
                                            ];
                                        } else {
                                            if ($result['err_code'] == 'SENDNUM_LIMIT') {
                                                DB::rollBack();
                                                $arr = [
                                                    'status' => 0,
                                                    'contents' => '今日兑换次数超限',
                                                    'errormsg' => $result['err_code'],
                                                ];
                                            } elseif ($result['err_code'] == 'NO_AUTH') {
                                                DB::rollBack();
                                                $arr = [
                                                    'status' => 0,
                                                    'contents' => '兑换失败',
                                                    'errormsg' => $result['err_code'],
                                                ];
                                            } elseif ($result['err_code'] == 'AMOUNT_LIMIT') {
                                                DB::rollBack();
                                                $arr = [
                                                    'status' => 0,
                                                    'contents' => '金额超限',
                                                    'errormsg' => $result['err_code'],
                                                ];
                                            } elseif ($result['err_code'] == 'NOTENOUGH') {
                                                DB::rollBack();
                                                $arr = [
                                                    'status' => 0,
                                                    'contents' => '余额不足',
                                                    'errormsg' => $result['err_code'],
                                                ];
                                            } elseif ($result['err_code'] == 'SYSTEMERROR') {
                                                DB::rollBack();
                                                $arr = [
                                                    'status' => 0,
                                                    'contents' => '系统繁忙，请稍后再试',
                                                    'errormsg' => $result['err_code'],
                                                ];
                                            } else {
                                                DB::rollBack();
                                                $arr = [
                                                    'status' => 0,
                                                    'contents' => '兑换失败',
                                                    'errormsg' => '',
                                                ];
                                            }
                                        }
//                                    $arr = [
//                                        'status' => 1,
//                                        'contents' => '数据库操作成功',
//                                    ];
                                    } else {
                                        DB::rollBack();
                                        $arr = [
                                            'status' => 0,
                                            'contents' => '兑换失败',
                                        ];
                                    }
                                }
                            } else {
                                DB::rollBack();
                                $arr = [
                                    'status' => 0,
                                    'contents' => '兑换失败',
                                ];
                            }
                        } else {
//                        DB::commit();
                            //拉新剩余句豆
                            $su = $beans - $surplus;
                            //更改拉新句豆为剩余差值
                            $changebeans = DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->update([
                                    'beans' => $su,
                                ]);
                            if ($changebeans) {
                                //执行付款
                                $params['amount'] = 3;
                                $params['openid'] = $res->openid;
                                $result = $this->sendMoney($params);
                                $result_code = $result['result_code'];
                                $return_code = $result['return_code'];
//                                $errormsg = $result['err_code_des'];
                                if ($result_code == 'SUCCESS' && $return_code == 'SUCCESS') {
                                    //更新order表
                                    $datas = [
                                        'uid' => $uid,
                                        'goodsid' => $id,
                                        'title' => $mall->title,
                                        'beans' => $price,
                                        'time' => time(),
                                        'date' => date('Y-m-d', time()),

                                    ];
                                    DB::table('order')
                                        ->insert($datas);
                                    DB::commit();
                                    $arr = [
                                        'status' => 1,
                                        'contents' => '兑换成功',
                                    ];

                                } else {
                                    if ($result['err_code'] == 'SENDNUM_LIMIT') {
                                        DB::rollBack();
                                        $arr = [
                                            'status' => 0,
                                            'contents' => '今日兑换次数超限',
                                            'errormsg' => $result['err_code'],
                                        ];
                                    } elseif ($result['err_code'] == 'NO_AUTH') {
                                        DB::rollBack();
                                        $arr = [
                                            'status' => 0,
                                            'contents' => '兑换失败',
                                            'errormsg' => $result['err_code'],
                                        ];
                                    } elseif ($result['err_code'] == 'AMOUNT_LIMIT') {
                                        DB::rollBack();
                                        $arr = [
                                            'status' => 0,
                                            'contents' => '金额超限',
                                            'errormsg' => $result['err_code'],
                                        ];
                                    } elseif ($result['err_code'] == 'NOTENOUGH') {
                                        DB::rollBack();
                                        $arr = [
                                            'status' => 0,
                                            'contents' => '余额不足',
                                            'errormsg' => $result['err_code'],
                                        ];
                                    } elseif ($result['err_code'] == 'SYSTEMERROR') {
                                        DB::rollBack();
                                        $arr = [
                                            'status' => 0,
                                            'contents' => '系统繁忙，请稍后再试',
                                            'errormsg' => $result['err_code'],
                                        ];
                                    } else {
                                        DB::rollBack();
                                        $arr = [
                                            'status' => 0,
                                            'contents' => '兑换失败',
                                            'errormsg' => '',
                                        ];
                                    }
                                }
//                            $arr = [
//                                'status' => 1,
//                                'contents' => '数据库操作成功',
//                            ];
                            } else {
                                DB::rollBack();
                                $arr = [
                                    'status' => 0,
                                    'contents' => '兑换失败',
                                ];
                            }
                        }

                    } else {
                        DB::rollBack();
                        $arr = [
                            'status' => 0,
                            'contents' => '兑换失败',
                        ];
                    }
                } else {
                    $surplus = $signbeans - $price;
                    //将签到句豆归0
                    $changesignbeans = DB::table('userinfo')
                        ->where('uid', '=', $uid)
                        ->update([
                            'signbeans' => $surplus,
                        ]);
//                return $changesignbeans;
                    if ($changesignbeans) {
                        //执行付款
                        $params['amount'] = 3;
                        $params['openid'] = $res->openid;
                        $result = $this->sendMoney($params);
//                    return $result;
                        $result_code = $result['result_code'];
                        $return_code = $result['return_code'];
//                    $errormsg = $result['err_code_des'];
                        if ($result_code == 'SUCCESS' && $return_code == 'SUCCESS') {
                            //更新order表
                            $datas = [
                                'uid' => $uid,
                                'goodsid' => $id,
                                'title' => $mall->title,
                                'beans' => $price,
                                'time' => time(),
                                'date' => date('Y-m-d', time()),

                            ];
                            DB::table('order')
                                ->insert($datas);

                            DB::commit();
                            $arr = [
                                'status' => 1,
                                'contents' => '兑换成功',
                            ];
                        } else {
                            if ($result['err_code'] == 'SENDNUM_LIMIT') {
                                DB::rollBack();
                                $arr = [
                                    'status' => 0,
                                    'contents' => '今日兑换次数超限',
                                    'errormsg' => $result['err_code'],
                                ];
                            } elseif ($result['err_code'] == 'NO_AUTH') {
                                DB::rollBack();
                                $arr = [
                                    'status' => 0,
                                    'contents' => '兑换失败',
                                    'errormsg' => $result['err_code'],
                                ];
                            } elseif ($result['err_code'] == 'AMOUNT_LIMIT') {
                                DB::rollBack();
                                $arr = [
                                    'status' => 0,
                                    'contents' => '金额超限',
                                    'errormsg' => $result['err_code'],
                                ];
                            } elseif ($result['err_code'] == 'NOTENOUGH') {
                                DB::rollBack();
                                $arr = [
                                    'status' => 0,
                                    'contents' => '余额不足',
                                    'errormsg' => $result['err_code'],
                                ];
                            } elseif ($result['err_code'] == 'SYSTEMERROR') {
                                DB::rollBack();
                                $arr = [
                                    'status' => 0,
                                    'contents' => '系统繁忙，请稍后再试',
                                    'errormsg' => $result['err_code'],
                                ];
                            } else {
                                DB::rollBack();
                                $arr = [
                                    'status' => 0,
                                    'contents' => '兑换失败',
                                    'errormsg' => '',
                                ];
                            }
                        }
                    } else {
                        DB::rollBack();
                        $arr = [
                            'status' => 0,
                            'contents' => '兑换失败',
                        ];
                    }
                }
            }
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
//        //查询商品
//        $res = DB::table('mall')
//            ->where('id', '=', $id)
//            ->first();
//
//        $params['amount'] = 0.5;
////        $params['openid'] = 'otV6H5GC3JusKGe_thoKdkATzLvk';
//        $params['openid'] = $res->openid;
////        var_dump($params);exit;
//        $result = $this->sendMoney($params);
//        $result_code = $result['result_code'];
//        $return_code = $result['return_code'];
////        var_dump($result);
////        var_dump($result_code);
////        var_dump($return_code);
//        if($result_code == "SUCCESS" && $return_code == "SUCCESS"){
//            return '成功';
//        }else{
//            return '失败';
//        }

    }

    public function paytest(){
        $params['amount'] = 0.3;
        $params['openid'] = 'otV6H5GC3JusKGe_thoKdkATzLvk';
//        $surplus = $signbeans-$price;
        //将签到句豆归0
        $user = DB::table('userinfo')
            ->where('uid', '=', '5cf87770e9ab3')
            ->first();
        $changesignbeans = DB::table('userinfo')
            ->where('uid', '=', '5cf87770e9ab3')
            ->update([
                'signbeans' => $user->signbeans+1,
            ]);
        if($changesignbeans){

//        $params['openid'] = $res->openid;
//        var_dump($params);exit;
            $result = $this->sendMoney($params);
            $result_code = $result['result_code'];
            $return_code = $result['return_code'];
            var_dump($result);
            var_dump($result_code);
            var_dump($return_code);
            if($result_code == "SUCCESS" && $return_code == "SUCCESS"){
//                return '成功';
                //更新order表
                $datas = [
                    'uid' => '5cd26e091d695',
                    'goodsid' => 1,
                    'title' => '现金红包1元',
                    'beans' => 100,
                    'time' => time(),
                    'date' => date('Y-m-d',time()),

                ];
                DB::table('order')
                    ->insert($datas);
                return '成功';
            }else{
                return '失败';
            }
        }

    }

}
