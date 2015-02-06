<?php
	include "functions.php";
	include "setting.php";
	$title_page="Thêm mới - Cập nhật";
	$action=$_POST['frmAction'];
	$edit_id=$_REQUEST['edit_id'];
	$error="";
	if($action=="Action")
	{
		$fullname=$_POST['fullname'];
		$phone=$_POST['phone'];
		$email=$_POST['email'];
		$address=$_POST['address'];
        $content=$_POST['content'];
		$edit_id=$_POST['edit_id'];
		
		if($fullname=="")
		{
			$error.=sprintf(ERR_NULL,"Họ tên");
		}
		if($phone=="")
		{
			$error.=sprintf(ERR_NULL,"Số điện thoại");
		}
		if($content=="")
		{
			$error.=sprintf(ERR_NULL,"Nội dung");
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
				
				$sql="UPDATE ".TABLE_PREFIX."contact
						SET 
							fullname='$fullname'
							,phone='$phone'
							,email='$email'
							,content='$content'
							,address='$address'
						WHERE md5(id)='$edit_id'";
				execSQL($sql);
				redir('index.php?mod=contact');
				exit();		
			
			}
			else
			{
				$sql="INSERT INTO ".TABLE_PREFIX."contact(
						fullname
						,phone
						,email
						,content
						,address
						) VALUES(
						'$fullname'
						,'$phone'
						,'$email'
						,'$content'
						,'$address'
						)";
				execSQL($sql);
				redir('index.php?mod=contact');
				exit();
			}
		}
	}
	else
	{
		if($edit_id){
			$sql="SELECT fullname
						,phone
						,email
						,content
						,address
						,md5(id) AS edit_id
					FROM ".TABLE_PREFIX."support
				 WHERE md5(id)='$edit_id'";
			$row=recordset($sql);
			$fullname					= $row['fullname'];
			$phone 				= $row['phone'];
			$email 				= $row['email'];
			$content 				= $row['content'];
            $address 				= $row['address'];
			$edit_id 				= $row['edit_id'];
			
		}
	}
	
	$input_fullname			= gen_input_text('fullname',$fullname,50,255,'','a_text');
	$input_phone			= gen_input_text('phone',$phone,50,255,'','a_text');
	$input_email			= gen_input_text('email',$email,50,255,'','a_text');
    $input_address			= gen_input_text('address',$address,50,255,'','a_text');
	$input_content				= gen_input_FCKEditor('content',$content);
	$input_hidden_edit_id		= gen_input_hidden('edit_id',$edit_id);
	
	$xtpl->assign('input_fullname',$input_fullname);
	$xtpl->assign('input_phone',$input_phone);
	$xtpl->assign('input_email',$input_email);
	$xtpl->assign('input_content',$input_content);
    $xtpl->assign('input_address',$input_address);
	
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('COM_ADD_UPDATE',COM_ADD_UPDATE);
	$xtpl->assign('COM_RESET',COM_RESET);
	$xtpl->assign('COM_BUTTON_BACK',COM_BUTTON_BACK);
	$xtpl->assign('MOD',get('mod'));
	$xtpl->assign('title_page',$title_page);
	
?>