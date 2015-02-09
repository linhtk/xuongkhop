<?php
@session_start();
function execSQL($stsql){
	$rs = mysql_query($stsql) or die(mysql_error().$stsql);
	return $rs;
}
function smooth_str($str){
	$str = (!get_magic_quotes_gpc()) ? addslashes($str) : $str;
	return $str;
}
function smooth_num($num){
	$num = ($num != "") ? intval($num) : "NULL";
	return $num;
}
function smooth_date($date){
	$date = ($date != "") ? "'$date'" : "NULL"; 
	return $date;
}

function recordset($sql){
	if($sql){
		$rs = mysql_query($sql) or die(mysql_error().$sql);
		$row =  mysql_fetch_array($rs);	
		return $row;
	}
}
function record($sql,$pos,$field){
	if(($sql)&&($field)){
		$rs = mysql_query($sql) or die(mysql_error().$sql);		
		if(mysql_num_rows($rs)>0){
			$record = mysql_result($rs,$pos,$field);
			return $record;
		}
		return "";
	}
}
function get_id_inserted()
{
	return mysql_insert_id();
}
function setfocus($cbovalue,$selected_key){
	return str_replace("'".$selected_key."'","'".$selected_key."' selected",$cbovalue);
}
function deletefile($file_path){
	if (file_exists($file_path)) { 
		echo 'fghdfkjh';
		$deleted = unlink($file_path);
	}
	return $deleted;
}
function uploadfile($path,$new_file,$allow_type,$max_size)
{
	/*****************************************************************************/
	//$allow_type can be:
	//	0: Images only
	//	1: Images and doc, xls, mpp, vso, pdf, zip, rar file
	//	2: All
	//$path: path to store new file
	//$new_file: Posted value of file going to be uploaded.
	//$old_file_name: Name of the old file going to be replaced. Leave "" or name.
	//It will return
	//	Name of the uploaded file
	//	0: Invalid file type
	//	1: Exceed size
	// -1: Unable to upload file
	//	2: Not a file
	/*****************************************************************************/
	$filetmpname=$new_file['tmp_name'];
	if(is_file($filetmpname))
	{
		$filetype=$new_file['type'];
		$filesize=$new_file['size'];
		$filename=$new_file['name'];
		//Check max size
		if($filesize>$max_size)
		{
			return 1;
		}
		else if ($allow_type==0 && $filetype!="image/jpeg" && $filetype!='image/jpg' && $filetype!='image/gif' && $filetype!='image/png' && $filetype!="image/pjpeg" && $filetype!="image/x-png" && $filetype!="application/x-shockwave-flash")
		{
			return 0;
		}
		else if ($allow_type==1 && $filetype!="" && $filetype!="image/jpeg" && $filetype!='image/jpg' && $filetype!='image/gif' && $filetype!='image/png'  && $filetype!="image/pjpeg" && $filetype!="image/bmp" && $filetype!="application/x-shockwave-flash" && $filetype!="application/msword" && $filetype!="text/plain" && $filetype!="application/vnd.ms-excel" && $filetype!="application/pdf" && $filetype!="application/vnd.ms-project" && $filetype!="application/vnd.visio")
		{
			return 0;
		}
		else
		{
			//Upload file
			$unique=time();
			$filename=str_replace(" ","_",$filename);
			$new_name=$unique."_".$filename;
			$uploaded_file_full_path=$path.$new_name;
			if(move_uploaded_file($filetmpname,$uploaded_file_full_path))
			{
				return $new_name;
			}
			else
			{
				return -1;
			}
		}
	}
	else
	{
		return 2;
	}
}
function pagenavigator($page, $row_total, $page_size, $pagegroup_size,$class,$url) 
{
	$andpage=(strrpos ($url,"?")===false)?"?page=":"&page=";
	$page_total = floor(($row_total-1)/$page_size)+1;
	if(!$page || $page > $page_total || $page < 1)
		$page = 1;
	$group = floor(($page-1)/$pagegroup_size)+1;
	$start_page = (($group-1)*$pagegroup_size)+1;
	$end_page = $start_page+$pagegroup_size-1;
	if ($end_page>$page_total) 
		$end_page = $page_total;
	if ($page_total>1) {
		$str.=	'<script language="javascript" type="text/javascript">
					function navigate(i)
					{
						var nav=document.frm_navigator;
						nav.page.value=i;
						nav.submit();
					}
				</script>';
		$str.='<form name="frm_navigator" method="post" action="">';
		$str.='<input type="hidden" name="page" id="page" value=""/>';
		$str.='<ul class="pagination">';
		if ($end_page>$pagegroup_size)
			$start_group = $pagegroup_size;
		else
			$start_group = 0;
		if ($group>1)
			//$str.= '<a  class='.$class.' style="text-decoration: none;" href="'.$url.$andpage.($start_page-$pagegroup_size).'">[Previous '.$pagegroup_size.' pages]</a>';
			$str.= '<a  class="'.$class.'Page" style="text-decoration: none;" href="#" onclick="navigate('.($start_page-$pagegroup_size).');">[Previous '.$pagegroup_size.' pages]</a>&nbsp;';
		//$str.='</td><td valign="center" class='.$class.'>';
		for ( $i=$start_page ; $i <= $end_page ;$i++)
		{
			$j=$i+$page_size;
			$begin = ($i-1)*$page_size + 1;
			$end = $begin + $page_size - 1; 
			if ($i == $page)
				//$str.= "[<span class='".$class."Visited'>$begin - $end</span>]";
				$str.= "<li class='active'><a href='#'>$i</a></li>";
			else
				//$str.= '<a class='.$class.' style="text-decoration: none;" href="'.$url.$andpage.$i.'"> '.$i.'</a> ';
				$str.= '<li><a href="#" onclick="navigate('.$i.');"> '.$i.'</a> </li>';
		}
		//$str.="</td><td class=".$class.">";		
		if ($page_total-$end_page>$pagegroup_size)
			$end_group = $pagegroup_size;
		else
			$end_group = $page_total-$end_page;
		if ($end_page<$page_total)
			//$str.= '<a  class='.$class.' style="text-decoration: none;" href="'.$url.$andpage.($end_page+1).'">[Next '.$pagegroup_size.' pages]</a>';
			$str.= '&nbsp;<a  class="'.$class.'Page" style="text-decoration: none;" href="#" onclick="navigate('.($end_page+1).')">[Next '.$pagegroup_size.' pages]</a>';
		$str.='</uh></form>';
		return $str;
	}	
}

