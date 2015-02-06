<?
    error_reporting(0);
	include "includes/xtpl.php";
	include "includes/global.php";
	include "includes/class.shoppingcart.php";
	include "includes/connection.php";
	include "includes/function.php";
	include "includes/function_page.php";
	include "includes/footer.php";
	include "includes/left.php";
	include "includes/header.php";
	include "includes/right.php";
	 
	$xtpl = new XTemplate ("templates/index.html");
		
//main page

//image
	$sql_image = "SELECT config_homepage_image FROM tg_config";
	$rs_image = execSQL($sql_image);
	$row_image = mysql_fetch_assoc($rs_image);
	if($row_image['config_homepage_image'])
	{
		if (file_exists("images/config/thumb_0_".$row_image['config_homepage_image']))
		{
			$home_image = $row_image['config_homepage_image'];
			$xtpl->assign("home_image",$home_image);
			$xtpl->parse("MAIN.home_image");
		}
	}
//news
	$sql_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_date, news_brief FROM tg_news WHERE news_is_hot = '1' AND news_active='1' ORDER BY news_date LIMIT 0 , 1";
	$rs_news = execSQL($sql_news);
	$no=mysql_num_rows($rs_news);
		if ($no)
			{
				$row_news = mysql_fetch_assoc($rs_news);
				if($row_news['news_image'])
					{
						if(file_exists("images/news/thumb_1_".$row_news['news_image']))
						{
							$row_news['news_image'] = "<a href='news_detail.php?news_id=".$row_news['news_id']."'><img src='images/news/thumb_1_".$row_news['news_image']."' border='0'></a>";
						} else 
						{
							$row_news['news_image'] = "";
						}
					} else
					{
						$row_news['news_image'] = "";
					}
			$xtpl->assign("row_news",$row_news);
			$xtpl->parse("MAIN.hot_news");
			}
		
//hot
	$sql="SELECT md5(products_id) AS products_id, 
				 product_name, 
				 product_image, 
				 product_price,
				 is_in_store
			FROM tg_product
			WHERE is_feature='1'
			ORDER BY product_date DESC
			LIMIT 0 , 9
		  ";
	$rs = mysql_query($sql, $link);
	$num=0;
	if (@mysql_num_rows($rs)>0)
	{
		while ($row=mysql_fetch_assoc($rs))
		{
			$num++;
			if($num % 3 == 0)
			{
				$row['line']="</tr><tr>";
			} else 
			{
				$row['line']="";
			}
			if(file_exists('images/product/thumb_1_'.$row['product_image']))
			{
				$xtpl->assign("image",$row['product_image']);
			} else 
			{
				$xtpl->assign("image","default.jpg");
			}
			if($row['is_in_store']==1)
			{
				$row['is_in_store'] = "Hết hàng";
			}else{
				$row['is_in_store'] = "Còn hàng";
			}
			$row['product_price'] = number_format($row['product_price']);
			$xtpl->assign("row",$row);
			$xtpl->parse("MAIN.hot");
		}
	} else
	{
		$ms = "Không có sản phẩm nào";
		$xtpl->assign("ms",$ms);
		$xtpl->parse("MAIN.ms");
	}
	//end hot
	//newest
	$sql1="SELECT md5(products_id) AS products_id, 
				 product_name, 
				 product_image, 
				 product_price,
				 is_in_store
			FROM tg_product
			WHERE product_status='1'
			ORDER BY product_date DESC
			LIMIT 0 , 9
		  ";
	$rs1 = mysql_query($sql1, $link);
	$num1=0;
	while ($row1=mysql_fetch_assoc($rs1))
	{
		$num1++;
		if($num1 % 3 == 0)
		{
			$row1['line']="</tr><tr>";
		} else 
		{
			$row1['line']="";
		}
		if(file_exists('images/product/thumb_1_'.$row1['product_image']))
		{
			$xtpl->assign("image",$row1['product_image']);
		} else 
		{
			$xtpl->assign("image","default.jpg");
		}
		if($row1['is_in_store']==1)
		{
			$row1['is_in_store'] = "Hết hàng";
		}else{
			$row1['is_in_store'] = "Còn hàng";
		}
		$row1['product_price'] = number_format($row1['product_price']);
		$xtpl->assign("row1",$row1);
		$xtpl->parse("MAIN.new");
	}
	//end
//
	
	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	$xtpl->assign("left_tostring",$left_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
	?>