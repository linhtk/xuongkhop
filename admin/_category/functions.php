<?php
	
	function create_cms_category($name)
	{
		$control="<select name='$name'><option value='' selected='selected'>Danh mục gốc</option>";
		$sql="SELECT category_name,category_id FROM tg_category WHERE category_has_child='1'";
		$rs=execSQL($sql);
		while ($row=mysql_fetch_assoc($rs)) {
			$num=mysql_num_rows($rs);
			for($i=0;$i<=$num;$i++)
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
					";
		$rs=execSQL($sql);
		$row=mysql_fetch_assoc($rs);
		$cate_name=$row['category_name'];
		if($cate_name)
		{
			$cate_name=$cate_name;
		} else 
		{
			$cate_name='Danh mục gốc';
		}
		return $cate_name;
	}
	function get_category_type()
	{
		$category_type='<select name="category_type">
					  	<option value="1">Nội thất văn phòng</option>
					  	<option value="2">Quầy lễ tân - Back drop</option>
					  	<option value="3">Vách ngăn văn phòng</option>
					  	<option value="4">Các công trình tiêu biểu</option>
					  </select>';
		return $category_type;	
	}
	function get_cate_name($id)
	{
		switch($id) 
		{
			case 1:
				$cate_name='Nội thất văn phòng';
				break;
			case 2:
				$cate_name='Quầy lễ tân - Back drop';
				break;
			case 3:
				$cate_name='Vách ngăn văn phòng';
				break;
			case 4:
				$cate_name='Các công trình tiêu biểu';
				break;
		}
		return $cate_name;
	}
?>