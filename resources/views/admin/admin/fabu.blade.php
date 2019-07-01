<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>发布人员管理</title>
    <link href="/mala/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/mala/js/jquery.js"></script>

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
            <a href="/admin/admin/addfabur"><li class=""><span><img src="/mala/images/t01.png" /></span>添加</li></a>
            {{--<li class="click"><span><img src="images/t02.png" /></span>修改</li>--}}
            {{--<li><span><img src="images/t03.png" /></span>删除</li>--}}
            {{--<li><span><img src="images/t04.png" /></span>统计</li>--}}
        </ul>


        <ul class="toolbar1">
            {{--<li><span><img src="images/t05.png" /></span>设置</li>--}}
        </ul>

    </div>


    <table class="tablelist">
        <thead>
        <tr>
            {{--<th><input name="" type="checkbox" value="" checked="checked"/></th>--}}
            <th>编号<i class="sort"><img src="/mala/images/px.gif" /></i></th>
            <th>昵称</th>
            <th>头像</th>
            {{--<th>状态</th>--}}
            {{--<th>籍贯</th>--}}
            {{--<th>发布时间</th>--}}
            {{--<th>是否审核</th>--}}
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($fabur))
        @foreach($fabur as $v)
        <tr>
            {{--<td><input name="" type="checkbox" value="" /></td>--}}
            <td>{{$v->id}}</td>
            <td>{{$v->nickname}}</td>
            <td class="imgtd"><img style="width: 80px;height: 60px" src="{{$v->photo}}" /></td>
            {{--<td>--}}
                {{--@if($v->status==1)--}}
                    {{--正常--}}
                {{--@else--}}
                    {{--禁用--}}
                {{--@endif--}}
            {{--</td>--}}
            {{--<td>江苏南京</td>--}}
            {{--<td>2013-09-09 15:05</td>--}}
            {{--<td>已审核</td>--}}
            <td>
                <a href="/admin/admin/updatefabu?id={{$v->id}}" class="tablelink">修改</a>
                {{--<a href="#" class="tablelink">禁用</a>--}}
            </td>
        </tr>
        @endforeach
        @endif
        </tbody>
    </table>


    {{--<div class="pagin">--}}
        {{--<div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>--}}
        {{--<ul class="paginList">--}}
            {{--<li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">1</a></li>--}}
            {{--<li class="paginItem current"><a href="javascript:;">2</a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">3</a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">4</a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">5</a></li>--}}
            {{--<li class="paginItem more"><a href="javascript:;">...</a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;">10</a></li>--}}
            {{--<li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>--}}
        {{--</ul>--}}
    {{--</div>--}}


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
@endsection
<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>
</body>
</html>
