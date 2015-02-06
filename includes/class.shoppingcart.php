<?php
/**
 * class ShoppingCart 
 * @copyright  2007 Qsoftvn
 * @author      canhpv
 */

/*

$_SESSION["ses_cart"][$index]['item_id'] 	=  $product_id;
$_SESSION["ses_cart"][$index]['item_qty'] 		=  $product_qty;
$_SESSION["ses_cart"][$index]['item_property'] =  $property;

	ses_property: 	price_per_item~discount_per_item~name~image~extra_property
	price_per_item: normal price (normal price - discount_per_item = sales price)
	extra_property: property1;property2;property3...

*/

class ShoppingCart 
{
	var $num_items, $total, $weight;
	var $cart_items;
 
	 function ShoppingCart() 
	 {

	 }
	 
	 function CountItem()
	 {
	 	$num_item_in_cart = count($_SESSION["ses_cart"]);
		return $num_item_in_cart;
	 }
	 
	 // input: id ->product_id
	 function AddToCart($id,$qty=1,$property='')
	 {	
		$check_existed = '0';
		if($qty=='') $qty=1;
		$num_item_in_cart = count($_SESSION["ses_cart"]);
		if($num_item_in_cart > 0)
		{
			for($i=0;$i<count($_SESSION["ses_cart"]);$i++)
			{	
				$item_id 		= $_SESSION["ses_cart"][$i]['item_id'];
				$item_qty 		= $_SESSION["ses_cart"][$i]['item_qty'];
				$item_property 	= $_SESSION["ses_cart"][$i]['item_property'];
				
				//kiem tra san pham co trong shopping cart chua?
				if($id==$item_id) 
				{  
					// truong hop item da ton tai trong shoppingcart va cac thuoc tinh giong nhau thi cong them qty
					if($item_property == $property)
					{
						$_SESSION["ses_cart"][$i]['item_qty'] =  $item_qty + $qty;
						$check_existed = '1';
						break;
					}
				}
			}
			if($check_existed=='0')
			{  
				//truong hop chua co trong shoppingcart (hoac co roi nhung thuoc tinh khac nhau) thi tao moi item
				$_SESSION["ses_cart"][$num_item_in_cart]['item_id'] 	=  $id;
				$_SESSION["ses_cart"][$num_item_in_cart]['item_qty'] 		=  $qty;
				$_SESSION["ses_cart"][$num_item_in_cart]['item_property'] =  $property;
			}
		} 
		else
		{  
			//truong hop tao moi shopping cart
			$_SESSION["ses_cart"][0]['item_id'] 	=  $id;
			$_SESSION["ses_cart"][0]['item_qty'] 		=  $qty;
			$_SESSION["ses_cart"][0]['item_property'] =  $property;
		}
	 }
	 
	 //update shopping cart
	 //input: array item_qty
	 function UpdateCart($arr_qty='')
	 {	
		if(count($_SESSION["ses_cart"]) > 0 && count($arr_qty)>0)
		{
			for($index=0;$index<count($_SESSION["ses_cart"]);$index++)
			{	
				$qty = intval($arr_qty[$index]);
				if($qty>0)
				{
					$_SESSION["ses_cart"][$index]['item_qty'] 		=  $qty;
				}
				else
				{
					$this->DeleteItem($index);
					$this->ReSort();
				}
			}
			
		}
	 }
	 
	 function ReSort()
	 {
	 	sort($_SESSION["ses_cart"]);
		reset($_SESSION["ses_cart"]);
	 }
	 
	
	 
