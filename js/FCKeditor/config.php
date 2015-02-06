<?php 

	// for data connection
	$host = 'localhost';
	$dbname = 'emitecc_networking';
	$dbuser = 'emitecc_emitecc';
	$dbpwd = 'emitec1993';
	$TABLE_PREFIX='etc_';
	
	//Whole site
	$SITE_TITLE='EMITEC';
	$SITE_CHARSET='charset=iso-8859-1';
	$MAX_FILE_SIZE=1024000;
	
	$dbconn = mysql_connect($host, $dbuser, $dbpwd) or die(mysql_error().$host);
	$db = mysql_select_db($dbname, $dbconn) or die(mysql_error().$host);
	
	$ROOT_SITE = $_SERVER['DOCUMENT_ROOT'] . "/emitec07/networking/";
	// site url
	$base_url='http://emitec.ch/emitec07/networking/';
	//$base_url='http://qsoftvietnam:888/testing/emitec/';
	$FCK_EDITOR_UPLOAD_PATH='/emitec07/networking/img/fck/'; //If your folder is not root, you must add it eg. /myfolder/img/fck/
?>