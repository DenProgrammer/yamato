<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
/**
* This is the default Basket Template. Modify as you like.
*
* @version $Id: basket_b2c.html.php 2409 2010-05-20 20:05:30Z soeren $
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
			<td><?php echo $product['update_form'] ?><?php echo $product['delete_form'] ?></td>
			<td align="right"><?php echo $product['subtotal'] ?></td>
		</tr>
<?php } ?>
	</tbody>
</table>

<table width="100%" cellspacing="2" cellpadding="4" border="0">
  <tr class="sectiontableentry1">
    <td colspan="6" align="right"><strong><?php echo $order_total_display ?></strong></td>
  </tr>
</table>
