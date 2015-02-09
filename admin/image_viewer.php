<?
error_reporting(0);
	//include "../settings.php";
	include "../includes/xtpl.php";
	include "../includes/global.php";
	include "includes/languages/language_en.php";
	include "includes/check_login.php";
	$xtpl = new XTemplate("templates/image_viewer.htm");
	$f="../upload/".$_GET['path']."/".$_GET['img'];
	$file="../upload/".$_GET['path']."/".$_GET['img'];
	if (file_exists($file)) 
	{
		$fileInfo = pathinfo($file);
  		$extension=$fileInfo["extension"];
		if($extension=='JPG' || $extension=='jpeg' || $extension=='jpg' || $extension=='gif' || $extension=='png' || $extension=='pjpeg' || $extension=='bmp')
		{	
			$size = getimagesize($file);
			$width=$size[0];
			$height=$size[1];
			$max=500;
			if($width>$max || $height>$max)
			{
				$actualwidth=$width;
				$actualheight=$height;
				if($width>$height)
				{
					$height=500*((float)($height/$width));
					$width=500;
				}
				else
				{
					$width=500*((float)($width/$height));
					$height=500;
				}		
			}
			$kbytes=round(filesize($file)/1024);
			$on_load="winBRopen(".$width.",".$height.")";
			$image="<img src=".$f." width=".$width." height=".$height." border=0>";
			if($actualwidth>0)
			{
				$actual=ACTUAL_WIDTH."=".$actualwidth."pixels. ".ACTUAL_HEIGHT."=".$actualheight."pixels";
			}
			$property=TOTAL." ".SIZE.": ".$kbytes."&nbsp;Kb(s).&nbsp;".$actual;
			$xtpl->assign("on_load",$on_load);
			$xtpl->assign("image",$image);
			$xtpl->assign("property",$property);
			$xtpl->assign("TIP_CLICK_TO_CLOSE_WINDOW",TIP_CLICK_TO_CLOSE_WINDOW);
			$xtpl->parse("MAIN.VIEW");
		}
		else
		{
			$file_path=$file;
			$on_load="winBRopen(370,300)";
			$xtpl->assign("on_load",$on_load);
			
			$xtpl->assign("MSG_NOT_VIEWABLE_AS_IMAGE",MSG_NOT_VIEWABLE_AS_IMAGE);
			$xtpl->assign("MSG_CLICK_TO_DOWNLOAD_OR_PLAY",sprintf(MSG_CLICK_TO_DOWNLOAD_OR_PLAY,$file));
			$xtpl->assign("MSG_CLICK_TO_CLOSE_WINDOW",MSG_CLICK_TO_CLOSE_WINDOW);
			$xtpl->parse("MAIN.DOWNLOAD");
		}
	}
	else
	{
		$on_load="winBRopen(370,300)";
		$xtpl->assign("on_load",$on_load);
		$xtpl->assign("MSG_IMAGE_NOT_EXIST",MSG_IMAGE_NOT_EXIST);
		$xtpl->assign("MSG_CLICK_TO_CLOSE_WINDOW",MSG_CLICK_TO_CLOSE_WINDOW);
	    $xtpl->parse("MAIN.ERROR");
	}
	
	
	$page_title=$SITE_TITLE." :: ".$SECTION_NAME." - Image viewer";
	$page_charset=$SITE_CHARSET;
	$main_css=str_replace("../","",$THEME_FOLDER."style.css");
	$xtpl->assign("page_charset",$page_charset);
	$xtpl->assign("main_css",$main_css);
	$xtpl->assign("page_title",$page_title);
	
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
?>