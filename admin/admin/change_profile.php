<?php
	$title_page="Đổi thông tin cá nhân";
	$xtpl->assign('title_page',$title_page);
	$action=post('frmAction');
	$admin_id=READ_SESSION('admin');
	if($action=="Action")
	{
		$error="";
		$admin_email=post('admin_email');
		$admin_fullname=post('admin_fullname');
		$admin_phone=post('admin_phone');
		$admin_mobile=post('admin_mobile');
		
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
			$sql="UPDATE ".TABLE_PREFIX."admin
					SET admin_fullname='$admin_fullname'
						,admin_email='$admin_email'
						,admin_phone='$admin_phone'
						,admin_mobile='$admin_mobile'
					WHERE admin_id='$admin_id'";
			execSQL($sql);
			redir('index.php?mod=admin&amp;act=view_detail');
			exit();		
		}
	}
	else
	{
		$sql="SELECT admin_email
					,admin_fullname
					,admin_phone
					,admin_mobile FROM ".TABLE_PREFIX."admin WHERE admin_id='$admin_id'";
		$row=recordset($sql);
		$admin_email=$row['admin_email'];
		$admin_fullname=$row['admin_fullname'];
		$admin_phone=$row['admin_phone'];
		$admin_mobile=$row['admin_mobile'];
	}
	$input_admin_email=gen_input_text('admin_email',$admin_email,50,100,'','a_text');
	$input_admin_fullname=gen_input_text('admin_fullname',$admin_fullname,50,100,'','a_text');
	$input_admin_phone=gen_input_text('admin_phone',$admin_phone,20,20,'','a_text');
	$input_admin_mobile=gen_input_text('admin_mobile',$admin_mobile,20,20,'','a_text');
	$xtpl->assign('input_admin_email',$input_admin_email);
	$xtpl->assign('input_admin_fullname',$input_admin_fullname);
	$xtpl->assign('input_admin_phone',$input_admin_phone);
	$xtpl->assign('input_admin_mobile',$input_admin_mobile);
?>