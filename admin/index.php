<?php
error_reporting(0);
include "includes/application_top.php";
include "includes/header.php";
$mod=urldecode(htmlspecialchars(trim(get('mod'))));	
$action=trim(get('act'));
$template="templates/";
$heading_page="<a href='index.php' class='a_header'>Trang chủ</a> ";
$title="Administrator system ";
if(!$mod)
{
	// if not is module return index page
	$template.="home.htm";
	$url="includes/home.php";
}
else
{
	// declare template file
	$template.=$mod . "/" ;
	if($action)
	{
		// include Ex: customer/action.php;
		$heading_page.="<strong>-></strong> <a href='index.php?mod=".$mod."' class='a_header'>".$page[$mod]."</a> <strong>-></strong> ".$name[$action];
		$url=$mod . "/" . $action.".php";
		$template.=$action.".htm";
	}
	else
	{
		// include module index page
		$heading_page.="<strong>-></strong> ".$page[$mod];
		$url=$mod . "/" . "index.php";
		$template.="index.htm";
	}
}

if(file_exists($url))
{
	$xtpl=new Xtemplate($template);
	$title.= " - ".$page[$mod];
	include $url;
}
else
{
	redir("404.php");
	exit();
}
include "includes/application_bottom.php";
?>
