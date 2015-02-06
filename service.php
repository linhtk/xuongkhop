<? 
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
	 
	$xtpl = new XTemplate ("templates/service.html");
		
	$sql="SELECT * FROM tg_cms WHERE page_code = 'service'";
	$rs = mysql_query($sql, $link);
	$row = mysql_fetch_assoc($rs);
	if(($row['page_image'])&(file_exists("images/cms/thumb_0_".$row['page_image'])))
	{
		$xtpl->assign("page_image",$row['page_image']);
		$xtpl->parse("MAIN.image");
	}
	$xtpl->assign("row",$row);
	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	$xtpl->assign("left_tostring",$left_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
	?>