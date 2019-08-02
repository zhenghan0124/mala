<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//登录页面
Route::any('/', function () {
    return view('admin/login/index');
});


//后台路由
Route::prefix('/admin')->group(function () {
    //测试
    Route::any('/login/test', 'Admin\LoginController@test');
    //登录页面
    Route::any('/login/index', 'Admin\LoginController@index');
    //后台首页
    Route::get('/admin/index', 'Admin\AdminController@index');
    //发布人员管理
    Route::get('/admin/fabu', 'Admin\AdminController@fabu');
    //修改发布人员
    Route::any('/admin/updatefabu', 'Admin\AdminController@updatefabu');
    //添加发布人员
    Route::any('/admin/addfabur', 'Admin\AdminController@addfabur');
    //分类管理
    Route::get('/admin/type', 'Admin\AdminController@type');
    //添加分类
    Route::any('/admin/addtype', 'Admin\AdminController@addtype');
    //修改分类
    Route::any('/admin/updatetype', 'Admin\AdminController@updatetype');
    //设置分类状态（status=1）
    Route::any('/admin/jintype', 'Admin\AdminController@jintype');
    //设置分类状态（status=2）
    Route::any('/admin/huifu', 'Admin\AdminController@huifu');
    //文章管理（后台发布）
    Route::any('/admin/content', 'Admin\AdminController@content');
    //文章管理（用户发布）
    Route::any('/index/content', 'Admin\IndexController@content');
    //查看用户发布的文章详情
    Route::any('/admin/details', 'Admin\IndexController@details');
    //修改当前文章
    Route::any('/admin/updatecontentone', 'Admin\IndexController@updatecontentone');
    //文章管理(一周精选)
    Route::any('/admin/jingxuan', 'Admin\AdminController@jingxuan');
    //文章管理(推荐)
    Route::any('/admin/tuijian', 'Admin\AdminController@tuijian');
    //发布文章
    Route::any('/admin/addcontent', 'Admin\AdminController@addcontent');
    //修改文章（为一周精选）
    Route::any('/admin/updateselected', 'Admin\AdminController@updateselected');
    //修改文章（取消一周精选）
    Route::any('/admin/delselected', 'Admin\AdminController@delselected');
    //修改文章（为推荐）
    Route::any('/admin/updaterecommended', 'Admin\AdminController@updaterecommended');
    //修改文章（取消推荐）
    Route::any('/admin/delrecommended', 'Admin\AdminController@delrecommended');
    //删除文章
    Route::any('/admin/delcontent', 'Admin\AdminController@delcontent');
});
//接口
Route::prefix('/home')->group(function () {
    //收集formid
    Route::any('/index/formid', 'Home\FormidController@formid');
    //消息通知（晚上7点发送一次；中午13点发送一次）
    Route::get('/index/sends', 'Home\CrontabController@sends');
    //登录接口
    Route::any('/index/dologin', 'Home\IndexController@dologin');
    //获取用户信息（授权）
    Route::any('/index/getuserinfo', 'Home\IndexController@getuserinfo');
    //编辑用户信息（上传头像）
    Route::any('/index/uploadphoto', 'Home\UserController@uploadimg');
    //编辑用户信息（编辑资料）
    Route::any('/index/editor', 'Home\UserController@editor');
    //获取用户信息（我的）
    Route::any('/index/getuserinfos', 'Home\UserController@getuserinfo');
    //添加关注
    Route::any('/index/addfocus', 'Home\UserController@addfocus');
    //取消关注
    Route::any('/index/delfocus', 'Home\UserController@delfocus');
    //获取关注人(关注)
    Route::any('/index/focususer', 'Home\UserController@focususer');
    //粉丝
    Route::any('/index/fans', 'Home\UserController@fans');
    //分类接口
    Route::any('/index/dotype', 'Home\IndexController@dotype');
    //首页接口
    Route::any('/index/doindex', 'Home\IndexController@doindex');
    //发现（一周精选）
    Route::any('/index/selected', 'Home\IndexController@selected');
    //发现（关注）
    Route::any('/index/focus', 'Home\IndexController@focus');
    //通过id获取文章
    Route::any('/index/contentone', 'Home\IndexController@contentone');
    //通过id获取评论
    Route::any('/index/getcomments', 'Home\IndexController@comments');
    //添加评论
    Route::any('/index/comments', 'Home\CommentsController@addComments');
    //添加评论的点赞次数
    Route::any('/index/commentsupport', 'Home\CommentsController@addSupport');
    //点赞接口
    Route::any('/index/support', 'Home\IndexController@support');
    //获取该用户的信息和文章(他们主页)
    Route::any('/index/getusercontent', 'Home\ContentController@getusercontent');
    //获取该用户的所有文章（动态）
    Route::any('/index/getusercontents', 'Home\ContentController@getusercontents');
    //查看消息（谁评论了我）
    Route::any('/index/message', 'Home\UserController@message');
    //查看消息（谁赞了我）
    Route::any('/index/issupport', 'Home\UserController@support');
    //收藏文章（点击收藏）
    Route::any('/index/collection', 'Home\ContentController@collection');
    //取消收藏文章（取消收藏）
    Route::any('/index/delcollection', 'Home\ContentController@delcollection');
    //我的收藏文章（我的收藏）
    Route::any('/index/mycollection', 'Home\ContentController@mycollection');
    //用户发布文章
    Route::any('/index/userrelease', 'Home\ContentController@userrelease');
    //删除文章
    Route::any('/index/delcontent', 'Home\ContentController@delcontent');
    //用户发布文章（上传图片-image）
    Route::any('/index/uploadimg', 'Home\ContentController@uploadimg');
    //生成代参的二维码
    Route::any('/index/qcode', 'Home\ImageController@hbimg');
    //生成代参的二维码
    Route::any('/index/qcodes', 'Home\ImageController@qcode');
    //分享生成代参的二维码
    Route::any('/index/shares', 'Home\ImageController@share');


    //生成代参的二维码
    Route::any('/index/huoqu', 'Home\ImagesController@hbimg');
    //生成代参的二维码
    Route::any('/index/ceshi', 'Home\ImagesController@qcode');
    //保存海报
    Route::any('/index/save', 'Home\ImageController@savehb');
    //测试
    Route::any('/index/test', 'Home\ImageController@test');

    //新粉丝
    Route::any('/index/newfan', 'Home\IndexController@newfans');

    //获取name
    Route::any('/index/name', 'Home\IndexController@name');

    //测试
    Route::any('/index/tests', 'Home\IndexController@tests');

    Route::any('/index/sign', 'Home\SignController@sign');

    Route::any('/index/signs', 'Home\SignController@source');

    Route::any('/index/signtest', 'Home\SignController@test');

    //总句豆
    Route::any('/index/querys', 'Home\IndexController@query');


    //测试路由
    Route::any('/index/thumb', 'Home\ImagesController@thumb');

    //图贴
    Route::any('/index/tutie', 'Home\TutieController@index');

    //美图
    Route::any('/index/meitu', 'Home\MeituController@index');

    /*
     * *
     *
     * 新版接口
     */

    //首页获取分类
    Route::any('/index/newtype', 'Home\NewindexController@donewtype');

    //首页
    Route::any('/index/newindex', 'Home\NewindexController@donewindex');

    //通过id获取文章
    Route::any('/index/newcontentone', 'Home\NewindexController@contentone');

    //同专辑推荐
    Route::any('/index/album', 'Home\NewindexController@album');

    //下载接口
    Route::any('/index/download', 'Home\NewindexController@download');

    //分享接口
    Route::any('/index/share', 'Home\NewindexController@share');

    //合集接口
    Route::any('/index/heji', 'Home\NewindexController@heji');

    //用户中心
    Route::any('/index/personal', 'Home\NewindexController@personal');

    //关注
    Route::any('/index/newmyfocus', 'Home\NewindexController@myfocus');

    //我的发布
    Route::any('/index/mycontents', 'Home\NewindexController@mycontents');

    //用户发布过的图片
    Route::any('/index/usercontentlist', 'Home\NewindexController@usercontentlist');

    //收藏文章（点击收藏）
    Route::any('/index/newcollection', 'Home\NewcontentController@collection');

    //取消收藏文章（取消收藏）
    Route::any('/index/newdelcollection', 'Home\NewcontentController@delcollection');

    //用户发布文章
    Route::any('/index/newuserrelease', 'Home\NewcontentController@userrelease');

    //用户发布文章（上传图片-image）
    Route::any('/index/newuploadimg', 'Home\NewcontentController@uploadimg');

    //获取固定图片
    Route::any('/index/fixedpicture', 'Home\NewcontentController@fixedpicture');

    //获取固定文字
    Route::any('/index/fixedtext', 'Home\NewcontentController@fixedtext');

    //画图
    Route::any('/index/shengcheng', 'Home\NewcontentController@shengcheng');
});



