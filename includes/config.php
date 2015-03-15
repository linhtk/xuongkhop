<?php 

	// for data connection
	$host = 'localhost';
	$dbname = 'xuongkhop';
	$dbuser = 'root';
	$dbpwd = '';
	$TABLE_PREFIX='tg_';
	define('TABLE_PREFIX','tg_');
	
	//Whole site
	$title='Benh Xuong Khop - ';
	$SITE_CHARSET='charset=utf-8';
	$MAX_FILE_SIZE=1024000;
	
	$dbconn = mysql_connect($host, $dbuser, $dbpwd) or die(mysql_error().$host);
	$db = mysql_select_db($dbname, $dbconn) or die(mysql_error().$host);
	
	//LOCALHOST
//	define('HTTP_SERVER', 'http://localhost/tggum/catalog'); 
//	define('HTTPS_SERVER', 'http://localhost/tggum/secure'); 
//	define('DIR_HTTP_ROOT', 'C:/AppServ/www/tggum/catalog');
//  	define('DIR_HTTPS_ROOT', 'C:/AppServ/www/tggum/secure');
	
	//TESTING
	/*define('HTTP_SERVER', 'http://qsoftvietnam:888/testing/tggum'); 
	define('HTTPS_SERVER', ''); 
	define('DIR_HTTP_ROOT', 'C:/AppServ/www');
  	define('DIR_HTTPS_ROOT', '');*/
	
	//NovaWhite
	/*define('HTTP_SERVER', 'http://localhost'); // eg, http://localhost - should not be empty for productive servers
	define('HTTPS_SERVER', ''); // eg, https://localhost - should not be empty for productive servers
	define('DIR_HTTP_ROOT', '/oscommerce/catalog/');
  	define('DIR_HTTPS_ROOT', '');*/
	
	$base_url='http://localhost/catalog';
	$FCK_EDITOR_UPLOAD_PATH='/img/fck/'; //If your folder is not root, you must add it eg. /myfolder/img/fck/
	$webmaster_email="admin@tggum.com.sg";
	
	
	///
//	$paypal_config['url']='https://www.sandbox.paypal.com/cgi-bin/webscr';
//	//$paypal_config['url']='https://www.paypal.com/cgi-bin/webscr';
//	$paypal_config['return']['cancel'] = "http://tggum.com.sg/onlinestore/index.php"; 
//	$paypal_config['return']['thanks'] = "http://tggum.com.sg/onlinestore/thankyou.php";  
// 	$paypal_config['account']='test@paypal.com';	
	
?>