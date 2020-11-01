<?php

require_once $smarty->_get_plugin_filepath('shared', 'make_timestamp');

function smarty_modifier_show_contact($str){
  $tmp = '';

  if (!empty($str)){
    $contacts = array_filter(explode(';', $str));
    if (count($contacts) > 1) {
      foreach ($contacts as $contact) {
        $arr = explode('|', $contact);
        $name = htmlspecialchars(rtrim($arr[0]));
        $email = htmlspecialchars(rtrim($arr[1]));
        if($name == ''){
            $name = '未知';
        }
       $tmp = $tmp . "<a email=\"$email\" title=\"$email\" >$name;</a>&nbsp;";
      }
    } else {
            $arr = explode('|', $contacts[0]);
            $name = htmlspecialchars(rtrim($arr[0]));
            $email = htmlspecialchars(rtrim($arr[1]));
             if($name == ''){
                $name = '未知';
            }
            $tmp = "";
            $tmp = $tmp . "<a email=\"$email\" title=\"$email\" >$name</a>";
      }
  }
  return $tmp;
}
?>
