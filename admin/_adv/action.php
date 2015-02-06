<?php
	include "functions.php";
	include "setting.php";
	$title_page="Thêm mới - Cập nhật";
	$action=$_POST['frmAction'];
	$edit_id=$_REQUEST['edit_id'];
	$error="";
	if($action=="Action")
	{
		$adv_title=$_POST['adv_title'];
		$adv_is_left=$_POST['adv_is_left'];
		$adv_link=$_POST['adv_link'];
		$adv_image=$_FILES['adv_image'];
		$adv_position = $_POST['adv_position'];
		$adv_active=$_POST['adv_active']?1:0;
		$hidden_adv_image = $_POST['hidden_adv_image'];
		
		if($adv_image=="")
		{
			$error.=sprintf(ERR_NULL,"Ảnh");
		}
		
/* check upload file*/
		if($edit_id)
		{
			if($adv_image['name'])
			{
				$adv_image=uploadfile($path,$adv_image,$upload_type,$MAX_FILE_SIZE);
			
				if($adv_image==-1)
				{
					$error.=ERROR_FILE_ACCESS;
				}elseif($adv_image==0)
				{
					$error.=ERROR_FILE_FORMAT;
				}elseif($adv_image==1)
				{
					$error.=sprintf(ERROR_FILE_SIZE,ini_get('upload_max_filesize'));
				}elseif($adv_image==2)
				{
					$error.=ERROR_FILE_NOT;
				}
			}
			else
			{
				$adv_image=$hidden_adv_image;
			}
				// create thumnail image
				if($_FILES['adv_image']['name'])
				{
					for($i=0;$i<count($MAX_THUMB_WIDTH);$i++)
					{
						$MAX_QUALITY[$i]=$MAX_THUMB_WIDTH[$i]>$MAX_THUMB_HEIGHT[$i]?$MAX_THUMB_WIDTH[$i]:$MAX_THUMB_HEIGHT[$i];
						thumbnail_images($_FILES['adv_image'],$MAX_THUMB_WIDTH[$i] ,$MAX_THUMB_HEIGHT[$i] ,$path,$MAX_QUALITY[$i],"thumb_".$i,$adv_image); 
						
						// delete old thumb
						deletefile($path."thumb_".$i."_".$hidden_adv_image);
					}
					
					// delete old file
					deletefile($path.$hidden_adv_image);
					if($DELETE_ORIGIN_IMAGE)
					{
						deletefile($path.$adv_image);
					}
				}
		}
		else
		{
			/* check upload error file  */
			if($adv_image['name'])
			{
				$adv_image=uploadfile($path,$adv_image,$upload_type,$MAX_FILE_SIZE);
			
				if($adv_image==-1)
				{
					$error.=ERROR_FILE_ACCESS;
				}elseif($adv_image==0)
				{
					$error.=ERROR_FILE_FORMAT;
				}elseif($adv_image==1)
				{
					$error.=sprintf(ERROR_FILE_SIZE,ini_get('upload_max_filesize'));
				}elseif($adv_image==2)
				{
					$error.=ERROR_FILE_NOT;
				}
			}
				// create thumnail image
				if($_FILES['adv_image']['name'])
				{
					for($i=0;$i<count($MAX_THUMB_WIDTH);$i++)
					{
						$MAX_QUALITY[$i]=$MAX_THUMB_WIDTH[$i]>$MAX_THUMB_HEIGHT[$i]?$MAX_THUMB_WIDTH[$i]:$MAX_THUMB_HEIGHT[$i];
						thumbnail_images($_FILES['adv_image'],$MAX_THUMB_WIDTH[$i] ,$MAX_THUMB_HEIGHT[$i] ,$path,$MAX_QUALITY[$i],"thumb_".$i,$adv_image); 
						
						// delete old thumb
						deletefile($path."thumb_".$i."_".$hidden_adv_image);
					}
					
					// delete old file
					deletefile($path.$hidden_adv_image);
					if($DELETE_ORIGIN_IMAGE)
					{
						deletefile($path.$adv_image);
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
					$sql="UPDATE ".TABLE_PREFIX."adv
							SET adv_title='$adv_title'
								,adv_image='$adv_image'
								,adv_link='$adv_link'
								,adv_is_left='$adv_is_left'
								,adv_position='$adv_position'
								,adv_active='$adv_active'
							WHERE md5(adv_id)='$edit_id'";
					execSQL($sql);
					redir('index.php?mod=adv');
					exit();		
			}
			else
			{
					$sql="INSERT INTO ".TABLE_PREFIX."adv(
							adv_title
							,adv_image
							,adv_link
							,adv_is_left
							,adv_position
							,adv_active
							) VALUES(
							'$adv_title'
							,'$adv_image'
							,'$adv_link'
							,'$adv_is_left'
							,'$adv_position'
							,'$adv_active'
							)";
					execSQL($sql);
					redir('index.php?mod=adv');
					exit();
			}
		}
	}
	else
	{
		if($edit_id){
			$sql="SELECT adv_title
						,adv_image	
						,adv_link	
						,adv_is_left 
						,adv_position
						,adv_active
						,md5(adv_id) AS edit_id
				 FROM ".TABLE_PREFIX."adv
				 WHERE md5(adv_id)='$edit_id'";
			$row=recordset($sql);
			$adv_title			= $row['adv_title'];
			$adv_image			= $row['adv_image'];
			$adv_link			= $row['adv_link'];
			$adv_is_left		= $row['adv_is_left'];
			$adv_position		= $row['adv_position'];
			$adv_active			= $row['adv_active'];
			$edit_id			= $row['edit_id'];
			$hidden_adv_image   = $adv_image;
		}
	}
	
	$input_adv_title				= gen_input_text('adv_title',$adv_title,50,255,'','a_text');
	$input_adv_image				= gen_input_file('adv_image',50,'','a_text');
	$input_adv_link					= gen_input_text('adv_link',$adv_link,50,255,'','a_text');
	$input_adv_is_left				= gen_input_checkbox('adv_is_left',1,$adv_is_left,'','');
	$input_adv_position				= gen_input_text('adv_position',$adv_position,50,255,'','a_text');
	$input_adv_active				= gen_input_checkbox('adv_active',1,$adv_active,'','');

	$input_hidden_edit_id			= gen_input_hidden('edit_id',$edit_id);
	$input_hidden_adv_image			= gen_input_hidden('hidden_adv_image',$hidden_adv_image);
	if($edit_id)
	{
		if ($adv_image)
		{
		$image_viewer	= '&nbsp;<a href="#" onclick="openwin(\'image_viewer.php?path=adv&img=thumb_0_'.$adv_image.'\');">'.COM_VIEW_IMAGE.'</a>';
		$xtpl->assign('image_viewer',$image_viewer);
		}
	}
	
	$xtpl->assign('input_adv_title',$input_adv_title);
	$xtpl->assign('input_adv_image',$input_adv_image);
	$xtpl->assign('input_adv_link',$input_adv_link);
	$xtpl->assign('input_adv_is_left',$input_adv_is_left);
	$xtpl->assign('input_adv_position',$input_adv_position);
	$xtpl->assign('input_adv_active',$input_adv_active);
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('input_hidden_adv_image',$input_hidden_adv_image);
	$xtpl->assign('COM_ADD_UPDATE',COM_ADD_UPDATE);
	$xtpl->assign('COM_RESET',COM_RESET);
	$xtpl->assign('title_page',$title_page);
	
?>