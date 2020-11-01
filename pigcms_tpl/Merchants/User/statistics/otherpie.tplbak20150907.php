<!DOCTYPE html>
<html>
<head>
    <title>商家收入数据统计</title>
    <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/header.tpl.php';?>
	<script src="<?php echo $this->RlStaticResource;?>plugins/js/chartJs/Chart.min.js"></script>

	<style type="text/css">
.doughnut-legend,.bar-legend {
    list-style: outside none none;
    position: absolute;
    right: 25px;
    top: 60px;
}
.doughnut-legend li ,.bar-legend li{
    border-radius: 5px;
    cursor: default;
    display: block;
    font-size: 14px;
    margin-bottom: 4px;
    padding: 2px 8px 2px 28px;
    position: relative;
    transition: background-color 200ms ease-in-out 0s;
}
.doughnut-legend li span ,.bar-legend li span{
    border-radius: 5px;
    display: block;
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 20px;
}
	</style>
</head>
<body>
    <div id="wrapper">
     <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/leftmenu.tpl.php';?>
        <div id="page-wrapper" class="gray-bg">
        <?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/top.tpl.php';?>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-10">
				<h2>本平台商家支付数据统计</h2>
				<ol class="breadcrumb">
					<li>
						<a>User</a>
					</li>
					<li>
						<a>statistics</a>
					</li>
					<li class="active">
						<strong>otherpie</strong>
					</li>
				</ol>
            </div>
            <div class="col-lg-2">

            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>刷卡支付扫码次数（正扫）
                                <small>商家刷卡支付统计</small>
                            </h5>
                            <div ibox-tools></div>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="PieChart_m" height="150"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>收银台扫码次数（反扫）
                                <small>商家收银台扫码统计</small>
                            </h5>
                            <div ibox-tools></div>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="PieChart_w" height="150"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Bar Chart Example</h5>
                            <div ibox-tools></div>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="barChart" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
			 <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>商家扫码支付柱状对照图</h5>
                            <div ibox-tools></div>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="mwbarChart" height="80"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
            <div class="row">
                <!--<div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Polar Area</h5>

                            <div ibox-tools></div>
                        </div>
                        <div class="ibox-content">
                            <div class="text-center">
                                <canvas id="polarChart" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>支付来源总体统计</h5>

                            <div ibox-tools></div>
                        </div>
                        <div class="ibox-content">
                            <div>
                                <canvas id="doughnutChart" height="140"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
		<?php include RL_PIGCMS_TPL_PATH.APP_NAME.'/'.ROUTE_MODEL.'/public/footer.tpl.php';?>
        </div>
        </div>

