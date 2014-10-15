<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');


class SincroniseModelConfig extends JModel
{
	public function getConf()
		{
			$db = JFactory::getDBO();
			
			$sql = 'SELECT `params` FROM `#__components` WHERE `option`=\'com_sincronise\'';
			$db->setQuery($sql);
			$str = $db->LoadResult();
			$mas = unserialize($str);
			
			return $mas;
		}
	public function saveConf()
		{
			$db = JFactory::getDBO();
			
			$action = JRequest::getVar('action');
			$conf = JRequest::getVar('conf');
			
			if ($action == 'saveconf')
				{
					$confstr = serialize($conf);
					
					$sql = 'UPDATE `#__components` SET `params`=\''.$confstr.'\'  WHERE `option`=\'com_sincronise\'';
					$db->setQuery($sql);
					$str = $db->query();
					return true;
				}
			else
				{
					return false;
				}
		}
	public function updateProduct($p_obj)
		{
			$db = JFactory::getDBO();
			$time = time();
			
			$link = $p_obj->link;
			$product_price = $p_obj->product_price;
			$product_sku = $p_obj->product_sku;
			$product_currency = $p_obj->product_currency;
			$product_category_id = $p_obj->product_category_id;
			$product_full_image = $p_obj->product_full_image;
			$product_model = $p_obj->model;
			$marka = $p_obj->marka;
			$year = $p_obj->year;
			
			if (!$product_model) $product_model = 'NONE';
			if (!$marka) $marka = 'NONE';
			
			if ($product_model)
				{
					$sql = "SELECT `id` FROM `#__models` WHERE `title`='$product_model'";
					$db->setQuery($sql);
					$checkid = $db->LoadResult();
					
					if (!$checkid>0)
						{
							$sql = "INSERT INTO `#__models` (`title`,`link`) VALUES ('$product_model','')";
							$db->setQuery($sql);
							$db->query();
						}
				}
			
			$sql = "SELECT `product_id` FROM `#__vm_product` WHERE `product_sku`='$product_sku'";
			$db->setQuery($sql);
			$product_id = $db->LoadResult();
			
			if ($product_id>0) $metod = 'update'; else $metod = 'insert';
			
			if ($metod == 'insert')
				{
					$product_sku = $p_obj->product_sku;
					$product_s_desc = $p_obj->product_s_desc;
					$product_desc = $p_obj->product_desc;
					$product_thumb_image = $p_obj->product_thumb_image;
					$product_in_stock = $p_obj->product_in_stock;
					$product_name = $p_obj->product_name;
					
					$sql = "INSERT INTO `#__vm_product` (
							`link`, `vendor_id`, `product_parent_id`, `product_sku`, `product_s_desc`, `product_desc`, 
							`product_thumb_image`, `product_full_image`, `product_publish`, `product_weight`, `product_weight_uom`, 
							`product_length`, `product_width`, `product_height`, `product_lwh_uom`, `product_url`, 
							`product_in_stock`, `product_available_date`, `product_availability`, `product_special`, `product_discount_id`, 
							`ship_code_id`, `cdate`, `mdate`, `product_name`, `product_sales`, 
							`attribute`, `custom_attribute`, `product_tax_id`, `product_unit`, `product_packaging`, 
							`child_options`, `quantity_options`, `child_option_ids`, `product_order_levels`, `model`, `marka`, `year`
							) VALUES (
							'$link', '1', '0', '$product_sku', '$product_s_desc', '$product_desc', 
							'$thumb_filename', '$filename', 'Y', '0', 'кг.', 
							'0', '0', '0', 'см.', '', 
							'$product_in_stock', '0', '', 'N', '0', 
							'', '$time', '$time', '$product_name', '', 
							'', '', '0', 'шт.', '0', 
							'N,N,N,N,N,Y,20%,10%,', 'none,0,0,1', '', '0,0', '$product_model', '$marka', '$year')";
					$db->setQuery($sql);
					$db->query();
					$product_id = $db->insertid();
				}
			if ($metod == 'update')
				{
					$product_sku = $p_obj->product_sku;
					$product_s_desc = $p_obj->product_s_desc;
					$product_desc = $p_obj->product_desc;
					$product_thumb_image = $p_obj->product_thumb_image;
					$product_full_image = $p_obj->product_full_image;
					$product_in_stock = $p_obj->product_in_stock;
					$product_name = $p_obj->product_name;
					
					$sql = "UPDATE `#__vm_product` SET
							`product_sku`='$product_sku', `product_s_desc`='$product_s_desc', `product_desc`='$product_desc', 
							`product_thumb_image`='$thumb_filename', `product_full_image`='$filename',
							`product_in_stock`='$product_in_stock', `mdate`='$time', `product_name`='$product_name', `model`='$product_model', `marka`='$marka', `year`='$year'
							WHERE `product_id`=$product_id";
					$db->setQuery($sql);
					$db->query();
				}
				
			//обновление валюты
			$sql = "SELECT `product_price_id` FROM `#__vm_product_price` WHERE `product_id`='$product_id' AND `product_currency`='$product_currency' AND `shopper_group_id`='5'";
			$db->setQuery($sql);
			$checkprise = $db->LoadResult();
			
			if ($checkprise>0)
				{
					$sql = "UPDATE `#__vm_product_price` SET `product_price`='$product_price' WHERE `product_price_id`='$checkprise'";
				}
			else
				{
					$sql = "INSERT INTO `#__vm_product_price` (
								`product_id`, `product_price`, `product_currency`, `product_price_vdate`, `product_price_edate`, 
								`cdate`, `mdate`, `shopper_group_id`, `price_quantity_start`, `price_quantity_end`
								) VALUES (
								'$product_id', '$product_price', '$product_currency', '0', '0', 
								'$time', '$time', '5', '0', '0')";
				}
			$db->setQuery($sql);
			$db->query();
			
			//обновление связки с категорией
			$sql = "DELETE FROM `#__vm_product_category_xref` WHERE `product_id`='$product_id' AND `category_id`='$product_category_id'";
			$db->setQuery($sql);
			$db->query();
			
			$sql = "INSERT INTO `#__vm_product_category_xref` (`product_id`, `category_id`) VALUES ('$product_id', '$product_category_id')";
			$db->setQuery($sql);
			$db->query();
			
			return $product_id;
		}
}

?>