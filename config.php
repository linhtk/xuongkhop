<?php 

	include "includes/global.php";
	include "includes/connection.php";
	include "includes/function.php";
	include "includes/function_page.php";
	
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
						$row_right_news['news_image'] = '<img src="upload/news/thumb_1_'.$row_right_news['news_image'].'" class="img-responsive" height="350" width="505" />';
					} else 
					{
						$row_right_news['news_image'] = "";
					}
				} else
				{
					$row_right_news['news_image'] = "";
				}
				var_dump($row_right_news);
		}
	}
	
?>