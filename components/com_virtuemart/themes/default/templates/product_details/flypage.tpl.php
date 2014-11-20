<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC')) {
    die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');
}
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

$user               = JFactory::getUser();
$closesectionaccess = $user->getParam('closesectionaccess', 0);
$closesectionlevel  = $user->getParam('closesectionlevel', 0);

$sql         = 'SELECT `category_id` FROM `#__vm_product_category_xref` WHERE `product_id` = ' . ((int) $product_id) . ' LIMIT 1';
$db->setQuery($sql);
$category_id = $db->LoadResult();

$ref = $_SERVER['HTTP_REFERER'];

$mas  = explode('?', $ref);
$mas2 = explode('&', $mas[1]);
foreach ($mas2 as $item) {
    $t = explode('=', $item);

    $referer[$t[0]] = $t[1];
}
?>
<script>
    jQuery('document').ready(function($) {
        $('.additionalimages a img').removeAttr('height').attr('width', 115);

        $.get('index.php?option=com_sincronise&type=loadCost&tmpl=ajax', {link: '<?php echo $prod->link; ?>'}, function(data) {
            $('td.costValue').html(parseFloat(data) + ' USD');
        })

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
                    if (!isValidEmailAddress(send_email_from)) {
                        alert('Введите правильно ваш электронный адрес!');
                        return;
                    }
                    if (!send_email_to)
                    {
                        alert('Введите электронный адрес получателя!');
                        return;
                    }
                    if (!isValidEmailAddress(send_email_to)) {
                        alert('Введите правильно электронный адрес получателя!');
                        return;
                    }

                    $.post('index.php?option=com_auk&view=mail&layout=form&tmpl=ajax', {
                        send_name: send_name, send_email_from: send_email_from, id:<?php echo $product_id; ?>,
                        send_email_to: send_email_to, send_comment: send_comment, sendlink: 'save'}, function(data) {
                        $('table.send_table tr').html('<td>' + data + '</td>');
                    });
                });

                $('#send_msg_win div.send_close').click(function() {
                    $('#send_msg_body').remove();
                });
            });
        });
    });

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }

    function openCost() {
        if (jQuery('#allPrices tr.cost').css('display') == 'table-row') {
            jQuery('#allPrices tr.cost').css('display', 'none');
        } else {
            jQuery('#allPrices tr.cost').css('display', 'table-row');
        }
    }
</script>
<style>
    #allPrices tr.cost{
        display: none;
    }
</style>
<div class="brdcrambs" >
    <a href="index.php">Каталог</a> / 
    <a href="index.php?option=com_virtuemart&page=shop.browse&category_id=<?php echo $category_id; ?>&Itemid=2"><?php echo $prod->category_name; ?></a>
    <?php
    if (isset($referer['model']) && isset($referer['cm']) && isset($referer['rul'])) {
        echo "<a style='float:right;' href='$ref'>Вернутся к результатам поиска</a>";
    }
    ?>
