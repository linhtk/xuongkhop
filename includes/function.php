<?php

/*
	@return HTTTP POST value
*/

function post($value)
{
	if($value)
	{
		if($HTTP_POST_VARS[$value])
		{
			//print_r($HTTP_POST_VARS);
			return addslashes(trim($HTTP_POST_VARS[$value]));
		}	
		elseif($post[$value])
		{
			return 	addslashes(trim($post[$value]));
		}	
	}	
}

/*
	@return HTTTP GET value
*/

function get($value)
{
	if($value)
	{
		if($HTTP_GET_VARS[$value])
			return addslashes(trim($HTTP_GET_VARS[$value]));
		elseif($_GET[$value])
			return 	addslashes(trim($_GET[$value]));
	}
		
}

function gen_input_text($name,$value="",$size='30',$maxlength='100',$event='',$class='',$readonly='')
{
	return create_text_control('text',$name,$value,$size,$maxlength,$event,$class,$readonly);
}

function gen_input_password($name,$value="",$size='30',$maxlength='100',$event='',$class='',$readonly='')
{
	return create_text_control('password',$name,$value,$size,$maxlength,$event,$class,$readonly);
}

function gen_input_hidden($name,$value="")
{
	return '<input type="hidden" name="'.$name.'" value="'.$value.'"/>';
}

function gen_input_button($caption,$event="",$class="")
{	
	return gen_button("button",$caption,$event,$class);
}

function gen_input_submit($caption,$event="",$class="")
{	
	return gen_button("submit",$caption,$event,$class);
}

function gen_input_reset($caption,$event="",$class="")
{	
	return gen_button("reset",$caption,$event,$class);
}

function gen_input_checkbox($name,$value1,$value2,$caption,$event='',$class='')
{
	return gen_check('checkbox',$name,$value1,$value2,$caption,$event,$class);
}

function gen_input_radio($name,$value1,$value2,$event='',$class='')
{
	if(post($name)==$value1 || $value1==$value2)
	{
		$checked=' checked="checked"';
	}
	return '<input type="radio" name="'.$name.'" value="'.$value1.'"'.$checked.' />';
}
function gen_input_file($name,$size=30,$event='',$class='')
{
	if($class)
	{
		$class=" class='$class'";
	}
	return '<input type="file" name="'.$name.'" size="'.$size.'" '.$event.' '.$class.'/>';
}

function gen_input_textarea($name,$value="",$cols=30,$rows=7,$event="",$class="")
{
	if($class)
	{
		$class=" class='$class'";
	}
	if($post[$name])
	{
		$value_1=	stripslashes(post($name));
	}elseif($value)
	{
		$value_1=$value;
	}
	return '<textarea name="'.$name.'" rows="'.$rows.'" cols="'.$cols.'" '.$event.' '.$class.' id="'.$name.'" >'.$value_1.'</textarea>';
}

/*
	create control type text, password
	@param $name: name of control
	@param $type:text or password or hidden
	@param size, maxlength, class
	@out control
*/

function create_text_control($type='text',$name,$value="",$size='30',$maxlength='100',$event='',$class='',$readonly)
{
	if($class)
	{
		$class=" class='$class'";
	}
	if($readonly)
	{
		$readonly= " readonly='readonly'";
	}
	if(post($name))
	{
		$value_1=	stripslashes(post($name));
	}elseif($value)
	{
		$value_1=$value;
	}else
	{
		$value_1='';
	}
	$value=' value="'.$value.'"';
	return '<input type="'.$type.'" name="'. $name .'" '.$value.' size="'. $size .'" maxlength="'.$maxlength.'" '.$event.' '.$class.' '.$readonly.' id="'.$name.'"/>';
}

/*
	create control type button, submit, reset
	@param $caption: value of control
	@param $type:submit
				 reset
				 button
	@param event: javascript event;
	@param class: class 
	@out control
*/


function gen_button($type="button",$caption,$event="",$class="")
{
	$class=$class?' class="'.$class.'"':'';
	return '<input type="'.$type.'" value="'.$caption.'" '.$event.' '.$class.' />';
}

