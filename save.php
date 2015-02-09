<? 
	error_reporting(0);
	include "includes/xtpl.php";
	include "includes/global.php";
	include "includes/connection.php";
	include "includes/function.php";
	include "includes/function_page.php";
	include "includes/footer.php";
	$flag = 'share';
	include "includes/header.php";
	include "includes/right.php";
	$xtpl = new XTemplate ("templates/save.html");
	
	$fullname = $_POST['fullname'];
	$phoneNumber = $_POST['phoneNumber'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$content = $_POST['content'];
	var_dump($_POST);
	die();
	$error = 0;
	if($fullname==''){ $error = 1;}
	if($phoneNumber == '') { $error = 1; }
	if($email == '') { $error = 1; }
	if($address == '') { $error = 1; }
	if($content == '') { $error = 1; }
	if($error == 0) {
		$sql = " INSERT INTO tg_share(fullname, address, phone, email, content) VALUES ('$fullname', '$address, '$phoneNumber', '$email', '$content')";
		execSQL($sql);
		redir('chiase.php');
	}
	
	
	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
?>