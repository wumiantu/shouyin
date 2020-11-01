$('#downloadEwm').click(function(){
 var canvasobj=$('#qr-code-forever').find('canvas');
 if(canvasobj.size() >0 ){
     saveCanvasImg(canvasobj.get(0),'JPEG','you-need-pay-money-'+thismoney+'yuan-ewmimg.jpg');
 }else{
    alert('您还没有生成支付二维码');
 }
});

function saveCanvasImg(canvasObj,imgtype,fname){
		var bRes = false;
		if (imgtype == "PNG")
			bRes = Canvas2Image.saveAsPNG(canvasObj,300,300,fname);
		if (imgtype == "BMP")
			bRes = Canvas2Image.saveAsBMP(canvasObj,300,300,fname);
		if (imgtype == "JPEG")
			bRes = Canvas2Image.saveAsJPEG(canvasObj,300,300,fname);
   }

 function GetDetail(id,mid){
   var getUrl='?m=User&c=cashier&a=odetail&orid='+id+'&mid='+mid;
    $.get(getUrl,function(ret){
	   if(ret){
		   $('body').append('<div class="modal-backdrop in"></div>');
	      $('#oderinfo .modal-body').html(ret);
		  $('#oderinfo').show();
	   }
	},'html');
 }

  $("#oderinfo ._close").click(function(){
	  $('#oderinfo').hide();
	  $('.modal-backdrop').remove();
	  $('#oderinfo .modal-body').html('');
  });