</div>
<table border="0" style="width: 100%;">
    <tbody>
        <tr>
            <td valign="top" width="290">
                <div class="imagecont">
                    <a rel="lightbox[product<?php echo $prod->product_id; ?>]" title="SUBARU FORESTER 2005 г. (6677)" href="<?php echo $prod->product_full_image; ?>">
                        <img border="0" width="260" alt="<?php echo $prod->product_name; ?>" title="<?php echo $prod->product_name; ?>" src="<?php echo $prod->product_full_image; ?>">
                    </a>
                    <div style="margin-top:10px;text-align:left;" class="additionalimages">
                        <?php foreach ($images as $image) { ?>
                            <a rel="lightbox[product<?php echo $image->file_product_id; ?>]" title="<?php echo $prod->product_name; ?>" href="<?php echo $image->file_url; ?>">
                                <img width="115" border="0" class="browseProductImage" alt="" src="<?php echo $image->file_url; ?>">
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="ask_seller"><a class="button" href="index.php?page=shop.ask&flypage=flypage.tpl&product_id=<?php echo $product_id ?>&option=com_virtuemart">Задать вопрос по этому товару</a></div>
            </td>
            <td width="10">&nbsp;</td>
            <td valign="top" align="left">
                <h1 class="product_name">
                    <span class="marka">
                        <?php echo JString::strtolower($prod->marka); ?>
                    </span>
                    <span class="model">
                        <?php echo $prod->model; ?>
                    </span>
                    <?php echo $prod->year; ?> г. 
                    &nbsp;
                    (<?php echo substr($prod->NomerKuzov, -4) ?>) 
                </h1>	
                <a target="_blank" href="index.php?option=com_manager&view=print&tmpl=component&product_id=<?php echo $product_id; ?>" style="float: right;margin-top: -40px;"><img src="images/print.png" /></a>
                <table class="proddetaylsinfo" cellpadding="0" cellspacing="0" border=0>
                    <thead>
                        <tr>
                            <td>Год выпуска</td>
                            <td>Обьем</td>
                            <td>КПП</td>
                            <td>Пробег</td>
                            <td>Кузов</td>
                            <td>Тип топлива</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php
                                if ($prod->year > 1900) {
                                    echo $prod->year;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($prod->EngineSize) {
                                    echo $prod->EngineSize;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($prod->TipKPP) {
                                    echo $prod->TipKPP;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($prod->Probeg) {
                                    echo $prod->Probeg;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($prod->TipKuzova) {
                                    echo $prod->TipKuzova;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($prod->TipTopliva) {
                                    echo $prod->TipTopliva;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br />
                <table width="100%">
                    <tr>
                        <td align="left" valign="top">
                            <table class="avto_dop_param" cellpadding="0" cellspacing="0" border="1">
                                <tr><td>Тип салона</td><td><?php echo $prod->TipSalona; ?></td></tr>
                                <tr><td>Цвет салона</td><td><?php echo $prod->CvetSalona; ?></td></tr>
                                <?php if ($user->id > 0) { ?>
                                    <tr><td>Поставщик</td><td><?php echo $prod->Postavshik; ?></td></tr>
                                <?php } ?>
                            </table>
                        </td>
                        <td align="right" valign="top">
                            <table onclick="openCost()" id="allPrices" class="avto_dop_param" cellpadding="0" cellspacing="0" border="1">
                                <tr><td>Цена</td><td><?php echo $product_price; ?></td></tr>
                                <?php if ($closesectionaccess == 1) { ?>
                                    <tr><td>Аукционная цена</td><td><?php echo round($prod->AukcionnayaCena, 2) . ' ' . $prod->ValutaAukcionnoiCeny; ?></td></tr>
                                    <tr><td>Цена продажи</td><td><?php echo round($prod->CenaProdaji, 2) . ' ' . $prod->ValutaCenyProdaji; ?></td></tr>
                                    <?php if ($closesectionlevel == 3) { ?>
                                        <tr class="cost"><td>Себестоимость</td><td class="costValue"><?php echo round($prod->Sebestoimost, 2) . ' USD'; ?></td></tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
                        </td>
                    </tr>
                </table>
                <br>
                <?php if ($prod->product_desc) echo 'Описание авто:<br>' . $prod->product_desc . '<br><br>'; ?>
                <?php if ($prod->contact) echo 'Контактная информация:<br>' . $prod->contact . '<br><br>'; ?>
                <div id="sendLink" >Отправить другу</div><br><br>
                <?php
                if ($prod->Prodan == 1) {
                    echo '<span style="color:red;">Этот автомобиль продан ' . date("d.m.Y", $prod->DataProdaji) . '</span>';
                } else {
                    if ($prod->product_in_stock == 0) {
                        ?>
                        <div class="flypage_message" >
                            <div class="flypage_arrow"></div>
                            <div class="flypage_text">Выбранный вами автомобиль ещё не доставлен в Бишкек. Если он вас заинтересовал, нажмите кнопку "Уведомить меня".</div>
                        </div>
                        <?php
                    }
                    echo $addtocart;
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>

