<?php
	
	include "functions.php";
	$title_page="Danh sách hỗ trợ";
	// update status
	$edit_id=$_REQUEST['edit_id'];
	$bool_field=$_POST['bool_field'];
	$edit_id=$_POST['edit_id'];
	$condition=" WHERE 1=1 ";

	$sql="SELECT md5(id) AS edit_id
				,fullname
				,address
				,phone
				,email
				FROM ".TABLE_PREFIX."share";
				
	$rs=execSQL($sql);
	$row_total=mysql_num_rows($rs);
	$num=0;
	while ($row=mysql_fetch_assoc($rs))
	{
		$edit_id=$row['edit_id'];
		$row['no']=++$num;
		$xtpl->assign('LIST',$row);
		$xtpl->parse('main.LIST');
	}			
	
	$xtpl->assign('show_result',$limit);								
	$xtpl->assign('COM_LBL_SEARCH',COM_LBL_SEARCH);	
	$xtpl->assign('COM_SHOW_RESULT',COM_SHOW_RESULT);								
	$xtpl->assign('COM_LBL_NO',COM_LBL_NO);
	$xtpl->assign('COM_LBL_ACTION',COM_LBL_ACTION);
	$xtpl->assign('COM_LBL_CHECKALL',COM_LBL_CHECKALL);
	$xtpl->assign('COM_LBL_TOTAL',sprintf(COM_LBL_TOTAL,$row_total));
	
	$xtpl->assign('MOD',$mod);	
	$xtpl->assign('title_page',$title_page);			
?>