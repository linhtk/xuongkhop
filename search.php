<? 
	include "includes/xtpl.php";
	include "includes/global.php";
	include "includes/class.shoppingcart.php";
	include "includes/connection.php";
	include "includes/function.php";
	include "includes/function_page.php";
	include "includes/footer.php";
	include "includes/left.php";
	include "includes/header.php";
	include "includes/right.php";
	 
	$xtpl = new XTemplate ("templates/search.html");
		
//main page
	$act = $_POST['act'];
	$keyword = $_POST['keyword'];
	$price = $_POST['price'];
	$cate_id = $_POST['category_id'];
	if($act)
	{
		$sql = "SELECT md5(products_id) AS products_id, 
					 product_name, 
					 product_image, 
					 product_price 
				FROM tg_product
				WHERE 1=1";
		if ($cate_id)
		{
		$sql .=" AND category_id='".$cate_id."' ";
		}
		if ($keyword)
		{
		$sql .=" AND (product_name LIKE '%$keyword%' OR product_description LIKE '$keyword')";
		}
		if ($price)
		{
		$sql .=" AND product_price='".$price."' ";
		}
		$sql .= "AND product_status='1' ORDER BY product_date DESC";
		$rs = execSQL($sql);
		$num=0;
		$total = mysql_num_rows($rs);
		if($total)
		{
			while($row = mysql_fetch_assoc($rs))
			{
				$num++;
				if($num % 3 == 0)
				{
					$row['line']="</tr><tr>";
				} else 
				{
					$row['line']="";
				}
				if(file_exists('images/product/thumb_1_'.$row['product_image']))
				{
					$xtpl->assign("image",$row['product_image']);
				} else 
				{
					$xtpl->assign("image","default.jpg");
				}
				$xtpl->assign("row",$row);
				$xtpl->parse("MAIN.result.hot");
			
			}
		} else
		{
			$ms = "Không có sản phẩm nào thỏa mãn điều kiện tìm của bạn. <br /> Mời bạn vui lòng thử lại với điều kiện khác. <br /> Cảm ơn bạn đã quan tâm tới cửa hàng chúng tôi.";
			$xtpl->assign("ms",$ms);
			$xtpl->parse("MAIN.result.ms");
		}
		$xtpl->parse("MAIN.result");
	}
	
	$cate_product = get_all_category($cate_id);

//
	$xtpl->assign("cate_product",$cate_product);
	$xtpl->assign("keyword",$keyword);
	$xtpl->assign("price",$price);
	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	$xtpl->assign("left_tostring",$left_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
	?>