<?php
	
	function create_cms_category($name)
	{
		$control="<select name='$name'><option value='' selected='selected'>Choose One</option>";
		$sql="SELECT category_name,category_id FROM tg_category WHERE category_status='1' AND category_has_child='0'";
		$rs=execSQL($sql);
		while ($row=mysql_fetch_assoc($rs)) {
			$num=mysql_num_rows($rs);
			for($i=1;$i<=$num;$i++)
			{
				if((post($name)==$i)||($i==$value))
				{
					$sel="selected='selected'";
				}
				else
				{
					$sel="";
				}
			}	
			$control.="<option value='".$row['category_id']."' $sel>".$row['category_name']."</option>";
		}
		$control.="</select>";
		return $control;
	}
	
	function get_category_level($id) {
		$sql="SELECT category_name
					FROM tg_category 
					WHERE category_id='".$id."' 
					AND category_status='1'
					";
		$rs=execSQL($sql);
		$row=mysql_fetch_assoc($rs);
		$cate_name=$row['category_name'];
		return $cate_name;
	}
?>