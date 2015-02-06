<?php
//echo md5('123456');
error_reporting(0);
include "../includes/config.php";
include "../includes/global.php";
include "../includes/xtpl.php";
include "../includes/function.php";
include "includes/languages/language_en.php";
include "modules/mod_login.php";
$xtpl=new Xtemplate("templates/login.htm");
$action=$_POST['frmAction'];
$save=$_POST['save'];
if($action=="act")
{
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$error="";
	if(!$username)
	{
		$error.=ERR_USERNAME_LOGIN."<br/>";
	}
	if(!$password)
	{
		$error.=ERR_PASSWORD_LOGIN."<br/>";
	}
	if(!$error)
	{
		$sql="SELECT count(*) as count FROM tg_admin WHERE admin_id='$username' and admin_password=md5('".$password."') and admin_is_active='1'";
		
		$rs=recordset($sql);
		$count=$rs['count'];
		if( $count > 0 )
		{	
			$error="";
		}else{
			$error=sprintf(ERR_INVALID_LOGIN,$username);
		}
	}
	
	if($error)
	{
		$xtpl->assign('error',$error);
		$xtpl->parse('main.error');
	}
	else
	{
		$username=$_POST['username'];
		$_SESSION['admin']=$username;
		$login_time=date("Y-m-d H:i:s");
		$ip=get_ip_address();
		$sql="UPDATE tg_admin SET admin_last_login='$login_time' WHERE admin_id='$username'";
		execSQL($sql);
		$sql="INSERT INTO tg_admin_session(
					session_in
					,session_ip
					,admin_id					
					) VALUES(
					'$login_time'
					,'$ip'
					,'$username'	
					)";
		execSQL($sql);	
		$id_insert=get_id_inserted();
		
		$_SESSION['session_id']=$id_insert;
		if($save)
		{
			setcookie("a_login",$username."~~".md5($password),time()+2592000);
		}
		
		redir('index.php');
		exit();
	}
	
}else 
{
	
	if($_COOKIE['a_login']&&($_SESSION['logout']!=1))
	{
		$cookie=$_COOKIE['a_login'];
		$cookie=split('~~',$cookie);
		$username=$cookie[0];
		$password=$cookie[1];
		$sql="SELECT count(*) as count FROM tg_admin WHERE admin_id='$username' and admin_password='".$password."' and admin_is_active='1'";
		
		$rs=recordset($sql);
		$count=$rs['count'];
		if($count)
		{
			$_SESSION['admin']=$username;
			$login_time=date("Y-m-d H:i:s");
			$ip=get_ip_address();
			$sql="UPDATE tg_admin SET admin_last_login='$login_time' WHERE admin_id='$username'";
			execSQL($sql);
			$sql="INSERT INTO tg_admin_session(
						session_in
						,session_ip
						,admin_id					
						) VALUES(
						'$login_time'
						,'$ip'
						,'$username'	
						)";
			execSQL($sql);	
			$id_insert=get_id_inserted();
			$_SESSION['session_id']=$id_insert;
			redir('index.php');
			exit();
		}
	}
}
$xtpl->assign('COM_SAVE_LOGIN_INFO',COM_SAVE_LOGIN_INFO);
$xtpl->parse('main');
eval("?>".$xtpl->text('main'));
//include "includes/application_bottom.php";
?>