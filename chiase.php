<? 
	error_reporting(0);
	include "includes/xtpl.php";
	include "includes/global.php";
	include "includes/connection.php";
	include "includes/function.php";
	include "includes/function_page.php";
	include "includes/footer.php";
	include "includes/benh.php";
	$flag = 'share';
	include "includes/header.php";
	include "includes/right.php";
	 
	$xtpl = new XTemplate ("templates/chiase.html");
///tin tuc
	$page=$_POST['page']?$_POST['page']:1;
	$pagegroup_size=10;
	$limit=($show_result?$show_result:4);
	$offset=($page-1)*$limit;
	$LIMIT=" LIMIT $offset,$limit";
	$sql_tin = "SELECT * FROM tg_share";
	$rs_tin1 = execSQL($sql_tin);
	$row_total=mysql_num_rows($rs_tin1);
	$sql_tin.=$LIMIT;
	$rs_tin=execSQL($sql_tin);
	$pages=pagenavigator($page, $row_total, $limit, $pagegroup_size,'',$PHP_SELF) ;
	while ($row_tin = mysql_fetch_assoc($rs_tin)){
		$row_tin['content'] = sub_string($row_tin['content'], 200);
		$xtpl->assign("tin",$row_tin);
		$xtpl->parse("MAIN.tin");	
	}
	
		
	$xtpl->assign("page",$pages);
	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	$xtpl->assign("benh_tostring",$benh_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
	?>