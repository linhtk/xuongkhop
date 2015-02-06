<?php
	$title_page="Đổi mật khẩu";
	$xtpl->assign('title_page',$title_page);
	$action=post('frmAction');
	$admin_id=READ_SESSION('admin');
	if($action=="Action")
	{
		$error="";
		$admin_password=post('admin_password');
		$admin_newpassword=post('admin_newpassword');
		$admin_confirmpassword=post('admin_confirmpassword');
		
		
		if(!$admin_password)
		{
			$error.=sprintf(ERR_NULL,"mật khẩu");
		}
		if(!$admin_newpassword)
		{
			$error.=sprintf(ERR_NULL,"mật khẩu mới");
		}
		if(!$admin_confirmpassword)
		{
			$error.=sprintf(ERR_NULL,"xác nhận mật khẩu");
		}
		if($admin_newpassword!=$admin_confirmpassword)
		{
			$error.="Mật khẩu mới không khớp với xác nhận mật khẩu.<br/>";
		}
		$password=md5($admin_password);
		$sql="SELECT count(*) as count FROM ".TABLE_PREFIX."admin WHERE admin_id='$admin_id' AND admin_password='$password' ";
		$rs=recordset($sql);
		if(!$rs['count'])
		{	
			$error.=ERR_PASSWORD_NOT_FOUND;
		}
		if($error)
		{
			
			$xtpl->assign('error',$error);
			$xtpl->parse('main.error');
		}
		else
		{
			$admin_newpassword=md5($admin_newpassword);
			$sql="UPDATE ".TABLE_PREFIX."admin
					SET admin_password='$admin_newpassword'
					WHERE admin_id='$admin_id'";
			execSQL($sql);
			redir('index.php?mod=admin&amp;act=view_detail');
			exit();		
		}
	}
	$admin_password='';
	$admin_newpassword='';
	$admin_confirmpassword='';
	$input_admin_password=gen_input_password('admin_password','',50,100,'','a_text');
	$input_admin_newpassword=gen_input_password('admin_newpassword','',50,100,'','a_text');
	$input_admin_confirmpassword=gen_input_password('admin_confirmpassword','',50,100,'','a_text');
	$xtpl->assign('input_admin_password',$input_admin_password);
	$xtpl->assign('input_admin_newpassword',$input_admin_newpassword);
	$xtpl->assign('input_admin_confirmpassword',$input_admin_confirmpassword);
	
?>