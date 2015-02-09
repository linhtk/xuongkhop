<?
    error_reporting(0);
	include "includes/xtpl.php";
	include "includes/global.php";
	include "includes/class.shoppingcart.php";
	include "includes/connection.php";
	include "includes/function.php";
	include "includes/function_page.php";
	include "includes/footer.php";
	//include "includes/left.php";
	$flag = 'index';
	include "includes/header.php";
	//include "includes/right.php";
	 
	$xtpl = new XTemplate ("templates/index.html");

//slide
	$sql_news = "SELECT md5(news_id) AS news_id, news_title, news_image, news_date, news_brief FROM tg_news WHERE news_is_hot = '1' AND news_active='1' ORDER BY news_date LIMIT 0 , 3";
	$rs_news = execSQL($sql_news);
	$no=mysql_num_rows($rs_news);
	if ($no)
	{
		$i = 0;
		while($row_news = mysql_fetch_assoc($rs_news)){
			if($i==0){$row_news['class']='active ';}
			if($row_news['news_image'])
				{
					if(file_exists("upload/news/thumb_0_".$row_news['news_image']))
					{
						$row_news['news_image'] = '<img src="upload/news/thumb_0_'.$row_news['news_image'].'" class="img-responsive" height="350" />';
					} else 
					{
						$row_news['news_image'] = "";
					}
				} else
				{
					$row_news['news_image'] = "";
				}
				$i++;
			$xtpl->assign("row_news",$row_news);
			$xtpl->parse("MAIN.hot_news");
		}
	}

//news
	$sql_news1 = "SELECT md5(news_id) AS news_id, news_title, news_image, news_date, news_brief FROM tg_news WHERE news_active='1' ORDER BY news_date LIMIT 0 , 4";
	$rs_news1 = execSQL($sql_news1);
	$no1=mysql_num_rows($rs_news1);
	if ($no1)
	{
		while($row_news1 = mysql_fetch_assoc($rs_news1)){
			if($row_news1['news_image'])
				{
					if(file_exists("upload/news/thumb_0_".$row_news1['news_image']))
					{
						$row_news1['news_image'] = '<img class="media-object" src="upload/news/thumb_0_'.$row_news1['news_image'].'" alt="Image" width="55" height="45">';
					} else 
					{
						$row_news1['news_image'] = "";
					}
				} else
				{
					$row_news1['news_image'] = "";
				}
				$row_news1['news_brief'] = sub_string($row_news1['news_brief'], 100, true);
			$xtpl->assign("row_news1",$row_news1);
			$xtpl->parse("MAIN.news");
		}
	}
//kien thuc
    $sql_kt = "SELECT category_id, category_name FROM tg_category WHERE category_parent = 101";
    $rs_kt = execSQL($sql_kt);
    $num = 1;
    while($row_kt = mysql_fetch_assoc($rs_kt)){
        $sql_news_kt = "SELECT news_id, news_title FROM tg_news_cate WHERE cate_id = ".$row_kt['category_id']." ORDER BY news_id DESC LIMIT 0,3";
        $rs_news_kt = execSQL($sql_news_kt);
        while($row_news_kt = mysql_fetch_assoc($rs_news_kt)){
            $xtpl->assign("news_kt",$row_news_kt);
            $xtpl->parse("MAIN.KT.NEWS_KT");
        }
        $row_kt['image'] = '<img alt="" src="upload/product/'.$num.'.jpg" class="img-responsive" />';
        $num++;
        $xtpl->assign("KT", $row_kt);
        $xtpl->parse("MAIN.KT");
    }
//cam nang
    $sql_cn = "SELECT news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 112 ORDER BY news_id DESC LIMIT 0,2";
    $rs_cn = execSQL($sql_cn);
    while($row_cn = mysql_fetch_assoc($rs_cn)){
        $row_cn['news_brief'] = sub_string($row_cn['news_brief'], 100, true);
        $xtpl->assign("CN", $row_cn);
        $xtpl->parse("MAIN.CN");
    }
//kinh nghiem
    $sql_kn = "SELECT news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 109 ORDER BY news_id DESC LIMIT 0,2";
    $rs_kn = execSQL($sql_kn);
    while($row_kn = mysql_fetch_assoc($rs_kn)){
        $row_kn['news_brief'] = sub_string($row_kn['news_brief'], 100, true);
        $xtpl->assign("KN", $row_kn);
        $xtpl->parse("MAIN.KN");
    }
//bai thuoc
    $sql_bt1 = "SELECT news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 120 ORDER BY news_id DESC LIMIT 0,1";
    $rs_bt1 = execSQL($sql_bt1);
    while($row_bt1 = mysql_fetch_assoc($rs_bt1)){
        $row_bt1['news_brief'] = sub_string($row_bt1['news_brief'], 100, true);
        $xtpl->assign("BT1", $row_bt1);
        $xtpl->parse("MAIN.BT1");
    }
    $sql_bt2 = "SELECT news_id, news_title, news_brief, news_image FROM tg_news_cate WHERE cate_id = 120 ORDER BY news_id DESC LIMIT 0,4";
    $rs_bt2 = execSQL($sql_bt2);
    while($row_bt2 = mysql_fetch_assoc($rs_bt2)){
        $row_bt2['news_brief'] = sub_string($row_bt2['news_brief'], 100, true);
        $xtpl->assign("BT2", $row_bt2);
        $xtpl->parse("MAIN.BT2");
    }

	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	$xtpl->assign("left_tostring",$left_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
	?>