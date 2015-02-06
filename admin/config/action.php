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
		$config_mobile=$_POST['config_mobile'];
		$config_email=$_POST['config_email'];
		$config_homepage_image=$_FILES['config_homepage_image'];
		$config_address=$_POST['config_address'];
		$config_yahoo = $_POST['config_yahoo'];
		$config_yahoo_sale = $_POST['config_yahoo_sale'];
		$config_footer_content = $_POST['config_footer_content'];
		$edit_id = $_POST['edit_id'];
		$hidden_config_homepage_image = $_POST['hidden_config_homepage_image'];
		
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
		if($config_mobile=="")
		{
			$error.=sprintf(ERR_NULL,"số di động");
		}
		
/* check upload file*/
		if($edit_id)
		{
			if($config_homepage_image['name'])
			{
				$config_homepage_image=uploadfile($path,$config_homepage_image,$upload_type,$MAX_FILE_SIZE);
			
				if($config_homepage_image==-1)
				{
					$error.=ERROR_FILE_ACCESS;
				}elseif($config_homepage_image==0)
				{
					$error.=ERROR_FILE_FORMAT;
				}elseif($config_homepage_image==1)
				{
					$error.=sprintf(ERROR_FILE_SIZE,ini_get('upload_max_filesize'));
				}elseif($config_homepage_image==2)
				{
					$error.=ERROR_FILE_NOT;
				}
			}
			else
			{
				$config_homepage_image=$hidden_config_homepage_image;
			}
		}
		else
		{
			/* check upload error file  */
			if($config_homepage_image['name'])
			{
				$config_homepage_image=uploadfile($path,$config_homepage_image,$upload_type,$MAX_FILE_SIZE);
			
				if($config_homepage_image==-1)
				{
					$error.=ERROR_FILE_ACCESS;
				}elseif($config_homepage_image==0)
				{
					$error.=ERROR_FILE_FORMAT;
				}elseif($config_homepage_image==1)
				{
					$error.=sprintf(ERROR_FILE_SIZE,ini_get('upload_max_filesize'));
				}elseif($config_homepage_image==2)
				{
					$error.=ERROR_FILE_NOT;
				}
			}
		}
