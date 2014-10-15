<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
/**
* This is the Read-Only Basket Template. Its is included
* in the last Step of the Checkout. The difference to the
* normal Basket is: All Update/Delete buttons and the
* quantity Box are missing.
*
* @version $Id: ro_basket_b2c.html.php 1377 2008-04-19 17:54:45Z gregdev $
* @package VirtueMart
* @subpackage templates
* @copyright Copyright (C) 2004-2005 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
?>
<table class="carttable" >
	<thead>
		<tr>
			<th><?php echo $VM_LANG->_('PHPSHOP_CART_NAME') ?></th>
			<th><?php echo $VM_LANG->_('PHPSHOP_CART_PRICE') ?></th>
			<th><?php echo $VM_LANG->_('PHPSHOP_CART_QUANTITY') ?></th>
			<th><?php echo $VM_LANG->_('PHPSHOP_CART_SUBTOTAL') ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach( $product_rows as $product ) { ?>
		<tr>
			<td><?php echo $product['product_name'] . $product['product_attributes'] ?></td>
			<td align="right"><?php echo $product['product_price'] ?></td>
			<td><?php echo $product['quantity'] ?></td>
			<td align="right"><?php echo $product['subtotal'] ?></td>
		</tr>
<?php } ?>
	</tbody>
</table>
<table width="100%" >
  <tr>
    <td align="right"><strong><?php echo $order_total_display ?></strong></td>
  </tr>
</table>
