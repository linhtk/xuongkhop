<?
	$xtpl_footer = new XTemplate ("templates/footer.html");

	//$sql = "SELECT config_footer_content FROM tg_config";
	//$rs = execSQL($sql);
	//$row = mysql_fetch_assoc($rs);
	//$xtpl_footer->assign("footer_content",$row['config_footer_content']);

	$xtpl_footer->parse("FOOTER");
	$footer_tostring = $xtpl_footer->text("FOOTER");
?>
