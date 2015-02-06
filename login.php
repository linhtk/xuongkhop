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
	$xtpl = new XTemplate ("templates/login.html");
	 
	$act=$_POST['act'];
	$fullname = $_POST['fullname'];
	$add = $_POST['add'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$content = $_POST['content'];
	if($act=='act')
	{
		if ($fullname=='')
		{
			$error = 'Bạn hãy nhập họ tên';
		}
		if ($email=='')
		{
			$error .= 'Bạn hãy nhập email';
		}
		if ($content=='')
		{
			$error .= 'Bạn hãy nhập nội dung';
		}
		if($error)
		{
			$xtpl->assign("fullname",$fullname);
			$xtpl->assign("add",$add);
			$xtpl->assign("email",$email);
			$xtpl->assign("phone",$phone);
			$xtpl->assign("content",$content);
			$xtpl->assign("error",$error);
			$xtpl->parse("MAIN.form");
		} else
		{
		$header = "From: ".$email."\n";
		$header.= "MIME-Version: 1.0\n";
		$header.= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
		$header.= "Content-Transfer-Encoding: 8bit\n";
//		$from = "From: $email\r\n";
//		$from .= 'MIME-Version: 1.0' . "\r\n";
//		$from .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$subject = "Contact from website";
		$message = "<table width='500' border='0' cellpadding='2' cellspacing='2'>
					  <tr>
						<td colspan='2'>You have a message from your website</td>
					  </tr>
					  <tr>
						<td width='110'>Contact name</td>
						<td width='376'>".$fullname."</td>
					  </tr>
					  <tr>
						<td>Address</td>
						<td>".$add."</td>
					  </tr>
					  <tr>
						<td>Telephone</td>
						<td>".$phone."</td>
					  </tr>
					  <tr>
						<td>Email</td>
						<td>".$email."</td>
					  </tr>
					  <tr>
						<td>Content</td>
						<td>".$content."</td>
					  </tr>
					</table>
					";
		$admin_email = get_admin_email();
		mail($admin_email, $subject, $message, $header);
		$xtpl->parse("MAIN.thanks");
		}
	} else 
	{
		$xtpl->parse("MAIN.form");
	}
	
	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	$xtpl->assign("left_tostring",$left_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
	?>