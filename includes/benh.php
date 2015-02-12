<?php
	$xtpl_benh = new XTemplate ("templates/benh.html");

/////cam nang
	$benh_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_brief FROM tg_news_cate WHERE cate_id = 119 LIMIT 0 , 3";
	$rs_benh_news = execSQL($benh_news);
	$benh_no=mysql_num_rows($rs_benh_news);
	if ($benh_no)
	{
		while($row_benh_news = mysql_fetch_assoc($rs_benh_news)){
			if($row_benh_news['news_image'])
				{
					if(file_exists("upload/news/thumb_1_".$row_benh_news['news_image']))
					{
						$row_benh_news['news_image'] = '<img src="upload/news/thumb_1_'.$row_benh_news['news_image'].'" class="img-responsive" />';
					} else 
					{
						$row_benh_news['news_image'] = "";
					}
				} else
				{
					$row_benh_news['news_image'] = "";
				}
				$row_benh_news['news_brief'] = sub_string($row_benh_news['news_brief'], 100, true);
			$xtpl_benh->assign("benh_news",$row_benh_news);
			$xtpl_benh->parse("BENH.benh_news");
		}
	}
/////duoc lieu
	$duoc_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_brief FROM tg_news_cate WHERE cate_id = 120 LIMIT 0 , 3";
	$rs_duoc_news = execSQL($duoc_news);
	$duoc_no=mysql_num_rows($rs_duoc_news);
	if ($duoc_no)
	{
		while($row_duoc_news = mysql_fetch_assoc($rs_duoc_news)){
			if($row_duoc_news['news_image'])
				{
					if(file_exists("upload/news/".$row_duoc_news['news_image']))
					{
						$row_duoc_news['news_image'] = '<img src="upload/news/'.$row_duoc_news['news_image'].'" class="img-responsive" />';
					} else 
					{
						$row_duoc_news['news_image'] = "";
					}
				} else
				{
					$row_duoc_news['news_image'] = "";
				}
				$row_duoc_news['news_brief'] = sub_string($row_duoc_news['news_brief'], 100, true);
			$xtpl_benh->assign("duoc_news",$row_duoc_news);
			$xtpl_benh->parse("BENH.duoc_news");
		}
	}
	$xtpl_benh->parse("BENH");
	$benh_tostring = $xtpl_benh->text("BENH");
	
?>
