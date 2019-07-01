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
            if ($type == 2) {
                $re = DB::table('userinfo')
                    ->where('uid', '=', $uid)
                    ->first();
                //获取上次签到时间
                $signtime = $re->signtime;
//            $day = $re->day;
                //获取当前时间
//            $date = date('Y-m-d',time());
//            $date = '2019-06-29';
                //计算当前签到时间与上一次签到时间之间的差值
//            $day = ceil((strtotime($date)-strtotime($signtime))/86400);
//            var_dump($day);exit;
                DB::beginTransaction();
                if ($signtime == 0) {
                    DB::commit();
//                //修改签到时间为当前日期
//                DB::table('userinfo')
//                    ->where('uid', '=', $uid)
//                    ->update([
//                        'signtime' => $date,
//                    ]);
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
                    $arr = [
                        'status' => 1,
                        'contents' => '签到成功',
                        'day' => $day,
                        'times' => 0,
                        'beans' => ['1' => '5', '2' => '5', '3' => '5', '4' => '10', '5' => '10', '6' => '20', '7' => '45',]
                    ];
                } else {
                    DB::commit();
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
                    $arr = [
                        'status' => 1,
                        'contents' => '签到成功',
                        'day' => $day,
                        'times' => $times,
                        'beans' => ['1' => '5', '2' => '5', '3' => '5', '4' => '5', '5' => '5', '6' => '5', '7' => '5',]
                    ];
                }
            } else {
                DB::rollBack();
                $re = DB::table('userinfo')
                    ->where('uid', '=', $uid)
                    ->first();
                $times = $re->signtime;
                if ($times > 0) {
                    $arr = [
                        'status' => 1,
                        'contents' => '查询成功',
                        'day' => $re->day,
                        'times' => $times,
                        'beans' => ['1' => '5', '2' => '5', '3' => '5', '4' => '5', '5' => '5', '6' => '5', '7' => '5',]
                    ];
                } else {
                    $arr = [
                        'status' => 1,
                        'contents' => '查询成功',
                        'day' => $re->day,
                        'times' => $times,
                        'beans' => ['1' => '5', '2' => '5', '3' => '5', '4' => '10', '5' => '10', '6' => '20', '7' => '45',]
                    ];
                }
//                exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
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
//            $uid = '1557122526';
            $page=isset($_POST['page']) ? $_POST['page'] : 1;
            $limit=isset($_POST['len']) ? $_POST['len'] : 10;
            $offset=($page-1)*$limit;
            $re = DB::table('beansource')
                ->where('uid', '=', $uid)
                ->offset($offset)
                ->limit($limit)
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

    public function test()
    {
////        DB::beginTransaction();
////        $uid = '1557122526';
////        $beans = DB::table('userinfo')
////            ->where('uid', '=', $uid)
////            ->update([
////                'newbeans' => 3,
////            ]);
////        if($beans){
////            var_dump(1);
////            DB::rollBack();
////        }else{
////            var_dump(2);
////            DB::commit();
////        }
//        $uid = '5cd02244bb62f';
////        echo date('Y-m-01');
////        echo "<br/>";
////        echo date('Y-m-t');
////        echo "<br/>";
//        $start = date('Y-m-01', strtotime('-1 month')); //当月第一天
//        $end = date('Y-m-t', strtotime('-1 month'));   //当月最后一天
//        $count = DB::table('order')
//            ->where('uid', '=', $uid)
////            ->where('goodsid', '= ', 1)
//            ->whereDate('date','>= ',$start)
//            ->whereDate('date','<= ',$end)
//            ->count();
//        var_dump($count);exit;
        $uid = '1557122526';
        $id = 1;

        $price = 100;

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
        var_dump($bean);
        DB::beginTransaction();
            if (intval($bean) < intval($price)) {
                var_dump($price);
                $arr = [
                    'status' => 0,
                    'contents' => '句豆不足',
                ];
            } else {
                //当签到获取的句豆小于100
                if (intval($signbeans) < intval($price)) {
                    $surplus = $price - $signbeans;
                    var_dump($surplus);
                    //将签到句豆归0
                    $signbeans = DB::table('userinfo')
                        ->where('uid', '=', $uid)
                        ->first();
                    if($signbeans->signbeans == 0){
                        var_dump('签到句豆为0，不用操作');
                        $changesignbeans = 1;
                    }else{
                        $changesignbeans = DB::table('userinfo')
                            ->where('uid', '=', $uid)
                            ->update([
                                'signbeans' => 0,
                            ]);
                    }

                    if ($changesignbeans) {
                        //当拉新获取到的句豆小于签到获取到的句豆和商品所需句豆的差时
                        if (intval($beans) < intval($surplus)) {
                            $sur = $surplus - $beans;
                            var_dump($sur);
                            //将拉新句豆归0
                            $beans = DB::table('userinfo')
                                ->where('uid', '=', $uid)
                                ->first();
                            if($beans->beans == 0){
                                var_dump('拉新句豆为0，不用操作');
                                $changebeans = 1;
                            }else{
                                $changebeans = DB::table('userinfo')
                                    ->where('uid', '=', $uid)
                                    ->update([
                                        'beans' => 0,
                                    ]);
                            }

                            if ($changebeans) {
                                //当第一次点赞或评论获取到的句豆小于所需句豆的差时
                                if (intval($newbeans) < intval($sur)) {
                                    $surp = $sur - $newbeans;
                                    var_dump($surp);
                                    //将第一次点赞或评论获取到的句豆归0
                                    $beans = DB::table('userinfo')
                                        ->where('uid', '=', $uid)
                                        ->first();
                                    if($beans->newbeans == 0){
                                        var_dump('第一次点赞或评论获取到的句豆为0，不用操作');
                                        $changenewbeans = 1;
                                    }else{
                                        $changenewbeans = DB::table('userinfo')
                                            ->where('uid', '=', $uid)
                                            ->update([
                                                'newbeans' => 0,
                                            ]);

                                    }
                                    var_dump($changenewbeans);
                                    if ($changenewbeans) {
                                        //当点赞获取到的句豆小于所需差值
                                        if (intval($supportbean*2) < intval($surp)) {
                                            var_dump(1);
                                            DB::rollBack();
                                            $arr = [
                                                'status' => 0,
                                                'contents' => '句豆不足',
                                            ];
                                        } else {
//                                        DB::commit();
                                            //点赞剩余句豆
                                            $surpl = $supportbean * 2 - $surp;
                                            var_dump($surpl);
                                            //更改点赞句豆为剩余差值
                                            $changesupport = DB::table('userinfo')
                                                ->where('uid', '=', $uid)
                                                ->update([
                                                    'support' => $surpl / 2,
                                                ]);
                                            if ($changesupport) {
                                                DB::commit();
                                                $arr = [
                                                    'status' => 1,
                                                    'contents' => '数据库操作成功',
                                                ];
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
                                        DB::commit();
                                        var_dump('成功');
                                        $arr = [
                                            'status' => 1,
                                            'contents' => '数据库操作成功',
                                        ];
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
                                DB::commit();
                                $arr = [
                                    'status' => 1,
                                    'contents' => '数据库操作成功',
                                ];
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
                    //将签到句豆更新
                    $changesignbeans = DB::table('userinfo')
                        ->where('uid', '=', $uid)
                        ->update([
                            'signbeans' => $surplus,
                        ]);
//                return $changesignbeans;
                    if ($changesignbeans) {
                            DB::commit();
                            $arr = [
                                'status' => 1,
                                'contents' => '兑换成功',
                            ];
                    } else {
                        DB::rollBack();
                        $arr = [
                            'status' => 0,
                            'contents' => '兑换失败',
                        ];
                    }
                }
            }
//        exit(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }
}
