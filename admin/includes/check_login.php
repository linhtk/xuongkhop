<?php
if($_SESSION['admin']=='')
{
	redir('login.php');
}
?>