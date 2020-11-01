

function ByWxPay(){
   var myf=document.getElementById('mydataform');
    myf.action=formPostUrl;
	$('#paytype').val('weixin');
	document.myform.submit();
}