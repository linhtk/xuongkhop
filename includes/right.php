<?php
	$xtpl_right = new XTemplate ("templates/right.html");

/////news
	$right_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_brief FROM tg_news WHERE news_is_hot = '1' AND news_active='1' ORDER BY news_date LIMIT 0 , 3";
	$rs_right_news = execSQL($right_news);
	$right_no=mysql_num_rows($rs_right_news);
	if ($right_no)
	{
		while($row_right_news = mysql_fetch_assoc($rs_right_news)){
			if($row_right_news['news_image'])
				{
					if(file_exists("upload/news/thumb_1_".$row_right_news['news_image']))
					{
						$row_right_news['news_image'] = '<img src="upload/news/thumb_1_'.$row_right_news['news_image'].'" class="img-responsive" />';
					} else 
					{
						$row_right_news['news_image'] = "";
					}
				} else
				{
					$row_right_news['news_image'] = "";
				}
				$row_right_news['news_brief'] = sub_string($row_right_news['news_brief'], 100, true);
			$xtpl_right->assign("right_news",$row_right_news);
			$xtpl_right->parse("RIGHT.right_news");
		}
	}

	$xtpl_right->parse("RIGHT");
	$right_tostring = $xtpl_right->text("RIGHT");
	
?>
