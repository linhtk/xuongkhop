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
	 
	$xtpl = new XTemplate ("templates/category.html");
		
	$category_id = $_REQUEST['category'];
	$sql="SELECT 
		  		category_name
				,category_has_child
		  FROM tg_category 
		  WHERE md5(category_id)='".$category_id."' AND category_status='1'
		  ";
	$rs = execSQL($sql);//mysql_query($sql, $link);//
	$row=mysql_fetch_assoc($rs);
	if ($row) {
		$xtpl->assign("cate",$row);
		//subcate
		$sql_subcategory="SELECT 
					category_name
					,category_description
					,md5(category_id) AS category_id	
				  FROM tg_category
				  WHERE md5(category_parent)='".$category_id."'
				  ";
		$rs_subcategory=mysql_query($sql_subcategory, $link);//execSQL($sql_subcategory);
		$is_subcate=mysql_num_rows($rs_subcategory);
		if ($is_subcate>0) {
			if ($rs_subcategory) {
				$num=0;
				while ($row_subcategory=mysql_fetch_assoc($rs_subcategory)) {
					$num++;
					$row_subcategory['sum']=count_item($row_subcategory['category_id']);
					if($num%2==0)
					{
						$row_subcategory['line'] = "</tr><tr>";
					} else
					{
						$row_subcategory['line'] = "";
					}
					$xtpl->assign("category_id",$category_id);
					$xtpl->assign("subcate",$row_subcategory);
					$xtpl->parse("MAIN.sub_category");
				}
			}
		} else
				redir("subcategory.php?subcate_id=" . $category_id);
		//endsubcate
	}
//list product
	$page=$_POST['page']?$_POST['page']:1;
	$pagegroup_size=10;
	$limit = 12;
	$offset=($page-1)*$limit;
	$LIMIT=" LIMIT $offset,$limit";
	$sql_product = "SELECT product_name
							,product_image
							,md5(products_id) AS product_id
							,product_price
							,product_description
							,is_in_store
					FROM tg_product
					WHERE category_id IN (SELECT category_id FROM tg_category WHERE md5(category_parent)='".$category_id."')";
	$rs_product = execSQL($sql_product);
	$row_total=mysql_num_rows($rs_product);
	$sql_product.=$LIMIT;
	$rs_product = execSQL($sql_product);
	$pages=pagenavigator($page, $row_total, $limit, $pagegroup_size,'',$PHP_SELF) ;
	while($row_product = mysql_fetch_assoc($rs_product))
	{
		if($row_product['product_image'])
		{
			if(file_exists("images/product/thumb_1_".$row_product['product_image']))
			{
				$row_product['product_image'] = $row_product['product_image'];
			} else
			{
				$row_product['product_image'] = "default.jpg";
			}
		} else
		{
			$row_product['product_image'] = "default.jpg";
		}
		if($row_product['is_in_store']==1)
		{
			$row_product['is_in_store'] = "Hết hàng";
		}else{
			$row_product['is_in_store'] = "Còn hàng";
		}
		$row_product['product_price'] = number_format($row_product['product_price']);
		$row_product['product_description'] = cutBrief($row_product['product_description'],'60');
		$xtpl->assign("row_product",$row_product);
		$xtpl->parse("MAIN.list_product");
	}
	if ($pages)
	{
		$xtpl->assign("pages",$pages);
	}
				
	
	$xtpl->assign("header_tostring",$header_tostring);
	$xtpl->assign("footer_tostring",$footer_tostring);
	$xtpl->assign("left_tostring",$left_tostring);
	$xtpl->assign("right_tostring",$right_tostring);
	//Parse the main body
	$xtpl->parse("MAIN");
	eval("?".">".$xtpl->text("MAIN"));
	?>