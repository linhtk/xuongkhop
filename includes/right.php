<?php
	$xtpl_right = new XTemplate ("templates/right.html");

/////news
	$right_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_brief FROM tg_news WHERE news_is_hot = '1' AND news_active='1' ORDER BY news_date LIMIT 0 , 4";
	$rs_right_news = execSQL($right_news);
	$right_no=mysql_num_rows($rs_right_news);
	if ($right_no)
	{
		while($row_right_news = mysql_fetch_assoc($rs_right_news)){
			if($row_right_news['news_image'])
				{
					if(file_exists("upload/news/".$row_right_news['news_image']))
					{
						$row_right_news['news_image'] = '<img src="upload/news/'.$row_right_news['news_image'].'" class="img-responsive" width="120" height="89" />';
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
//san pham
    $sql_sp = "SELECT * FROM tg_product ORDER BY product_id DESC LIMIT 0,4";
    $rs_sp = execSQL($sql_sp);
    while($row_sp = mysql_fetch_assoc($rs_sp))
    {
        if($row_sp['product_image'])
        {
            if(file_exists("upload/products/".$row_sp['product_image']))
            {
                $row_sp['product_image'] = '<img src="upload/products/'.$row_sp['product_image'].'" class="img-responsive" width="120" height="89" />';
            } else
            {
                $row_sp['product_image'] = "";
            }
        } else
        {
            $row_sp['product_image'] = "";
        }
        $row_sp['product_desc'] = sub_string($row_sp['product_desc'], 150, true);
        $xtpl_right->assign("SP",$row_sp);
        $xtpl_right->parse("RIGHT.SP");
    }
	$xtpl_right->parse("RIGHT");
	$right_tostring = $xtpl_right->text("RIGHT");
	
?>
