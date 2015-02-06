<?php
	$title_page="Danh sách nhà quản trị";
	$admin_id=READ_SESSION('admin');
	// update status
	$bool_field=$_POST['bool_field'];
	$edit_id=$_POST['edit_id'];
	if($bool_field)
	{
		$sql="UPDATE ".TABLE_PREFIX."admin SET ".$bool_field."= not ".$bool_field." WHERE md5(admin_id)='$edit_id'";
		execSQL($sql); 
	}
	$keyword=$_POST['keyword'];
	$condition=" WHERE 1=1 ";
	if($keyword)
	{
		$condition.=" AND (admin_fullname LIKE '%$keyword%' OR admin_email LIKE '$keyword')";
	}

	$page=$_POST['page']?$_POST['page']:1;
	$pagegroup_size=10;
	$limit=20;
	$offset=($page-1)*$limit;
	$LIMIT=" LIMIT $offset,$limit";
	$sql="SELECT admin_id
				,md5(admin_id) as edit_id	
				,admin_fullname
				,admin_email
				,admin_is_active
				FROM ".TABLE_PREFIX."admin ".$condition ;
	$rs=execSQL($sql);
	$row_total=mysql_num_rows($rs);
	$sql.=$LIMIT;
	$rs=execSQL($sql);
	$array=get_fetch_assoc($rs);
	$pages=pagenavigator($page, $row_total, $limit, $pagegroup_size,'',$PHP_SELF) ;
	for($i=0;$i<count($array);$i++)
	{
		$array[$i]['no']=++$offset;
		$edit_id=$array[$i]['edit_id'];
		if($array[$i]['admin_is_active'])
		{
			$array[$i]['admin_is_active']='<a href="#" onclick="SetBoolean(\''.$edit_id.'\',\'admin_is_active\');">No</a> / <font color="red">Yes</font>';
		}else
		{
			$array[$i]['admin_is_active']='<a href="#" onclick="SetBoolean(\''.$edit_id.'\',\'admin_is_active\');">Yes</a> / <font color="red">No</font>';
		}
		$xtpl->assign('LIST',$array[$i]);
		$xtpl->parse('main.LIST');
	}			
	if($pages)
	{
		$xtpl->assign('pages',$pages);				
	}
	
	$xtpl->assign('COM_LBL_SEARCH',COM_LBL_SEARCH);								
	$xtpl->assign('COM_LBL_NO',COM_LBL_NO);
	$xtpl->assign('COM_LBL_ACTION',COM_LBL_ACTION);
	$xtpl->assign('COM_LBL_CHECKALL',COM_LBL_CHECKALL);
	$xtpl->assign('COM_LBL_TOTAL',sprintf(COM_LBL_TOTAL,$row_total));
	
	$xtpl->assign('title_page',$title_page);			
?>