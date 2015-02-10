<? 
	error_reporting(0);
	include "includes/xtpl.php";
	include "includes/global.php";
	include "includes/connection.php";
	include "includes/function.php";
	include "includes/function_page.php";
	include "includes/footer.php";
	include "includes/benh.php";
	$flag='hoidap';
	include "includes/header.php";
	include "includes/right.php";
	 
	$xtpl = new XTemplate ("templates/hoidap.html");
///tin tuc
	$page=$_POST['page']?$_POST['page']:1;
	$pagegroup_size=10;
	$limit=($show_result?$show_result:4);
	$offset=($page-1)*$limit;
	$LIMIT=" LIMIT $offset,$limit";
	$sql = "SELECT * FROM tg_support";
	$rs = execSQL($sql);
	$row_total=mysql_num_rows($rs);
	$sql.=$LIMIT;
	$rs_tin=execSQL($sql);
	$pages=pagenavigator($page, $row_total, $limit, $pagegroup_size,'',$PHP_SELF) ;
	while ($row = mysql_fetch_assoc($rs_tin)){
		$row['support_date'] = formatDateFromDatabase($row['support_created_date']);
		$row['content'] = sub_string($row['content'], 200);
		if($row['answer'] != ''){
			$row['support_date'] = formatDateFromDatabase($row['support_created_date']);
			$row['answer'] = sub_string($row['answer'], 200);
            $row['support_id'] = $row['support_id'];
            $xtpl->assign('id',$row['support_id']);
            $xtpl->parse("MAIN.faq.answer");
		}
		$xtpl->assign("faq",$row);
		$xtpl->parse("MAIN.faq");	
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