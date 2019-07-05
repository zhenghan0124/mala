$.fn.extend({
  qy_upload_file:function(action,name,multiple){
    $(this).on("change","input[type='file']",function(){
      //添加form
      $(this).wrap("<form class='qy-upload-form' action="+action+" method='post' enctype='multipart/form-data'></form>");

      //提交form
      thisObj = $(this);
      $(this).parent().ajaxSubmit({
        dataType:  'json', //数据格式为json
        beforeSend: function() { //开始上传
        },
        uploadProgress: function(event, position, total, percentComplete) {
        },
        success: function(data) { //成功
          if(data.status == 1){
            thisObj.unwrap();
            thisObj.val("");

            //判断是否上传多张图片
            if(multiple == 0){
              thisObj.parent().before('<li><img src="/Public/admin/assets/images/document-icon.png" /><input type="hidden" name="'+name+'" value="'+data.path+data.pic+'" /><span class="qy-upload-del"><i class="fa fa-remove"></i></span><div class="attachment-title">'+data.name+'</div></li>');
              thisObj.parent().hide();
            }else{
              thisObj.parent().before('<li><img src="/Public/home/images/document-icon.png" /><input type="hidden" name="'+name+'[]" value="'+data.path+data.pic+'" /><span class="qy-upload-del"><i class="fa fa-remove"></i></span><div class="attachment-title">'+data.name+'</div></li>');
            }
          }else{
            thisObj.unwrap();
            thisObj.val("");
            alert("上传失败 "+data.info);
          }
        },
        error:function(xhr){ //上传失败
          thisObj.unwrap();
          thisObj.val("");
          alert("上传失败 "+xhr.responseText);
        }
      });
    });
    $(".qy-upload").on('click','.qy-upload-del',function(){
      if(multiple == 1){
        filename = $(this).parent().find("input[name='"+name+"[]']").val();
        this_file = $(this).parent();
        this_wrap = $(this).parent().parent();
        $.post("/admin/upload/del/",{filename:filename,},function(data,status){
          if(status == "success"){
            if(data == "1"){
              this_file.remove();
              size = this_wrap.find("input[name='"+name+"[]']").size();
              if(size == 0){
                $(".upload-pic-wrap").show();
              }
            }else{
              this_file.remove();
              size = this_wrap.find("input[name='"+name+"[]']").size();
              if(size == 0){
                $(".upload-pic-wrap").show();
              }
            }
          }else{
            alert("删除失败");
          }
        });
      }else{
        filename = $(this).parent().find("input[name='"+name+"']").val();
        this_file = $(this).parent();
        this_wrap = $(this).parent().parent();
        $.post("/admin/upload/del/",{filename:filename,},function(data,status){
          if(status == "success"){
            if(data == "1"){
              this_file.remove();
              size = this_wrap.find("input[name='"+name+"']").size();
              if(size == 0){
                this_wrap.find(".upload-pic-wrap").show();
              }
            }else{
              this_file.remove();
              size = this_wrap.find("input[name='"+name+"']").size();
              if(size == 0){
                this_wrap.find(".upload-pic-wrap").show();
              }
            }
          }else{
            alert("删除失败");
          }
        });
      }
    });
  },
});
