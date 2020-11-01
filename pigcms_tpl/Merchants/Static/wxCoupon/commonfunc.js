$(document).ready(function() {
var preview_dom="#js_preview_area .js_preview",
 is_first=false;
 edit_dom="#js_edit_area";
var previewdivH=$('#js_preview_area .msg_card').offset().top;
$("#js_preview_area").on("click",".js_edit_icon",function(){
         var actid=$(this).data('actionid');
         if($(edit_dom+' .econtent'+actid).css('display')!='block'){
		    $(edit_dom+' .js_edit_content').css('display','none');
			$(edit_dom+' .econtent'+actid).css('display','block');
		 }
		 var divobj=$(this).parent().parent('.itemdiv');
		 gothat(actid,divobj);
		 return false;
	});

	function gothat(acid,divobj){
		    var mytop=tmpH=itemdivH=0;
		    switch(acid){
			  case 1:
			  $(edit_dom).css("marginTop",0);
			  break;
			  case 2:
			  $('#js_destroy_title').hide();
			  $('.js_code_preview_2').show();
			  mytop =divobj.offset().top;
			  itemdivH=divobj.height();
			  tmpH=mytop-previewdivH-130+itemdivH/2;
			  tmpH=Math.ceil(tmpH);
			  $(edit_dom).css("marginTop",tmpH);
			  break;
			  case 3:
			  case 4:
			  case 5:
			  mytop =divobj.offset().top;
			  itemdivH=divobj.height();
			  tmpH=mytop-previewdivH-130+itemdivH/2;
			  tmpH=Math.ceil(tmpH);
			  $(edit_dom).css("marginTop",tmpH);
			  break;
			}
			
		}
  $('#js_edit_area .ckinput').each(function(){
      var thisid=$(this).attr('id');
    $('#'+thisid).keyup(function(){
	  var inputstr=$(this).val();
	  var strleng=inputstr.gbLen();
	  var tmplen=0;
	  if(!inputstr && (thisid=='promotionname' || thisid=='customurlname')){
	      $('#'+thisid+'_preview').text('自定义入口(选填)');
	  }else{
          $('#'+thisid+'_preview').text(inputstr);
	  }
	  $('#js_'+thisid+'_tip').text(Math.ceil(strleng/2));
	  var tipsObj=$(this).parent().siblings('.frm_msg');
	  var limitnum=$.trim($('#js_'+thisid+'_limit').text());
	  limitnum=parseInt(limitnum);
	  if(limitnum>0){
		  limitnum=limitnum*2;
		  if(strleng > limitnum){
			  tmplen=strleng-limitnum;
			  tipsObj.find('span').find('strong').text(Math.ceil(tmplen/2)+'个汉字或者'+tmplen+'个英文字母');
			  tipsObj.show();
		  }else{
			  tipsObj.hide();
			  tipsObj.find('span').find('strong').text('');
		  }
	  }
  });

  });

 function checkInPut(){
	 var tflag=true;
	 if(wxCouponType==2){
	   var discount=$.trim($('#js_discount').val());
	   discount=parseFloat(discount);
	   if(!(discount>1)){
	      $('#js_discount').val('').focus();
		  tflag=false;
	   }else{
	      $('#js_discount').val(discount);
	   }
     }else if(wxCouponType==4){
	     var reduce_cost=$.trim($('#js_reduce_cost').val());
		 reduce_cost=parseFloat(reduce_cost);
		 if(reduce_cost > 0.01){
		   $('#js_reduce_cost').val(reduce_cost.toFixed(2));
		 }else{
		    $('#js_reduce_cost').val('0').focus();
		 }
		 var least_cost=$.trim($('#js_least_cost').val());
		 least_cost=parseFloat(least_cost);
		 if(least_cost>0.01){
		   $('#js_least_cost').val(least_cost.toFixed(2));
		 }else{
		    $('#js_least_cost').val('0').focus();
		 }
	 }
   $('#js_edit_area .ckinput').each(function(){
      var thisid=$(this).attr('id');
    
	  var inputstr=$(this).val();
	  var strleng=inputstr.gbLen();
	  var limitnum=$.trim($('#js_'+thisid+'_limit').text());
	  limitnum=parseInt(limitnum);
	  if(limitnum>0){
		  limitnum=limitnum*2;
		  if(strleng > limitnum){
			  var divobj=$(this).parents('.js_edit_content');
			  divobj.siblings().hide();
			  divobj.show();
			  $(this).focus();
			  tflag=false;
			  return false;
		  }
	  }
  });

	return tflag;
  }
  /*$('#brand_name').keyup(function(){
	  var inputstr=$(this).val();
	  var strleng=inputstr.gbLen();
	  var tmplen=0;
      $('#brand_name_preview').text(inputstr);
	  $('#js_brand_name_tip').text(Math.ceil(strleng/2));
	  var tipsObj=$(this).parent().parent().siblings('.frm_msg');
	  if(strleng > 24){
		  tmplen=strleng-24;
		  tipsObj.find('span').find('strong').text(Math.ceil(tmplen/2)+'个汉字或者'+tmplen+'个英文字母');
	      tipsObj.show();
	  }else{
		  tipsObj.hide();
		  tipsObj.find('span').find('strong').text('');
	  }
  });
*/
  $('#js_colorpicker .jsDropdownBt').click(function(){
      $('#js_colorpicker .dropdown_data_container').show();
  });

  $('#description').change(function(){
     var content=$.trim($(this).val());
	 if(!content || content.gbLen() > 600){
	     $(this).parent().parent().siblings('.frm_msg').show();
	 }else{
	     $(this).parent().parent().siblings('.frm_msg').hide();
	 }
  });
  $('#detailtext').change(function(){
     var content=$.trim($(this).val());
	 if(!content || content.gbLen() > 6144){
	     $(this).parent().parent().siblings('.frm_msg').show();
	 }else{
	     $(this).parent().parent().siblings('.frm_msg').hide();
	 }
  });
	$('#js_reduce_cost').change(function(){
	   var reduce_cost=$.trim($(this).val());
	   if(!(parseFloat(reduce_cost)>0.01)){
	      $(this).parent().parent().siblings('.frm_msg').show();
	   }else{
	      $(this).parent().parent().siblings('.frm_msg').hide();
	   }
	});
	
	$('#ymstart').change(function(){
      $('#js_time_preview .time1').text($(this).val());
   }); 

  $('#ymend').change(function(){
      $('#js_time_preview .time2').text($(this).val());
   }); 
   
$('#sub_add_card').click(function(){
	    if(checkInPut()){
		$.ajax({
			url:$('#js_editform').attr('action'),
			type:"post",
			data:$('form').serialize(),
			dataType:"JSON",
			success:function(ret){
				if(!ret.error){
				   window.location.href="?m=User&c=wxCoupon&a=index";
				}else{
					swal({
					  title: "保存失败！",
					  text: ret.msg,
					  type: "error"
					 }, function () {
					//window.location.reload();
					});
			   }
			}
		});
	  }
	  return false;
       //document.js_editform.submit();
	});
  $('#js_discount').keyup(function(){
        $(this).val($(this).val().replace(/[^1234567890\.]+/g,''));
		var inputstr=$.trim($(this).val());
		if(inputstr.length>3){
		   $(this).val(inputstr.slice(0,3));
		}
   });
   $('#brand_name').keyup();
});

function GetTishColor(colorN,colorV){
  $('#js_colorpicker .jsBtLabel').css('background-color',colorV);
  $('#js_color').val(colorN);
  $('#js_color_preview').css('background-color',colorV);
  $('#js_colorpicker .dropdown_data_container').hide();
}

/***计算字符串长度(英文占1个字符，中文汉字占2个字符)*****/
String.prototype.gbLen = function() {    
	var len = 0;    
	for (var i=0; i<this.length; i++) {    
		if (this.charCodeAt(i)>127 || this.charCodeAt(i)==94) {    
			 len += 2;    
		 } else {    
			 len ++;    
		 }    
	 }    
	return len;    
}
function strLen(str){  
	var len = 0;  
	for (var i=0; i<str.length; i++) {   
	 var c = str.charCodeAt(i);   
	//单字节加1   
	 if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {   
	   len++;   
	 }   
	 else {   
	  len+=2;   
	 }   
	}   
	return len;  
}  