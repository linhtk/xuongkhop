<?php
	
	include "functions.php";
	$title_page="Danh sách tin tức";
	$table_name="news";
	// update status
	$bool_field=$_POST['bool_field'];
	$edit_id=$_POST['edit_id'];
	if($bool_field)
	{
		$sql="UPDATE ".TABLE_PREFIX.$table_name." SET ".$bool_field."= not ".$bool_field." WHERE md5(".$table_name."_id)='$edit_id'";
		execSQL($sql); 
	}
	if(is_array($position))
	{
		foreach ($position as $edit_id => $value)
		{
			$sql="UPDATE ".TABLE_PREFIX.$table_name." SET ".$table_name."_position= '$value' WHERE md5(".$table_name."_id)='$edit_id'";
			execSQL($sql); 
		}
	}
	$condition=" WHERE 1=1";
	$page=$_POST['page']?$_POST['page']:1;
	$pagegroup_size=10;
	$limit=($show_result?$show_result:20);
	$offset=($page-1)*$limit;
	$LIMIT=" LIMIT $offset,$limit";
	$sql="SELECT 
				md5(".$table_name."_id) as edit_id	
				,".$table_name."_id
				,news_title
				,news_image
				,news_active
				,news_is_hot
				FROM ".TABLE_PREFIX.$table_name." 
				".$condition ;
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
		if($array[$i]['news_image'])
		{
			if (file_exists("../upload/news/thumb_0_".$array[$i]['news_image']))
			{
				$array[$i]['news_image'] = '<a href="#" onclick="openwin(\'image_viewer.php?path=news&img=thumb_0_'.$array[$i]['news_image'].'\');">'.COM_VIEW_IMAGE.'</a>';
			} else 
			{
				$array[$i]['news_image'] = 'Không có ảnh';
			}
		} else 
		{
			$array[$i]['news_image'] = 'Không có ảnh';
		}
		if($array[$i]['news_active'])
		{
			$array[$i]['news_active']='<font color="red">'.COM_YES.'</font> / <a href="#" onclick="SetBoolean(\''.$edit_id.'\',\'news_active\');">'.COM_NO.'</a> ';
		}else
		{
			$array[$i]['news_active']='<a href="#" onclick="SetBoolean(\''.$edit_id.'\',\'news_active\');">'.COM_YES.'</a> / <font color="red">'.COM_NO.'</font>';
		}
		
		if($array[$i]['news_is_hot'])
		{
			$array[$i]['news_is_hot']='<font color="red">'.COM_YES.'</font> / <a href="#" onclick="SetBoolean(\''.$edit_id.'\',\'news_is_hot\');">'.COM_NO.'</a> ';
		}else
		{
			$array[$i]['news_is_hot']='<a href="#" onclick="SetBoolean(\''.$edit_id.'\',\'news_is_hot\');">'.COM_YES.'</a> / <font color="red">'.COM_NO.'</font>';
		}
		$xtpl->assign('LIST',$array[$i]);
		$xtpl->parse('main.LIST');
	}			
	if($pages)
	{
		$xtpl->assign('pages',$pages);				
	}
	
	
	$xtpl->assign('show_result',$limit);								
	$xtpl->assign('COM_LBL_SEARCH',COM_LBL_SEARCH);	
	$xtpl->assign('COM_SHOW_RESULT',COM_SHOW_RESULT);								
	$xtpl->assign('COM_LBL_NO',COM_LBL_NO);
	$xtpl->assign('COM_LBL_ACTION',COM_LBL_ACTION);
	$xtpl->assign('COM_LBL_CHECKALL',COM_LBL_CHECKALL);
	$xtpl->assign('COM_LBL_TOTAL',sprintf(COM_LBL_TOTAL,$row_total));
	
	$xtpl->assign('COM_CONFIRM_DELETE',COM_CONFIRM_DELETE);
	$xtpl->assign('MOD',$mod);
	$xtpl->assign('keyword',$keyword);	
	$xtpl->assign('title_page',$title_page);			
?>