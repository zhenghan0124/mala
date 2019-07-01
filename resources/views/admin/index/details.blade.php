<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>文章详情</title>
    <link href="/mala/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/mala/css/select.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/mala/js/jquery.js"></script>
    <script type="text/javascript" src="/mala/js/jquery.idTabs.min.js"></script>
    <script type="text/javascript" src="/mala/js/select-ui.min.js"></script>
    <script type="text/javascript" src="/mala/editor/kindeditor.js"></script>

    <script type="text/javascript">
        KE.show({
            id : 'content7',
            cssPath : './index.css'
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(e) {
            $(".select1").uedSelect({
                width : 345
            });
            $(".select2").uedSelect({
                width : 167
            });
            $(".select3").uedSelect({
                width : 100
            });
        });
    </script>
</head>

<body>

@extends('/admin/admin/public')
@section('body')
    <div class="formbody">

        <div id="tab1" class="tabson">

            {{--<div class="formtext">Hi，<b>admin</b>，欢迎您试用信息发布功能！</div>--}}
            <form action="" method="post" enctype="multipart/form-data">

                <ul class="forminfo">
                    <li><label>是否一周精选<b></b></label>
                        <div class="vocation">
                            <select id="selected" class="select1" name="selected">
                                <option value="1">否</option>
                                <option value="2">是</option>
                            </select>
                        </div>
                    </li>
                    <li><label>是否推荐<b></b></label>
                        <div class="vocation">
                            <select id="recommended" class="select1" name="recommended">
                                <option value="1">否</option>
                                <option value="2">是</option>
                            </select>
                        </div>
                    </li>
                    <li><label>用户的头像<b></b></label>
                        @if(!empty($content->photo))
                        <img style="width: 160px;height: 120px" src="{{$content->photo}}" />
                        @else
                            该用户使用的微信头像
                        @endif
                    </li>
                    <li><label>标题<b></b></label>

                        {{--<textarea  id="content7" name="title" style=" border:1px solid green;width:700px;height:250px;"></textarea>--}}
                        {{--<textarea id="content7" name="title" style="width:700px;height:250px;visibility:hidden;"></textarea>--}}
                        <textarea name="title" style=" border:1px solid green;width:700px;height:300px;" readonly>{{$content->title}}</textarea>
                    </li>
                    <li><label>图片<b></b></label>
                        @foreach(explode(',', $content->imgurl) as $v)
                        <img style="width: 240px;height: 180px" src="{{$v}}" />
                        @endforeach
                    </li>
                    <li><label>&nbsp;</label><input  onclick="audit('{{$content->id}}')" name="" type="button" class="btn" value="审核通过"/></li>
                </ul>
            </form>
        </div>

        <script type="text/javascript">
            $("#usual1 ul").idTabs();
        </script>

        <script type="text/javascript">
            $('.tablelist tbody tr:odd').addClass('odd');
        </script>


        <script type="text/javascript">
            //提交审核
            function audit(id){
                //alert(id)
                var selected=$('#selected').val();
                var recommended=$('#recommended').val();
                var id=id;
                $.ajax({
                    url:'/admin/admin/updatecontentone',
                    type:'post',
                    data:{'id':id,'selected':selected,'recommended':recommended},
                    dataType:'json',
                    success:function(re){
                        if(re.status==1){
                            alert(re.info)
                        }else{
                            alert(re.info)
                        }
                    }
                })
            }

        </script>




    </div>
@endsection
</body>
</html>
