<?php
	$title_page="Thêm mới - Cập nhật";
	$xtpl->assign('title_page',$title_page);
	$action=$_POST['frmAction'];
	$edit_id=$_POST['edit_id'];
	if($action=="Action")
	{
		$error="";
		$admin_id				= $_POST['admin_id'];
		$admin_password			= $_POST['admin_password'];
		$admin_confirm_password = $_POST['admin_confirm_password'];
		$admin_email			= $_POST['admin_email'];
		$admin_fullname			= $_POST['admin_fullname'];
		$admin_phone			= $_POST['admin_phone'];
		$admin_mobile			= $_POST['admin_mobile'];
		$admin_is_active		= $_POST['admin_is_active']?1:0;
		$hidden_admin_password	= $_POST['hidden_admin_password'];
		$hidden_admin_id		= $_POST['hidden_admin_id'];
		if(!$edit_id)
		{
			if(!$admin_id)
			{
				$error.=sprintf(ERR_NULL,"tên truy cập");
			}
			$sql="SELECT count(*) as count FROM ".TABLE_PREFIX."admin WHERE admin_id='$admin_id'";
			$rs=recordset($sql);
			if($rs['count'])
			{
				$error.=sprintf(ERR_EXISTS,$admin_id);
			}
		}
		if(!$edit_id)
		{
			if(!$admin_password)
			{
				$error.=sprintf(ERR_NULL,"mật khẩu");
			}
			if(!$admin_confirm_password)
			{
				$error.=sprintf(ERR_NULL,"xác nhận mật khẩu");
			}
			if($admin_confirm_password!=$admin_password)
			{
				$error.=ERROR_NOT_MATCH_PASSWORD;
			}
		}
		else
		{
			
		}
		if(!$admin_fullname)
		{
			$error.=sprintf(ERR_NULL,"họ tên");
		}
		if(!$admin_email)
		{
			$error.=sprintf(ERR_NULL,"địa chỉ email");
		}
		if(!is_email($admin_email))
		{
			$error.=ERR_VALID_EMAIL;
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
				if($admin_password)
				{
					$admin_password=",admin_password=md5('$admin_password')";
				}
				$sql="UPDATE ".TABLE_PREFIX."admin
						SET admin_fullname='$admin_fullname'
							,admin_email='$admin_email'
							,admin_phone='$admin_phone'
							$admin_password
							,admin_mobile='$admin_mobile'
							,admin_is_active='$admin_is_active'
						WHERE md5(admin_id)='$edit_id'";
				execSQL($sql);
				redir('index.php?mod=admin');
				exit();		
			}
			else
			{
				$sql="INSERT INTO ".TABLE_PREFIX."admin(
						admin_id
						,admin_password
						,admin_fullname
						,admin_email
						,admin_phone
						,admin_mobile
						,admin_is_active
						) VALUES(
						'$admin_id'
						,md5('$admin_password')
						,'$admin_fullname'
						,'$admin_email'
						,'$admin_phone'
						,'$admin_mobile'
						,'$admin_is_active'
						)";
				execSQL($sql);
				redir('index.php?mod=admin');
				exit();
			}
		}
	}
	else
	{
		if($edit_id){
			$sql="SELECT admin_email
						,admin_id
						,admin_password	
						,admin_fullname
						,admin_phone
						,admin_is_active
						,admin_mobile FROM ".TABLE_PREFIX."admin WHERE md5(admin_id)='$edit_id'";
			$row=recordset($sql);
			$admin_email=$row['admin_email'];
			$admin_id=$row['admin_id'];
			$admin_fullname=$row['admin_fullname'];
			$admin_phone=$row['admin_phone'];
			$admin_mobile=$row['admin_mobile'];
			$admin_password=$row['admin_password'];
			$admin_is_active=$row['admin_is_active'];
		}
	}
	$admin_id=$admin_id?$admin_id:$hidden_admin_id;
	$admin_password=$admin_password?$admin_password:$hidden_admin_password;
	if($edit_id)
	{
		$input_hidden_admin_password=gen_input_hidden('hidden_admin_password',$admin_password);
		$input_hidden_admin_id=gen_input_hidden('hidden_admin_id',$admin_id);
		$admin_id_event = 'disabled="disabled"';
		$xtpl->assign('input_hidden_admin_password',$input_hidden_admin_password);
		$xtpl->assign('input_hidden_admin_id',$input_hidden_admin_id);
		$xtpl->assign('message_change_password',PASSWORD_NOT_CHANGE);
	}
	
	$input_admin_id=gen_input_text('admin_id',$admin_id,50,100,$admin_id_event,'a_text');
	$input_admin_email=gen_input_text('admin_email',$admin_email,50,100,'','a_text');
	$input_admin_password=gen_input_password('admin_password','',50,100,'','a_text');
	$input_admin_confirm_password=gen_input_password('admin_confirm_password','',50,100,'','a_text');
	$input_admin_fullname=gen_input_text('admin_fullname',$admin_fullname,50,100,'','a_text');
	$input_admin_phone=gen_input_text('admin_phone',$admin_phone,20,20,'','a_text');
	$input_admin_mobile=gen_input_text('admin_mobile',$admin_mobile,20,20,'','a_text');
	$input_admin_is_active=gen_input_checkbox('admin_is_active',1,$admin_is_active,'','');
	$input_hidden_edit_id=gen_input_hidden('edit_id',$edit_id);
	
	$xtpl->assign('input_admin_id',$input_admin_id);
	$xtpl->assign('input_admin_password',$input_admin_password);
	$xtpl->assign('input_admin_confirm_password',$input_admin_confirm_password);
	$xtpl->assign('input_admin_email',$input_admin_email);
	$xtpl->assign('input_admin_fullname',$input_admin_fullname);
	$xtpl->assign('input_admin_phone',$input_admin_phone);
	$xtpl->assign('input_admin_mobile',$input_admin_mobile);
	$xtpl->assign('input_admin_is_active',$input_admin_is_active);
	
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('COM_ADD_UPDATE',COM_ADD_UPDATE);
	$xtpl->assign('COM_RESET',COM_RESET);
	$xtpl->assign('COM_BUTTON_BACK',COM_BUTTON_BACK);
	$xtpl->assign('MOD',get('mod'));
	$xtpl->assign('title_page',$title_page);
?>