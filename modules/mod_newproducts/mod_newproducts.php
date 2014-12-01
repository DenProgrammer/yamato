<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC'))
    die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');

$product_currency = $GLOBALS['product_currency'];
$Itemid           = JRequest::getInt('Itemid');

$db             = JFactory::getDBO();
$query          = "	SELECT `p`.*, (
					SELECT `product_price` 
					FROM `#__vm_product_price` 
					WHERE `product_id`=`p`.`product_id` AND `shopper_group_id`=5
					LIMIT 1
						) AS `price` , (
					SELECT `product_currency` 
					FROM `#__vm_product_price` 
					WHERE `product_id`=`p`.`product_id` AND `shopper_group_id`=5
					LIMIT 1
						) AS `currency` 
				FROM `#__vm_product` AS `p` 
				LEFT JOIN `#__vm_product_category_xref` AS `pcx` ON `p`.`product_id`=`pcx`.`product_id`
				WHERE `p`.`product_publish`='Y' AND `pcx`.`category_id`=1
				ORDER BY `p`.`cdate` DESC LIMIT 4";
$db->setQuery($query);
$rows           = $db->loadObjectList();
//pr($rows);
$path           = '';
$defpath        = 'components/com_virtuemart/themes/default/images/noimage.gif';
$main           = $rows[0];
$image          = $main->product_full_image;
$image1         = $rows[1]->product_full_image;
$image2         = $rows[2]->product_full_image;
$image3         = $rows[3]->product_full_image;
if ($main->currency == 'USD')
    $main->currency = '$';
?>
<div class="newProductsWrap">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="270" valign="top" style="cursor:pointer;" onclick="document.location = 'index.php?page=shop.product_details&flypage=flypage.tpl&product_id=<?php echo $main->product_id; ?>&category_id=1&option=com_virtuemart'">
                <div style="position:relative;">
                    <div class="pricestar"><?php if (round($main->price) > 0) echo round($main->price) . ' ' . $main->currency; ?></div>
                    <table width="100%" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="2">
                                <img width="280" src="<?php echo $image; ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" style="padding-left:10px;"><span class="marka"><?php echo JString::strtolower($main->marka); ?></span>&nbsp;<span class="model"><?php echo $main->model; ?></span></td>
                            <td align="right" valign="top" style="padding-right:10px;"><?php echo $main->year; ?></td>
                        </tr>
                    </table>
                </div>
            </td>
            <td valign="top">
                <div class="smallitem" onclick="document.location = 'index.php?page=shop.product_details&flypage=flypage.tpl&product_id=<?php echo $rows[1]->product_id; ?>&category_id=1&option=com_virtuemart'">
                    <img class="smallimg" style="float:left;width:78px;border-color:#cccccc;" src="<?php echo $image1; ?>"/>
                    <div class="new_product_name">
                        <span class="marka"><?php echo JString::strtolower($rows[1]->marka); ?></span>
                        &nbsp;
                        <span class="model"><?php echo $rows[1]->model; ?></span>
                    </div>
                    <div class="new_product_name"><?php echo $rows[1]->year; ?></div>
                    <div class="new_price"><?php if ($rows[1]->price > 0) echo round($rows[1]->price) . ' ' . $rows[1]->currency; ?></div>
                </div>
                <hr class="itemsep">
                <div class="smallitem" onclick="document.location = 'index.php?page=shop.product_details&flypage=flypage.tpl&product_id=<?php echo $rows[2]->product_id; ?>&category_id=1&option=com_virtuemart'">
                    <img class="smallimg" style="float:left;width:78px;border-color:#cccccc;" src="<?php echo $image2; ?>"/>
                    <div class="new_product_name">
                        <span class="marka"><?php echo JString::strtolower($rows[2]->marka); ?></span>
                        &nbsp;
                        <span class="model"><?php echo $rows[2]->model; ?></span>
                    </div>
                    <div class="new_product_name"><?php echo $rows[2]->year; ?></div>
                    <div class="new_price"><?php if ($rows[2]->price > 0) echo round($rows[2]->price) . ' ' . $rows[2]->currency; ?></div>
                </div>
                <hr class="itemsep">
                <div class="smallitem" onclick="document.location = 'index.php?page=shop.product_details&flypage=flypage.tpl&product_id=<?php echo $rows[3]->product_id; ?>&category_id=1&option=com_virtuemart'">
                    <img class="smallimg" style="float:left;width:78px;border-color:#cccccc;" src="<?php echo $image3; ?>"/>
                    <div class="new_product_name">
                        <span class="marka"><?php echo JString::strtolower($rows[3]->marka); ?></span>
                        &nbsp;
                        <span class="model"><?php echo $rows[3]->model; ?></span>
                    </div>
                    <div class="new_product_name"><?php echo $rows[3]->year; ?></div>
                    <div class="new_price"><?php if ($rows[3]->price > 0) echo round($rows[3]->price) . ' ' . $rows[3]->currency; ?></div>
                </div>
            </td>
        </tr>
    </table>
</div>