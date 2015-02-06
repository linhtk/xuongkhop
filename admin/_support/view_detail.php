<?php
	include "functions.php";
	$title_page="Thông tin chi tiết";
	$edit_id=$_REQUEST['edit_id'];
	$sql="SELECT * FROM ".TABLE_PREFIX."cms WHERE page_code='$edit_id'";
	$row=recordset($sql);
		if($row['page_image'])
		{
			if (file_exists("../images/cms/thumb_0_".$row['page_image']))
			{
				$row['page_image'] = '<a href="#" onclick="openwin(\'image_viewer.php?path=cms&img=thumb_0_'.$row['page_image'].'\');">'.COM_VIEW_IMAGE.'</a>';
			} else 
			{
				$row['page_image'] = 'Không có ảnh';
			}
		} else 
		{
			$row['page_image'] = 'Không có ảnh';
		}
	$xtpl->assign('row',$row);
	$xtpl->assign("COM_BUTTON_BACK",COM_BUTTON_BACK);
	$xtpl->assign('title_page',$title_page);			
?>