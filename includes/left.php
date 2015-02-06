<?
	$xtpl_left = new XTemplate ("templates/left.html");
//	include "includes/function_page.php";
		$category_id=$_REQUEST['category'];
		$sub_cate=$_REQUEST['subcate_id'];
		$oldcategory_id=$_REQUEST['oldcategory'];
		$oldsub_cate=$_REQUEST['oldsubcate_id'];
		$user_id=READ_SESSION('user_id');
		$sql="SELECT category_name
					,md5(category_id) AS category_id
					,category_has_child
			FROM tg_category 
			WHERE category_status='1' AND category_parent='0' 
			ORDER BY category_position
			";
		$rs = mysql_query($sql, $link);

	//	$rs=execSQL($sql);
		if ($rs) {
			while ($row=mysql_fetch_assoc($rs)) {
				if(($category_id==$row['category_id']) || ($sub_cate==$row['category_id']))
								{
									$class_cate="left_link_selected";
								}
								else
								{
									$class_cate="left_link";
								}
///////subcate
					if ($category_id==$row['category_id']) {
						$sql_subcate="SELECT category_name
											,md5(category_id) AS category_id 
										FROM tg_category 
										WHERE md5(category_parent)='".$category_id."' ";
					$rs_subcate = mysql_query($sql_subcate, $link);
					//	$rs_subcate=execSQL($sql_subcate);
						if ($rs_subcate) {
						$sum_cate=mysql_num_rows($rs_subcate);
							if ($sum_cate!='0') {
								while ($row_subcate=mysql_fetch_assoc($rs_subcate)) {
									$num=count_item($row_subcate['category_id']);
										if($sub_cate==$row_subcate['category_id'])
										{
											$class="subcate_selected";
										}
										else
										{
											$class="subcate";
										}						
									$xtpl_left->assign("cateid",$row['category_id']);
									$xtpl_left->assign("num",$num);
									$xtpl_left->assign("class",$class);
									$xtpl_left->assign("subcate_name",$row_subcate['category_name']);
									$xtpl_left->assign("subcate_parent",$row_subcate['category_parent']);
									$xtpl_left->assign("subcate_id",$row_subcate['category_id']);
									$xtpl_left->parse("LEFT.category.subcate");
								}
							} 
						}
					}

///////endsubcate

				$xtpl_left->assign("class_cate",$class_cate);	
				$xtpl_left->assign("category_name",$row['category_name']);
				$xtpl_left->assign("category_id",$row['category_id']);
				$xtpl_left->parse("LEFT.category");
					}
				///
		}
//////hang cu

		$sql_old="SELECT category_name
					,md5(category_old_id) AS category_old_id
					,category_has_child
			FROM tg_category_old 
			WHERE category_status='1' AND category_parent='0' 
			ORDER BY category_position
			";
		$rs_old = mysql_query($sql_old, $link);

	//	$rs=execSQL($sql);
		if ($rs_old) {
			while ($row_old=mysql_fetch_assoc($rs_old)) {
				if(($oldcategory_id==$row_old['category_old_id']) || ($oldsub_cate==$row_old['category_old_id']))
								{
									$class_cate_old="left_link_selected";
								}
								else
								{
									$class_cate_old="left_link";
								}
///////subcate
					if ($oldcategory_id==$row['category_old_id']) {
						$sql_subcate_old="SELECT category_name
											,md5(category_old_id) AS category_old_id 
										FROM tg_category_old 
										WHERE md5(category_parent)='".$category_old_id."' ";
					$rs_subcate_old = mysql_query($sql_subcate_old, $link);
					//	$rs_subcate=execSQL($sql_subcate);
						if ($rs_subcate_old) {
						$sum_cate_old=mysql_num_rows($rs_subcate_old);
							if ($sum_cate!='0') {
								while ($row_subcate_old=mysql_fetch_assoc($rs_subcate_old)) {
									$num_old=count_item($row_subcate_old['category_old_id']);
										if($sub_cate==$row_subcate_old['category_old_id'])
										{
											$class_old="subcate_selected";
										}
										else
										{
											$class_old="subcate";
										}						
									$xtpl_left->assign("oldcateid",$row['category_old_id']);
									$xtpl_left->assign("num_old",$num_old);
									$xtpl_left->assign("class_old",$class_old);
									$xtpl_left->assign("subcate_name_old",$row_subcate_old['category_name']);
									$xtpl_left->assign("subcate_parent_old",$row_subcate_old['category_parent']);
									$xtpl_left->assign("oldsubcate_id",$row_subcate_old['category_id']);
									$xtpl_left->parse("LEFT.oldcategory.oldsubcate");
								}
							} 
						}
					}

///////endsubcate

				$xtpl_left->assign("class_cate_old",$class_cate_old);	
				$xtpl_left->assign("oldcategory_name",$row_old['category_name']);
				$xtpl_left->assign("oldcategory_id",$row_old['category_old_id']);
				$xtpl_left->parse("LEFT.oldcategory");
					}
				///
		}