function gen_check($type,$name,$value1,$value2,$caption,$event='',$class='')
{
	$class=$class?' class="'.$class.'"':'';
	$value1=(post($name)?post($name):$value1);
	if($value1==$value2 || post($name)==$value1 )
		$check=' checked="checked"';
	else 
		$check='';	
	return '<input type="'.$type.'" name="'.$name.'" id="'.$name.'" value="'.$value1.'" '.$check.' '.$event.' '.$class.'/>&nbsp;<label for="'.$name.'">'.$caption.'</label>' ;
}
/*
	gen select control
	@param $name : name of control
	@param arr_source: array to get data show control
	@param key: value of control
	@param value: caption show bettween option tag
	@param selected: value focus selected status value
	@param event: event javascript or define inline style
	@param class : class of control
*/
function gen_input_select($name,$arr_source,$key,$value,$selected="",$event="",$class="")
{
	if($class)
	{
		$class=" class='$class'";
	}
	$control='<select name="'.$name.'" '.$event.' '.$class.'><option value="" selected="selected">Choose one</option>';
	
	if(is_array($arr_source))
	{
		for($i=0;$i<count($arr_source);$i++)
		{
			if($arr_source[$i][$key]==post($name)||$arr_source[$i][$key]==$selected)
			{
				$select= 'selected="selected"';
			}else
			{
				$select='';
			}
			$control.='<option value="'.$arr_source[$i][$key].'" '.$select.'>'.$arr_source[$i][$value].'</option>';		
		}
		
	}
	$control.="</select>";
	return $control;
}

function gen_input_datetime($name,$value,$show_time=true,$event='',$class='')
{
	$control=gen_input_text($name,$value,20,20,event,$class)."&nbsp;<small>(YYYY-mm-dd)</small>";
	$control.="<script language='javascript' type='text/javascript'>
				Calendar.setup({
							inputField     :    '".$name."',   // id of the input field
							ifFormat       :    '%Y-%m-%d',       // format of the input field
							showsTime      :    ".($show_tile?'true':'false').",
							timeFormat     :    '24'
						});	
				</script>";
	return $control;			
}
/*
	gen multi select control defaut size = 10
	@param $name : name of control
	@param arr_source: array to get data show control
	@param key: value of control
	@param value: caption show bettween option tag
	@param array_selected: one dimenstion array value focus selected value
	@param event: event javascript or define inline style
	@param class : class of control
*/
function gen_input_multiselect($name,$arr_source,$key,$value,$array_selected,$event="",$class="")
{
	if($class)
	{
		$class=" class='$class'";
	}
	$control='<select name="'.$name.'[]" '.$event.' '.$class.' multiple="multiple" size="10">';
	$array_select=$post[$name]?$post[$name]:$array_selected;
	if(is_array($arr_source))
	{
		for($i=0;$i<count($arr_source);$i++)
		{
			if(is_array($array_select))
			{
				if(in_array($arr_source[$i][$key],$array_select))
				{
					$select=' selected="selected"';
				}
				else
				{
					$select='';
				}
			}
			$control.='<option value="'.$arr_source[$i][$key].'" '.$select.'>'.$arr_source[$i][$value].'</option>';	
		}
	}
	$control.='</select>';
	return $control;
}

function gen_input_FCKEditor($name,$value)
{
	/*if(post($name))
	{
		$string=stripslashes(post($name));
	}else{
		$string=$value;
	}
	require_once "../js/FCKeditor/fckeditor.php";
	$sBasePath="../js/FCKeditor/";
	$oFCKeditor = new FCKeditor($name);
	$oFCKeditor->BasePath	= $sBasePath ;
	$oFCKeditor->Value		= $string;
	$oFCKeditor->Config['SkinPath'] = 'skins/silver/';
	$oFCKeditor->ToolbarSets='MyToolBar';
	$field=$oFCKeditor->Create();
	return $field;*/
        $content = "<script type='text/javascript' src='../js/ckeditor/ckeditor.js'></script>
	<textarea class='ckeditor' cols='".$col."' id='".$name."' name='".$name."' rows='".$row."'>".$value."</textarea>";
	return $content;
}
//function gen_input_
/*
	return array two dimenstion of database
*/

