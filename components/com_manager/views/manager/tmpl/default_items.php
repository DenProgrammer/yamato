<?php if(!defined( '_JEXEC' ) ) die( 'Direct Access is not allowed.' );

	foreach($this->cars as $car) {
		$image = (is_file('components/com_virtuemart/shop_image/product/'.$car->product_thumb_image)) ? 'components/com_virtuemart/shop_image/product/'.$car->product_thumb_image : 'components/com_virtuemart/themes/default/images/noimage.gif';
?>
	<div class="car">
		<div class="car_image" >
			<a href="index.php?option=com_manager&layout=edit&car_id=<?php echo $car->product_id; ?>&Itemid=32" >
				<img width="150" src="<?php echo $image; ?>" border="0" />
			</a>
		</div>
		<div class="car_details">
			<div class="car_title" >
				<a href="index.php?option=com_manager&layout=edit&car_id=<?php echo $car->product_id; ?>&Itemid=32" >
					<?php echo $car->marka.' '.$car->model; ?>
				</a>
			</div>
			<div class="car_nomer" ><?php echo $car->NomerKuzov; ?></div>
			<div class="car_year" ><?php echo $car->year; ?></div>
			<div class="car_price" >Цена : <?php echo round($car->price,2).' '.$car->currency; ?></div>
		</div>
	</div>
<?php
	}
?>