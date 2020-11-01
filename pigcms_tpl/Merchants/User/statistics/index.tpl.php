<!DOCTYPE html>
<html>
<head>
    <title>商家收入数据统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<link href="<?php echo $this->RlStaticResource;?>plugins/css/datapicker/datepicker3.css" rel="stylesheet">
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/chartJs/Chart.min.js"></script>
	<!-- Data picker -->
    <script src="<?php echo $this->RlStaticResource;?>plugins/js/datapicker/bootstrap-datepicker.js"></script>
	<style type="text/css">
	  #dataselect .input-group-btn,#ym-select .input-group-btn{width: 12%;}
	  #dataselect .input-sm ,#ym-select .input-sm{ border-radius: 7px; height:40px;}
	  #dataselect .btn-primary ,#ym-select .btn-primary{ margin-left: 20px; border-radius:4px;margin-bottom: 0px;}
	  #dataselect .input-group-addon,#ym-select .input-group-addon{border-radius: 7px;}
	  .ibox-content{ min-height:550px;}
	  .input-group .form-control{width: 45%;float:none;}
	</style>
</head>
<body>
    <div id="wrapper">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>商家支付数据统计</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>User</a>
                        </li>
                        <li>
                            <a>statistics</a>
                        </li>
                        <li class="active">
                            <strong>index</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
       	 	<div class="wrapper wrapper-content animated fadeIn">

			   <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
						<div class="ibox-title">
						<div id="dataselect" class="form-group">
                                <label class="font-noraml">选择日期</label>
                                <div id="datepicker" class="input-daterange input-group">
                                    <input type="text" value="<?php echo $aweekago;?>" name="start" class="input-sm form-control" id="datestart">
                                    &nbsp;<span> T O </span>&nbsp;
                                    <input type="text" value="<?php echo $today;?>" name="end" class="input-sm form-control" id="dateend">
									<span class="input-group-btn">
										<button class="btn btn-primary"> 查 询 </button>
									</span>
                                </div>
                            </div>
						</div>
                            <div class="ibox-content">
                                    <div id="canvasdesc">
                                        <span class="pull-right text-right">
                                        <small>每日支付状况<strong></strong></small>
                                            <br>
                                            
                                        </span>
                                        <h2 class="m-b-xs">总净收入 ￥<strong class="price1">0</strong></h2>
                                        <h3 class="m-b-xs">
                                           <span>总流水收入 ￥<strong class="price2">0</strong></span>
										   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>总退款 ￥<strong class="price3">0</strong></span>
                                        </h3>
                                        <!---<small></small>--->
                                    </div>

                                <div id="canvascontext" >
                                    <canvas height="100" id="lineChart"></canvas>
                                </div>

                                <!--<div class="m-t-md">
                                    <small class="pull-right">
                                        <i class="fa fa-clock-o"> </i>
                                        Update on 16.07.2015
                                    </small>
                                   <small>
                                       <strong>Analysis of sales:</strong> The value has been changed over time, and last month reached a level over $50,000.
                                   </small>
                                </div>-->

                            </div>
                        </div>
                    </div>
                </div>

			   <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
						<div class="ibox-title">
						<div id="ym-select" class="form-group">
                                <label class="font-noraml">选择年月</label>
                                <div id="ymdatepicker" class="input-daterange input-group">
                                    <input type="text" value="<?php echo $aYearagom;?>" name="start" class="input-sm form-control" id="ymstart">
                                    &nbsp;<span> T O </span>&nbsp;
                                    <input type="text" value="<?php echo $todaym;?>" name="end" class="input-sm form-control" id="ymend">
									<span class="input-group-btn">
										<button class="btn btn-primary"> 查 询 </button>
									</span>
                                </div>
                            </div>
						</div>
                            <div class="ibox-content">
                                    <div id="ymcanvasdesc">
                                        <span class="pull-right text-right">
                                        <small>每月支付状况<strong></strong></small>
                                            <br>
                                            
                                        </span>
                                        <h2 class="m-b-xs">总净收入 ￥<strong class="price1">0</strong></h2>
                                        <h3 class="m-b-xs">
                                           <span>总流水收入 ￥<strong class="price2">0</strong></span>
										   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>总退款 ￥<strong class="price3">0</strong></span>
                                        </h3>
                                        <!---<small></small>--->
                                    </div>

                                <div id="ym-canvascontext" >
                                    <canvas height="100" id="ymlineChart"></canvas>
                                </div>

                                <!--<div class="m-t-md">
                                    <small class="pull-right">
                                        <i class="fa fa-clock-o"> </i>
                                        Update on 16.07.2015
                                    </small>
                                   <small>
                                       <strong>Analysis of sales:</strong> The value has been changed over time, and last month reached a level over $50,000.
                                   </small>
                                </div>-->

                            </div>
                        </div>
                    </div>
                </div>

        	</div>
			<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
			$('#datepicker input').datepicker({
                keyboardNavigation: false,
                forceParse: false,
				format: "yyyy-mm-dd",
                autoclose: true
            });
			$('#ymdatepicker input').datepicker({
                keyboardNavigation: false,
                forceParse: false,
				format: "yyyy-mm",
                autoclose: true
            });
            var lineOptions = {
				//scaleStartValue:0,
				//scaleSteps : 10,//y轴刻度的个数
				//scaleStepWidth : 100,   //y轴每个刻度的宽度
				//scaleOverride :true ,   //是否用硬编码重写y轴网格线
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                bezierCurve: true,
                bezierCurveTension: 0.4,
                pointDot: true,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 2,
                datasetFill: true,
                responsive: true,
            };

	function GetChartData(typ,idstr,idstr2){
		if(typ=='date'){
		  $('#canvascontext').html('<canvas height="100" id="lineChart"></canvas>');
		  var start = $.trim($('#datestart').val());
		  var end = $.trim($('#dateend').val());
		  var pdatas={
		        'typ': typ,
			    'dstart':start,
			    'dend':end
			   }
			$.post('/merchants.php?m=User&c=statistics&a=getchart', pdatas, function(ret) {
				/*data = $.parseJSON(data);*/
				$('#'+idstr2+' .price1').text(ret.expand.ic);
				$('#'+idstr2+' .price2').text(ret.expand.tt);
				$('#'+idstr2+' .price3').text(ret.expand.rf);
				var lineChartData = {
					labels: ret.xdata,
					datasets: [{
                        label: "流水收入",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
						data: ret.ydata.idx1
					}]
				}

				if(typeof(ret.ydata.idx2)!='undefined'){
					var tmpobj={
							label: '退款金额',
							fillColor: "rgba(26,179,148,0.5)",
							strokeColor: "rgba(26,179,148,0.7)",
							pointColor: "rgba(26,179,148,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(26,179,148,1)",
							data: ret.ydata.idx2
						}
					lineChartData.datasets.push(tmpobj);
					
				}
				if(typeof(ret.ydata.idx3)!='undefined'){
					var tmpobj={
							label: '实际收入',
							fillColor: "rgba(26,179,148,0.5)",
							strokeColor: "rgba(26,179,148,0.7)",
							pointColor: "rgba(26,179,148,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(26,179,148,1)",
							data: ret.ydata.idx3
						}
					lineChartData.datasets.push(tmpobj);
					
				}
				/*obj = myLine.Line(lineChartData, {
					responsive: true
				});*/
				 var ctx = document.getElementById(idstr).getContext("2d");
				 var myNewChart = new Chart(ctx).Line(lineChartData, lineOptions);
			},'JSON');
		}else{
		  $('#ym-canvascontext').html('<canvas height="100" id="ymlineChart"></canvas>');
		  var start = $.trim($('#ymstart').val());
		  var end = $.trim($('#ymend').val());
		  var pdatas={
		        'typ': typ,
			    'dstart':start,
			    'dend':end
			   }
			$.post('/merchants.php?m=User&c=statistics&a=getchart', pdatas, function(ret) {
				/*data = $.parseJSON(data);*/
				$('#'+idstr2+' .price1').text(ret.expand.ic);
				$('#'+idstr2+' .price2').text(ret.expand.tt);
				$('#'+idstr2+' .price3').text(ret.expand.rf);
				var lineChartData = {
					labels: ret.xdata,
					datasets: [{
                        label: "流水收入",
                        fillColor: "rgba(220,220,220,0.5)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
						data: ret.ydata.idx1
					}]
				}

				if(typeof(ret.ydata.idx2)!='undefined'){
					var tmpobj={
							label: '退款金额',
							fillColor: "rgba(26,179,148,0.5)",
							strokeColor: "rgba(26,179,148,0.7)",
							pointColor: "rgba(26,179,148,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(26,179,148,1)",
							data: ret.ydata.idx2
						}
					lineChartData.datasets.push(tmpobj);
					
				}
				if(typeof(ret.ydata.idx3)!='undefined'){
					var tmpobj={
							label: '实际收入',
							fillColor: "rgba(26,179,148,0.5)",
							strokeColor: "rgba(26,179,148,0.7)",
							pointColor: "rgba(26,179,148,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(26,179,148,1)",
							data: ret.ydata.idx3
						}
					lineChartData.datasets.push(tmpobj);
					
				}
				/*obj = myLine.Line(lineChartData, {
					responsive: true
				});*/
				 var ctx = document.getElementById(idstr).getContext("2d");
				 var myNewChart = new Chart(ctx).Line(lineChartData, lineOptions);
			},'JSON');
		
		}
	 }
	 GetChartData('date','lineChart','canvasdesc');
		$('#dataselect .btn-primary').click(function(){
			GetChartData('date','lineChart','canvasdesc');
		});

	 GetChartData('month','ymlineChart','ymcanvasdesc');
		$('#ym-select .btn-primary').click(function(){
			GetChartData('month','ymlineChart','ymcanvasdesc');
		});

	});
    </script>
</body>
</html>