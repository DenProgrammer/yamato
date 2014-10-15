<?php
/**
 * @version		$Id: categories.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Weblinks Component Categories Model
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class ManagerModelApi extends JModel
{
	public function deleteImage($id){
		$db = JFactory::getDbo();
		$sql = 'SELECT * FROM `#__vm_product_files` WHERE `file_id` = '.$id;
		$db->setQuery($sql);
		$image = $db->LoadObject();
		
		if ($image->uploaded_from1C == 1) {
			$sql = 'UPDATE `#__vm_product_files` SET `file_published` = 0 WHERE `file_id` = '.$id;
			$db->setQuery($sql);
			$image = $db->query();
		} else {
			$sql = 'DELETE FROM `#__vm_product_files` WHERE `file_id` = '.$id;
			$db->setQuery($sql);
			$image = $db->query();
			
			if (is_file('components/com_virtuemart/shop_image/product/'.$image->file_name)) {
				unlink('components/com_virtuemart/shop_image/product/'.$image->file_name);
			}
			if (is_file('components/com_virtuemart/shop_image/product/resized/'.$image->file_name)) {
				unlink('components/com_virtuemart/shop_image/product/resized/'.$image->file_name);
			}
		}
		
		return true;
	}
	
	public function uploadImage($product_id) {
		$db = JFactory::getDbo();
		$access_type = array('image/png', 'image/jpeg');
		
		$filename = str_replace(' ', '_', $_FILES['newimage']['name']);
		$tempfile = $_FILES['newimage']['tmp_name'];
		$filetype = $_FILES['newimage']['type'];
		switch($filetype){
			case 'image/png':{
				$ext = 'png';
				break;
			}
			case 'image/jpeg':{
				$ext = 'jpg';
				break;
			}
		}
				
		if (!in_array($filetype, $access_type)) {
			return false;
		}
		
		$img = getimagesize($tempfile);
		
		$w = $img[0];
		$h = $img[1];
										
		$wb = ($w > 800) ? 800 : $w; 								
		$hb = ($w > 600) ? 600 : $h; 
										
		$ws = ($w > 280) ? 280 : $w; 								
		$hs = ($w > 200) ? 200 : $h; 	
		
		$fullpath  = 'components/com_virtuemart/shop_image/product/'.$filename;
		$thumbpath = 'components/com_virtuemart/shop_image/product/resized/'.$filename;
		
		system("C:/ImageMagick/convert.exe -quality 90 -resize $wb".'x'."$hb $tempfile $fullpath");						
		system("C:/ImageMagick/convert.exe -quality 90 -resize $ws".'x'."$hs $tempfile $thumbpath");	

		$sql = 'SELECT * FROM `#__vm_product` WHERE `product_id` = '.$product_id;
		$db->setQuery($sql);//echo $sql.'<br>';
		$prod = $db->LoadObject();		
		
		if ($prod->product_full_image) {
		$sql = "INSERT INTO `#__vm_product_files` (
				`file_product_id`, `file_name`, `file_title`, `file_description`, 
				`file_extension`, `file_mimetype`, `file_url`, `file_published`,
				`file_is_image`, `file_image_height`, `file_image_width`, `file_image_thumb_height`, 
				`file_image_thumb_width`, `uploaded_from1C`, `image_hash`
				) VALUES (
				'$product_id', '$filename', '$filename', '', 
				'$ext', '$filetype', 'components/com_virtuemart/shop_image/product/$filename', '1', 
				'1', '800', '600', '280', 
				'200', '0', '')";
		} else {
			$sql = "UPDATE `#__vm_product` SET
					`product_thumb_image`='resized/$filename', 
					`product_full_image`='$filename', 
					`image_hash` = ''
					WHERE `product_id`=$product_id";
		}
		$db->setQuery($sql);//echo $sql.'<br>';
		$db->query();		
		
		return true;
	}
	
}
?>
