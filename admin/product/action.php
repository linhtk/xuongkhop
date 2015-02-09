<?php
	include "functions.php";
	include "setting.php";
	$title_page="Thêm mới - Cập nhật";
	$action=$_POST['frmAction'];
	$edit_id=$_REQUEST['edit_id'];
	$error="";
	if($action=="Action")
	{
		$product_name=$_POST['product_name'];
        $rate=$_POST['rate'];
        $product_desc = $_POST['product_desc'];
		$product_image=$_FILES['product_image'];
		$hidden_product_image = $_POST['hidden_product_image'];
		
		if($product_name=="")
		{
			$error.=sprintf(ERR_NULL,"tên sản phẩm");
		}
		if($product_desc=="")
		{
			$error.=sprintf(ERR_NULL,"mô tả sản phẩm");
		}
		
/* check upload file*/
		if($edit_id)
		{
			if($product_image['name'])
			{
                $product_image=uploadfile($path,$product_image,$upload_type,$MAX_FILE_SIZE);
			
				if($product_image==-1)
				{
					$error.=ERROR_FILE_ACCESS;
				}elseif($product_image==0)
				{
					$error.=ERROR_FILE_FORMAT;
				}elseif($product_image==1)
				{
					$error.=sprintf(ERROR_FILE_SIZE,ini_get('upload_max_filesize'));
				}elseif($product_image==2)
				{
					$error.=ERROR_FILE_NOT;
				}
			}
			else
			{
                $product_image=$hidden_product_image;
			}
				// create thumnail image
				if($_FILES['product_image']['name'])
				{
					for($i=0;$i<count($MAX_THUMB_WIDTH);$i++)
					{
						$MAX_QUALITY[$i]=$MAX_THUMB_WIDTH[$i]>$MAX_THUMB_HEIGHT[$i]?$MAX_THUMB_WIDTH[$i]:$MAX_THUMB_HEIGHT[$i];
						thumbnail_images($_FILES['product_image'],$MAX_THUMB_WIDTH[$i] ,$MAX_THUMB_HEIGHT[$i] ,$path,$MAX_QUALITY[$i],"thumb_".$i,$product_image);
						
						// delete old thumb
						deletefile($path."thumb_".$i."_".$hidden_product_image);
					}
					
					// delete old file
					deletefile($path.$hidden_product_image);
					if($DELETE_ORIGIN_IMAGE)
					{
						deletefile($path.$product_image);
					}
				}
		}
		else
		{
			/* check upload error file  */
			if($product_image['name'])
			{
                $product_image=uploadfile($path,$product_image,$upload_type,$MAX_FILE_SIZE);
			
				if($product_image==-1)
				{
					$error.=ERROR_FILE_ACCESS;
				}elseif($product_image==0)
				{
					$error.=ERROR_FILE_FORMAT;
				}elseif($product_image==1)
				{
					$error.=sprintf(ERROR_FILE_SIZE,ini_get('upload_max_filesize'));
				}elseif($product_image==2)
				{
					$error.=ERROR_FILE_NOT;
				}
			}
				// create thumnail image
				if($_FILES['product_image']['name'])
				{
					for($i=0;$i<count($MAX_THUMB_WIDTH);$i++)
					{
						$MAX_QUALITY[$i]=$MAX_THUMB_WIDTH[$i]>$MAX_THUMB_HEIGHT[$i]?$MAX_THUMB_WIDTH[$i]:$MAX_THUMB_HEIGHT[$i];
						thumbnail_images($_FILES['product_image'],$MAX_THUMB_WIDTH[$i] ,$MAX_THUMB_HEIGHT[$i] ,$path,$MAX_QUALITY[$i],"thumb_".$i,$product_image);
						
						// delete old thumb
						deletefile($path."thumb_".$i."_".$hidden_product_image);
					}
					
					// delete old file
					deletefile($path.$hidden_product_image);
					if($DELETE_ORIGIN_IMAGE)
					{
						deletefile($path.$product_image);
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
					$sql="UPDATE ".TABLE_PREFIX."product
							SET product_name='$product_name'
								,product_image='$product_image'
								,rate='$rate'
								,product_desc='$product_desc'
							WHERE md5(product_id)='$edit_id'";
					execSQL($sql);
					redir('index.php?mod=product');
					exit();
							
			}
			else
			{
					$sql="INSERT INTO ".TABLE_PREFIX."product(
							product_name
							,product_image
							,rate
							,product_desc
							) VALUES(
							'$product_name'
							,'$product_image'
							,'$rate'
							,'$product_desc'
							)";
					$rs = execSQL($sql);
					redir('index.php?mod=product');
					exit();
			}
		}
	}
	else
	{
		if($edit_id){
			$sql="SELECT product_name
						,product_image
						,rate
						,product_desc
				 FROM ".TABLE_PREFIX."product
				 WHERE md5(product_id)='$edit_id'";
			$row=recordset($sql);
			$product_name			= $row['product_name'];
			$product_image			= $row['product_image'];
			$rate			= $row['rate'];
			$product_desc			= $row['product_desc'];
			$hidden_product_image  = $product_image;
		}
		
	}
	
	$input_product_name				= gen_input_text('product_name',$product_name,50,255,'','a_text');
	$input_product_image				= gen_input_file('product_image',50,'','a_text');
	$input_rate			            = gen_input_text('rate',$rate,50,255,'','a_text');
	$input_product_desc				= gen_input_FCKEditor('product_desc',$product_desc);
	$input_hidden_edit_id			= gen_input_hidden('edit_id',$edit_id);
	$input_hidden_product_image		= gen_input_hidden('hidden_product_image',$hidden_product_image);
	if($edit_id)
	{
		if ($product_image)
		{
		$image_viewer	= '&nbsp;<a href="#" onclick="openwin(\'image_viewer.php?path=product&img=thumb_0_'.$product_image.'\');">'.COM_VIEW_IMAGE.'</a>';
		$xtpl->assign('image_viewer',$image_viewer);
		}
	}
	
	$xtpl->assign('input_product_name',$input_product_name);
	$xtpl->assign('input_product_image',$input_product_image);
	$xtpl->assign('input_rate',$input_rate);
	$xtpl->assign('input_product_desc',$input_product_desc);
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('input_hidden_product_image',$input_hidden_product_image);
	$xtpl->assign('COM_ADD_UPDATE',COM_ADD_UPDATE);
	$xtpl->assign('COM_RESET',COM_RESET);
	$xtpl->assign('title_page',$title_page);
	
?>