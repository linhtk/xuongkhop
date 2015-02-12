<?
error_reporting(0);
	include "includes/xtpl.php";
	include "includes/global.php";
	include "includes/connection.php";
	include "includes/function.php";
	include "includes/function_page.php";
	include "includes/footer.php";
	include "includes/header.php";
	include "includes/right.php";
	$xtpl = new XTemplate ("templates/news_detail.html");
	
	$news_id = $_REQUEST['id'];
	
	$sql = "SELECT * FROM tg_news WHERE md5(news_id) = '".$news_id."'";
	$rs = execSQL($sql);
	$row = mysql_fetch_assoc($rs);
	if($row['news_image'])
	{
		if(file_exists("upload/news/".$row['news_image']))
		{
			$row['news_image'] = "<img src='upload/news/".$row['news_image']."' />";
		} else 
		{
			$row['news_image'] = "";
		}
	} else
	{
		$row['news_image'] = "";
	}
	$xtpl->assign("row",$row);
	//other
	$sql1 = "SELECT md5(news_id) AS news_id, news_title FROM tg_news WHERE news_id <> '".$row['news_id']."' AND news_active = '1' LIMIT 0,4";
	$rs1 = execSQL($sql1);

	while ($row1 = mysql_fetch_assoc($rs1))
	{
        $xtpl->assign("row1",$row1);
		$xtpl->parse("MAIN.other");
	}
	
	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	//$xtpl->assign("left_tostring",$left_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
?>