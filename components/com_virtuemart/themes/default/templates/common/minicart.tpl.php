<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
 ?>
<table>
	<tr>
		<td colspan="3" align="left"><a title="Корзина" href="index.php?page=shop.cart&option=com_virtuemart&Itemid=3">Корзина</a></td>
	</tr>
	<tr>
		<td align="left"><?php echo $total_products ?></td>
		<td> <?php if ($total_products) echo '-'; ?> </td>
		<td align="right"><?php echo $total_price ?></td>
	</tr>
</table>
