<?php

namespace App\Http\Controllers\Home;

use App\Home\Formid;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrontabController extends Controller
{
    //模板消息
    protected function curl_post($url, $fields, $data_type = 'text')

    {

        $cl = curl_init();

        if (stripos($url, 'https://') !== FALSE) {

            curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, FALSE);

            curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, FALSE);

            curl_setopt($cl, CURLOPT_SSLVERSION, 1);

        }

        curl_setopt($cl, CURLOPT_URL, $url);

        curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($cl, CURLOPT_POST, true);

        curl_setopt($cl, CURLOPT_POSTFIELDS, $fields);

        $content = curl_exec($cl);

        $status = curl_getinfo($cl);

        curl_close($cl);

        if (isset($status['http_code']) && $status['http_code'] == 200) {

            if ($data_type == 'json') {

                $content = json_decode($content);

            }

            return $content;

        } else {

            return false;

        }

    }

    protected function getMsg($openid, $template_id, $form_id)//, $emphasis_keyword = 'keyword1')
    {

        $data['data'] = [
            'keyword1' => [
                'value' => '天天刷短句，给生活加点诗意',
                'color' => ''
            ],
            'keyword2' => [
                'value' => '爱你的麻辣短句',
                'color' => ''
            ],
        ];

        $data['touser'] = $openid;//用户的openid

        $data['template_id'] = $template_id;//从微信后台获取的模板id

        $data['form_id'] = $form_id;//前端提供给后端的form_id

        //$data['page'] = 'pages/orderList/orderList?openid=' . $openid; //'pages/index/index?ordernum=' . $ordernum;//小程序跳转页面
        $data['page'] = 'pages/index/index';
        //$data['emphasis_keyword'] = $emphasis_keyword;//选择放大的字体

        return $data;
    }

    //通知(晚上7点发送一次；中午13点发送一次)
    public function sends()
    {
        //获取用户的个数
        $usercount = DB::table('user')->count();
        $limit = 200;
        $totalpage = ceil($usercount / $limit);//总页数
        $formid = new Formid();
        $template_id = 'PqRAk_4edEuOAOVL8sVHaLwcSI3yxDX96upifrSeVVI';
        $index = new PublicController();
        $access_token = $index->getAccent_token();//获取token
        $send_url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $access_token;
        for ($i = 1; $i <= $totalpage; $i++) {
            $user = DB::table('user')
                ->select('openid')
                ->offset(($i-1)*$limit)
                ->limit($limit);
            if ($user->exists()) {
                foreach($user->get() as $v){
                    //获取formid
                    $form_id = $formid->getFormid($v->openid);
                    if($form_id){
                        //删除formid
                        $formid->delformid($form_id->formid);
                        //发送消息
                        $data = $this->getMsg($v->openid, $template_id, $form_id->formid);
                        $str = $this->curl_post($send_url, json_encode($data));
//                        $str = json_decode($str, true);
//                        if ($str['errcode'] == 0) {
//                            return 1;
//                        } else {
//                            return 0;
//                        }
                    }
                }
            }else{
                return 0;
            }
        }

    }

}
