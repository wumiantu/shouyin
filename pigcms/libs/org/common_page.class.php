<?php
	/****样式*****#commonpage{width:100%; padding-bottom: 5px;border: 1px solid #bfbfbf;height: 52px;margin-top: 20px; text-align: center;}
	#commonpage .pages{display:inline-block;}
	#commonpage .pages a,#commonpage .pages span{display: inline-block;height: 35px;width: 40px;line-height: 35px;border: 1px solid #eee;margin-left: 5px;}
	#commonpage .pages a.prev{background:url(../images/shop_07.png) no-repeat;}
	#commonpage .pages a.next{background:url(../images/shop_09.png) no-repeat;}
	#commonpage .pn_page{position: relative;top: 12px;}
	#commonpage .pages .current{background-color: #fe5842;color: #fff;}*****
	HTML 直接输出 调用变量
		如 {pigcms{$pagebar}
	****************************/
class Page{
	// 起始行数
    public $firstRow;
	//现在页数
	public $nowPage;
	//总页数
	public $totalPage;
	//总行数
	public $totalRows;
	//分页的条数
	public $page_rows;
	//架构函数
	public function __construct($totalRows,$listRows){
		$this->totalRows = $totalRows;
		$this->nowPage  = !empty($_GET['page']) ? intval($_GET['page']) : 1;
		$this->listRows = $listRows;
		$this->totalPage = ceil($totalRows/$listRows);
		if($this->nowPage > $this->totalPage && $this->totalPage>0){
			$this->nowPage = $this->totalPage;
		}
		$this->firstRow = $listRows*($this->nowPage-1);
	}
    public function show($type=1){
		if($this->totalRows == 0) return false;
		$now = $this->nowPage;
		$total = $this->totalPage;
		
		$url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?");
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params['page']);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
		if(strpos(strrev($url),'?') === 0){
		   $url .= 'page=';
		}else{
		   $url .= '&page=';
		}
		/*$str = '<span class="total"><span id="row_count">'.$this->totalRows.'</span> 条记录 '.$now.' / '.$total.' 页  </span><div class="pages">';*/
		$str = '<div class="col-sm-6" id="commonpage"><div id="editable_paginate" class="dataTables_paginate paging_simple_numbers"><ul class="pagination"><li id="editable_previous" class="paginate_button previous"  ><span id="row_count">'.$now.' / '.$total.' 页 '.($type==1 ? '&nbsp;&nbsp;':'&nbsp;&nbsp;&nbsp;&nbsp;').'</span></li>';
		if($now > 1){
			$str .= '<li id="editable_previous" class="paginate_button previous"  >
				<a href="'.$url.($now-1).'">上一页</a>
			</li>';
			/*$str .= '<a href="'.$url.($now-1).'" class="prev pn_page" title="上一页">'.($type==1 ? '':'上一页').'</a>';*/
		}
		if($now!=1 && $now>4 && $total>6){
			/*$str .= '<a href="'.$url.'1" title="1">1</a><span class="page-numbers dots">…</span>';*/
			$str .= '<li class="paginate_button "  ><a href="'.$url.'1">1</a></li><li class="paginate_button "  ><a href="">...</a></li>';
		}
		for($i=1;$i<=5;$i++){
			if($now <= 1){
				$page = $i;
			}elseif($now > $total-1){
				$page = $total-5+$i;
			}else{
				$page = $now-3+$i;
			}
			if($page != $now  && $page>0){
				if($page<=$total){
					/*$str .= '<a href="'.$url.$page.'" title="第'.$page.'页" class="pga">'.$page.'</a>';*/
					$str .= '<li class="paginate_button"><a href="'.$url.$page.'">'.$page.'</a></li>';
				}else{
					break;
				}
			}else{
				if($page == $now) {/*$str.='<span class="current">'.$page.'</span>';*/
				    $str.='<li class="paginate_button active"  ><a href="">'.$page.'</a></li>';
				}
			}
		}
		if($total != $now && $now<$total-5 && $total>10){
			/*$str .= '<span class="dots">…</span><a href="'.$url.$total.'" title="第'.$total.'页">'.$total.'</a>';*/
			$str .='<li class="paginate_button"><a href="">...</a></li><li class="paginate_button active"  ><a href="'.$url.$total.'">'.$total.'</a></li>';
		}
		if ($now != $total){
			/*$str .= '<a href="'.$url.($now+1).'" class="next pn_page">'.($type==1 ? '':'下一页').'</a>';*/
			$str .= '<li class="paginate_button next"   id="editable_next"><a href="'.$url.($now+1).'">下一页</a></li>';
		}
		$str.='</ul></div></div>';
		return $this->totalRows > $this->listRows ?  $str : '';
    }
}
?>