//end upload		
		if($error)
		{
			$xtpl->assign('error',$error);
			$xtpl->parse('main.error');
		}
		else
		{
			if($edit_id)
			{
				// create thumnail image
				if($_FILES['config_homepage_image']['name'])
				{
					for($i=0;$i<count($MAX_THUMB_WIDTH);$i++)
					{
						$MAX_QUALITY[$i]=$MAX_THUMB_WIDTH[$i]>$MAX_THUMB_HEIGHT[$i]?$MAX_THUMB_WIDTH[$i]:$MAX_THUMB_HEIGHT[$i];
						thumbnail_images($_FILES['config_homepage_image'],$MAX_THUMB_WIDTH[$i] ,$MAX_THUMB_HEIGHT[$i] ,$path,$MAX_QUALITY[$i],"thumb_".$i,$config_homepage_image); 
						
						// delete old thumb
						deletefile($path."thumb_".$i."_".$hidden_config_homepage_image);
					}
					
					// delete old file
					deletefile($path.$hidden_config_homepage_image);
					if($DELETE_ORIGIN_IMAGE)
					{
						deletefile($path.$config_homepage_image);
					}
				}
				if($error)
				{
					$xtpl->assign('error',$error);
					$xtpl->parse('main.error');
				}
				else
				{
					$sql="UPDATE ".TABLE_PREFIX."config
							SET config_title_site='$config_title_site'
								,config_phone='$config_phone'
								,config_mobile='$config_mobile'
								,config_email='$config_email'
								,config_homepage_image='$config_homepage_image'
								,config_address='$config_address'
								,config_yahoo='$config_yahoo'
								,config_yahoo_sale='$config_yahoo_sale'
								,config_footer_content='$config_footer_content'
							WHERE config_id='$edit_id'";
					execSQL($sql);
					redir('index.php?mod=config');
					exit();		
				}
			}
			else
			{
				if($error)
				{
					$xtpl->assign('error',$error);
					$xtpl->parse('main.error');
				}
				else
				{
					$sql="INSERT INTO ".TABLE_PREFIX."config(
							config_title_site
							,config_phone
							,config_mobile
							,config_email
							,config_homepage_image
							,config_address
							,config_yahoo
							,config_yahoo_sale
							,config_footer_content
							) VALUES(
							'$config_title_site'
							,'$config_phone'
							,'$config_mobile'
							,'$config_email'
							,'$config_homepage_image'
							,'$config_address'
							,'$config_yahoo'
							,'$config_yahoo_sale'
							,'$config_footer_content'
							)";
					execSQL($sql);
					redir('index.php?mod=config');
					exit();
				}
			}
		}
	}
	else
	{
		if($edit_id){
			$sql="SELECT config_title_site
						,config_phone
						,config_mobile	
						,config_email	
						,config_homepage_image 
						,config_address
						,config_yahoo
						,config_yahoo_sale
						,config_footer_content
						,config_id AS edit_id
				 FROM ".TABLE_PREFIX."config
				 WHERE md5(config_id)='$edit_id'";
			$row=recordset($sql);
			
			$edit_id							= $row['edit_id'];
			$config_title_site					= $row['config_title_site'];
			$config_phone						= $row['config_phone'];
			$config_mobile						= $row['config_mobile'];
			$config_email						= $row['config_email'];
			$config_homepage_image				= $row['config_homepage_image'];
			$config_address						= $row['config_address'];
			$config_yahoo						= $row['config_yahoo'];
			$config_yahoo_sale					= $row['config_yahoo_sale'];
			$config_footer_content				= $row['config_footer_content'];
			$hidden_config_homepage_image 		= $config_homepage_image;
		}
	}
	
	$input_config_title_site				= gen_input_text('config_title_site',$config_title_site,50,255,'','a_text');
	$input_config_phone						= gen_input_text('config_phone',$config_phone,50,255,'','a_text');
	$input_config_mobile					= gen_input_text('config_mobile',$config_mobile,50,255,'','a_text');
	$input_config_email						= gen_input_text('config_email',$config_email,50,255,'','a_text');
	$input_config_yahoo						= gen_input_text('config_yahoo',$config_yahoo,50,255,'','a_text');
	$input_config_yahoo_sale				= gen_input_text('config_yahoo_sale',$config_yahoo_sale,50,255,'','a_text');
	$input_config_address					= gen_input_text('config_address',$config_address,50,255,'','a_text');
	$input_config_homepage_image			= gen_input_file('config_homepage_image',50,'','a_text');
	$input_config_footer_content			= gen_input_FCKEditor('config_footer_content',$config_footer_content);
	$input_hidden_edit_id					= gen_input_hidden('edit_id',$edit_id);
	$input_hidden_gioithieu_anh				= gen_input_hidden('hidden_gioithieu_anh',$hidden_gioithieu_anh);
	if($edit_id)
	{
		if ($config_homepage_image)
		{
		$image_viewer	= '&nbsp;<a href="#" onclick="openwin(\'image_viewer.php?path=config&img=thumb_0_'.$config_homepage_image.'\');">'.COM_VIEW_IMAGE.'</a>';
		$xtpl->assign('image_viewer',$image_viewer);
		}
	}
	$xtpl->assign('input_config_title_site',$input_config_title_site);
	$xtpl->assign('input_config_phone',$input_config_phone);
	$xtpl->assign('input_config_mobile',$input_config_mobile);
	$xtpl->assign('input_config_email',$input_config_email);
	$xtpl->assign('input_config_yahoo',$input_config_yahoo);
	$xtpl->assign('input_config_yahoo_sale',$input_config_yahoo_sale);
	$xtpl->assign('input_config_address',$input_config_address);
	$xtpl->assign('input_config_homepage_image',$input_config_homepage_image);
	$xtpl->assign('input_config_footer_content',$input_config_footer_content);
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('input_hidden_gioithieu_anh',$input_hidden_gioithieu_anh);
	$xtpl->assign('COM_ADD_UPDATE',COM_ADD_UPDATE);
	$xtpl->assign('COM_RESET',COM_RESET);
	$xtpl->assign('title_page',$title_page);
	
?>