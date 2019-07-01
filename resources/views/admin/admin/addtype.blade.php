<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>添加分类</title>
    <link href="/mala/css/style.css" rel="stylesheet" type="text/css"/>
</head>

<body>

@extends('admin/admin/public')
@section('body')
<div class="formbody">

    <div class="formtitle"><span>基本信息</span></div>
    <form action="" method="post">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <ul class="forminfo">
        <li><label>分类标题</label><input name="title" type="text" class="dfinput"/>
            {{--<i>标题不能超过30个字符</i>--}}
        </li>
        <li><label>分类位置</label><input name="id" type="text" class="dfinput"/>
            {{--<i>标题不能超过30个字符</i>--}}
        </li>
        {{--<li><label>关键字</label><input name="" type="text" class="dfinput"/><i>多个关键字用,隔开</i></li>--}}
        {{--<li><label>是否审核</label><cite><input name="" type="radio" value=""--}}
                                            {{--checked="checked"/>是&nbsp;&nbsp;&nbsp;&nbsp;<input name="" type="radio"--}}
                                                                                               {{--value=""/>否</cite></li>--}}
        {{--<li><label>引用地址</label><input name="" type="text" class="dfinput" value="http://www..com/html/uidesign/"/></li>--}}
        {{--<li><label>文章内容</label><textarea name="" cols="" rows="" class="textinput"></textarea></li>--}}
        <li><label>&nbsp;</label><input name="" type="submit" class="btn" value="确认保存"/></li>
    </ul>
    </form>
@endsection

</div>
</body>
</html>
