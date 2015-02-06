<?php
include "../includes/global.php";
include "../includes/config.php";
$_SESSION['admin']="";
$session_id=$_SESSION['session_id'];
$out_time=date("Y-m-d H:i:s");
$sql="UPDATE ".TABLE_PREFIX."admin_session SET session_out='$out_time' WHERE session_id='$session_id'";
execSQL($sql);
$_SESSION['session_id']='';
session_unregister("admin");
session_unregister("session_id");
$_SESSION['logout']=1;
redir("login.php");
exit();
?>