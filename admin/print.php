<?
	//include "../settings.php";
	include "includes/application_top.php";
	include "includes/languages/language_en.php";
	include "includes/check_login.php";
	$xtpl = new XTemplate("templates/print.html");
	$id=$_GET['id'];
	if(isset($id)){
		$sql="SELECT * FROM hoadon WHERE md5(ID)='$id'";
		$rs = execSQL($sql);
		$row=mysql_fetch_array($rs);
	}
	$xtpl->assign("row",$row);	
	$xtpl->parse("MAIN.VIEW");
	
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
?>