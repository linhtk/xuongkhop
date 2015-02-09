<?php
	include "functions.php";
	$title_page="Thông tin chi tiết";
	$edit_id=$_REQUEST['edit_id'];
	$sql="SELECT * FROM ".TABLE_PREFIX."news WHERE md5(news_id)='$edit_id'";
	$row=recordset($sql);
	$row['news_active']=$row['news_active']?COM_YES:COM_NO;
	$row['news_image']="<a href='#' onclick='openwin(\"image_viewer.php?path=news&img=thumb_0_".$row['news_image']."\")'>".substr($row['news_image'],11,strlen($row['news_image'])-11)."</a>";
	$xtpl->assign('row',$row);
	$xtpl->assign("COM_BUTTON_BACK",COM_BUTTON_BACK);
	$xtpl->assign('title_page',$title_page);			
?>