<?php
/**
 * Created by PhpStorm.
 * User: linhtruongtk
 * Date: 1/26/2015
 * Time: 4:21 PM
 */
$xtpl_header=new Xtemplate("templates/left.htm");
$xtpl_header->parse("left");
$header_tostring=$xtpl_header->text("left");
?>