<?php
	$title_page="Xác nhận thông tin xóa";
	$action=$_POST['frmAction'];
	$edit_id=$_POST['edit_id'];
	if($action=="Action")
	{
		if(strpos($edit_id,"~~~")===false)
		{
			
			$sql="DELETE FROM ".TABLE_PREFIX."category WHERE md5(category_id)='".$edit_id."'";
			execSQL($sql);
			$sql="DELETE FROM ".TABLE_PREFIX."category WHERE md5(category_id)='".$edit_id."'";
			execSQL($sql);
			
		}
		else
		{
			$arr_del=split("~~~",$edit_id);
			if(is_array($arr_del))
			{
				for($i=0;$i<count($arr_del);$i++)
				{
					$edit_id=trim($arr_del[$i]);
			
					$sql="DELETE FROM ".TABLE_PREFIX."category WHERE md5(category_id)='".$edit_id."'";
					execSQL($sql);
					$sql="DELETE FROM ".TABLE_PREFIX."product WHERE md5(category_id)='".$edit_id."'";
					execSQL($sql);
				}
			}
		}
		$message_confirm		= COM_MESSAGE_DEL_SUCCSESS;
		$input_submit_ok		= gen_input_button(COM_BUTTON_BACK,'onclick="history.go(-2);"','a_button');
	}
	else
	{
	
		$message_confirm		= COM_MESSAGE_CONFIRM;
		$input_submit_ok		= gen_input_submit(COM_BUTTON_DELETE,'','a_button');
		$input_button_cancel	= gen_input_reset(COM_BUTTON_UNDELETE,'onclick="history.go(-1);"','a_button');	
		$input_hidden_edit_id	= gen_input_hidden('edit_id',$edit_id);
	}
	
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('input_submit_ok',$input_submit_ok);	
	$xtpl->assign('input_button_cancel',$input_button_cancel);	
	$xtpl->assign('message_confirm',$message_confirm);			
	$xtpl->assign('title_page',$title_page);			
?>