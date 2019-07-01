<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
//引入门面
use Input;
use DB;
//引入模型
use App\Admin\Type;
use  App\Admin\Content;
use App\Admin\Userinfo;
class AdminController extends BaseController
{
    //后台首页
    public function index()
    {
        //dd(Session::get('admin'));
        return view('admin/admin/index');
    }

    //发布人员管理
    public function fabu()
    {
        //获取后台发布人员
        $model = new Userinfo();
        $fabur = $model->getFabur();
        $arr = [
            'fabur' => $fabur
        ];
        return view('admin/admin/fabu', $arr);
    }

    //添加发布人员
    public function addfabur(Request $request)
    {
        if (Input::method() == 'POST') {
            if ($request->hasFile('photo')) {
                $rootpath = './upload/fabuphto/';
                $filename = time() . '.png';
                $file = $request->file('photo')->move($rootpath, $filename);
                $validatedData = $request->validate([
                    'nickname' => 'required|unique:userinfo',
                    //'imgurl' => 'required|unique:type',
                ]);
                if ($validatedData) {
                    $model = new Userinfo();
                    $models = $model->addfabur($validatedData, trim($rootpath . $filename, '.'));
                    if ($models) {
                        echo "<script>alert('添加成功!');location.href='" . url('/admin/admin/fabu') . "';</script>";
                    } else {
                        echo "<script>alert('添加失败!');location.href='" . url('/admin/admin/addfabur') . "';</script>";
                    }
                }
            } else {
                echo "<script>alert('请上传头像!');location.href='" . url('/admin/admin/addfabur') . "';</script>";
            }

        }
        return view('admin/admin/addfabur');
    }

    //修改发布人员
    public function updatefabu(Request $request)
    {
        if (Input::method() == 'POST') {
            $validatedData = $request->validate([
                'nickname' => 'required',
                //'imgurl' => 'required|unique:type',
            ]);
            if ($request->hasFile('photo')) {
                $rootpath = './upload/fabuphto/';
                $filename = time() . '.png';
                $file = $request->file('photo')->move($rootpath, $filename);
                if ($validatedData) {
                    $model = new Userinfo();
                    $models = $model->updatefaburimg($_GET['id'],$validatedData,trim($rootpath . $filename, '.'));
                    if ($models) {
                        echo "<script>alert('修改成功!');location.href='" . url('/admin/admin/fabu') . "';</script>";
                    } else {
                        echo "<script>alert('修改失败!');location.href='" . url('/admin/admin/fabu') . "';</script>";
                    }
                }
            } else {

                if ($validatedData) {
                    $model = new Userinfo();
                    $models = $model->updatefabur($_GET['id'],$validatedData);
                    if ($models) {
                        echo "<script>alert('修改成功!');location.href='" . url('/admin/admin/fabu') . "';</script>";
                    } else {
                        echo "<script>alert('修改失败!');location.href='" . url('/admin/admin/fabu') . "';</script>";
                    }
                }
            }

        }
            if (isset($_GET['id'])) {
                $userinfo = DB::table('userinfo')
                    ->where('id', '=', $_GET['id'])
                    ->first();
                if ($userinfo) {
                    $arr = [
                        'userinfo' => $userinfo
                    ];
                } else {
                    $arr = [
                        'userinfo' => []
                    ];
                }
            } else {
                $arr = [
                    'userinfo' => []
                ];
            }

            return view('admin/admin/updatefabu', $arr);
        }


    //分类管理
    public function type()
    {
        //查询分类
        $model = new Type();
        $models = $model->type();
        $arr = [
            'type' => $models
        ];
        return view('admin/admin/type', $arr);
    }

    //添加分类
    public function addtype(Request $request)
    {
        if (Input::method() == 'POST') {
            $validatedData = $request->validate([
                'id' => 'unique:type',
                'title' => 'required|unique:type',
            ]);
            if ($validatedData) {
                //写入数据库
                $model = new Type();
                $models = $model->addtype($validatedData);
                if ($models) {
                    echo "<script>alert('添加成功!');location.href='" . url('/admin/admin/type') . "';</script>";
                } else {
                    echo "<script>alert('添加失败!');location.href='" . url('/admin/admin/addtype') . "';</script>";
                }
            }
        }
        return view('admin/admin/addtype');
    }

