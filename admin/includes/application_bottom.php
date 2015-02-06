<?php
include "footer.php";
$header_tostring=str_replace("#TITLE#",$title,$header_tostring);
$header_tostring=str_replace("#HEADING#",$heading_page,$header_tostring);
$header_tostring=str_replace("#MYMENU#",$my_menu,$header_tostring);
$xtpl->assign("header_tostring",$header_tostring);
$xtpl->assign("footer_tostring",$footer_tostring);
@mysql_close($dbconn);
$xtpl->parse('main');
eval("?>".$xtpl->text('main'));

?>