////support
	$sql_support = "SELECT config_phone,config_mobile FROM tg_config";
	$rs_support = execSQL($sql_support);
	$row_support = mysql_fetch_assoc($rs_support);
	$xtpl_left->assign("row_support",$row_support);
//online
	$sql1 = "SELECT support_name, support_mobile, support_yahoo FROM tg_support WHERE support_status = '1'";
	$rs1 = execSQL($sql1);
	while($row1 = mysql_fetch_assoc($rs1))
	{
		$xtpl_left->assign("ONLINE",$row1);
		$xtpl_left->parse("LEFT.ONLINE");
	}
	
/////adv
	$sql_adv = "SELECT adv_image, adv_link, adv_title FROM tg_adv WHERE adv_active='1' AND adv_is_left='1' ORDER BY adv_position LIMIT 0,6";
	$rs_adv = execSQL($sql_adv);
	while ($row_adv = mysql_fetch_assoc($rs_adv))
	{
		if($row_adv['adv_image'])
		{
			if(file_exists("images/adv/thumb_0_".$row_adv['adv_image']))
			{
				$row_adv['adv_image'] = $row_adv['adv_image'];
				$xtpl_left->assign("row_adv",$row_adv);
				$xtpl_left->parse("LEFT.adv");
			}
		}
	}
	$cate_product = get_all_category($id);
	$xtpl_left->assign("cate_product",$cate_product);

	session_start(); // Khoi dong session
	$s_id = session_id(); // Bien s_id
	$time = time(); // Lay thoi gian hien tai
	$time_secs = 900; // Thoi gian tinh bang seconds de delete & insert cai $s_id moi, test tren localhost thi cho no bang 3 seconds de nhanh thay ket qua, chạy trên host thì để 900 = 15 phút là vừa
	$time_out = $time - $time_secs; // Lay thoi gian hien tai
	$s_ip = get_ip_address();
	$s_user = $_SESSION['username'];
	$s_link = selfURL();
	@mysql_query("DELETE FROM counter WHERE s_time < '$time_out'"); // Delete tat ca nhung rows trong khoang thoi gian qui dinh san
	@mysql_query("DELETE FROM counter WHERE s_id = '$s_id'"); // Delete cai $s_id cua chinh thang nay
	@mysql_query("INSERT INTO counter (s_id, s_time, s_ip, s_link, s_user) VALUES ('$s_id', '$time', '$s_ip', '$s_link', '$s_user')"); // Delete no xong lai insert chinh no
	$user_online = @mysql_num_rows(@mysql_query("SELECT id FROM counter")); // Dem so dong trong table stats, chinh la so nguoi dang online
	// Them 1 cai, xem page nay da duoc mo bao nhieu lan:
	$sql_to = "SELECT MAX(id) AS max_id FROM counter";
	$rs_to = execSQL($sql_to);
	$row_to = mysql_fetch_assoc($rs_to);
	
	$page_visited = number_format($row_to['max_id'],0,'','.');
	// Xong rui, cho no ra thui
//	echo "Online: <b>".$user_online."</b><br>";
//	echo "Trang nay duoc mo: <b>".$page_visited."</b> lan";
	$xtpl_left->assign("total_page",$page_visited);
	$xtpl_left->assign("user_online",$user_online);


		
	$xtpl_left->parse("LEFT");
	$left_tostring = $xtpl_left->text("LEFT");
	
?>