function redir($url)
{
  while (strstr($url, '&&')) $url = str_replace('&&', '&', $url);
  while (strstr($url, '&amp;&amp;')) $url = str_replace('&amp;&amp;', '&amp;', $url);
  while (strstr($url, '&amp;')) $url = str_replace('&amp;', '&', $url);
  echo "<meta http-equiv=\"refresh\" content=\"0; url=".$url."\"/>";		 
  echo "<script type='text/javascript' language = 'javascript'>window.location.href='".$url."'</script>";
  exit();
}

function _POST($value){
	$value=trim(addslashes($value));
	global  $_POST, $HTTP_POST_VARS;
	if (isset($_POST["$value"]))
		return $_POST["$value"];
	elseif (isset($HTTP_POST_VARS["$value"]))
	    return $HTTP_POST_VARS["$value"];
	else
	    return ;
}
function _GET($value)
{
	$value=trim(addslashes($value));
	global $_GET,$HTTP_GET_VARS;
	if (isset($_GET[$value]))
	    return $_GET[$value];
	elseif (isset($HTTP_GET_VARS[$value]))
	    return $HTTP_GET_VARS[$value];
	else
	    return ;
	
}
function READ_SESSION($session_name)
{
    return $_SESSION[$session_name];
}
function WRITE_SESSION($session_name, $session_value)
{
	$_SESSION[$session_name]=$session_value;
}
function is_alphanumeric_str($string) { 
    if (eregi("^[A-Z0-9 .,:!-]{1,}$", $string)) 
        return true; 
    else 
        return false; 
} 
function is_numeric_str($string) { 
    if (eregi("^[0-9]{1,}$", $string)) 
        return true; 
    else 
        return false; 
} 
function is_alphabetic_str($string) { 
    if (eregi("^[A-Z]{1,}$", $string)) 
        return true; 
    else 
        return false; 
} 
function is_valid_login($string) { 
    if (eregi("^[A-Z0-9_]{1,}$", $string)) 
        return true; 
    else 
        return false; 
} 
function is_valid_dbname($string) { 
    if (eregi("^[A-Z0-9_]{1,}$", $string)) 
        return true; 
    else 
        return false; 
} 
function is_valid_email($string)
{
	$atom = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
	$domain = '([a-z]([-a-z0-9]*[a-z0-9]+)?)';
	$regex = '^' . $atom . '+' . '(\.' . $atom . '+)*'. '@'. '(' . $domain . '{1,63}\.)+'. $domain . '{2,63}'. '$'; 
	if (strlen($string) == 0)
	{
		return false;
	}
	else
	{
		if (eregi($regex, $string))
		{
			return true;
		}
	 	else
		{
			return false;
		}
	}
}
function is_valid_date($string)
{
	return true;
}
function is_valid_date_time($string)
{
	return true;
}
function is_valid_time($string)
{
	return true;
}