</body>
<script type="text/javascript">
$(function () {
	var helpers = Chart.helpers;
    var doughnutData_m = [
        {
            value: <?php echo $mt_count;?>,
            color: "#a3e1d4",
            highlight: "#1ab394",
            label: "扫码总次数"
        },
        {
            value: <?php echo $mf_count;?>,
            color: "#CDE443",
            highlight: "#1ab394",
            label: "扫码支付次数"
        },
        {
            value: <?php echo $mt_price;?>,
            color: "#F38630",
            highlight: "#1ab394",
            label: "扫码支付金额￥"
        }
    ];

    var doughnutOptions = {
        segmentShowStroke: true,
        segmentStrokeColor: "#fff",
        segmentStrokeWidth: 2,
        //percentageInnerCutout: 45, // This is 0 for Pie charts
		percentageInnerCutout: 0, // This is 0 for Pie charts
        animationSteps: 100,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        animateScale: false,
        responsive: true,
		//tooltipTemplate : "<%if (label){%><%=label%>: <%}%><%= value %>kb", animation: false
    };


    var ctx = document.getElementById("PieChart_m").getContext("2d");
    var myNewChart = new Chart(ctx).Doughnut(doughnutData_m, doughnutOptions);
		/*var legendHolder = document.createElement('div');
		legendHolder.innerHTML = myNewChart.generateLegend();
		// Include a html legend template after the module doughnut itself
		helpers.each(legendHolder.firstChild.childNodes, function(legendNode, index){
			helpers.addEvent(legendNode, 'mouseover', function(){
				var activeSegment = myNewChart.segments[index];
				activeSegment.save();
				activeSegment.fillColor = activeSegment.highlightColor;
				myNewChart.showTooltip([activeSegment]);
				activeSegment.restore();
			});
		});
		helpers.addEvent(legendHolder.firstChild, 'mouseout', function(){
			myNewChart.draw();
		});*/
		$("#PieChart_m").parent().parent('.ibox-content').append(myNewChart.generateLegend());

    var doughnutData_w = [
        {
            value: <?php echo $wt_count;?>,
            color: "#a3e1d4",
            highlight: "#1ab394",
            label: "扫码总次数"
        },
        {
            value: <?php echo $wf_count;?>,
            color: "#CDE443",
            highlight: "#1ab394",
            label: "扫码支付次数"
        },
        {
            value: <?php echo $wt_price;?>,
            color: "#F38630",
            highlight: "#1ab394",
            label: "扫码支付金额￥"
        }
    ];

    var ctx = document.getElementById("PieChart_w").getContext("2d");
    var myNewChart = new Chart(ctx).Doughnut(doughnutData_w, doughnutOptions);
	$("#PieChart_w").parent().parent('.ibox-content').append(myNewChart.generateLegend());

    var barData = {
        labels: ["扫码总次数", "扫码支付次数", "扫码支付金额￥"],
        datasets: [
            {
                label: "刷卡支付数据（正扫）",
                fillColor: "rgba(87,187,7,0.5)",
                strokeColor: "rgba(87,187,7,0.8)",
                highlightFill: "rgba(87,187,7,0.75)",
                highlightStroke: "rgba(87,187,7,1)",
                data: [<?php echo $mt_count;?>, <?php echo $mf_count;?>, <?php echo $mt_price;?>]
            },
            {
                label: "收银台扫码次数（反扫）",
                fillColor: "rgba(245,129,37,0.5)",
                strokeColor: "rgba(245,129,37,0.8)",
                highlightFill: "rgba(245,129,37,0.75)",
                highlightStroke: "rgba(245,129,37,1)",
                data: [<?php echo $wt_count;?>, <?php echo $wf_count;?>, <?php echo $wt_price;?>]
            }
        ]
    };

    var barOptions = {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        barShowStroke: true,
        barStrokeWidth: 2,
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        responsive: true,
    }


    var ctx = document.getElementById("mwbarChart").getContext("2d");
    var myNewChart = new Chart(ctx).Bar(barData, barOptions);
	$("#mwbarChart").parent().parent('.ibox-content').append(myNewChart.generateLegend());

    var doughnutData = [
        {
            value: <?php echo $entirearr['local'];?>,
            color: "#a3e1d4",
            highlight: "#1ab394",
            label: "本平台支付总额"
        },
        {
            value: <?php echo $entirearr['other'];?>,
            color: "#dedede",
            highlight: "#1ab394",
            label: "其他平台支付总额"
        },
        {
            value: <?php echo $entirearr['refund'];?>,
            color: "#b5b8cf",
            highlight: "#1ab394",
            label: "退款总额"
        }
    ];

    var doughnutOptions = {
        segmentShowStroke: true,
        segmentStrokeColor: "#fff",
        segmentStrokeWidth: 2,
        percentageInnerCutout: 45, // This is 0 for Pie charts
        animationSteps: 100,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        animateScale: false,
        responsive: true,
		tooltipTemplate : "<%if (label){%><%=label%>: ￥<%}%><%= value %> 元", animation: false
    };


    var ctx = document.getElementById("doughnutChart").getContext("2d");
    var myNewChart = new Chart(ctx).Doughnut(doughnutData, doughnutOptions);
	$("#doughnutChart").parent().parent('.ibox-content').append(myNewChart.generateLegend());
	//var myNewChart = new Chart(ctx).Pie(doughnutData,doughnutOptions);

   /* var radarData = {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 90, 81, 56, 55, 40]
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(26,179,148,0.2)",
                strokeColor: "rgba(26,179,148,1)",
                pointColor: "rgba(26,179,148,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 96, 27, 100]
            }
        ]
    };

    var radarOptions = {
        scaleShowLine: true,
        angleShowLineOut: true,
        scaleShowLabels: false,
        scaleBeginAtZero: true,
        angleLineColor: "rgba(0,0,0,.1)",
        angleLineWidth: 1,
        pointLabelFontFamily: "'Arial'",
        pointLabelFontStyle: "normal",
        pointLabelFontSize: 10,
        pointLabelFontColor: "#666",
        pointDot: true,
        pointDotRadius: 3,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        responsive: true,
    }

    var ctx = document.getElementById("radarChart").getContext("2d");
    var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);*/

});
</script>
</html>
