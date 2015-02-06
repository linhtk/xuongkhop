<?php
	$title_page="Thông tin cá nhân";
	$admin_id=READ_SESSION('admin');
	$sql="SELECT admin_email
				,admin_fullname
				,admin_phone
				,admin_mobile FROM ".TABLE_PREFIX."admin WHERE admin_id='$admin_id'";
	$row=recordset($sql);
	$xtpl->assign('row',$row);
	$xtpl->assign('title_page',$title_page);			
?>