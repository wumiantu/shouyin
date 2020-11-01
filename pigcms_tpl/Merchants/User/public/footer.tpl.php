    <div class="appfooter">
        <ul class="clearfix">
            <li>
                <a href="/merchants.php?m=User&c=index&a=index"><i class="fa fa-home"></i>首页</a>
            </li>
            <li>
                <a href="/merchants.php?m=User&c=cashier&a=payment&type=1"><i class="fa fa-inbox"></i>收款</a>
            </li>
            <li>
                <a href="/merchants.php?m=User&c=cashier&a=payment&type=2"><i class="fa fa-undo"></i>退款</a>
            </li>
            <li>
                <a href="/merchants.php?m=User&c=wxCoupon&a=consumeCard"><i class="fa fa-file-text-o"></i>核销</a>
            </li>
        </ul>
    </div>
<script type="text/javascript">
if(mobilecheck()){
$("#side-menu li").click(function () {
   $("#side-menu li").find('.nav-second-level').css('display','none');
   $(this).find('.nav-second-level').css('display','block').css('min-width','140px');
 });
}
</script>