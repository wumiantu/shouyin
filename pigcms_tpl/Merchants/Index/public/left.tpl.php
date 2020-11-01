<div id="sidebar" class="page-sidebar">
        <div class="page-sidebar-scroll">
            <div class="sidebar-controls" style="display:none">
            	<a href="#" class="sidebar-call"></a>
                <a href="#" class="sidebar-text"></a>
                <a href="#" class="sidebar-face"></a>
                <a href="#" class="sidebar-twit"></a>
                <a href="#" class="sidebar-close"></a>
            </div>  
 
            <div class="sidebar-header">
            <div style="width:262px;padding:0;margin:0">
            	<img class="sidebar-logo round-decoration" src="{$staff.avatar}" alt="img">
                <h4 class="center-text">{$staff.name}</h4>
                <em class="center-text">{$staff.position}</em>
            </div>
            </div>
            
            <div class="sidebar-breadcrumb">
            	<div class="sidebar-decoration"></div>
                <p>导航菜单</p>
                <div class="sidebar-decoration"></div>
            </div>
            
            <div class="navigation-items">
                <div class="nav-item" style="display:none">
                    <a href="index.html" class="home-nav">Home<em class="selected-nav"></em></a>
                </div>
                <div class="sidebar-decoration" style="display:none"></div>
                {if $menus}
                {foreach from=$menus item=m key=k}
                <div class="nav-item">
                    <a href="#" class="{$k}-nav submenu-deploy">{$m.name}<em{if $k!=$route_control} class="dropdown-nav"{/if}></em></a>
                    <div class="nav-item-submenu{if $k==$route_control} active-submenu{/if}">
                    	<div class="sidebar-decoration"></div>
                    	{if $m.subs}
                    	{foreach from=$m.subs item=sm key=sk}
                    	<a href="{$sm.link}">{$sm.name}	<em class="{if $k==$route_control&&$sk==$route_action}selected-sub-nav{else}unselected-sub-nav{/if}"></em></a>
                        {/foreach}
                        {/if}
                    </div>
                </div>
                <div class="sidebar-decoration"></div>
                {/foreach}
                {/if}
               
                <div class="nav-item">
                    <a href="#" class="close-nav">关闭菜单<em class="unselected-nav"></em></a>
                </div> 
            </div>      
            
            <div class="sidebar-breadcrumb" style="display:none">
            	<div class="sidebar-decoration"></div>
                <p>Page Updates</p>
                <div class="sidebar-decoration"></div>
            </div>     
            
            <div class="sidebar-updates" style="display:none">               
                <div class="sidebar-update red-update">
                    <strong>Warning</strong>
                    <em>Warning, something red here!</em>
                </div>     
                <div class="sidebar-update blue-update">
                    <strong>Notification</strong>
                    <em>Check it out! A blue notification!</em>
                </div>
                
                <div class="sidebar-update green-update">
                    <strong>Information</strong>
                    <em>Did you know? An information!</em>
                </div>
                
                <div class="sidebar-update yellow-update no-bottom">
                    <strong>Attention</strong>
                    <em>Pay attention, check this stuff!</em>
                </div>
            </div>
            
            <div class="sidebar-breadcrumb" style="display:none">
            	<div class="sidebar-decoration"></div>
                <p>Let's get social!</p>
                <div class="sidebar-decoration"></div>
            </div>  
            
            <div class="navigation-items" style="display:none">
                <div class="nav-item">
                    <a href="#" class="facebook-nav">Facebook<em class="link-nav"></em></a>
                </div> 
                <div class="sidebar-decoration"></div>
                <div class="nav-item">
                    <a href="#" class="twitter-nav">Twitter<em class="link-nav"></em></a>
                </div> 
            </div>  
            
            <div class="sidebar-decoration"></div>
            <div style="display:none">cGlnY21zIDA1NTEtNjUzNzE5OTgg5ZCI6IKl5b285bK45LqS6IGU5L+h5oGv5oqA5pyv5pyJ6ZmQ5YWs5Y+4</div>
			<p class="sidebar-copyright center-text" style="display:none">Copyright 2013.<br>All rights reserved.</p>
                    
        </div>
    </div>