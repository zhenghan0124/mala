<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>文件：</td>
            <td><input type="file" name="text"/></td>
        </tr>
        <tr>
            <td><input type="submit" value="提交"/></td>
        </tr>
    </table>
    @if(!empty($ship))
    <video width="150" height="240" controls>
        <source src="{{$ship}}" type="video/mp4">
    </video>
    @endif
</form>
</body>
</html>