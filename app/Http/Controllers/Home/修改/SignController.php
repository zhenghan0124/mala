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
class SignController extends Controller
{
    public function sign()
    {
        //1，进签到页面调取接口。2，点击立即签到调取接口
        if (isset($_POST['type']) && isset($_POST['uid'])) {
            $type = $_POST['type'];
            $uid = $_POST['uid'];
            $uidredis = Rediss::get('uid');
            if($uidredis){
                $arr = [
                    'status' => 0,
                    'contents' => '签到失败,正在进行签到操作',
                    'day' => '',
                    'times' => '',
                    'beans' => '',
                ];
            }else {
                if ($type == 2) {
                    //该用户正在进行签到操作记录redis
                    Rediss::setex('uid',60,$uid);
                    $re = DB::table('userinfo')
                        ->where('uid', '=', $uid)
                        ->first();
                    //获取签到轮回次数
                    $signtime = $re->signtime;
                    //获取上次签到时间
                    $time = $re->time;
//            $day = $re->day;
                    //获取当前时间
                    $date = date('Y-m-d');
//            $date = '2019-06-29';
                    //计算当前签到时间与上一次签到时间之间的差值
//            $day = ceil((strtotime($date)-strtotime($signtime))/86400);
//            var_dump($day);exit;
                    DB::beginTransaction();
                    if ($date != $time) {
                        if ($signtime == 0) {

                            //修改签到时间为当前日期
                            DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->update([
                                    'time' => $date
                                ]);
                            //连续签到天数加1
                            DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->increment('day');
                            //获取连续签到天数
                            $re = DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->first();
                            $day = $re->day;
//                var_dump($day);exit;
                            $beans = $re->signbeans;
                            if ($day == 1) {
                                $signbeans = $beans + 5;
                                $bean = 5;
                            } elseif ($day == 2) {
                                $signbeans = $beans + 5;
                                $bean = 5;
                            } elseif ($day == 3) {
                                $signbeans = $beans + 5;
                                $bean = 5;
                            } elseif ($day == 4) {
                                $signbeans = $beans + 10;
                                $bean = 10;
                            } elseif ($day == 5) {
                                $signbeans = $beans + 10;
                                $bean = 10;
                            } elseif ($day == 6) {
                                $signbeans = $beans + 20;
                                $bean = 20;
                            } elseif ($day == 7) {
                                $signbeans = $beans + 45;
                                $bean = 45;
                                DB::table('userinfo')
                                    ->where('uid', '=', $uid)
                                    ->update([
                                        'signtime' => 1,
                                        'day' => 0,
                                    ]);
                            }
                            //添加签到句豆
                            $new = DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->update([
                                    'signbeans' => $signbeans,
                                ]);

                            //记录句豆来源
                            if ($new) {
                                DB::commit();
                                $datas = [
                                    'uid' => $uid,
                                    'source' => 3,
                                    'time' => time(),
                                    'date' => date('Y-m-d', time()),
                                    'beans' => $bean,
                                ];
                                DB::table('beansource')
                                    ->insert($datas);
                            }

//                if($day == 7){
//                    //修改签到时间为当前日期
//                    DB::table('userinfo')
//                        ->where('uid', '=', $uid)
//                        ->update([
//                            'signtime' => 1,
//                            'day' => 0,
//                        ]);
//                }
                            //清除redis
                            Rediss::delete('uid');
                            $arr = [
                                'status' => 1,
                                'contents' => '签到成功',
                                'day' => $day,
                                'times' => 0,
                                'sign' => 1,
                                'beans' => ['1' => '5', '2' => '5', '3' => '5', '4' => '10', '5' => '10', '6' => '20', '7' => '45',]
                            ];
                        } else {

                            //修改签到时间为当前日期
                            DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->update([
                                    'time' => $date
                                ]);
                            //连续签到天数加1
                            DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->increment('day');
                            //获取连续签到天数
                            $re = DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->first();
                            $day = $re->day;

                            $beans = $re->signbeans;
                            if ($day == 1) {
                                $signbeans = $beans + 2;
                                $bean = 2;
                            } elseif ($day == 2) {
                                $signbeans = $beans + 2;
                                $bean = 2;
                            } elseif ($day == 3) {
                                $signbeans = $beans + 2;
                                $bean = 2;
                            } elseif ($day == 4) {
                                $signbeans = $beans + 6;
                                $bean = 6;
                            } elseif ($day == 5) {
                                $signbeans = $beans + 6;
                                $bean = 6;
                            } elseif ($day == 6) {
                                $signbeans = $beans + 15;
                                $bean = 15;
                            } elseif ($day == 7) {
                                $signbeans = $beans + 30;
                                $bean = 30;
                            }

                            //添加签到句豆
                            $new = DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->update([
                                    'signbeans' => $signbeans,
                                ]);

                            //记录句豆来源
                            if ($new) {
                                DB::commit();
                                $datas = [
                                    'uid' => $uid,
                                    'source' => 3,
                                    'time' => time(),
                                    'date' => date('Y-m-d', time()),
                                    'beans' => $bean,
                                ];
                                DB::table('beansource')
                                    ->insert($datas);
                            }

                            if ($day == 7) {
                                //修改签到时间为当前日期
                                DB::table('userinfo')
                                    ->where('uid', '=', $uid)
                                    ->update([
                                        'day' => 0,
                                    ]);
                                //签到轮回次数加1
                                DB::table('userinfo')
                                    ->where('uid', '=', $uid)
                                    ->increment('signtime');
                                //获取轮回次数
                                $res = DB::table('userinfo')
                                    ->where('uid', '=', $uid)
                                    ->first();
                                $times = $res->signtime;
                            } else {
                                $times = $re->signtime;
                            }
                            //清除redis
                            Rediss::delete('uid');
                            $arr = [
                                'status' => 1,
                                'contents' => '签到成功',
                                'day' => $day,
                                'times' => $times,
                                'sign' => 1,
                                'beans' => ['1' => '2', '2' => '2', '3' => '2', '4' => '6', '5' => '6', '6' => '15', '7' => '30',]
                            ];
                        }
                    } else {
                        $re = DB::table('userinfo')
                            ->where('uid', '=', $uid)
                            ->first();
                        $day = $re->day;
                        $times = $re->signtime;
                        if ($day == 0 && $times != 0) {
                            $arr = [
                                'status' => 0,
                                'contents' => '签到失败，重复签到',
                                'day' => 7,
                                'times' => $times,
                                'beans' => '',
                            ];
                        } else {
                            $arr = [
                                'status' => 0,
                                'contents' => '签到失败，重复签到',
                                'day' => $day,
                                'times' => $times,
                                'beans' => '',
                            ];
                        }

                    }

                } else {
                    DB::rollBack();
                    $re = DB::table('userinfo')
                        ->where('uid', '=', $uid)
                        ->first();
                    $times = $re->signtime;

                    //获取上次签到时间
                    $time = $re->time;
                    //获取当前时间
                    $date = date('Y-m-d');

                    if ($times > 0) {
                        if ($time != $date) {
                            $arr = [
                                'status' => 1,
                                'contents' => '查询成功',
                                'day' => $re->day,
                                'times' => $times,
                                'sign' => 0,
                                'beans' => ['1' => '2', '2' => '2', '3' => '2', '4' => '6', '5' => '6', '6' => '15', '7' => '30',]
                            ];
                        } else {
                            $arr = [
                                'status' => 1,
                                'contents' => '查询成功',
                                'day' => $re->day,
                                'times' => $times,
                                'sign' => 1,
                                'beans' => ['1' => '2', '2' => '2', '3' => '2', '4' => '6', '5' => '6', '6' => '15', '7' => '30',]
                            ];
                        }

                    } else {
                        if ($time != $date) {
                            $arr = [
                                'status' => 1,
                                'contents' => '查询成功',
                                'day' => $re->day,
                                'times' => $times,
                                'sign' => 0,
                                'beans' => ['1' => '5', '2' => '5', '3' => '5', '4' => '10', '5' => '10', '6' => '20', '7' => '45',]
                            ];
                        } else {
                            $arr = [
                                'status' => 1,
                                'contents' => '查询成功',
                                'day' => $re->day,
                                'times' => $times,
                                'sign' => 1,
                                'beans' => ['1' => '5', '2' => '5', '3' => '5', '4' => '10', '5' => '10', '6' => '20', '7' => '45',]
                            ];
                        }

                    }
//                exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
                }
            }

        }else{
            $arr = [
                'status' => 0,
                'contents' => '查询失败',
                'day' => '',
                'times' => '',
                'beans' => '',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    //句豆来源
    public function source()
    {
        if(isset($_POST['uid']) && isset($_POST['page']) && isset($_POST['len'])){
            $uid = $_POST['uid'];
            $page=isset($_POST['page']) ? $_POST['page'] : 1;
            $limit=isset($_POST['len']) ? $_POST['len'] : 10;
            $offset=($page-1)*$limit;
            $re = DB::table('beansource')
                ->where('uid', '=', $uid)
                ->offset($offset)
                ->limit($limit)
                ->orderBy('time','desc')
                ->get();
            $arr = [
                'status' => 1,
                'contents' => $re,
            ];
        }else{
            $arr = [
                'status' => 0,
                'contents' => '',
            ];
        }
        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }
}
