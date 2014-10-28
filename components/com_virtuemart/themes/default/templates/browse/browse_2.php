<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__);

$db = JFactory::getDBO();
$sql = 'SELECT * FROM `#__vm_product` WHERE `product_id`='.$product_id.' LIMIT 1';
$db->setQuery($sql);
$prod = $db->LoadObject();
$product_thumb_image = $prod->product_thumb_image;

if ($prod->product_discount_id > 0){
	//echo '<div class="pos_rel"><img class="discount" src="images/discount.png" /></div>';
}
?>
 <div class="browseProductContainer">
	<a href="<?php echo $product_flypage ?>">
    <table cellpadding="0" cellspacing="0">
		<tr>
			<td align="center">
				<div class="productPreviewWrap">
					<?php 
						echo '<img src="'.$product_thumb_image.'" class="browseProductImage" width="208" border="0" title="'.$product_name.'" alt="'.$product_name .'" />'; 
					?>
				</div>
			</td>
		</tr>
		<tr>
			<td align="left">
				<span class="product_price_cont" ><?php echo $product_price ?></span>
				<span class="marka">
					<?php
						echo $prod->product_name;
					?>
				</span>
			</td>
		</tr>
    </table>  
	</a>
</div>