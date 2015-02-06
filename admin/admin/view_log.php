<?php
	$title_page="Quá trình đăng nhập";
	$xtpl->assign('title_page',$title_page);
	$action=post('frmAction');
	$admin_id=READ_SESSION('admin');
	$page=post('page')?post('page'):1;
	$pagegroup_size=10;
	$limit=20;
	$offset=($page-1)*$limit;
	$LIMIT=" LIMIT $offset,$limit";
	$sql="SELECT session_in,session_out, session_ip FROM ".TABLE_PREFIX."admin_session WHERE admin_id='$admin_id' ORDER BY session_in DESC ";
	$rs=execSQL($sql);
	$row_total=mysql_num_rows($rs);
	$sql.=$LIMIT;
	$rs=execSQL($sql);
	$array=get_fetch_assoc($rs);
	$pages=pagenavigator($page, $row_total, $limit, $pagegroup_size,'',$PHP_SELF) ;
	for($i=1;$i<count($array);$i++)
	{
		if($array[$i]['session_out']=="0000-00-00 00:00:00")
			$array[$i]['session_out']="<font color=red>N/A</font>";
		else
		{	
			$array[$i]['session_out']=formatDateFromDatabase($array[$i]['session_out'],false);	
		}
		$array[$i]['session_in']=formatDateFromDatabase($array[$i]['session_in'],false);	
		$xtpl->assign('session',$array[$i]);
		$xtpl->parse('main.session');
	}
	$xtpl->assign('pages',$pages);
	
?>