	 function DisplayCart()
	 {	
	 	$xtpl_cart = new XTemplate("templates/shoppingcart_box.html");
	 	
		if(count($_SESSION["ses_cart"]) > 0)
		{
			for($index=0;$index<count($_SESSION["ses_cart"]);$index++)
			{	
				$id = $_SESSION["ses_cart"][$index]['item_id'];
				$qty = $_SESSION["ses_cart"][$index]['item_qty'];
				$property = $_SESSION["ses_cart"][$index]['item_property'];
				
				if($qty=="")
				{
					$qty = 1;
				}
				
				list($price_per_item, $name,$image, $extra_property) = explode("~", $property);
				
				$price = $price_per_item * $qty;
				$row['price'] = number_format($price,2);

				$extra_property = str_replace(";","<br>",$extra_property);
				$row['description'] = $extra_property;
				
				$row['name'] = $name;
				$row['qty'] = $qty;
				$row['id'] = md5($id);
				$row['index'] = $index;
				$row['extra_property'] = $extra_property;
				
				if(file_exists('images/product/thumb_1_'.$image))
				{				
					$row['image'] = '<img src="images/product/thumb_1_'.$image.'" border="0" width="50" alt="" />';
				}
				else
				{
					$row['image'] = '<img src="images/product/thumb_1_default.jpg" border="0" width="50" alt="" />';
				}
				
				$xtpl_cart->insert_loop("SHOPPING_CART.LIST",array("LIST"=>$row));

			} 
		} 
		else
		{
			$xtpl_cart->parse("SHOPPING_CART.DISPLAY_MSG");
		}
		$xtpl_cart->parse("SHOPPING_CART");
		$out_html = $xtpl_cart->text("SHOPPING_CART");
		return $out_html;
	 }
	 
	 
	 function DisplayCartForConfirm()
	 {	
	 	$xtpl_cart = new XTemplate("templates/shoppingcart_box_confirm.html");
	 	
		if(count($_SESSION["ses_cart"]) > 0)
		{
			for($index=0;$index<count($_SESSION["ses_cart"]);$index++)
			{	
				$id = $_SESSION["ses_cart"][$index]['item_id'];
				$qty = $_SESSION["ses_cart"][$index]['item_qty'];
				$property = $_SESSION["ses_cart"][$index]['item_property'];
				
				list($price_per_item, $name,$image, $extra_property) = explode("~", $property);
				
				$price = $price_per_item * $qty;
				$row['price'] = number_format($price,2);

				$extra_property = str_replace(";","<br>",$extra_property);
				$row['description'] = $extra_property;
				
				if(file_exists('images/product/thumb_1_'.$image))
				{				
					$row['image'] = '<img src="images/product/thumb_1_'.$image.'" border="0" width="50" alt="" />';
				}
				else
				{
					$row['image'] = '<img src="images/product/default_small.jpg" border="0" width="50" alt="" />';
				}
				
				$xtpl_cart->insert_loop("SHOPPING_CART.LIST",array("LIST"=>$row));

			} 
		} 
		else
		{
			$xtpl_cart->parse("SHOPPING_CART.DISPLAY_MSG");
		}
		$xtpl_cart->parse("SHOPPING_CART");
		$out_html = $xtpl_cart->text("SHOPPING_CART");
		return $out_html;
	 }
	 
	 
	 
	 
	 function GetTotalValue()
	 {
	 	$total=0;
		if(count($_SESSION["ses_cart"]) > 0)
		{
			for($index=0;$index<count($_SESSION["ses_cart"]);$index++)
			{	
				$qty = $_SESSION["ses_cart"][$index]['item_qty'];
				$property = $_SESSION["ses_cart"][$index]['item_property'];
				list($price_per_item, $name,$image, $extra_property) = explode("~", $property);
				$sub_total = $price_per_item * $qty;
				$total += $sub_total;
			} 
		} 
		$this->total = $total;
		return $total;
	 }
	 
	 function GetTotalDiscount()
	 {
		$total_discount = 0;
		if(count($_SESSION["ses_cart"]) > 0)
		{
			for($index=0;$index<count($_SESSION["ses_cart"]);$index++)
			{	
				$qty = $_SESSION["ses_cart"][$index]['item_qty'];
				$property = $_SESSION["ses_cart"][$index]['item_property'];
				list($price_per_item, $discount_per_item, $name,$image, $extra_property ) = explode("~", $property);
				$sub_total_discount = $discount_per_item * $qty;
				$total_discount += $sub_total_discount;
			} 
		} 
		return $total_discount;
	 }
	 
	 //input: item_id
	 function DeleteItem($index)
	 {
		unset($_SESSION["ses_cart"][$index]);
	 }
	 
	 // input: array item_id
	 function DeleteMultiItems($arrId)
	 {
		for($i=0;$i<count($arrId);$i++)
		{
			$index = $arrId[$i];
			$this->DeleteItem($index);
		}
	 }
	 
	 
	 // empty shopping cart
	 function EmptyCart()
	 {
		unset($_SESSION["ses_cart"]);
		session_unregister('ses_cart');
	 }
 
}
?>