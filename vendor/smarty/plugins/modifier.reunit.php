<?php
function smarty_modifier_reunit($str){
        $unit=" B";
        if ($str > 1024) {
          $str = $str / 1024;
          $unit = " KB";
        }
        if ($str > 1024) {
          $str = $str / 1024;
          $unit = " MB";
        }
        if ($str > 1024) {
          $str = $str / 1024;
          $unit = " GB";
        }
        return round($str, 2) . $unit;
}
?>
