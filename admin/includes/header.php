<?php
$xtpl_header=new Xtemplate("templates/header.htm");
$xtpl_header->parse("main");
$header_tostring=$xtpl_header->text("main");
?>