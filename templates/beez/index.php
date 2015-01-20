<?php
/**
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
defined('_JEXEC') or die('Restricted access');

if (JRequest::getVar('testmail')) {
    jimport('joomla.utilities.utility');

    $fromEmail = 'vasya.boldirev@mail.ru'; // отправитель, почта
    $fromName  = 'Test Server'; // отправитель, имя

    $email = 'fenix.programmer@gmail.com'; // кому

    $subject = 'Test Mail Message'; // тема письма

    $convertedBody = '<p>TEST MESSAGE</p>'; // сообщение в html
    // отправляем 

    JUtility::sendMail($fromEmail, $fromName, $email, $subject, $convertedBody, true, null, null, null);
}
$ajax = JRequest::getInt("ajax");

if ($ajax == 1) {
    ?><jdoc:include type="component" /><?php
} else {
    $user = JFactory::getUser();

    $db     = jFactory::getDBO();
    $sql    = 'SELECT * FROM `#__models`';
    $db->setQuery($sql);
    $models = $db->loadObjectList();

    $countuser4     = $this->countModules('user4');
    $countuserlikes = $this->countModules('likes');

    $flypage    = JRequest::getVar('flypage');
    $option     = JRequest::getVar('option');
    $product_id = JRequest::getInt('product_id');

    $document = & JFactory::getDocument();
    $title    = $document->getTitle();
    if (($flypage) and ($product_id > 0)) {
        $sql            = 'SELECT *, 
                                    (SELECT `product_price` FROM `#__vm_product_price` WHERE `product_id`=' . $product_id . ' LIMIT 1) AS `price`, 
                                    (SELECT `product_currency` FROM `#__vm_product_price` WHERE `product_id`=' . $product_id . ' LIMIT 1) AS `currency` 
                            FROM `#__vm_product` WHERE `product_id`=' . $product_id . ' LIMIT 1';
        $db->setQuery($sql);
        $prod           = $db->LoadObject();
        if ($prod->currency == 'USD')
            $prod->currency = '$';
        $title          = $prod->marka . ' ' . $prod->model;
        if ($prod->year)
            $title .= ' ' . $prod->year . ' г.';
        if ($prod->price) {
            $title .= ' ' . round($prod->price) . ' ' . $prod->currency;
        }
        if ($prod->product_type == 'automobil')
            $document->setTitle($title);
    }

    if (JRequest::getInt('Itemid') != 1) {
        $document->setTitle($document->getTitle() . ' - автосалон «Ямато», Бишкек, Кыргызстан. Автомобили из США, Европы и Японии в наличии и на заказ');
    }
    ?>
    <?php echo '<?xml version="1.0" encoding="utf-8"?' . '>'; ?>
    <!DOCTYPE html>
    <html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
        <head>
        <jdoc:include type="head" />
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
        <!--[if lte IE 6]>
                <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <!--[if IE 7]>
                <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
        <![endif]-->
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/jquery.js"></script>
        <script>jQuery.noConflict();</script>
        <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/script.js"></script>
        <script src="//tdcdn.blob.core.windows.net/toolbar/assets/prod/td.js" data-trackduck-id="52fae5d1100006861a000015" async=""></script>

        <!------------------------datepicker-------------------------->
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/themes/ui-darkness/jquery.ui.all.css">
        <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/demos.css">

        <script src="media/system/js/jquery.ui.core.js"></script>
        <script src="media/system/js/jquery.ui.datepicker.js"></script>
        <script src="media/system/js/jquery-ui.custom.js"></script>
        <script>
            jQuery("document").ready(function($) {
                jQuery("#howorder").click(function() {
                    var width = jQuery("#howorderfon").css("width");
                    width = parseInt(width.replace('px'));

                    if (width > 0)
                    {
                        jQuery("#howorderfon").css("width", 0);
                    }
                    else
                    {
                        jQuery("#howorderfon").css("width", 200);
                    }
                });

                jQuery("ul.wmcategory li").click(function() {
                    var katalog = jQuery("#" + this.id).attr("rel");
                    document.location = 'index.php?option=com_details&Itemid=3&view=' + katalog;
                });
                var view = '<?php echo $_GET['view']; ?>';
                jQuery("ul.wmcategory li").removeClass('active');
                if (jQuery("ul.wmcategory li[rel=" + view + ']'))
                    jQuery("ul.wmcategory li[rel=" + view + ']').addClass('active');

                $('#btndown').click(function() {
                    $("html, body").animate({scrollTop: document.body.scrollHeight}, 1000);
                });
                $('#btnup').hide().click(function() {
                    $("html, body").animate({scrollTop: 0}, 1000);
                });
                $(window).scroll(function() {
                    if ($(window).scrollTop() <= 400) {
                        $('#btndown').show();
                        $('#btnup').hide();
                    } else {
                        $('#btndown').hide();
                        $('#btnup').show();
                    }
                });
            });

            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-42088222-1', 'yamato.kg');
            ga('send', 'pageview');
        </script>
    </head>
    <body>
        <style>
            #btnupdown{
                position: fixed;
                right: 0px;
                bottom: 0px;
            }
            #btnupdown div{
                width: 72px;
                height: 72px;
                cursor: pointer;
            }
            #btndown{
                background-image: url(images/arrow-down.png);
            }
            #btnup{
                background-image: url(images/arrow-up.png);
            }
        </style>
        <div id="btnupdown">
            <div id="btndown"></div>
            <div id="btnup"></div>
        </div>

        <?php if ($countuser4 > 0) { ?>
            <div id="howorderfon" style="position: fixed; z-index: 100; left: 0px; top: 200px; height: 164px; width: 0px; background: url(images/howorderfon.png) center center repeat-x;">
                <div style="position: relative;">
                    <div id="howorder" style="position: absolute; right: -45px; top: 0px; width: 45px; height: 164px; background: url(images/howorder.png) center center no-repeat;"></div>
                    <div id="howordertext" style="width:100%;overflow:hidden;padding:20px 10px;height:124px;"><jdoc:include type="modules" name="user4" style="xhtml" /></div>
                </div>
            </div>
        <?php } ?>

        <?php if ($countuserlikes > 0) { ?>
            <div class="likes">
                <jdoc:include type="modules" name="likes" style="xhtml" />
            </div>
        <?php } ?>

        <table width="990" cellpadding="0" cellspacing="0" border="0" class="mainWrap">
            <tr>
                <td width="990" valign="top">

                    <div class="head">
                        <?php if ($user->id > 0) { ?>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr height="40">
                                    <td valign="middle" rowspan="2" width="200" height="100" align="left">
                                <jdoc:include type="modules" name="logo" />
                                </td>
                                <td colspan="3" valign="top" height="0" align="right">
                                    <a style="float:left;margin-top:10px;" href="http://m.yamato.kg">Мобильная версия</a>
                                <jdoc:include type="modules" name="kabinet" style="xhtml" />
                                </td>
                                </tr>
                                <tr>
                                    <td valign="middle">&nbsp;</td>
                                    <td valign="middle" width="400" align="left">
                                        <span style="color:#616161;">Добро пожаловать,</span> 
                                        <a href="index.php?page=account.index&option=com_virtuemart&Itemid=3" ><?php echo $user->name; ?></a>
                                    </td>
                                    <td valign="top" width="150" class="minikart">

                                        <style>
                                            .moduletable_lgn{display:none;}
                                        </style>
                                <jdoc:include type="modules" name="login" style="xhtml" />
                                <jdoc:include type="modules" name="kart" style="xhtml" />
                                </td>
                                </tr>
                            </table>
                        <?php } else { ?>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr height="40">
                                    <td valign="middle" rowspan="2" width="200" height="100" align="left">
                                <jdoc:include type="modules" name="logo" />
                                </td>
                                <td colspan="3" valign="top" height="0" align="right">
                                    <a style="float:left;margin-top:10px;" href="http://m.yamato.kg">Мобильная версия</a>
                                <jdoc:include type="modules" name="user7" style="xhtml" />
                                </td>
                                </tr>
                                <tr>
                                    <td valign="middle" align="left"><jdoc:include type="modules" name="phone" style="xhtml" /></td>
                                <td valign="middle" align="left"><jdoc:include type="modules" name="timework" style="xhtml" /></td>
                                <td valign="top" width="150" class="minikart">
                                <jdoc:include type="modules" name="login" style="xhtml" />
                                <jdoc:include type="modules" name="kart" style="xhtml" />
                                </td>
                                </tr>
                            </table>
                        <?php } ?>
                    </div>

                    <?php if (JRequest::getInt('Itemid') == 1) { ?>
                        <div class="moduletable-mainpage">
                            <div class="autopartsForms">
                                <h1>Поиск автозапчастей</h1>
                                <div id="columnOne">
                                    <h3>По номеру запчасти</h3>
                                    <script type="text/javascript">
                                        function checkOem(form, oem) {
                                            var reg = new RegExp('([a-zйцукенггшщзфыывапролдячсмить0-9])', 'gi');
                                            if (reg.test(oem)) {
                                                form.submit();
                                            } else {
                                                alert('MOD_AUTO_INCORRECT_OEM');
                                            }
                                            return false;
                                        }
                                    </script>
                                    <p class="italic">Пример: 48820-47010</p>
                                    <form action="http://parts.yamato.kg/index.php" method="get" id="search_frm" name="oemSearchForm" class="" onSubmit="checkOem(this, document.oemSearchForm.keyword);
                                                    return false;">
                                        <input id="search_field" class="g_input" type="text" name="keyword" value="" />
                                        <input type="submit" name="OemSubmit" value="Искать" id="OemSubmit" />
                                        <input type="hidden" name="Itemid" value="627" />
                                        <input type="hidden" name="option" value="com_auto" />
                                        <input type="hidden" name="task" value="detail.search" />
                                    </form>
                                </div>
                                <div id="columnTwo">
                                    <h3>по VIN-коду (номеру кузова) автомобиля</h3>
                                    <h2>Левый руль <span class="italic">Пример: WAUBH54B11N111054</span></h2>
                                    <script type="text/javascript">
                                        function checkVinValue(value, submit_btn) {
                                            value = value.replace(/[^\da-zA-Z]/g, '');
                                            var expr = new RegExp('\^[A-z0-9]{12}[0-9]{5}\$', 'i');
                                            if (expr.test(value))
                                            {
                                                jQuery(submit_btn).attr('disabled', '1');
                                                jQuery('#VINInput').attr('class', 'g_input');
                                                window.location = 'http://parts.yamato.kg/index.php?option=com_guayaquil&view=vehicles&ft=findByVIN&c=&vin=$vin$&ssd=&Itemid=621'.replace('\$vin\$', value);
                                            } else
                                                jQuery('#VINInput').attr('class', 'g_input_error');
                                        }
                                    </script>
                                    <form name="findByVIN" onSubmit="checkVinValue(this.vin.value);
                                                    return false;" id="findByVIN">
                                        <input name="vin" type="text" id="vin" size="17" value="">
                                        <input type="submit" name="vinSubmit" value="Искать" id="vinSubmit">
                                        <input type="hidden" name="option" value="com_guayaquil">
                                        <input type="hidden" name="view" value="vehicles">
                                        <input type="hidden" name="ft" value="findByVIN">
                                    </form>
                                </div>
                                <div id="columnThree">
                                    <h2>Правый руль <span class="italic">Пример: FNN15-502358</span></h2>
                                    <script type="text/javascript">
                                        function checkFrameValue(frame, frameno, submit_btn) {
                                            frame = frame.replace(/[^\da-zA-Z]/g, '');
                                            frameno = frameno.replace(/[^\da-zA-Z]/g, '');
                                            var frexpr = new RegExp('\^[A-z0-9]{3,7}\$', 'i');
                                            var frnexpr = new RegExp('\^[0-9]{3,7}\$', 'i');
                                            var result = true;

                                            if (frexpr.test(frame))
                                                jQuery('#FrameInput').attr('class', 'g_input');
                                            else {
                                                jQuery('#FrameInput').attr('class', 'g_input_error');
                                                result = false;
                                            }

                                            if (frnexpr.test(frameno))
                                                jQuery('#FrameNoInput').attr('class', 'g_input');
                                            else {
                                                jQuery('#FrameNoInput').attr('class', 'g_input_error');
                                                result = false;
                                            }

                                            if (result) {
                                                jQuery(submit_btn).attr('disabled', '1');
                                                window.location = 'http://parts.yamato.kg/index.php?option=com_guayaquil&view=vehicles&ft=findByFrame&c=&frame=$frame$&frameNo=$frameno$&Itemid=621'.replace('\$frame\$', frame).replace('\$frameno\$', frameno);
                                            }

                                            return false;  // return result;
                                        }
                                    </script>
                                    <form name="findByFrame" onSubmit="return checkFrameValue(this.frame.value, this.frameNo.value, this.frameSubmit);" id="findByFrame">
                                        <input name="frame" type="text" id="frame" size="17" value="">
                                        -
                                        <input name="frameNo" type="text" id="frameNo" size="17" value="">
                                        <input type="submit" name="frameSubmit" value="Искать" id="frameSubmit">
                                    </form>
                                </div>
                                <br clear="all" />
                                <div id="catalogueSearch">
                                    <h3>По каталогу</h3>
                                    <ul class="catalogs-links" id="colOne">
                                        <li><img src="/images/audi.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=EAU1007&amp;ssd=&amp;spi2=t&amp;Itemid=627">Audi</a></li>
                                        <li><img src="/images/bmw.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=BMW201402&amp;ssd=&amp;Itemid=627">BMW</a></li>
                                        <li><img src="/images/chevrolet.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=ch1106&amp;ssd=&amp;Itemid=627">Chevrolet</a></li>
                                        <li><img src="/images/citroen.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=AC1205&amp;ssd=&amp;Itemid=627">Citroen</a></li>
                                    </ul>
                                    <ul class="catalogs-links" id="colTwo">
                                        <li><img src="/images/fiat.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=FFiat112013&amp;ssd=&amp;Itemid=627">Fiat</a></li>
                                        <li><img src="/images/ford.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=FEE201202&amp;ssd=&amp;Itemid=627">Ford Europe</a></li>
                                        <li><img src="/images/honda.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=HONDA201401&amp;ssd=&amp;Itemid=627">Honda</a></li>
                                        <li><img src="/images/hyundai.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=HYW201409&amp;ssd=&amp;spi2=t&amp;Itemid=627">Hyundai</a></li>
                                    </ul>
                                    <ul class="catalogs-links" id="colThree">
                                        <li><img src="/images/kia.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=KIA201406&amp;ssd=&amp;spi2=t&amp;Itemid=627">Kia</a></li>
                                        <li><img src="/images/landrover.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=LRE201312&amp;ssd=&amp;Itemid=627">Land Rover Europe</a></li>
                                        <li><img src="/images/lexus.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=LA201311&amp;ssd=&amp;spi2=t&amp;Itemid=627">Lexus</a></li>
                                        <li><img src="/images/mazda.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=MAZDA201401&amp;ssd=&amp;spi2=t&amp;Itemid=627">Mazda</a></li>
                                    </ul>
                                    <ul class="catalogs-links" id="colFour">
                                        <li><img src="/images/mercedes.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=MB2222&amp;ssd=&amp;Itemid=627">Mercedes</a></li>
                                        <li><img src="/images/mmc.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=MMC201407&amp;ssd=&amp;spi2=t&amp;Itemid=627">Mitsubishi</a></li>
                                        <li><img src="/images/nissan.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=ne1210&amp;ssd=&amp;spi=t&amp;Itemid=627">Nissan</a></li>
                                        <li><img src="/images/opel.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=op1210&amp;ssd=&amp;Itemid=627">Opel/Vauxhall</a></li>
                                    </ul>
                                    <ul class="catalogs-links" id="colFive">
                                        <li><img src="/images/peugeot.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=AP1211&amp;ssd=&amp;Itemid=627">Peugeot</a></li>
                                        <li><img src="/images/porsche.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=PO340&amp;ssd=&amp;spi2=t&amp;Itemid=627">Porsche</a></li>
                                        <li><img src="/images/renault.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=RENAULT201305&amp;ssd=&amp;Itemid=627">Renault</a></li>
                                        <li><img src="/images/seat.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=ESE533&amp;ssd=&amp;spi2=t&amp;Itemid=627">Seat</a></li>
                                    </ul>
                                    <ul class="catalogs-links" id="colSix">
                                        <li><img src="/images/skoda.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=ESK539&amp;ssd=&amp;spi2=t&amp;Itemid=627">Skoda</a></li>
                                        <li><img src="/images/subaru.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=SSF1302&amp;ssd=&amp;Itemid=627">Subaru Japan</a></li>
                                        <li><img src="/images/toyota.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=TA201311&amp;ssd=&amp;spi2=t&amp;Itemid=627">Toyota</a></li>
                                        <li><img src="/images/vw.png" /><a href="http://parts.yamato.kg/index.php?option=com_guayaquil&amp;view=catalog&amp;c=EVW1007&amp;ssd=&amp;spi2=t&amp;Itemid=627">VW</a></li>
                                    </ul>
                                </div>
                                <br clear="all" />

                            </div>

                        <?php } ?>
                        <div class="topmenu">
                            <jdoc:include type="modules" name="menu" />
                        </div>
                        <jdoc:include type="message" />
                        <?php if ((!$_GET['product_id']) and ($_GET['page'] == 'shop.browse') and ($_GET['option'] == 'com_virtuemart')) { ?>
                            <jdoc:include type="modules" name="user1" style="xhtml" />
                        <?php } ?>
                        <jdoc:include type="modules" name="user5" style="xhtml" />
                        <jdoc:include type="component" />
                        <jdoc:include type="modules" name="user6" style="xhtml" />
                </td>
            </tr>
            <tr class="gsep"><td></td></tr>
            <tr>
                <td><jdoc:include type="modules" name="user2" style="xhtml" /></td>
    </tr>
    <tr class="gsep"><td colspan="5"></td></tr>
    <tr>
        <td>
            <div class="brcatnav">
                <div class="brcatarrow br_prev"></div>
                <div class="brcatarrow br_next"></div>
            </div>
    <jdoc:include type="modules" name="user3" style="xhtml" />
    </td>
    </tr>
    </table>
    <script language="javascript" type="text/javascript">
        java = "1.0";
        java1 = "" + "refer=" + escape(document.referrer) + "&amp;page=" + escape(window.location.href);
        document.cookie = "astratop=1; path=/";
        java1 += "&amp;c=" + (document.cookie ? "yes" : "now");
    </script>
    <script language="javascript1.1" type="text/javascript">
        java = "1.1";
        java1 += "&amp;java=" + (navigator.javaEnabled() ? "yes" : "now");
    </script>
    <script language="javascript1.2" type="text/javascript">
        java = "1.2";
        java1 += "&amp;razresh=" + screen.width + 'x' + screen.height + "&amp;cvet=" +
                (((navigator.appName.substring(0, 3) == "Mic")) ?
                        screen.colorDepth : screen.pixelDepth);
    </script>
    <script language="javascript1.3" type="text/javascript">java = "1.3"</script>
    <script language="javascript" type="text/javascript">
        java1 += "&amp;jscript=" + java + "&amp;rand=" + Math.random();
        document.write("<p align=center><a href='http://www.net.kg/stat.php?id=93&amp;fromsite=93' target='_blank'>" +
                "<img src='http://www.net.kg/img.php?id=93&amp;" + java1 +
                "' border='0' alt='WWW.NET.KG' width='88' height='31' /></a></p>");
    </script>
    <noscript>
    <p align="center"><a href='http://www.net.kg/stat.php?id=93&amp;fromsite=93' target='_blank'><img
                src="http://www.net.kg/img.php?id=93" border='0' alt='WWW.NET.KG' width='88'
                height='31' /></a></p>
    </noscript>

    </body>
    </html>
<?php } 