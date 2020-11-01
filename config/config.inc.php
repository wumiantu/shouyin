<?php
if(PHP_VERSION > '5.1'){
    @date_default_timezone_set('Asia/Shanghai');
}
/************************MySQL settings**************************/
define('TABLE_PREFIX','');
//define('GAME_TABLE_PREFIX','wechat_');
define('CHARSET','utf-8');
define('DB_CHARSET','utf-8');

/************************程序 settings**************************/
define('PIGCMS_KEY','pigcmso2oCashier');



/************************又拍云 settings*******************************/
define('upload_type',0); // 0为本地上传 1为又拍云 
define('up_bucket','');
define('up_form_api_secret','');
define('up_username','');
define('up_password','');
define('up_domainname','');
define('up_exts','jpeg,jpg,png,mp3,gif');
define('up_size','102400000');
require("update.class.php");
/*************加密配置**********************/
define('File_Service_Key','gewgdgxidconvsaifh');
define('File_Emergent_Mode','0');
define('File_Server_Topdomain','vnlcms.com');
?>