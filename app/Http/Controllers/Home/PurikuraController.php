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
class PurikuraController extends Controller
{
    public function picture(){
        // 图片base64编码
        header("Content-type: text/html; charset=utf-8");
        $path   = $_POST['imgurl'];
        $data   = file_get_contents($path);
        $base64 = base64_encode($data);
        $sticker = $_POST['sticker'];
        // 设置请求数据
        $appkey = 'Tui5vOhYnGf9agDu';
        $params = array(
            'app_id'     => '2118616492',
            'image'      => $base64,
            'sticker'    => $sticker,
            'time_stamp' => strval(time()),
            'nonce_str'  => strval(rand()),
            'sign'       => '',
        );
        $params['sign'] = $this->getReqSign($params, $appkey);

        // 执行API调用
        $url = 'https://api.ai.qq.com/fcgi-bin/ptu/ptu_facesticker';
        $response = $this->doHttpPost($url, $params);
        $arrs = json_decode($response,true);
        if($arrs['ret'] == 0){
            $img = base64_decode($arrs['data']['image']);
            $path = './upload/renxiang/handled' . time() . rand(1, 9) . rand(1, 9) . rand(1, 9) . '.jpg';
//        $path = './upload/rexiang/handled' . time() . '.jpg';
            file_put_contents($path,$img,true);
            $imageurl = ltrim($path, ".");
            $imageurl = 'http://duanju.58100.com'.$imageurl;
            $arr = [
                'status' => 1,
                'info' => '',
                'imgurl' => $imageurl
            ];
        }else{
            $arr = [
                'status' => 1,
                'info' => $arrs['msg'],
                'imgurl' => ''
            ];
        }

        exit(json_encode($arr));
    }

    public function face(){
        header("Content-type: text/html; charset=utf-8");
        $path   = $_POST['imgurl'];
        $data   = file_get_contents($path);
        $base64 = base64_encode($data);

        // 设置请求数据
        $appkey = 'Tui5vOhYnGf9agDu';
        $params = array(
            'app_id'     => '2118616492',
            'image'      => $base64,
            'mode'    => '0',
            'time_stamp' => strval(time()),
            'nonce_str'  => strval(rand()),
            'sign'       => '',
        );
        $params['sign'] = $this->getReqSign($params, $appkey);

        // 执行API调用
        $url = 'https://api.ai.qq.com/fcgi-bin/face/face_detectface';
        $response = $this->doHttpPost($url, $params);
        $arrs = json_decode($response,true);
        if($arrs['ret'] == 0){
            $arr = [
                'status' => 1,
                'info' => '',
                'age' => $arrs['data']['face_list'][0]['age'],
                'beauty' => $arrs['data']['face_list'][0]['beauty']
            ];
        }else{
            $arr = [
                'status' => 1,
                'info' => $arrs['msg'],
                'age' => '',
                'beauty' => ''
            ];
        }
        exit(json_encode($arr));
    }

    // getReqSign ：根据 接口请求参数 和 应用密钥 计算 请求签名
// 参数说明
//   - $params：接口请求参数（特别注意：不同的接口，参数对一般不一样，请以具体接口要求为准）
//   - $appkey：应用密钥
// 返回数据
//   - 签名结果
    function getReqSign($params /* 关联数组 */, $appkey /* 字符串*/)
    {
        // 1. 字典升序排序
        ksort($params);

        // 2. 拼按URL键值对
        $str = '';
        foreach ($params as $key => $value)
        {
            if ($value !== '')
            {
                $str .= $key . '=' . urlencode($value) . '&';
            }
        }

        // 3. 拼接app_key
        $str .= 'app_key=' . $appkey;

        // 4. MD5运算+转换大写，得到请求签名
        $sign = strtoupper(md5($str));
        return $sign;
    }


// doHttpPost ：执行POST请求，并取回响应结果
// 参数说明
//   - $url   ：接口请求地址
//   - $params：完整接口请求参数（特别注意：不同的接口，参数对一般不一样，请以具体接口要求为准）
// 返回数据
//   - 返回false表示失败，否则表示API成功返回的HTTP BODY部分
    function doHttpPost($url, $params)
    {
        $curl = curl_init();

        $response = false;
        do
        {
            // 1. 设置HTTP URL (API地址)
            curl_setopt($curl, CURLOPT_URL, $url);

            // 2. 设置HTTP HEADER (表单POST)
            $head = array(
                'Content-Type: application/x-www-form-urlencoded'
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $head);

            // 3. 设置HTTP BODY (URL键值对)
            $body = http_build_query($params);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);

            // 4. 调用API，获取响应结果
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_NOBODY, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            if ($response === false)
            {
                $response = false;
                break;
            }

            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($code != 200)
            {
                $response = false;
                break;
            }
        } while (0);

        curl_close($curl);
        return $response;
    }

    //上传人像
    public function uploadportrait(Request $request)
    {
        //查看是否有图片上传
        if ($request->hasFile('image')) {
            //dd($request->hasFile('image'));
            $rootpath = './upload/renxiang/';
            $filename = 'upload'.time().rand(1,9) . '.jpg';
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
}
