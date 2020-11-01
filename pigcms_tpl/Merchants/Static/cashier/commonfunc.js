/*****退款处理******/
function wxRefundBtn(dom,orderid,mid){
   if(confirm('您确认要给该单退款？')){
		$.ajax({
			url: "?m=User&c=cashier&a=wxRefund",
			type: "POST",
			dataType: "json",
			data:{ordid:orderid,mid:mid},
			success: function(res){
				if(!res.error){
					swal({
        				title: "退款成功",
        					text: res.msg,
        					type: "success"
    					}, function () {
        					window.location.reload();
   						});

				}else{
					swal({
        					title: "退款失败",
        					text: res.msg,
        					type: "error"
    					}, function () {
        					//window.location.reload();
   						});
				}
				
				/*setTimeout(function(){
				  window.location.reload();
				}, 1000);*/
			}
		});
   }
}
/*****删除处理******/
function deltheOrder(dom,orderid,mid){
   if(confirm('您确定要删除此项？')){
		$.ajax({
			url: "?m=User&c=cashier&a=delOrderByid",
			type: "POST",
			dataType: "json",
			data:{ordid:orderid,mid:mid},
			success: function(res){
				if(res.status){
					swal({
        				title: "删除成功",
        					text: res.msg,
        					type: "success"
    					}, function () {
        					$(dom).parent().parent('tr').remove();
   						});

				}else{
					swal({
        					title: "删除失败",
        					text: res.msg,
        					type: "error"
    					}, function () {
        					//window.location.reload();
   						});
				}
				
				/*setTimeout(function(){
				  window.location.reload();
				}, 1000);*/
			}
		});
   }
}
function is_mobile(){
		var ua = navigator.userAgent.toLowerCase();
		if ((ua.match(/(iphone|ipod|android|ios|ipad|mobile)/i))){
				return true;
		}else{
			return false;
		}
	}