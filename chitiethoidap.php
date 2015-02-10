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
	$xtpl = new XTemplate ("templates/chitiethoidap.html");
	
	$news_id = $_REQUEST['id'];
	
	$sql = "SELECT * FROM tg_support WHERE support_id = '".$news_id."'";
	$rs = execSQL($sql);
	$row = mysql_fetch_assoc($rs);
	$row['created_date'] = formatDateFromDatabase($row['support_created_date'],true);
    if($row['answer'] != ''){
        $row['support_date'] = formatDateFromDatabase($row['support_created_date']);
        $xtpl->assign('support_date', $row['support_date']);
        $xtpl->assign('answer',$row['answer']);
        $xtpl->parse("MAIN.answer");
    }
	$xtpl->assign("row",$row);
    //other
    $sql1 = "SELECT support_id, support_title FROM tg_support WHERE support_id <> '".$row['support_id']."' LIMIT 0,4";
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