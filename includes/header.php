<?
	$xtpl_header = new XTemplate ("templates/header.html");
		
		$sql = "SELECT config_title_site FROM tg_config";
		$rs = execSQL($sql);
		$row = mysql_fetch_assoc($rs);
		$xtpl_header->assign("title",$row['config_title_site']);
		
	$xtpl_header->parse("HEADER");
	$header_tostring = $xtpl_header->text("HEADER");
	
?>
