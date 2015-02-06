<?php
function mod_login($table)
{
	$username = post('username');
	$password = post('password');
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
		$sql="SELECT count(*) as count FROM ".$table. " WHERE admin_id='$username' and admin_password=md5('".$password."') and admin_is_active='1'";
		$rs=recordset($sql);
		$count=$rs['count'];
		if( $count > 0 )
		{	
			$error="";
			return $error;
			
		}else{
			$error=sprintf(ERR_INVALID_LOGIN,$username);
		}
	}
	return $error;
}

function get_admin_full_name($id)
{
	$sql="SELECT admin_fullname FROM ".TABLE_PREFIX."admin WHERE admin_id='$id'";
	$rs=recordset($sql);
	return $rs['admin_fullname'];
}


?>