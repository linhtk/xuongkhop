<?php

$title=$SITE_TITLE.' - '.$title;
$header_tostring=str_replace("#TITLE#",$title,$header_tostring);

$xtpl->assign("header_tostring",$header_tostring);
$xtpl->assign("left_tostring",$left_tostring);
$xtpl->assign("right_tostring",$right_tostring);
$xtpl->assign("footer_tostring",$footer_tostring);
$xtpl->parse('main');
eval("?>".$xtpl->text('main'));
@mysql_close($dbconn);
?>