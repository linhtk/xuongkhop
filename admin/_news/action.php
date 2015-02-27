<?php
	include "functions.php";
	include "setting.php";
	$title_page="Thêm mới - Cập nhật";
	$action=$_POST['frmAction'];
	$edit_id=$_REQUEST['edit_id'];
	$error="";
	if($action=="Action")
	{
		$news_title=$_POST['news_title'];
		$news_id=$_POST['news_id'];
		$news_cate = $_POST['news_cate'];
		$news_brief=$_POST['news_brief'];
		$news_content=$_POST['news_content'];
		$news_image=$_FILES['news_image'];
		$news_date=date("Y-m-d H:s:i");
		$news_position = $_POST['news_position']?$_POST['news_position']:0;
		$news_active=$_POST['news_active']?1:0;
		$news_is_hot=$_POST['news_is_hot']?1:0;
		$hidden_news_image = $_POST['hidden_news_image'];
		
		if($news_title=="")
		{
			$error.=sprintf(ERR_NULL,"tiêu đề tin");
		}
		if(count($news_cate)<1)
		{
			$error.=sprintf(ERR_NULL,"danh mục tin");
		}
		if($news_content=="")
		{
			$error.=sprintf(ERR_NULL,"nội dung tin");
		}
		
/* check upload file*/
		if($edit_id)
		{
			if($news_image['name'])
			{
				$news_image=uploadfile($path,$news_image,$upload_type,$MAX_FILE_SIZE);

				if($news_image==-1)
				{
					$error.=ERROR_FILE_ACCESS;
				}elseif($news_image==0)
				{
					$error.=ERROR_FILE_FORMAT;
				}elseif($news_image==1)
				{
					$error.=sprintf(ERROR_FILE_SIZE,ini_get('upload_max_filesize'));
				}elseif($news_image==2)
				{
					$error.=ERROR_FILE_NOT;
				}
			}
			else
			{
				$news_image=$hidden_news_image;
			}
//            var_dump($news_image); die('in edit');
//				// create thumnail image
//				if($_FILES['news_image']['name'])
//				{
//					for($i=0;$i<count($MAX_THUMB_WIDTH);$i++)
//					{
//						$MAX_QUALITY[$i]=$MAX_THUMB_WIDTH[$i]>$MAX_THUMB_HEIGHT[$i]?$MAX_THUMB_WIDTH[$i]:$MAX_THUMB_HEIGHT[$i];
//						thumbnail_images($_FILES['news_image'],$MAX_THUMB_WIDTH[$i] ,$MAX_THUMB_HEIGHT[$i] ,$path,$MAX_QUALITY[$i],"thumb_".$i,$news_image);
//
//						// delete old thumb
//						unlink($path."thumb_".$i."_".$hidden_news_image);
//					}
//
//					// delete old file
//                    unlink($path.$hidden_news_image);
//					if($DELETE_ORIGIN_IMAGE)
//					{
//                        unlink($path.$news_image);
//					}
//				}
		}
		else
		{
			/* check upload error file  */
			if($news_image['name'])
			{
				$news_image=uploadfile($path,$news_image,$upload_type,$MAX_FILE_SIZE);

				if($news_image==-1)
				{
					$error.=ERROR_FILE_ACCESS;
				}elseif($news_image==0)
				{
					$error.=ERROR_FILE_FORMAT;
				}elseif($news_image==1)
				{
					$error.=sprintf(ERROR_FILE_SIZE,ini_get('upload_max_filesize'));
				}elseif($news_image==2)
				{
					$error.=ERROR_FILE_NOT;
				}
			}
//            var_dump($news_image); die('in add');
//				// create thumnail image
//				if($_FILES['news_image']['name'])
//				{
//                    die('here');
//					for($i=0;$i<count($MAX_THUMB_WIDTH);$i++)
//					{
//						$MAX_QUALITY[$i]=$MAX_THUMB_WIDTH[$i]>$MAX_THUMB_HEIGHT[$i]?$MAX_THUMB_WIDTH[$i]:$MAX_THUMB_HEIGHT[$i];
//						$news_image_1 = thumbnail_images($_FILES['news_image'],$MAX_THUMB_WIDTH[$i] ,$MAX_THUMB_HEIGHT[$i] ,$path,$MAX_QUALITY[$i],"thumb_".$i,$news_image);
//						var_dump($news_image_1);die('aa');
//						// delete old thumb
//						unlink($path."thumb_".$i."_".$hidden_news_image);
//					}
//
//					// delete old file
//                    unlink($path.$hidden_news_image);
//					if($DELETE_ORIGIN_IMAGE)
//					{
//                        unlink($path.$news_image);
//					}
//				}
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
					$sql="UPDATE ".TABLE_PREFIX."news
							SET news_title='$news_title'
								,news_brief='$news_brief'
								,news_content='$news_content'
								,news_image='$news_image'
								,news_date='$news_date'
								,news_position='$news_position'
								,news_active='$news_active'
								,news_is_hot='$news_it_hot'
							WHERE md5(news_id)='$edit_id'";
					execSQL($sql);
					$sql_cate1 = "DELETE FROM tg_news_cate WHERE news_id='".$news_id."'";
					execSQL($sql_cate1);
					$sql_cate2 = "INSERT INTO tg_news_cate(news_id, cate_id, news_title, news_image, news_brief) 
							VALUES ";
					for($i=0;$i<count($news_cate);$i++){
						if($i == count($news_cate)-1){
							$sql_cate2 .= "('$news_id', '$news_cate[$i]', '$news_title', '$news_image', '$news_brief')";
						} else {
							$sql_cate2 .= "('$news_id', '$news_cate[$i]', '$news_title', '$news_image', '$news_brief'),";
						}
					}
					
					//echo $sql_cate2;
					execSQL($sql_cate2);
					redir('index.php?mod=_news');
					exit();
							
			}
			else
			{
					$sql="INSERT INTO ".TABLE_PREFIX."news(
							news_title
							,news_brief
							,news_content
							,news_image
							,news_date
							,news_position
							,news_active
							,news_is_hot
							) VALUES(
							'$news_title'
							,'$news_brief'
							,'$news_content'
							,'$news_image'
							,'$news_date'
							,'$news_position'
							,'$news_active'
							,'$news_is_hot'
							)";
					$rs = execSQL($sql);
					$news_id = mysql_insert_id();
					$sql_cate2 = "INSERT INTO tg_news_cate(news_id, cate_id, news_title, news_image, news_brief) 
							VALUES ";
					for($i=0;$i<count($news_cate);$i++){
						if($i == count($news_cate)-1){
							$sql_cate2 .= "('$news_id', '$news_cate[$i]', '$news_title', '$news_image', '$news_brief')";
						} else {
							$sql_cate2 .= "('$news_id', '$news_cate[$i]', '$news_title', '$news_image', '$news_brief'),";
						}
					}
					$sql_cate2 .= "";
					execSQL($sql_cate2);
					redir('index.php?mod=_news');
					exit();
			}
		}
	}
	else
	{
		if($edit_id){
			$sql="SELECT news_title
						,news_brief	
						,news_id 
						,md5(news_id) as edit_id
						,news_content	
						,news_image 
						,news_position
						,news_active
						,news_is_hot
				 FROM ".TABLE_PREFIX."news
				 WHERE md5(news_id)='$edit_id'";
			$row=recordset($sql);
			$sql_current_cate = "SELECT cate_id FROM tg_news_cate WHERE news_id = '".$row['news_id']."'";
			$rs_cur_cate = execSQL($sql_current_cate);
			$arr_cur_cate = get_fetch_assoc($rs_cur_cate);
			$arr_cur = array();
			for($j=0;$j<count($arr_cur_cate);$j++)
			{
				$arr_cur[$j] = (int)$arr_cur_cate[$j]['cate_id'];
			}
			//var_dump($arr_cur);
			$sql_cate = "SELECT * FROM tg_category WHERE category_has_child = 0 AND category_status = 1 ORDER BY category_parent";
			$rs_cate = execSQL($sql_cate);
			$array=get_fetch_assoc($rs_cate);
			for($i=0;$i<count($array);$i++)
			{
				if(in_array((int)$array[$i]['category_id'], $arr_cur))
				{
					$array[$i]['checked']=" checked='checked'";
				}
				$xtpl->assign('CATE',$array[$i]);
				$xtpl->parse('main.CATE');
			}		
			$news_title			= $row['news_title'];
			$edit_id			= $row['edit_id'];
			$news_id			= $row['news_id'];
			$news_brief			= $row['news_brief'];
			$news_content		= $row['news_content'];
			$news_image			= $row['news_image'];
			$news_position		= $row['news_position'];
			$news_active		= $row['news_active'];			
			$news_is_hot		= $row['news_is_hot'];
			$hidden_news_image  = $news_image;
		} else {
			$sql_cate = "SELECT * FROM tg_category WHERE category_has_child = 0 AND category_status = 1 ORDER BY category_parent";
			$rs_cate = execSQL($sql_cate);
			$array=get_fetch_assoc($rs_cate);
			for($i=0;$i<count($array);$i++)
			{
				$xtpl->assign('CATE',$array[$i]);
				$xtpl->parse('main.CATE');
			}
		}
		
	}
	
	$input_news_title				= gen_input_text('news_title',$news_title,50,255,'','a_text');
	$input_news_image				= gen_input_file('news_image',50,'','a_text');
	$input_news_position			= gen_input_text('news_position',$news_position,50,255,'','a_text');
	$input_news_active				= gen_input_checkbox('news_active',1,$news_active,'','');
	$input_news_is_hot				= gen_input_checkbox('news_is_hot',1,$news_is_hot,'','');
	$input_news_brief				= gen_input_textarea('news_brief',$news_brief,50,10,'','a_text');
	$input_news_content				= gen_input_FCKEditor('news_content',$news_content);
	$input_hidden_edit_id			= gen_input_hidden('edit_id',$edit_id);
	$input_hidden_news_image		= gen_input_hidden('hidden_news_image',$hidden_news_image);
	if($edit_id)
	{
		if ($news_image)
		{
		$image_viewer	= '&nbsp;<a href="#" onclick="openwin(\'image_viewer.php?path=news&img='.$news_image.'\');">'.COM_VIEW_IMAGE.'</a>';
		$xtpl->assign('image_viewer',$image_viewer);
		}
	}
	
	$xtpl->assign('news_id',$news_id);
	$xtpl->assign('input_news_title',$input_news_title);
	$xtpl->assign('input_news_image',$input_news_image);
	$xtpl->assign('input_news_position',$input_news_position);
	$xtpl->assign('input_news_active',$input_news_active);
	$xtpl->assign('input_news_is_hot',$input_news_is_hot);	
	$xtpl->assign('input_news_brief',$input_news_brief);
	$xtpl->assign('input_news_content',$input_news_content);
	$xtpl->assign('input_hidden_edit_id',$input_hidden_edit_id);
	$xtpl->assign('input_hidden_news_image',$input_hidden_news_image);
	$xtpl->assign('COM_ADD_UPDATE',COM_ADD_UPDATE);
	$xtpl->assign('COM_RESET',COM_RESET);
	$xtpl->assign('title_page',$title_page);
	
?>