function formatDataForMySql($data)
{
	$data=str_replace("\\",'',$data);
	$data=str_replace('"',"&quot;",$data);
	$data=str_replace("'","&#039;",$data);
	return $data;
}
function formatDataForFCK($data)
{
	$data=str_replace("'","&#039;",$data);
	return $data;
}
function formatDateFromDatabase($date,$is_display_date_only=true) //Format to the display format
{
	if(!$date || $date=="0000-00-00 00:00:00" || $date=="0000-00-00")
	{
		return "N/A";
	}
	$y=substr($date,0,4);
	$m=substr($date,5,2);
	$d=substr($date,8,2);
	$h=substr($date,11,2);
	$i=substr($date,14,2);
	$s=substr($date,17,2);
	$new_h=$h.":".$i;
	switch ($m)
	{
		case "01": $m="01";break;
		case "02": $m="02";break;
		case "03": $m="03";break;
		case "04": $m="04";break;
		case "05": $m="05";break;
		case "06": $m="06";break;
		case "07": $m="07";break;
		case "08": $m="08";break;
		case "09": $m="09";break;
		case "10": $m="10";break;
		case "11": $m="11";break;
		case "12": $m="12";break;
	}
	
	if($is_display_date_only)
	{
		return $d." / ".$m." / ".$y;
	}
	else
	{
		//return $d."-".$m."-".$y." at ".$h.":".$i.":".$s;
		return $d." / ".$m." / ".$y;
	}
}
function dateDiff($interval,$dateTimeBegin,$dateTimeEnd) 
{
	$dateTimeBegin=strtotime($dateTimeBegin);
	if($dateTimeBegin === -1) 
	{
	  	return("..begin date Invalid");
	}
	$dateTimeEnd=strtotime($dateTimeEnd);
	if($dateTimeEnd === -1) 
	{
	  	return("..end date Invalid");
	}
	$dif=$dateTimeEnd - $dateTimeBegin;
	switch($interval) 
	{
		case "s"://seconds
			return($dif);
		case "n"://minutes
			return(floor($dif/60)); //60s=1m
		case "h"://hours
			return(floor($dif/3600)); //3600s=1h
		case "d"://days
			return(floor($dif/86400)); //86400s=1d
		case "ww"://Week
			return(floor($dif/604800)); //604800s=1week=1semana
		case "m": //similar result "m" dateDiff Microsoft
		  	$monthBegin=(date("Y",$dateTimeBegin)*12)+date("n",$dateTimeBegin);
		  	$monthEnd=(date("Y",$dateTimeEnd)*12)+date("n",$dateTimeEnd);
		  	$monthDiff=$monthEnd-$monthBegin;
		  	return($monthDiff);
	  	case "yyyy": //similar result "yyyy" dateDiff Microsoft
		  	return(date("Y",$dateTimeEnd) - date("Y",$dateTimeBegin));
	  	default:
		  	return(floor($dif/86400)); //86400s=1d
	}
}
function DateAdd($v,$d=null , $f="Y-m-d")
{ 
	/****************************************/
	//echo DateAdd(2);  // 2 days after
	//echo DateAdd(-2,0,"Y-m-d");  // 2 days before with gigen format
	//echo DateAdd(3,"01/01/2000");  // 3 days after given date
	/****************************************/

 	$d=($d?$d:date("Y-m-d")); 
 	return date($f,strtotime($v." days",strtotime($d))); 
}
function display_review_image($review_mark,$review_number,$user_id,$alignment)
{
	if($review_number==0)
	{
		$review_number = "(No feedback yet)";
	}
	else if($review_number==1)
	{
		$review_number = "(".$review_number." review)";
	}
	else
	{
		$review_number = "(".$review_number." reviews)";
	}
	if($review_number=="(No feedback yet)")
	{
		$result="<table cellpadding='0' cellspacing='0' width='90'><tr><td colspan='10' align=\"".$alignment."\"  class=\"review\">".$review_number."</td></tr></table>";
	}
	else 
	{
		$result="<table cellpadding=\"0\" cellspacing=\"0\" width=\"90\"><tr>";
		$review_mark=round($review_mark);
		for($i=1;$i<=$review_mark;$i++)
		{
			$result.="<td><a href=\"review_list.php?id=".$user_id."\" class=\"review\" style='display:block;'><img src=\"images/rate.gif\" border=\"0\" alt=\"\" /></a></td>";
		}
		for($i=$review_mark+1;$i<=10;$i++)
		{
			$result.="<td><a href=\"review_list.php?id=".$user_id."\" class=\"review\" style='display:block;'><img \"src=images/unrate.gif\" border=\"0\" alt =\"\" /></a></td>";
		}
		$result.="</tr><tr><td colspan=\"10\" align=\"".$alignment."\"><a href=\"review_list.php?id=".$user_id."\" class=\"review\" style='display:block;'>".$review_number."</a></td></tr></table>";
	}
	
	return $result;
}
function GetRandomString($length) 
{
	settype($template, "string");
	$template = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    settype($length, "integer");
    settype($rndstring, "string");
    settype($a, "integer");
    settype($b, "integer");
    for ($a = 0; $a <= $length; $a++) 
	{
        $b = rand(0, strlen($template) - 1);
        $rndstring .= $template[$b];
    }
    return $rndstring;
}
function send_email_with_template($template_file,$to,$subject,$dir_text, $message , $before_end_text)
{
	//This function will send email with HTML content read from a page. 
	//You can change content of file using {variable} to do str_replace in $message
	include "config.php";
	$filename=$template_file;
	if(is_file($filename))
	{
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize($filename));
		$body_message = $contents;
		$body_message =str_replace("{dir_text}",$dir_text,$body_message);
		$body_message =str_replace("{message}",$message,$body_message);
		$body_message =str_replace("{before_end_text}",$before_end_text,$body_message);
		$body_message =str_replace("{site_name}",$SITE_TITLE,$body_message);
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Webmaster '.$SITE_TITLE.'<'.$WEBMASTER_EMAIL.'>' . "\r\n";
		@mail($to, $subject, $body_message, $headers);
		fclose($handle);
	}
}
function display_menu($mnu_string_origin)
{
	include "config.php";
	if(READ_SESSION('recovery_mode')=="Yes")
	{
		$r_menu='
[
		[null,\'Dash board\',\''.$base_url.'backoffice/express_main.php\',\'_self\',\'Dash board\'],
		[null,\'Log off\',\'http://localhost/xcms/backoffice/logout.php\',\'_self\',\'Log off\']
]
		';
		return $r_menu;
	}
	$mnu_string_origin=str_replace("'",'"',$mnu_string_origin);
	$mnu_string_origin=str_replace("\r","",$mnu_string_origin);
	$mnu_string_origin=str_replace("\n","",$mnu_string_origin);
	$mnu_string_origin=str_replace("\t","",$mnu_string_origin);
	$mnu=explode(",",$mnu_string_origin);
	$sql="SELECT CONCAT(a.rights_path,'/', b.rights_detail_file) FROM ".$TABLE_PREFIX."rights a INNER JOIN ".$TABLE_PREFIX."rights_detail b ON b.rights_id=a.rights_id INNER JOIN ".$TABLE_PREFIX."admin_rights c ON c.admin_rights_detail_id=b.rights_detail_id WHERE c.admin_id='".READ_SESSION('a_username')."'";
	$rs=execSQL($sql);
	for($i=0;$i<mysql_num_rows($rs);$i++)
	{
		$award[]='"'.$base_url.mysql_result($rs,$i,0).'"';
	}
	$sql="SELECT CONCAT(a.rights_path,'/', b.rights_detail_file) FROM ".$TABLE_PREFIX."rights a INNER JOIN ".$TABLE_PREFIX."rights_detail b ON b.rights_id=a.rights_id";
	$rs=execSQL($sql);
	for($i=0;$i<mysql_num_rows($rs);$i++)
	{
		$rights[]='"'.$base_url.mysql_result($rs,$i,0).'"';
	}
	for($i=0;$i<count($mnu);$i+=5)
	{
		$m[$i]=$mnu[$i].",".$mnu[$i+1].",".$mnu[$i+2].",".$mnu[$i+3].",".$mnu[$i+4];
		$m[$i]=trim($m[$i]);
		if(trim($mnu[$i+2])=='""' || in_array(trim($mnu[$i+2]),$award) || !in_array(trim($mnu[$i+2]),$rights))
		{
			$mnu_s.=$m[$i].",";
		}
		else
		{
			if(substr($m[$i],strlen($m[$i])-2,2)=="]]")
			{
				if(substr($mnu_s,strlen($mnu_s)-1,1)==",")
				{
					$mnu_s=substr($mnu_s,0,strlen($mnu_s)-1);
				}
				$mnu_s.="],";
			}
		}
	}
	if(substr($mnu_s,strlen($mnu_s)-1,1)==",")
	{
		$mnu_s=substr($mnu_s,0,strlen($mnu_s)-1)."]";
	}
	$mnu_second_string=explode(',',$mnu_s);
	for($i=0;$i<count($mnu_second_string);$i+=5)
	{
		if(trim($mnu_second_string[$i+2])=='""' && substr($mnu_second_string[$i+4],strlen($mnu_second_string[$i+4])-1,1)=="]")
		{
		}
		else
		{
			$new_string.=$mnu_second_string[$i].",".$mnu_second_string[$i+1].",".$mnu_second_string[$i+2].",".$mnu_second_string[$i+3].",".$mnu_second_string[$i+4].",";
		}
	}
	$new_string=trim($new_string);
	if(substr($new_string,strlen($new_string)-1,1)==",")
	{
		$new_string=substr($new_string,0,strlen($new_string)-1);
	}
	if(substr($new_string,0,2)!="[[")
	{
		$new_string="[".$new_string;
	}
	$open_bracket=substr_count($new_string,"[");
	$close_bracket=substr_count($new_string,"]");
	if($open_bracket>$close_bracket)
	{
		$new_string=$new_string."]";
	}
	else if($open_bracket<$close_bracket)
	{
		while($open_bracket<$close_bracket)
		{
			$new_string=substr($new_string,0,strlen($new_string)-1);
			$open_bracket=substr_count($new_string,"[");
			$close_bracket=substr_count($new_string,"]");
		}
	}
	return $new_string;
}
function list_files_in_dir($path)
{
	$i=0;
   	if ($handle = opendir($path)) 
   	{
  		while (false !== ($file = readdir($handle))) 
		{
			if ($file != "." && $file != "..")
			{
				$file_arr[$i]['Name']=$file;
				$file_arr[$i]['Size']=round(filesize($path.$file) / 1024, 0);
				$file_arr[$i]['Date']=formatDateFromDatabase(date("Y-m-d H:i:s",filemtime($path.$file)),false);
				$i++;
			}
   		}
	}
	closedir($handle);
	return $file_arr;
}
function thumbnail_images($image,$needed_width,$needed_height,$save_path,$needed_quality,$new_name_prefix,$uploaded_image_name) 
{
	$img_name 		= $image['name'];
	$filetype=$image['type'];
	if($filetype!="image/jpeg" && $filetype!='image/jpg' && $filetype!='image/gif' && $filetype!='image/png' && $filetype!="image/pjpeg" && $filetype!='image/x-png')
	{
		return;
	}
	else
	{
		$img_tmp_name 	= $image['tmp_name'];
		$img_name_original 		= $image['name'];
		$img_name		=	str_replace(" ","_",$uploaded_image_name);
		$result = move_uploaded_file($img_tmp_name, $save_path.$img_name);
		if($filetype == "image/jpg" || $filetype == "image/pjpeg" || $filetype == "image/jpeg") 
		{
			$src_img    = imagecreatefromjpeg($save_path.$img_name);
		}
		else if($filetype == "image/gif") 
		{
			$src_img    = imagecreatefromgif($save_path.$img_name);
		}
		else if($filetype == 'image/png' || $filetype == 'image/x-png')
		{
			$src_img    = imagecreatefrompng($save_path.$img_name);
		}
		$size       = getimagesize($save_path.$img_name);
		list($src_width, $src_height) = $size;
		if ($src_width > $src_height) 
		{
		    $dest_width     = $needed_width;
		    $factor         = $needed_width / $src_width;
		    $dest_height    = $factor * $src_height;
		} 
		else 
		{
		    $dest_height    = $needed_height;
		    $factor         = $needed_height / $src_height;
		    $dest_width     = $factor * $src_width;
		}
		$dest_img = imagecreatetruecolor($dest_width, $dest_height);
		@imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
		$thumb_name = $new_name_prefix."_" . $img_name;
		@imagejpeg($dest_img, $save_path.$thumb_name, 100);
		imagedestroy($src_img);
		imagedestroy($dest_img);
		return	$thumb_name;		
	}
}
?>