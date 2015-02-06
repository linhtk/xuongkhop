<?php
	$xtpl_right = new XTemplate ("templates/right.html");

	$shopcart = new ShoppingCart();
	$sub_total = $shopcart->GetTotalValue();
	$total_item = $shopcart->CountItem();
	$tax= 0;
	$charge=0;
		//$delivery_fee = get_delivery_fee('flat');
		$total = $sub_total + $tax + $charge ;
		
		
		$xtpl_right->assign("total",number_format($total,2));
		$xtpl_right->assign("total_item",$total_item);
	//sp ban chay
	$sql_sell="SELECT product_name, product_price, md5(products_id) AS products_id, product_image 
		  FROM tg_product WHERE product_status='1' AND is_best_seller='1'";
	$rs_sell = mysql_query($sql_sell);
	//print_r($row_sell=mysql_fetch_assoc($rs_sell));
	while($row_sell=mysql_fetch_assoc($rs_sell))
	{
		if(file_exists('images/product/thumb_1_'.$row_sell['product_image']))
		{
			//print_r($row_sell);
			$row_sell['product_price'] = number_format($row_sell['product_price']);
			$xtpl_right->assign("sell_image",$row_sell['product_image']);
			$xtpl_right->assign("sell_products_id",$row_sell['products_id']);
			$xtpl_right->assign("sell_product_name",$row_sell['product_name']);
			$xtpl_right->assign("sell_product_price",$row_sell['product_price']);
			$xtpl_right->parse("RIGHT.list_sellt.image");
			$xtpl_right->assign("row_sell",$row_sell);
			$xtpl_right->parse("RIGHT.list_sell");
	}
	}
	//sp moi
	$sql="SELECT product_name, product_price, md5(products_id) AS products_id, product_image, is_in_store 
		  FROM tg_product WHERE product_status='1' ORDER BY product_date DESC LIMIT 0,3";
	$rs = mysql_query($sql, $link);
	while($row=mysql_fetch_assoc($rs))
	{
		if(file_exists('images/product/thumb_1_'.$row['product_image']))
		{
			if($row['is_in_store']==1)
			{
				$row['is_in_store'] = "Hết hàng";
			}else{
				$row['is_in_store'] = "Còn hàng";
			}
			$xtpl_right->assign("image",$row['product_image']);
			$xtpl_right->assign("products_id",$row['products_id']);
			$xtpl_right->assign("product_name",$row['product_name']);
			$xtpl_right->assign("product_price",$row['product_price']);
			$xtpl_right->assign("is_in_store",$row['is_in_store']);
			$xtpl_right->parse("RIGHT.list_product.image");
		}
		$row['product_price'] = number_format($row['product_price']);
		$xtpl_right->assign("row",$row);
		$xtpl_right->parse("RIGHT.list_product");
	}
/////adv
	$sql_adv = "SELECT adv_image, adv_link, adv_title FROM tg_adv WHERE adv_active='1' AND adv_is_left='0' ORDER BY adv_position LIMIT 0,6";
	$rs_adv = execSQL($sql_adv);
	while ($row_adv = mysql_fetch_assoc($rs_adv))
	{
		if($row_adv['adv_image'])
		{
			if(file_exists("images/adv/thumb_0_".$row_adv['adv_image']))
			{
				$row_adv['adv_image'] = $row_adv['adv_image'];
				$xtpl_right->assign("row_adv",$row_adv);
				$xtpl_right->parse("RIGHT.adv");
			}
		}
	}

	$xtpl_right->parse("RIGHT");
	$right_tostring = $xtpl_right->text("RIGHT");
	
?>