function get_fetch_assoc($rs)
{
	$array=array();
	while($row=mysql_fetch_assoc($rs))
	{
		array_push($array,stripslashes_deep($row));
	}
	return $array;
}
function stripslashes_deep($value)
{
   $value = is_array($value) ?
               array_map('stripslashes_deep', $value) :
               stripslashes($value);

   return $value;
}

/*
	check valid email
	return true if valid email 
*/

function is_email($email)
{
    $valid_address = true;
    // fail if contains no @ symbol
    if (!strstr($email,'@')) return false;

    // split the email address into user and domain parts
    // need to update to trap for addresses in the format of "first@last"@someplace.com
    // this method will most likely break in that case
    list( $user, $domain ) = explode( "@", $email );
    $valid_ip_form = '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}';
    $valid_email_pattern = '^[a-z0-9]+[a-z0-9_\.\'\-]*@[a-z0-9]+[a-z0-9\.\-]*\.(([a-z]{2,6})|([0-9]{1,3}))$';
    //preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9\._-]+)+$/', $email))
    //preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*?[a-z]+$/is');
    $space_check = '[ ]';

    // strip beginning and ending quotes, if and only if both present
    if( (ereg('^["]', $user) && ereg('["]$', $user)) ){
      $user = ereg_replace ( '^["]', '', $user );
      $user = ereg_replace ( '["]$', '', $user );
      $user = ereg_replace ( $space_check, '', $user ); //spaces in quoted addresses OK per RFC (?)
      $email = $user."@".$domain; // contine with stripped quotes for remainder
    }

    // fail if contains spaces in domain name
    if (strstr($domain,' ')) return false;

    // if email domain part is an IP address, check each part for a value under 256
    if (ereg($valid_ip_form, $domain)) {
      $digit = explode( ".", $domain );
      for($i=0; $i<4; $i++) {
        if ($digit[$i] > 255) {
          $valid_address = false;
          return $valid_address;
          exit;
        }
        // stop crafty people from using internal IP addresses
        if (($digit[0] == 192) || ($digit[0] == 10)) {
          $valid_address = false;
          return $valid_address;
          exit;
        }
      }
    }

    if (!ereg($space_check, $email)) { // trap for spaces in
      if ( eregi($valid_email_pattern, $email)) { // validate against valid email patterns
        $valid_address = true;
      } else {
        $valid_address = false;
        return $valid_address;
        exit;
      }
    }
    return $valid_address;

}
/*
	create radom string
	
	@param length: length of output string
	@param $type: type of out put string : 
		-mixed: 	both of numberic and alpha
		-digits: 	only numberic
		-chars:		only characters
*/
  function create_random($length, $type = 'mixed') {
    if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;

    $rand_value = '';
    while (strlen($rand_value) < $length) {
      if ($type == 'digits') {
        $char = get_rand(0,9);
      } else {
        $char = chr(get_rand(0,255));
      }
      if ($type == 'mixed') {
        if (eregi('^[a-z0-9]$', $char)) $rand_value .= $char;
      } elseif ($type == 'chars') {
        if (eregi('^[a-z]$', $char)) $rand_value .= $char;
      } elseif ($type == 'digits') {
        if (ereg('^[0-9]$', $char)) $rand_value .= $char;
      }
    }

    return $rand_value;
  }
 
 function get_rand($min = null, $max = null) {
    static $seeded;

    if (!isset($seeded)) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }
  /*
  * get ip address
  */
   function get_ip_address() {
    if (isset($_SERVER)) {
      if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } else {
        $ip = $_SERVER['REMOTE_ADDR'];
      }
    } else {
      if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ip = getenv('HTTP_X_FORWARDED_FOR');
      } elseif (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
      } else {
        $ip = getenv('REMOTE_ADDR');
      }
    }
    return $ip;
  }
