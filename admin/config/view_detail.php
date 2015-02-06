<?php
	include "functions.php";
	$title_page="Thông tin chi tiết";
	$edit_id=$_REQUEST['edit_id'];
	$sql="SELECT * FROM ".TABLE_PREFIX."gioithieu WHERE md5(gioithieu_id)='$edit_id'";
	$row=recordset($sql);
	$row['gioithieu_hienthi']=$row['gioithieu_hienthi']?COM_YES:COM_NO;
	$row['gioithieu_anh']="<a href='#' onclick='openwin(\"image_viewer.php?path=gioithieu&img=thumb_0_".$row['gioithieu_anh']."\")'>".substr($row['gioithieu_anh'],11,strlen($row['gioithieu_anh'])-11)."</a>";
	$xtpl->assign('row',$row);
	$xtpl->assign("COM_BUTTON_BACK",COM_BUTTON_BACK);
	$xtpl->assign('title_page',$title_page);			
?>