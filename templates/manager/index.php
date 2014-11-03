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
?>
<?php echo '<?xml version="1.0" encoding="utf-8"?' . '>'; ?>
<!DOCTYPE html>
<html xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
    <head>
        <!--meta content="width=device-width, initial-scale=1.0,maximum-scale=2.0,user-scalable=1" name="viewport"-->
        <meta name="viewport" content="width=device-width, user-scalable=no">
    <jdoc:include type="head" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
    <!--[if lte IE 6]>
            <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if IE 7]>
            <link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/<?php echo DEVICE_TYPE; ?>.css" type="text/css" />
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/jquery.js"></script>
    <script>
        jQuery.noConflict();

        jQuery(document).ready(function($) {

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

        var device_type = '<?php echo DEVICE_TYPE; ?>';
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
            width: 48px;
            height: 48px;
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
    <div class="wrapper">
        <div class="head" >
            <div class="logo" >
                <jdoc:include type="modules" name="logo" />
            </div>
            <a style="margin-top:10px 0 0 20px;" href="http://m.yamato.kg">Мобильная версия</a>
            <ul class="topmenu" >
                <li class="item1"><a href="index.php?component=com_manager&Itemid=32">Закрытый раздел</a></li>
                <li class="item2"><a href="http://yamato.kg" >www.yamato.kg</a></li>
                <li class="item3"><jdoc:include type="modules" name="login" style="xhtml" /></li>
            </ul>
        </div>
        <div class="topmenu">
            <jdoc:include type="modules" name="menu" />
        </div>
        <div class="content" > 
            <jdoc:include type="component" />
            <jdoc:include type="modules" name="user6" style="xhtml" />
        </div>	
    </div>
    <br /><br />	
</body>
</html>