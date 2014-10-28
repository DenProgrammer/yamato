<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__);
 ?>

<?php echo $buttons_header // The PDF, Email and Print buttons ?>

<table border=1 bordercolor="white" align="center" style="border: 1px solid white; width: 100%; background: #e2e2e2;" >
    <tr>
    	<td width=200>Автозапчасть  </td>
	<td width=400 align="left">
         <?php echo $product_name; ?>
        </td>
      <td align="left"><?php echo $product_price ?></td>
      <td valign="top"><?php echo $addtocart ?></td>
</tr>
</table>
	<hr>
	<?php echo $ask_seller ?>