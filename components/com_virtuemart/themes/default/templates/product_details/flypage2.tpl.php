<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC'))
    die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');
mm_showMyFileName(__FILE__);

$db   = JFactory::getDBO();
$sql  = 'SELECT *, (
                SELECT `product_price` 
                FROM `#__vm_product_price` 
                WHERE `product_id`=' . ((int) $product_id) . ' 
                LIMIT 1
                ) AS `price` , (
                SELECT `category_name` 
                FROM `#__vm_category` 
                WHERE `category_id`=(
                        SELECT `category_id` FROM `#__vm_product_category_xref` WHERE `product_id` = ' . ((int) $product_id) . ' LIMIT 1)
                ) AS `category_name`
        FROM `#__vm_product` 
        WHERE `product_id`=' . ((int) $product_id) . ' 
        LIMIT 1';
$db->setQuery($sql);
$prod = $db->LoadObject();

$sql         = 'SELECT `category_id` FROM `#__vm_product_category_xref` WHERE `product_id` = ' . ((int) $product_id) . ' LIMIT 1';
$db->setQuery($sql);
$category_id = $db->LoadResult();

$sql    = 'SELECT `product_id`, `product_thumb_image`, `Razmer`, `group_uom` 
            FROM `#__vm_product` 
            WHERE `group_article`=\'' . $prod->group_article . '\' AND `product_id` <> ' . $product_id . ' AND `product_publish` = \'Y\' 
            ORDER BY `Razmer`';
$db->setQuery($sql);
$groups = $db->LoadObjectList();

$group_url = 'index.php?page=shop.product_details&option=com_virtuemart&flypage=' . $_GET['flypage'] . '&category_id=' . $_GET['category_id'] . '&Itemid=' . $_GET['Itemid'];
?>
<script>
    jQuery('document').ready(function($) {
        $('.additionalimages a img').removeAttr('height').attr('width', 115);

        $('#sendLink').click(function() {
            $.post('index.php?option=com_auk&view=mail&layout=form&tmpl=ajax', {id:<?php echo $product_id; ?>, sendlink: 'form'}, function(data) {
                $('body').prepend(data);

                $('#btn_send').click(function() {
                    var send_name = $('#send_name').val();
                    var send_email_from = $('#send_email_from').val();
                    var send_email_to = $('#send_email_to').val();
                    var send_comment = $('#send_comment').val();

                    if (!send_name)
                    {
                        alert('Введите ваше имя!');
                        return;
                    }
                    if (!send_email_from)
                    {
                        alert('Введите ваш электронный адрес!');
                        return;
                    }
                    if (!send_email_to)
                    {
                        alert('Введите электронный адрес получателя!');
                        return;
                    }

                    $.post('index.php?option=com_auk&view=mail&layout=form&tmpl=ajax', {
                        send_name: send_name, send_email_from: send_email_from, id:<?php echo $product_id; ?>,
                        send_email_to: send_email_to, send_comment: send_comment, sendlink: 'save'}, function(data) {
                        $('table.send_table tr').html('<td>' + data + '</td>');
                    });
                });

                $('#send_msg_win .send_close').click(function() {
                    $('#send_msg_body').remove();
                });
            });
        });
    });
</script>
<div class="brdcrambs" >
    <a href="index.php">Каталог</a> / <a href="index.php?option=com_virtuemart&page=shop.browse&category_id=<?php echo $category_id; ?>&Itemid=<?php echo JRequest::getInt('Itemid'); ?>"><?php echo $prod->category_name; ?></a>
</div>
<table border="0" style="width: 100%;">
    <tbody>
        <tr>
            <td valign="top" width="290">
                <div class="imagecont">
                    <a rel="lightbox[product<?php echo $prod->product_id; ?>]" title="<?php echo $prod->product_name; ?>" href="<?php echo $prod->product_thumb_image; ?>">
                        <img width="278" border="0" alt="<?php echo $prod->product_name; ?>" title="<?php echo $prod->product_name; ?>" src="<?php echo $prod->product_thumb_image; ?>">
                    </a>
                    <div style="margin-top:10px;text-align:left;" class="additionalimages">
<?php foreach ($images as $image) { ?>
                            <a rel="lightbox[product<?php echo $image->file_product_id; ?>]" title="<?php echo $prod->product_name; ?>" href="<?php echo $image->file_url; ?>">
                                <img width="115" border="0" class="browseProductImage" alt="" src="<?php echo $image->file_url; ?>">
                            </a>
<?php } ?>
                    </div>
                </div>
                <div class="meashurements">
                    <?php
                    if ($groups)
                        foreach ($groups as $group) {
                            $url = $group->product_thumb_image;
                            echo '<a href="' . $group_url . '&product_id=' . $group->product_id . '">
						<img src="' . $url . '" />
						<div>' . $group->Razmer . ' ' . $group->group_uom . '</div>
					</a>';
                        }
                    ?>
                </div>
                <br />
                <br />
                <div class="ask_seller"><a class="button" href="index.php?page=shop.ask&flypage=flypage.tpl&product_id=<?php echo $product_id ?>&option=com_virtuemart">Задать вопрос по этому товару</a></div>
            </td>
            <td width="10">&nbsp;</td>
            <td valign="top" align="left">
                <h1 class="product_name">
                    <span class="marka">
                <?php echo JString::strtolower($prod->product_name); ?>
                    </span>
                </h1>	
                    <?php echo $prod->Razmer . ' ' . $prod->product_weight_uom ?>
                <br />
                <div class="detprice">
                    <?php
                    if ($prod->price > 0)
                        echo 'Цена: ' . $product_price;
                    if ($prod->product_discount_id > 0)
                        echo '<img class="discount2" src="images/discount.png" />';
                    ?>
                </div>
                <br>
                <?php if (($prod->product_s_desc) or ($prod->product_desc)) echo 'Описание:<br>' . $prod->product_s_desc . $prod->product_desc . '<br><br>'; ?>
                <?php if ($prod->contact) echo 'Контактная информация:<br>' . $prod->contact . '<br><br>'; ?>
                <div id="sendLink" >Отправить другу</div><br><br>
                <?php
                if ($prod->product_in_stock > 10) {
                    echo 'Есть в наличии<br><br>';
                    echo $addtocart;
                } else if (($prod->product_in_stock > 0) and ($prod->product_in_stock <= 10)) {
                    echo 'Количество на складе: ' . $prod->product_in_stock . '<br><br>';
                    echo $addtocart;
                } else {
                    echo 'Пока нет на складе';
                    echo $addtocart;
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>

