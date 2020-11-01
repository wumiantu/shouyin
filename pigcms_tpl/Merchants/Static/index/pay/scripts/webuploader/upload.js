jQuery(function() {
        var $ = jQuery,
        $list = $('.images_box').find('ul'),

        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 100 * ratio,
        thumbnailHeight = 100 * ratio,

        // Web Uploader实例
        uploader;

        // 初始化Web Uploader
        uploader = WebUploader.create({

			// 自动上传。
			auto: true,

			// swf文件路径
			swf: './Uploader.swf',

			// 文件接收服务端。
			server: uplode_url,

			// 选择文件的按钮。可选。
			// 内部根据当前运行是创建，可能是input元素，也可能是flash.
			pick: '#filePicker',

			// 只允许选择文件，可选。
			accept: {
				title: 'Images',
				extensions: 'gif,jpg,jpeg,bmp,png',
				mimeTypes: 'image/*'
			}
		});

        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function(file){
            var $li = $(
                    '<li id="'+file.id+'"><div class="fl" style="80%;"><img  class="img_box"/><p class="fl"><span class="img_name">'+file.name+'</span><span class="img_size">'+fmart_size(file.size)+'</span></p></div><div class="fr close-box">X</div><div class="file_box" style="display:none;"><input type="hidden" name="info[images][]" value=""><div style="clear:both;"></div></li>'),

                $img = $li.find('img');
                $list.append($li);

            // 创建缩略图
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }
                $img.attr( 'src', src );
            }, thumbnailWidth, thumbnailHeight );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function(file,response) {
                if(response.status == 1){
                          $('#'+file.id).find('.file_box').find('input').val(response.path);
                }else{
                            alert('上传失败'+response.msg);
                }
          
        });

        // 文件上传失败，现实上传出错。
        uploader.on( 'uploadError', function(file,response) {
            alert('上传失败:'+response.msg);
            $('#'+file.id).remove();
        });
});
function fmart_size(size){
        var file_size = '';
        if(size/1204/1024 > 1){
            file_size = changeTwoDecimal(size/1024/1024)+'m';
        }else{
            file_size = changeTwoDecimal(size/1024)+'k';
        }
        return file_size;
}
                        