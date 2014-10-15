<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
/**
*
* @version $Id: login_registration.tpl.php 1345 2008-04-03 20:26:21Z soeren_nb $
* @package VirtueMart
* @subpackage templates
* @copyright Copyright (C) 2008 soeren - All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/

   // If we have a POST value for "func", we were oviously directed here, because a validation error
   // occured during registration. So, let's show the Registration Details Stretcher first
   // Otherwise the Login Form will be shown by default
   $open_to_stretcher = !isset($_POST['func']) ? '0' : '1';
   $show_login = VM_REGISTRATION_TYPE == 'NO_REGISTRATION' ? 0 : 1;
?>
<table width="100%" >
	<tr>
		<td valign="top" align="left" width="50%">
<?php if( $show_login ) : ?>
<h4><input type="radio" name="togglerchecker" id="toggler1" class="toggler" <?php if($open_to_stretcher == 0 ) { ?>checked="checked"<?php } ?> />
<span><?php echo $VM_LANG->_('PHPSHOP_RETURN_LOGIN') ?></span>
</h4>
<?php include( PAGEPATH . 'checkout.login_form.php' ); ?>
<?php endif; ?>
		</td>
		<td valign="top" align="left">
<h4><input type="radio" name="togglerchecker" id="toggler2" class="toggler" <?php if($open_to_stretcher == 1 ) { ?>checked="checked"<?php } ?> />
<span><?php echo $VM_LANG->_('PHPSHOP_NEW_CUSTOMER') ?></span></h4>
<?php include(PAGEPATH. 'checkout_register_form.php'); ?>
		</td>
	</tr>
</table>