function sub_string($str = "", $len = 150, $more = 'true') {
	if ($str == "") return $str;
	if (is_array($str)) return $str;
	$str = trim($str);
	// if it's les than the size given, then return it
	if (strlen($str) <= $len) return $str;
	// else get that size of text
	$str = substr($str, 0, $len);
	// backtrack to the end of a word
	if ($str != "") {
	  // check to see if there are any spaces left
	  if (!substr_count($str , " ")) {
		if ($more == 'true') $str .= "...";
		return $str;
	  }
	  // backtrack
	  while(strlen($str) && ($str[strlen($str)-1] != " ")) {
		$str = substr($str, 0, -1);
	  }
	  $str = substr($str, 0, -1);
	  if ($more == 'true') $str .= "...";
	  if ($more != 'true' and $more != 'false') $str .= $more;
	}
	return $str;
}
// get day between two dates	
 function _date_diff($date1, $date2) {
  //$date1  today, or any other day
  //$date2  date to check against
    $d1 = explode("-", $date1);
    $y1 = $d1[0];
    $m1 = $d1[1];
    $d1 = $d1[2];

    $d2 = explode("-", $date2);
    $y2 = $d2[0];
    $m2 = $d2[1];
    $d2 = $d2[2];

    $date1_set = mktime(0,0,0, $m1, $d1, $y1);
    $date2_set = mktime(0,0,0, $m2, $d2, $y2);

    return(round(($date2_set-$date1_set)/(60*60*24)));
  }	
  
  /*
  	count day between two date
  */
  
  function count_day($start_date, $end_date, $lookup = 'm') {
    if ($lookup == 'd') {
    // Returns number of days
      $start_datetime = gmmktime (0, 0, 0, substr ($start_date, 5, 2), substr ($start_date, 8, 2), substr ($start_date, 0, 4));
      $end_datetime = gmmktime (0, 0, 0, substr ($end_date, 5, 2), substr ($end_date, 8, 2), substr ($end_date, 0, 4));
      $days = (($end_datetime - $start_datetime) / 86400) + 1;
      $d = $days % 7;
      $w = date("w", $start_datetime);
      $result = floor ($days / 7) * 5;
      $counter = $result + $d - (($d + $w) >= 7) - (($d + $w) >= 8) - ($w == 0);
    }
    if ($lookup == 'm') {
    // Returns whole-month-count between two dates
    // courtesy of websafe<at>partybitchez<dot>org
      $start_date_unixtimestamp = strtotime($start_date);
      $start_date_month = date("m", $start_date_unixtimestamp);
      $end_date_unixtimestamp = strtotime($end_date);
      $end_date_month = date("m", $end_date_unixtimestamp);
      $calculated_date_unixtimestamp = $start_date_unixtimestamp;
      $counter=0;
      while ($calculated_date_unixtimestamp < $end_date_unixtimestamp) {
        $counter++;
        $calculated_date_unixtimestamp = strtotime($start_date . " +{$counter} months");
      }
      if ( ($counter==1) && ($end_date_month==$start_date_month)) $counter=($counter-1);
    }
    return $counter;
  }
 /*
 	return day name of week
	@param date YYYY-mm-dd
 */ 
function day_of_week($date)
{
	$date=split("[/.-]",$date);
	$year=(int)$date[0];
	$month=(int)$date[1];
	$day=(int)$date[2];
	$arrday[0]="Sun";
	$arrday[1]="Mon";
	$arrday[2]="Tue";
	$arrday[3]="Wed";
	$arrday[4]="Thu";
	$arrday[5]="Fri";
	$arrday[6]="Sat";
	if ((1901 < $year) and ($year < 2038)) {
		return $arrday[(int) date('w', mktime(0, 0, 0, $month, $day, $year))];
	}

	// gregorian correction
	$correction = 0;
	if (($year < 1582) or (($year == 1582) and (($month < 10) or (($month == 10) && ($day < 15))))) {
		$correction = 3;
	}

	if ($month > 2) {
		$month -= 2;
	} else {
		$month += 10;
		$year--;
	}

	$day  = floor((13 * $month - 1) / 5) + $day + ($year % 100) + floor(($year % 100) / 4);
	$day += floor(($year / 100) / 4) - 2 * floor($year / 100) + 77 + $correction;
	
	$i=(int) ($day - 7 * floor($day / 7));
	return $arrday[(int) ($day - 7 * floor($day / 7))];
}
  /*
  * function check null value
  */
  function is_not_null($value) {
  	$value=trim($value);
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }
 function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val{strlen($val)-1});
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }
    return $val;
}
 
