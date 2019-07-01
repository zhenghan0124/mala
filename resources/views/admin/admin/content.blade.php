<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台文章管理</title>
    <link href="/mala/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/mala/js/jquery.js"></script>
    <script language="javascript">
        $(function(){
            //导航切换
            $(".imglist li").click(function(){
                $(".imglist li.selected").removeClass("selected")
                $(this).addClass("selected");
            })
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".click").click(function(){
                $(".tip").fadeIn(200);
            });

            $(".tiptop a").click(function(){
                $(".tip").fadeOut(200);
            });

            $(".sure").click(function(){
                $(".tip").fadeOut(100);
            });

            $(".cancel").click(function(){
                $(".tip").fadeOut(100);
            });

        });
    </script>
</head>


<body>

@extends('admin/admin/public')
@section('body')
<div class="rightinfo">

    <div class="tools">

        <ul class="toolbar">
            <a href="/admin/admin/addcontent"><li class=""><span><img src="/mala/images/t01.png" /></span>添加</li></a>
            <li class=""><span><img src="/mala/images/t04.png" /></span>后台人员发布</li>
            @foreach($type as $v)
                <a href="/admin/admin/content?id={{$v->id}}"><li class=""><span></span>{{$v->title}}</li></a>
            @endforeach
            {{--<li class="click"><span><img src="images/t02.png" /></span>修改</li>--}}
            {{--<li><span><img src="images/t03.png" /></span>删除</li>--}}
            {{--<li><span><img src="images/t04.png" /></span>统计</li>--}}
        </ul>


        <ul class="toolbar1">
            {{--<li><span><img src="images/t05.png" /></span>设置</li>--}}
        </ul>

    </div>


    <table class="imgtable">

        <thead>
        <tr>
            <th>编号</th>
            <th>分类</th>
            <th width="100px;">图片</th>
            <th>标题</th>
            {{--<th>栏目</th>--}}
            {{--<th>权限</th>--}}
            <th>发布人</th>
            <th>发布人头像</th>
            {{--<th>是否审核</th>--}}
            <th>点赞</th>
            <th>是否为一周精选</th>
            <th>是否为推荐</th>
            <th>发布时间</th>
            <th>操作</th>
        </tr>
        </thead>

        <tbody>
        @if(!empty($content))
        @foreach($content as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->typename}}</td>
            <td class="imgtd"><img style="width: 80px;height: 60px" src="{{explode(',', $v->imgurl)[0]}}" /></td>
            <td><a href="#"><textarea readonly>{{mb_substr($v->title,0,20)}}</textarea></a><p>{{$v->time}}</p></td>
            {{--<td>后台界面<p>ID: 82122</p></td>--}}
            {{--<td>开放浏览</td>--}}
            <td>{{$v->nickname}}</td>
            <td class="imgtd"><img style="width: 80px;height: 60px" src="{{$v->avatarurl}}" /></td>
            {{--<td>已审核</td>--}}
            <td>{{$v->support}}</td>
            <td>
                @if($v->selected==1)
                    不是
                    |  <a href="javascript:void(0)" onclick="add('{{$v->id}}')">添加</a>
                @else
                    是
                    |  <a href="javascript:void(0)" onclick="up('{{$v->id}}')">取消</a>
                @endif
            </td>
            <td>
                @if($v->recommended==1)
                    不是
                    |  <a href="javascript:void(0)" onclick="adds('{{$v->id}}')">添加</a>
                @else
                    是
                    |  <a href="javascript:void(0)" onclick="ups('{{$v->id}}')">取消</a>
                @endif
            </td>
            <td>{{$v->time}}</td>
            <td><a href="javascript:void(0)" onclick="del('{{$v->id}}')">删除</a></td>
        </tr>
        @endforeach
        @endif
        </tbody>

    </table>






    <div class="pagin">
        <div class="message">共<i class="blue">{{$count}}</i>条记录，当前显示第&nbsp;<i class="blue">{{$page}}</i>页</div>

        @if($id!=0)
            {{$content->appends(['id' => $id])->links()}}
        @endif
        {{--<ul class="paginList">--}}
            {{--<li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">1</a></li>--}}
            {{--<li class="paginItem current"><a href="javascript:;">2</a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">3</a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">4</a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">5</a></li>--}}
            {{--<li class="paginItem more"><a href="javascript:;">...</a></li>--}}
            {{--@for($i=1;$i<=$totalpage;$i++)--}}
            {{--<li class="paginItem"><a href="/admin/admin/content?id={{$id}}&p={{$i}}">{{$i}}</a></li>--}}
            {{--@endfor--}}
            {{--<li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>--}}
        {{--</ul>--}}
    </div>


    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>

        <div class="tipinfo">
            <span><img src="images/ticon.png" /></span>
            <div class="tipright">
                <p>是否确认对信息的修改 ？</p>
                <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
            </div>
        </div>

        <div class="tipbtn">
            <input name="" type="button"  class="sure" value="确定" />&nbsp;
            <input name="" type="button"  class="cancel" value="取消" />
        </div>

    </div>




</div>

<div class="tip">
    <div class="tiptop"><span>提示信息</span><a></a></div>

    <div class="tipinfo">
        <span><img src="images/ticon.png" /></span>
        <div class="tipright">
            <p>是否确认对信息的修改 ？</p>
            <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
    </div>

    <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
    </div>

</div>
@endsection
<script type="text/javascript">
    $('.imgtable tbody tr:odd').addClass('odd');
</script>
</body>
</html>
<script>
    function add(id){
        //alert(id)
        if (confirm("真的要添加吗?")){
            $.ajax({
                url:'/admin/admin/updateselected',
                dataType:'json',
                data:{'id':id},
                type:'post',
                success:function(re){
                    if(re.status==1){
                        alert(re.info)
                        location.href=location.href
                    }else{
                        alert(re.info)
                        location.href=location.href
                    }
                }
            })
        }
    }

    function adds(id){
        if (confirm("真的要添加吗?")){
            $.ajax({
                url:'/admin/admin/updaterecommended',
                dataType:'json',
                data:{'id':id},
                type:'post',
                success:function(re){
                    if(re.status==1){
                        alert(re.info)
                        location.href=location.href
                    }else{
                        alert(re.info)
                        location.href=location.href
                    }
                }
            })
        }
    }
    function ups(id){
        //alert(id)
        if (confirm("真的要取消吗?")){
            $.ajax({
                url:'/admin/admin/delrecommended',
                dataType:'json',
                data:{'id':id},
                type:'post',
                success:function(re){
                    if(re.status==1){
                        alert(re.info)
                        location.href=location.href
                    }else{
                        alert(re.info)
                        location.href=location.href
                    }
                }
            })
        }
    }


    function up(id){
        //alert(id)
        if (confirm("真的要取消吗?")){
            $.ajax({
                url:'/admin/admin/delselected',
                dataType:'json',
                data:{'id':id},
                type:'post',
                success:function(re){
                    if(re.status==1){
                        alert(re.info)
                        location.href=location.href
                    }else{
                        alert(re.info)
                        location.href=location.href
                    }
                }
            })
        }
    }
    function del(id){
        //alert(id)
        if (confirm("真的要删除吗?")){
            $.ajax({
                url:'/admin/admin/delcontent',
                dataType:'json',
                data:{'id':id},
                type:'post',
                success:function(re){
                    if(re.status==1){
                        alert(re.info)
                        location.href=location.href
                    }else{
                        alert(re.info)
                        location.href=location.href
                    }
                }
            })
        }
    }
</script>