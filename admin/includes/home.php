<?php
	include "modules/mod_login.php";
	$title=" Trang chủ";
	$admin_id=READ_SESSION('admin');
	$max=20;
	$sql="SELECT session_in,session_out, session_ip FROM ".TABLE_PREFIX."admin_session WHERE admin_id='$admin_id' ORDER BY session_in DESC LIMIT 0,$max";
	$rs=execSQL($sql);
	$array=get_fetch_assoc($rs);
	for($i=1;$i<count($array);$i++)
	{
		if($array[$i]['session_out']=="0000-00-00 00:00:00")
		{
			$array[$i]['session_out']="<font color=red>N/A</font>";
		}else
		{	
			$array[$i]['session_out']=formatDateFromDatabase($array[$i]['session_out'],false);	
		}
		$array[$i]['session_in']=formatDateFromDatabase($array[$i]['session_in'],false);	
		$xtpl->assign('session',$array[$i]);
		$xtpl->parse('main.session');
	}
	if($i == ($max))
	{
		$xtpl->assign('view_more',SESSION_VIEW_MORE);
		$xtpl->parse('main.view_more_session');
	}
	$admin_full_name=sprintf(SESSION_TITLE,get_admin_full_name($admin_id));
	$xtpl->assign('admin_full_name',$admin_full_name);
?>