<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); ?>

<?php
// User is not allowed to see a price or there is no price
if( !$auth['show_prices'] || ( !isset($price_info["product_price_id"] ) && ( !$parent_has_children) ) ) {
	
	$link = $sess->url( $_SERVER['PHP_SELF'].'?page=shop.ask&amp;product_id='.$product_id.'&amp;subject='. urlencode( $VM_LANG->_('PHPSHOP_PRODUCT_CALL').": $product_name") );
	echo vmCommonHTML::hyperLink( $link, $VM_LANG->_('PHPSHOP_PRODUCT_CALL') );
}
?>

<?php
// DISCOUNT: Show old price! Inline style specified for PDF creation, remove it if you don't need it
if(!empty($discount_info["amount"])) {
	?>
	<span class="product-Old-Price">
		<?php echo $CURRENCY_DISPLAY->getFullValue($undiscounted_price); ?></span>
	<?php
}
?>

<?php
if( !empty( $price_info["product_price_id"] )) { ?>
	<span class="productPrice">
		<?php echo $CURRENCY_DISPLAY->getFullValue($base_price, 0) ?>
		<?php echo $text_including_tax ?>
	</span>
<?php
}
echo $price_table;
?>