    //修改分类
    public function updatetype(Request $request)
    {
        if (Input::method() == 'POST') {
            $validatedData = $request->validate([
                //'id'=>'unique:type',
                'title'=> 'required',
                'location' => 'required|unique:type',
            ]);
            if ($validatedData) {
                //写入数据库
                $models = DB::table('type')
                    ->where('id', '=', $_GET['id'])
                    ->update($validatedData);
                if ($models) {
                    echo "<script>alert('修改成功!');location.href='" . url('/admin/admin/type') . "';</script>";
                } else {
                    echo "<script>alert('修改失败!');location.href='" . url('/admin/admin/type') . "';</script>";
                }
            }
        }
        //获取该分类
        $gettype = DB::table('type')
            ->where('id', '=', $_GET['id'])
            ->first();
        $arr = [
            'type' => $gettype
        ];
        return view('admin/admin/updatetype', $arr);
    }

    //设置分类状态（禁用status=2）
    public function jintype()
    {
        if (Input::method() == 'POST') {
            $selected = DB::table('type')
                ->where('id', $_POST['id'])
                ->update(['status' => 2]);
            if ($selected) {
                $arr = [
                    'status' => 1,
                    'info' => '禁用成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '禁用失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '禁用失败'
            ];
        }
        exit(json_encode($arr));
    }

    //设置分类状态（正常status=1）
    public function huifu()
    {
        if (Input::method() == 'POST') {
            $selected = DB::table('type')
                ->where('id', $_POST['id'])
                ->update(['status' => 1]);
            if ($selected) {
                $arr = [
                    'status' => 1,
                    'info' => '恢复成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '恢复失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '恢复失败'
            ];
        }
        exit(json_encode($arr));
    }

    //文章管理
    public function content()
    {
        //获取分类（status=1）
        $model = new Type();
        $models = $model->normaltype();
        //获取该分类下的文章
        if (isset($_GET['id'])) {
            //获取该分类下的后台人员发布的文章
            $content = new Content();
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = 10;
            $contents = $content->content($_GET['id'], $limit);
            //dd($contents[0]);
            $count = $content->contentcount($_GET['id']);
            $arr = [
                'type' => $models,
                'content' => $contents,
                'count' => $count,
                'page' => $page,
                'id' => $_GET['id'],
            ];
        } else {
            $arr = [
                'type' => $models,
                'content' => [],
                'count' => 0,
                'page' => 0,
                'id' => 0
            ];
        }
        return view('admin/admin/content', $arr);
    }

    //一周精选
    public function jingxuan(){
        $content = new Content();
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $contents = $content->getSelected($limit);
        //dd($contents[0]);
        $count = $content->selectedcount();
        $arr = [
            'content' => $contents,
            'count' => $count,
            'page' => $page,
        ];
        return view('admin/admin/jingxuan', $arr);
    }
    //推荐
    public function tuijian(){
        $content = new Content();
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $contents = $content->getRecommended($limit);
        //dd($contents[0]);
        $count = $content->recommendedcount();
        $arr = [
            'content' => $contents,
            'count' => $count,
            'page' => $page,
        ];
        return view('admin/admin/tuijian', $arr);
    }
    //添加文章
    public function addcontent(Request $request)
    {
        if (Input::method() == 'POST') {
            if ($request->hasFile('image')) {
                $rootpath = './upload/content/';
                $imgurl = '';
                foreach ($request->file('image') as $k => $file) {
                    $filename = time() . $k . '.png';
                    $file->move($rootpath, $filename);
                    $imgurl .= trim($rootpath, '.') . $filename . ',';
                }
                //var_dump($imgurl);exit;
                //$file = $request->file('image')->move($rootpath, $filename);
                $validatedData = $request->validate([
                    'openid' => 'required',
                    'typeid' => 'required',
                    //'imgurl' => 'required|unique:type',
                    'title' => 'required',
                    'support' => 'required',
                    'selected' => 'required'
                ]);
                if ($validatedData) {
                    //dd($validatedData['title']);
                    $model = new Content();
                    $models = $model->addcontent($validatedData, trim($imgurl, ','));
                    if ($models) {
                        echo "<script>alert('添加成功!');location.href='" . url('/admin/admin/content?id=' . $validatedData['typeid']) . "';</script>";
                    } else {
                        echo "<script>alert('添加失败!');location.href='" . url('/admin/admin/addcontent') . "';</script>";
                    }
                }
            } else {
                //echo "<script>alert('请上传文件!');location.href='" . url('/admin/admin/addcontent') . "';</script>";
                $validatedData = $request->validate([
                    'openid' => 'required',
                    'typeid' => 'required',
                    //'imgurl' => 'required|unique:type',
                    'title' => 'required|max:1000',
                    'support' => 'required',
                    'selected' => 'required'
                ]);
                if ($validatedData) {
                    //dd($validatedData['title']);
                    $model = new Content();
                    $models = $model->addcontent($validatedData, $imgurl = '');
                    if ($models) {
                        echo "<script>alert('添加成功!');location.href='" . url('/admin/admin/content?id=' . $validatedData['typeid']) . "';</script>";
                    } else {
                        echo "<script>alert('添加失败!');location.href='" . url('/admin/admin/addcontent') . "';</script>";
                    }
                }
            }

        }
        //获取类型
        $typemodel = new Type();
        $type = $typemodel->normaltype();
        //获取发布人员
        $faburmodel = new Userinfo();
        $fabur = $faburmodel->getFabur();
        $arr = [
            'type' => $type,
            'fabur' => $fabur
        ];
        return view('admin/admin/addcontent', $arr);
    }

    //删除文章
    public function delcontent()
    {
        if (Input::method() == 'POST') {
            $selected = DB::table('content')
                ->where('id','=', $_POST['id'])
                ->update([
                    'status'=>2
                ]);
            if ($selected) {
                $arr = [
                    'status' => 1,
                    'info' => '删除成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '删除失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '删除失败'
            ];
        }
        exit(json_encode($arr));
    }

    //设置文章的状态为一周精选
    public function updateselected()
    {
        if (Input::method() == 'POST') {
            $selected = DB::table('content')
                ->where('id','=', $_POST['id'])
                ->update(['selected' => 2]);
            if ($selected) {
                $arr = [
                    'status' => 1,
                    'info' => '修改成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '修改失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '修改失败'
            ];
        }
        exit(json_encode($arr));
    }

    //取消文章的状态为一周精选
    public function delselected()
    {
        if (Input::method() == 'POST') {
            $selected = DB::table('content')
                ->where('id','=', $_POST['id'])
                ->update(['selected' => 1]);
            if ($selected) {
                $arr = [
                    'status' => 1,
                    'info' => '修改成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '修改失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '修改失败'
            ];
        }
        exit(json_encode($arr));
    }

    //设置文章的状态为推荐
    public function updaterecommended()
    {
        if (Input::method() == 'POST') {
            $selected = DB::table('content')
                ->where('id','=', $_POST['id'])
                ->update(
                    [
                        'recommended' => 2,
                        'tjtime'=>time()
                    ]
                );

            if ($selected) {
                $arr = [
                    'status' => 1,
                    'info' => '修改成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '修改失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '修改失败'
            ];
        }
        exit(json_encode($arr));
    }

    //取消文章状态推荐
    public function delrecommended()
    {
        if (Input::method() == 'POST') {
            $selected = DB::table('content')
                ->where('id','=', $_POST['id'])
                ->update(
                    [
                        'recommended' => 1,
                        'tjtime'=>''
                    ]
                );
            if ($selected) {

                $arr = [
                    'status' => 1,
                    'info' => '修改成功'
                ];
            } else {
                $arr = [
                    'status' => 0,
                    'info' => '修改失败'
                ];
            }
        } else {
            $arr = [
                'status' => 0,
                'info' => '修改失败'
            ];
        }
        exit(json_encode($arr));
    }

}
