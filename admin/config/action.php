<?php
	include "functions.php";
	include "setting.php";
	$title_page="Thêm mới - Cập nhật";
	$action=$_POST['frmAction'];
	$edit_id=$_REQUEST['edit_id'];
	$error="";
	if($action=="Action")
	{
		$config_title_site=$_POST['config_title_site'];
		$config_phone=$_POST['config_phone'];
		$config_facebook=$_POST['config_facebook'];
		$config_email=$_POST['config_email'];
		$config_google_plus=$_POST['config_google_plus'];
		$config_meta = $_POST['config_meta'];
		//$config_yahoo_sale = $_POST['config_yahoo_sale'];
		//$config_footer_content = $_POST['config_footer_content'];
		$edit_id = $_POST['edit_id'];
		//$hidden_config_homepage_image = $_POST['hidden_config_homepage_image'];
		
		if($config_title_site=="")
		{
			$error.=sprintf(ERR_NULL,"tiêu đề trang web");
		}
		if($config_email=="")
		{
			$error.=sprintf(ERR_NULL,"email");
		}
		if($config_phone=="")
		{
			$error.=sprintf(ERR_NULL,"số điện thoại");
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
                $sql="UPDATE ".TABLE_PREFIX."config
                        SET config_title_site='$config_title_site'
                            ,config_phone='$config_phone'
                            ,config_facebook='$config_facebook'
                            ,config_email='$config_email'
                            ,config_google_plus='$config_google_plus'
                            ,config_meta='$config_meta'
                        WHERE config_id='$edit_id'";
                execSQL($sql);
                redir('index.php?mod=config');
                exit();
			}
			else
			{
				$sql="INSERT INTO ".TABLE_PREFIX."config(
                        config_title_site
                        ,config_phone
                        ,config_facebook
                        ,config_email
                        ,config_google_plus
                        ,config_meta
                        ) VALUES(
                        '$config_title_site'
                        ,'$config_phone'
                        ,'$config_facebook'
                        ,'$config_email'
                        ,'$config_google_plus'
                        ,'$config_meta'
                        )";
					execSQL($sql);
					redir('index.php?mod=config');
					exit();
			}
		}
	}
	else
	{
		if($edit_id){
			$sql="SELECT config_title_site
						,config_phone
						,config_facebook
						,config_email	
						,config_google_plus
						,config_meta
						,config_id AS edit_id
				 FROM ".TABLE_PREFIX."config
				 WHERE md5(config_id)='$edit_id'";
			$row=recordset($sql);
			
			$edit_id							= $row['edit_id'];
			$config_title_site					= $row['config_title_site'];
			$config_phone						= $row['config_phone'];
			$config_facebook					= $row['config_facebook'];
			$config_email						= $row['config_email'];
			$config_google_plus				    = $row['config_google_plus'];
			$config_meta						= $row['config_meta'];

		}
	}
	
	$input_config_title_site				= gen_input_text('config_title_site',$config_title_site,50,255,'','a_text');
	$input_config_phone						= gen_input_text('config_phone',$config_phone,50,255,'','a_text');
	$input_config_facebook					= gen_input_text('config_facebook',$config_facebook,50,255,'','a_text');
	$input_config_email						= gen_input_text('config_email',$config_email,50,255,'','a_text');
    $input_config_google_plus				= gen_input_text('config_google_plus',$config_google_plus,50,255,'','a_text');
	$input_config_meta				        = gen_input_textarea('config_meta',$config_meta,50,20,'','a_text');
	$input_hidden_edit_id					= gen_input_hidden('edit_id',$edit_id);
	$xtpl->assign('input_config_title_site',$input_config_title_site);
	$xtpl->assign('input_config_phone',$input_config_phone);
	$xtpl->assign('input_config_facebook',$input_config_facebook);
	$xtpl->assign('input_config_email',$input_config_email);
	$xtpl->assign('input_config_google_plus',$input_config_google_plus);
	$xtpl->assign('input_config_meta',$input_config_meta);
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('COM_ADD_UPDATE',COM_ADD_UPDATE);
	$xtpl->assign('COM_RESET',COM_RESET);
	$xtpl->assign('title_page',$title_page);
	
?>