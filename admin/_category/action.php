<?php
	include "functions.php";
	include "setting.php";
	$title_page="Thêm mới - Cập nhật";
	$action=$_POST['frmAction'];
	$edit_id=$_REQUEST['edit_id'];
	$error="";
	if($action=="Action")
	{
		$category_name=$_REQUEST['category_name'];
		$category_parent=$_REQUEST['category_parent'];
		$category_has_child=$_REQUEST['category_has_child'];
		$category_position=$_REQUEST['category_position'];
		$category_status=$_REQUEST['category_status']?1:0;
		
		if($category_name=="")
		{
			$error.=sprintf(ERR_NULL,"tên danh mục");
		}
		
		if($error)
		{
			$xtpl->assign('error',$error);
			$xtpl->parse('main.error');
		}
		else
		{
			if($edit_id)
			{
					$sql="UPDATE ".TABLE_PREFIX."category
							SET category_name='$category_name'
								,category_parent='$category_parent'
								,category_has_child='$category_has_child'
								,category_position='$category_position'
								,category_status='$category_status'
							WHERE md5(category_id)='$edit_id'";
					execSQL($sql);
					redir('index.php?mod=category');
					exit();		
			}
			else
			{
					$sql="INSERT INTO ".TABLE_PREFIX."category(
							category_name
							,category_parent
							,category_has_child
							,category_position
							,category_status
							) VALUES(
							'$category_name'
							,'$category_parent'
							,'$category_has_child'
							,'$category_position'
							,'$category_status'
							)";
					execSQL($sql);
					redir('index.php?mod=category');
					exit();
		}
		}
	}
	else
	{
		if($edit_id){
			$sql="SELECT category_name
						,category_parent	
						,category_has_child	
						,category_position
						,category_status
				 FROM ".TABLE_PREFIX."category
				 WHERE md5(category_id)='$edit_id'";
			$row=recordset($sql);
			$category_name			= $row['category_name'];
			$category_parent		= $row['category_parent'];
			$category_has_child		= $row['category_has_child'];
			$category_position		= $row['category_position'];
			$category_status		= $row['category_status']?1:0;
			
		}
	}
	
	$input_category_name			= gen_input_text('category_name',$category_name,50,255,'','a_text');
	$input_category_position		= gen_input_text('category_position',$category_position,10,10,'onkeypress="return onlynumber(event);"','a_text');
	$input_category_status			= gen_input_checkbox('category_status',1,$category_status,'','');
	$input_category_has_child		= gen_input_checkbox('category_has_child',1,$category_has_child,'','');
	$input_category_parent			= create_cms_category('category_parent');
	$input_hidden_edit_id			= gen_input_hidden('edit_id',$edit_id);
	
	$xtpl->assign('input_category_name',$input_category_name);
	$xtpl->assign('input_category_position',$input_category_position);
	$xtpl->assign('input_category_status',$input_category_status);
	$xtpl->assign('input_category_has_child',$input_category_has_child);
	$xtpl->assign('input_category_parent',$input_category_parent);
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('COM_ADD_UPDATE',COM_ADD_UPDATE);
	$xtpl->assign('COM_RESET',COM_RESET);
	$xtpl->assign('title_page',$title_page);
	
?>