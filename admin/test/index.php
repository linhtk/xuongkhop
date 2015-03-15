<?php
	
	include "functions.php";
	$title_page="Danh sách hỗ trợ";
	// update status
	$edit_id=$_REQUEST['edit_id'];
	$bool_field=$_POST['bool_field'];
	$edit_id=$_POST['edit_id'];
	$condition=" WHERE 1=1 ";
        $page=$_POST['page']?$_POST['page']:1;
	$pagegroup_size=10;
	$limit=($show_result?$show_result:20);
	$offset=($page-1)*$limit;
	$LIMIT=" ORDER BY position LIMIT $offset,$limit";
	$sql="SELECT md5(id) AS edit_id
				,question
				,position
				FROM ".TABLE_PREFIX."test_question".$condition ;
				
	$rs=execSQL($sql);
	$row_total=mysql_num_rows($rs);
	$sql.=$LIMIT;
	$rs=execSQL($sql);
	$array=get_fetch_assoc($rs);
	$pages=pagenavigator($page, $row_total, $limit, $pagegroup_size,'',$PHP_SELF) ;
	for($i=0;$i<count($array);$i++)
	{
		$edit_id=$array[$i]['edit_id'];
		$array[$i]['no']=++$num;
		$xtpl->assign('LIST',$array[$i]);
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