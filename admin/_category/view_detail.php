<?php
	include "functions.php";
	$title_page="Thông tin chi tiết";
	$edit_id=$_REQUEST['edit_id'];
	$sql="SELECT * FROM ".TABLE_PREFIX."category WHERE md5(category_id)='$edit_id'";
	$row=recordset($sql);
	$row['category_parent']=get_category_level($row['category_parent']);
	$row['category_status']=$row['category_status']?COM_YES:COM_NO;
	$row['category_image']="<a href='#' onclick='openwin(\"image_viewer.php?path=category&img=thumb_0_".$row['category_image']."\")'>".substr($row['category_image'],11,strlen($row['category_image'])-11)."</a>";
	$xtpl->assign('row',$row);
	$xtpl->assign("COM_BUTTON_BACK",COM_BUTTON_BACK);
	$xtpl->assign('title_page',$title_page);			
?>