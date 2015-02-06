<?php 
	function get_admin_email()
	{
		$sql = "SELECT config_email FROM tg_config";
		$rs = execSQL($sql);
		$row = mysql_fetch_assoc($rs);
		return $row['config_email'];
	}
	
	function get_cate_name($id)
	{
		$sql = "SELECT category_name FROM tg_category WHERE md5(category_id)='".$id."'";
		$rs = execSQL($sql);
		$row = mysql_fetch_assoc($rs);
		return $row['category_name'];
	}
	function get_category($id)
	{
		if($id)
		{
			$sql = "SELECT category_name FROM tg_category WHERE category_id = '".$id."'";
			$rs = execSQL($sql);
			$row = mysql_fetch_assoc($rs);
			$cate_name = $row['category_name'];
		} else 
		{
			$cate_name = "Danh mục gốc";
		}
		return $cate_name;
	}
	function get_all_category($id)
	{
		$cate = "<select name='category_id' style='width:200px;'>";
		$cate .="<option value=''>---- Chọn danh mục ----</option>";
		$sql = "SELECT category_name,category_id FROM tg_category WHERE category_has_child = '0' AND category_status = '1'";
		$rs = execSQL($sql);
		while($row = mysql_fetch_assoc($rs))
		{
			if ($row['category_id'] == $id)
			{
				$cate .= "<option value='".$row['category_id']."' selected='selected'>".$row['category_name']."</option>";
			} else 
			{
				$cate .= "<option value='".$row['category_id']."'>".$row['category_name']."</option>";
			}
		}
		$cate .= "</select>";
		return $cate;
	}
?>