function cutBrief($str,$len)
{
 $space=" ";
 if(strlen($str)<=$len)
 {
  return $str;
 }
 else
 {
  $thelen=strlen($str);
  for($i=$len;$i<$thelen;$i++)
  {
   if(substr($str,$i,1)==$space)
   {
    $result=substr($str,0,$i);
    return $result." ...";
   }
  }
  if($thelen=="")
  {
   return $str;
  }
 }
 return $str;
}
function formatData($text)
{
	$search = array ('@<script[^>]*?>.*?</script>@si', // Strip out javascript
                 '@<[\/\!]*?[^<>]*?>@si',          // Strip out HTML tags
                 '@([\r\n])[\s]+@',                // Strip out white space
                 '@&(quot|#34);@i',                // Replace HTML entities
                 '@&(amp|#38);@i',
                 '@&(lt|#60);@i',
                 '@&(gt|#62);@i',
                 '@&(nbsp|#160);@i',
                 '@&(iexcl|#161);@i',
                 '@&(cent|#162);@i',
                 '@&(pound|#163);@i',
                 '@&(copy|#169);@i',
                 '@&#(\d+);@e');                    // evaluate as php

	$replace = array ('',
                  '',
                  '\1',
                  '"',
                  '&',
                  '<',
                  '>',
                  ' ',
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  'chr(\1)');

	$text = preg_replace($search, $replace, $text);
	return $text;
}	

function count_item ($id) {
	$sql="SELECT 
		  		products_id
		  FROM tg_product
		  WHERE md5(category_id)='".$id."' AND product_status='1'
		  ";
	$rs=execSQL($sql);
	if ($rs) {
		$num=mysql_num_rows($rs);
	}
	return $num;
}
function check_product ($id){
	$sql=" SELECT products_id FROM tg_product WHERE category_id='".$id."' ";
	$rs=execSQL($sql);
	if ($rs) {
		$sum=mysql_num_rows($rs);
		if ($sum>0) {
			return 1;
		} else {
			return 0;
		}
	}
}
function check_login($user,$pass) {
	$sql="SELECT customers_id 
			FROM tg_customers 
			WHERE customers_username='".$user."' 
					AND md5(customers_password)='".$pass."'";
	$rs=execSQL($sql);
	if ($rs) {
		$no=mysql_num_rows($rs);
		if ($no>0) {
			return true;
		} else {
			return false;
		}
	}
}
function get_user_id($user) {
	$sql="SELECT 
		  	md5(customers_id) AS customers_id
		  FROM tg_customers
		  WHERE customers_username='".$user."'";
	$rs=execSQL($sql);
	if ($rs) {
		$row=mysql_fetch_assoc($rs);
		$id=$row['customers_id'];
	}
	return $id;
}
function gen_rand_string($hash){
	$chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');		
	$max_chars = count($chars) - 1;
	srand( (double) microtime()*1000000);		
	$rand_str = '';
	for($i = 0; $i < 8; $i++)
	{
		$rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
	}	
	return ( $hash ) ? md5($rand_str) : $rand_str;
}

/**
 * Code generation
 *
 * Generate code for product, order, ... 
 * The format of code like as: QS0027, QS0028,..
 * Availabe for PHP 4, PHP 5.
 *
 * @param  string  $prefix  Begin characters of Code string
 * @param  int $number 
 * @param  int $length Length of code except prefix
 * @return string
 */
function generate_code ($prefix, $number, $length = 5)
{
	/*$length = (intval($length)<1)? 5 : intval($length);
	$code = $prefix;
	$number_length = strlen($number);
	if ($number_length >= $length)
		$code .= $number;
	else
		$code .= str_repeat("0", $length - $number_length) . $number;*/
	
	return $number;
} 

	function selfURL() {
     $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
     $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
     $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
     return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	 }
	 //$s2 la chuoi so sanh.Ham tra ve phan ben trai cua chuoi $s1 va cat bo chuoi $s2.
	 function strleft($s1, $s2)
	 {
		 return substr($s1, 0, strpos($s1, $s2));
	 } 
?>