<?php

/**
 * @version		$Id: categories.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * Weblinks Component Categories Model
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class SincroniseModelSincronise extends JModel {

    public $db;

    public function updateCategory($c_obj, $metod = 'insert') {
        $db   = JFactory::getDBO();
        $time = time();

        if ($metod == 'insert') {
            $category_name        = $c_obj->category_name;
            $category_description = $c_obj->category_description;
            $category_thumb_image = $c_obj->category_thumb_image;
            $category_full_image  = $c_obj->category_full_image;
            $model                = $c_obj->model;

            $sql = "INSERT INTO `#__vm_category` (
                    `vendor_id`, `category_name`, `category_description`, 
                    `category_thumb_image`, `category_full_image`, `category_publish`, 
                    `cdate`, `mdate`, `category_browsepage`, 
                    `products_per_row`, `category_flypage`, `list_order`, `model`
                    ) VALUES (
                    '1', '$category_name', '$category_description', 
                    '$category_thumb_image', '$category_full_image', 'Y', 
                    '$time', '$time', 'browse_1', 
                    '1', 'flypage.tpl', '0', '$model')";
            $db->setQuery($sql);
            $db->query();

            $catid = $db->insertid();
        }
        if ($metod == 'update') {
            $category_id          = $c_obj->category_id;
            $category_name        = $c_obj->category_name;
            $category_description = $c_obj->category_description;
            $category_thumb_image = $c_obj->category_thumb_image;
            $category_full_image  = $c_obj->category_full_image;
            $model                = $c_obj->model;

            $sql = "UPDATE `#__vm_category` SET
                    `category_name`='$category_name', `category_description`='$category_description', 
                    `category_thumb_image`='$category_thumb_image', `category_full_image`='$category_full_image',
                    `mdate`='$time', `model`='$model' 
                    WHERE `category_id`=$category_id";
            $db->setQuery($sql);
            $db->query();

            $catid = $category_id;
        }

        $category_name = $c_obj->category_name;

        return $catid;
    }

    public function updateProduct($p_obj, $updateimg = false) {
        $db   = $this->db;
        $time = ($p_obj->cdate > 0) ? $p_obj->cdate : time();

        $link                  = $p_obj->link;
        $product_price         = $p_obj->product_price;
        $product_sku           = $p_obj->product_sku;
        $product_currency_link = $p_obj->product_currency_link;
        $product_category_id   = $p_obj->product_category_id;
        $product_image         = $p_obj->product_image;
        $product_model         = $p_obj->model;
        $marka                 = $p_obj->marka;
        $year                  = $p_obj->year;
        $RaspolojenieRulya     = $p_obj->RaspolojenieRulya;
        $TipKPP                = $p_obj->TipKPP;
        $TipKuzova             = $p_obj->TipKuzova;
        $EngineSize            = $p_obj->EngineSize;
        $NomerKuzov            = $p_obj->NomerKuzov;
        $Probeg                = $p_obj->Probeg;
        $TipTopliva            = $p_obj->TipTopliva;
        $CvetSalona            = $p_obj->CvetSalona;
        $Prodan                = $p_obj->Prodan;
        $DataProdaji           = $p_obj->DataProdaji;
        $TipSalona             = $p_obj->TipSalona;
        $product_publish       = $p_obj->product_publish;
        $product_currency      = $p_obj->product_currency;
        $AukcionnayaCena       = $p_obj->AukcionnayaCena;
        $ValutaAukcionnoiCeny  = $p_obj->ValutaAukcionnoiCeny;
        $product_type          = $p_obj->product_type;
        $CenaProdaji           = (isset($p_obj->CenaProdaji)) ? $p_obj->CenaProdaji : null;
        $ValutaCenyProdaji     = (isset($p_obj->ValutaCenyProdaji)) ? $p_obj->ValutaCenyProdaji : null;
        $DneiSMomentaPokupki   = (isset($p_obj->DneiSMomentaPokupki)) ? $p_obj->DneiSMomentaPokupki : null;
        $status                = (isset($p_obj->status)) ? $p_obj->status : null;
        $Sebestoimost          = (isset($p_obj->Sebestoimost)) ? $p_obj->Sebestoimost : 0;
        $TipPoSostavu          = (isset($p_obj->TipPoSostavu)) ? $p_obj->TipPoSostavu : null;
        $TipPoNaznacheniyu     = (isset($p_obj->TipPoNaznacheniyu)) ? $p_obj->TipPoNaznacheniyu : null;
        $Razmer                = (isset($p_obj->Razmer)) ? $p_obj->Razmer : 0;
        $group_uom             = (isset($p_obj->group_uom)) ? $p_obj->group_uom : null;
        $group_article         = (isset($p_obj->group_article)) ? $p_obj->group_article : $product_sku;
        $CustomerLink          = $p_obj->CustomerLink;
        $DataDostavki          = $p_obj->DataDostavki;
        $DataPokupki           = $p_obj->DataPokupki;
        $Postavshik            = $p_obj->Postavshik;
        $product_width         = (isset($p_obj->product_width)) ? $p_obj->product_width : 0;
        $product_height        = (isset($p_obj->product_height)) ? $p_obj->product_height : 0;
        $product_length        = (isset($p_obj->product_length)) ? $p_obj->product_length : 0;
        $sezon                 = (isset($p_obj->sezon)) ? $p_obj->sezon : null;
        $Properties            = $p_obj->Properties;

        if (!$product_model) {
            $product_model = 'NONE';
        }
        if (!$marka) {
            $marka = 'NONE';
        }

        if ($product_model) {
            $sql     = "SELECT `id` FROM `#__models` WHERE `title`='$product_model'";
            $db->setQuery($sql);
            $checkid = $db->LoadResult();

            if (!$checkid > 0) {
                $sql = "INSERT INTO `#__models` (`title`,`link`) VALUES ('$product_model','')";
                $db->setQuery($sql);
                $db->query();
            }
        }

        $sql     = "SELECT * FROM `#__vm_product` WHERE `product_sku`='$product_sku'";
        $db->setQuery($sql);
        $product = $db->LoadObject();

        $product_id         = 0;
        $product_image_hash = '';
        if ($product) {
            $metod      = 'update';
            $product_id = $product->product_id;
        } else {
            $metod = 'insert';
        }

        if ($metod == 'insert') {
            $product_sku      = $p_obj->product_sku;
            $product_s_desc   = $p_obj->product_s_desc;
            $product_desc     = $p_obj->product_desc;
            $product_in_stock = $p_obj->product_in_stock;
            $product_name     = $p_obj->product_name;

            $sql        = "INSERT INTO `#__vm_product` (
                            `link`, `vendor_id`, `product_parent_id`, `product_sku`, `product_s_desc`, `product_desc`, 
                            `product_thumb_image`, `product_full_image`, `product_publish`, `product_weight`, `product_weight_uom`, 
                            `product_length`, `product_width`, `product_height`, `product_lwh_uom`, `product_url`, 
                            `product_in_stock`, `product_available_date`, `product_availability`, `product_special`, `product_discount_id`, 
                            `ship_code_id`, `cdate`, `mdate`, `product_name`, `product_sales`, 
                            `attribute`, `custom_attribute`, `product_tax_id`, `product_unit`, `product_packaging`, 
                            `child_options`, `quantity_options`, `child_option_ids`, `product_order_levels`, `model`, `marka`, `year`
                            ) VALUES (
                            '$link', '1', '0', '$product_sku', '$product_s_desc', '$product_desc', 
                            '', '', '$product_publish', '0', 'кг.', 
                            '0', '0', '0', 'см.', '', 
                            '$product_in_stock', '0', '', 'N', '0', 
                            '', '$time', '$time', '$product_name', '', 
                            '', '', '0', 'шт.', '0', 
                            'N,N,N,N,N,Y,20%,10%,', 'none,0,0,1', '', '0,0', '$product_model', '$marka', '$year')";
            $db->setQuery($sql);
            $db->query();
            $product_id = $db->insertid();
        }
        if ($metod == 'update') {
            $product_sku      = $p_obj->product_sku;
            $product_s_desc   = $p_obj->product_s_desc;
            $product_desc     = $p_obj->product_desc;
            $product_in_stock = $p_obj->product_in_stock;
            $product_name     = $p_obj->product_name;

            $sql = "UPDATE `#__vm_product` SET
                    `product_sku`='$product_sku', `product_s_desc`='$product_s_desc', `product_desc`='$product_desc', 
                    `product_in_stock`='$product_in_stock', `mdate`='$time', `product_name`='$product_name', 
                    `model`='$product_model', `marka`='$marka', `year`='$year', `product_publish`='$product_publish'
                    WHERE `product_id`=$product_id AND `writeble`=1";
            $db->setQuery($sql);
            $db->query();
        }

        //дополнительные параметры
        $filename             = '';
        $image_hash           = '';
        $thumb_filename       = '';
        $first_filename       = '';
        $first_thumb_filename = '';
        if (count($product_image) > 0) {
            $image = $product_image[0];

            $sql = "UPDATE `#__vm_product` SET
                    `product_thumb_image`='$image', 
                    `product_full_image`='$image'
                    WHERE `product_id`=$product_id AND `writeble`=1";
            $db->setQuery($sql);
            $db->query();
            unset($product_image[0]);
        }


        if ($Prodan == 1) {
            if (($DataProdaji > 0) and (time() - $DataProdaji > (4 * 24 * 3600))) {
                $product_publish = 'N';
            }
        }

        $dopsql = $this->prepareProperties($Properties);
        if ($p_obj->product_weight_uom) {
            $dopsql .= ' ,`product_weight_uom` = \'' . $p_obj->product_weight_uom . '\'';
        }

        $sql = "UPDATE `#__vm_product` SET
                `RaspolojenieRulya`='$RaspolojenieRulya', `TipKPP`='$TipKPP', `TipKuzova`='$TipKuzova', 
                `EngineSize`='$EngineSize', `NomerKuzov`='$NomerKuzov', `product_type`='$product_type',
                `Probeg`='$Probeg', `TipTopliva`='$TipTopliva', `CvetSalona`='$CvetSalona', 
                `Prodan`='$Prodan', `DataProdaji`='$DataProdaji', `TipSalona`='$TipSalona', 
                `product_publish`='$product_publish', `ValutaAukcionnoiCeny`='$ValutaAukcionnoiCeny', `AukcionnayaCena`='$AukcionnayaCena',
                `CenaProdaji`='$CenaProdaji', `ValutaCenyProdaji`='$ValutaCenyProdaji', `status`='$status', 
                `DneiSMomentaPokupki` = '$DneiSMomentaPokupki', `Sebestoimost` = '$Sebestoimost', `group_uom` = '$group_uom',
                `TipPoSostavu` = '$TipPoSostavu', `TipPoNaznacheniyu` = '$TipPoNaznacheniyu', `Razmer` = '$Razmer',
                `group_article` = '$group_article', `DataDostavki` = '$DataDostavki', `DataPokupki` = '$DataPokupki',
                `product_width` = '$product_width', `product_height` = '$product_height', `product_length` = '$product_length',
                `Postavshik` = '$Postavshik', `sezon` = '$sezon'
                $dopsql
                WHERE `product_id`=$product_id";
        $db->setQuery($sql);
        $db->query();

        if ((count($product_image) > 0) and ($product_id > 0)) {
            $sql = 'DELETE FROM #__vm_product_files WHERE `uploaded_from1C`=1 AND file_product_id=' . $product_id;
            $db->setQuery($sql);
            $db->query();

            foreach ($product_image as $image) {
                $sql = "INSERT INTO `#__vm_product_files` (
                        `file_product_id`, `file_name`, `file_title`, `file_description`, 
                        `file_extension`, `file_mimetype`, `file_url`, `file_published`,
                        `file_is_image`, `file_image_height`, `file_image_width`, `file_image_thumb_height`, 
                        `file_image_thumb_width`, `uploaded_from1C`
                        ) VALUES (
                        '$product_id', 'filename', 'filename', '', 
                        'jpg', 'image/jpeg', '$image', '1', 
                        '1', '800', '600', '280', 
                        '200', '1')";
                $db->setQuery($sql);
                $db->query();
            }
        }


        if (($product_price > 0) and ($product_currency)) {
            //обновление валюты
            $sql        = "SELECT `product_price_id` FROM `#__vm_product_price` WHERE `product_id`='$product_id' AND `shopper_group_id`='5'";
            $db->setQuery($sql);
            $checkprise = $db->LoadResult();

            if ($checkprise > 0) {
                $sql = "UPDATE `#__vm_product_price` SET `product_price`='$product_price', `product_currency`='$product_currency' WHERE `product_price_id`='$checkprise'";
            } else {
                $sql = "INSERT INTO `#__vm_product_price` (
                        `product_id`, `product_price`, `product_currency`, `product_price_vdate`, `product_price_edate`, 
                        `cdate`, `mdate`, `shopper_group_id`, `price_quantity_start`, `price_quantity_end`
                        ) VALUES (
                        '$product_id', '$product_price', '$product_currency', '0', '0', 
                        '$time', '$time', '5', '0', '0')";
            }
            $db->setQuery($sql);
            $db->query(); //echo $sql.'<br><br>';
        }

        $sql = "DELETE FROM `#__vm_product_category_xref` WHERE `product_id`='$product_id'";
        $db->setQuery($sql);
        $db->query();

        //обновление связки с категорией
        $sql = "INSERT INTO `#__vm_product_category_xref` (`category_id`, `product_id`) VALUES ('$product_category_id', '$product_id')";
        $db->setQuery($sql);
        $db->query();

        //attached avto for contragent
        if ($CustomerLink) {
            $sql   = "SELECT `id` FROM `#__cagents_avto` WHERE `avto_link` = '$link'";
            $db->setQuery($sql);
            $check = $db->LoadResult();

            if ($check) {
                $sql = "UPDATE `#__cagents_avto` SET `cagent_link` = '$CustomerLink' WHERE `avto_link` = '$link'";
            } else {
                $sql = "INSERT INTO `#__cagents_avto` (
                        `cdate`, `cagent_link`, `avto_link`, `etap_dostavki`
                        ) VALUES (
                        '0', '$CustomerLink', '$link', '')";
            }
            $db->setQuery($sql);
            $db->query();
        }

        return $product_id;
    }

    public function prepareProperties($properties) {
        $sql = '';

        if (isset($properties['Полярность'])) {
            $sql .= ' ,`polar` = \'' . str_replace(array('+', '-', ' '), '', $properties['Полярность']) . '\'';
        }
        if (isset($properties['Тип клемм'])) {
            $sql .= ' ,`clema` = \'' . $properties['Тип клемм'] . '\'';
        }
        if (isset($properties['Ёмкость'])) {
            $sql .= ' ,`power` = \'' . $properties['Ёмкость'] . '\'';
        }

        return $sql;
    }

    public function updateManufacturer($obj) {
        $name = $obj->name;
        $link = $obj->link;

        $db = JFactory::getDBO();

        $sql     = "SELECT `manufacturer_id` FROM `#__vm_manufacturer` WHERE `link`='$link' LIMIT 1";
        $db->setQuery($sql);
        $checkid = $db->LoadResult();

        if ($checkid > 0) {
            $sql = "UPDATE `#__vm_manufacturer` SET `mf_name`='$name' WHERE `manufacturer_id`=$checkid";
        } else {
            $sql = "INSERT INTO `#__vm_manufacturer` (
                    `mf_name`, `mf_email`, `mf_desc`, `mf_category_id`, `mf_url`, `link`
                    ) VALUES (
                    '$name', NULL, NULL, '0', '', '$link')";
        }
        $db->setQuery($sql);
        $checkid = $db->query();
    }

    public function updateUser($obj) {
        $db = JFactory::getDBO();

        $link          = $obj->link;
        $name          = $obj->name;
        $username      = $obj->username;
        $email         = $obj->email;
        $origpass      = '312122';
        $password      = $obj->password;
        $usertype      = $obj->usertype;
        $gid           = $obj->gid;
        $block         = $obj->block;
        $sendemail     = $obj->sendEmail;
        $registerdate  = $obj->registerDate;
        $lastvisitdate = $obj->lastvisitDate;
        $activation    = $obj->activation;
        $params        = $obj->params;
        $ballans       = $obj->ballans;
        $phone_1       = $obj->phone_1;
        $address_1     = $obj->address_1;

        //создание пользователя joomla
        $sql     = "SELECT `id` FROM `#__users` WHERE `link`='$link'";
        $db->setQuery($sql);
        $user_id = $db->LoadResult();

        if ($user_id > 0) {
            $sql = "UPDATE `#__users` SET `block`='0', `gid`='$gid', `name`='$name', `username`='$username', `email`='$email', `ballans`='$ballans' WHERE `id`=$user_id";
            $db->setQuery($sql);
            $db->query();
        } else {
            $sql     = "INSERT INTO `#__users` (
                        `link`, `name`, `username`, `email`, `password`, `usertype`, `block`, 
                        `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`, `ballans`
                        ) VALUES (
                        '$link', '$name', '$username', '$email', '$password', '$usertype', '0', 
                        '$sendemail', '$gid', '$registerdate', '$lastvisitdate', '$activation', '$params', '$ballans')";
            $db->setQuery($sql);
            $db->query();
            $user_id = $db->insertid();

            $sql    = "INSERT INTO `#__core_acl_aro` (`section_value`, `value`, `order_value`, `name`, `hidden`) VALUES ('users', '$user_id', '0', '$name', '0')";
            $db->setQuery($sql);
            $db->query();
            $aro_id = $db->insertid();

            $sql = "INSERT INTO `#__core_acl_groups_aro_map` (`group_id`, `section_value`, `aro_id`) VALUES ('18', '', '$aro_id')";
            $db->setQuery($sql);
            $db->query();

            $mailer = JFactory::getMailer();

            $config = JFactory::getConfig();
            $sender = array($config->getValue('config.mailfrom'), $config->getValue('config.fromname'));
            $mailer->setSender($sender);

            $recipient = $email;
            $mailer->addRecipient($recipient);

            $body = "<h4>Здравствуйте, $name!</h4>
<br>
<p>Это автоматическое приглашение на сайт www.yamato.kg, 
где вы можете посмотреть свои личные данные, автомобили и узнать другую полезную информацию.</p>
<br>
<p>Для входа на сайт, воспользуйтесь следующими реквизитами:</p>
<p>имя пользователя: $username</p>
<p>пароль: $origpass</p>
<br>
<p>После входа вы можете сменить ваши логин и пароль в разделе 'Настройки'.</p>
<br>
<p>Спасибо, что вы с нами!</p>
<p>С уважением, автосалон 'Ямато'</p>";
            $mailer->isHTML(true);
            $mailer->setSubject('Приглашаем на сайт YAMATO.KG');
            $mailer->setBody($body);

            $mailer->Send();
        }

        $cdate        = time();
        $user_info_id = md5($user_id);
        $names        = explode(' ', $name);
        $first_name   = $names[0];
        $middle_name  = (isset($names[1])) ? $names[1] : null;
        $last_name    = (isset($names[2])) ? $names[2] : null;

        $sql = "SELECT `user_info_id` FROM `#__vm_user_info` WHERE `user_id`='$user_id'";
        $db->setQuery($sql);
        $uid = $db->LoadResult();

        //создание/обновление пользователя виртуемарта
        if ($uid) {
            $sql = "UPDATE `#__vm_user_info` SET
                    `last_name` = '$last_name', `first_name` = '$first_name', `middle_name` = '$middle_name', 
                    `phone_1` = '$phone_1', `address_1` = '$address_1', `user_email` = '$email'
                    WHERE `user_id` = '$user_id'";
            $db->setQuery($sql);
            $db->query();
        } else {
            $sql = "INSERT INTO `#__vm_user_info` (
                    `user_info_id`, `user_id`, `address_type`, `address_type_name`, `company`, 
                    `title`, `last_name`, `first_name`, `middle_name`, `phone_1`, 
                    `phone_2`, `fax`, `address_1`, `address_2`, `city`, 
                    `state`, `country`, `zip`, `user_email`, `extra_field_1`, 
                    `extra_field_2`, `extra_field_3`, `extra_field_4`, `extra_field_5`, `cdate`, 
                    `mdate`, `perms`, `bank_account_nr`, `bank_name`, `bank_sort_code`, 
                    `bank_iban`, `bank_account_holder`, `bank_account_type`
                    ) VALUES (
                    '$user_info_id', '$user_id', 'BT', '-default-', '', 
                    '', '$last_name', '$first_name', '$middle_name', '$phone_1', 
                    '', '', '$address_1', '', '', 
                    '-', '', '', '$email', '', 
                    '', '', '', '', '$cdate', 
                    '$cdate', 'shopper', '', '', '', 
                    '', '', '')";
            $db->setQuery($sql);
            $db->query();
        }
    }

    public function delUser() {
        $db = JFactory::getDBO();

        $sql = "UPDATE `#__users` SET `block`='1' WHERE `gid`='19'";
        $db->setQuery($sql);
        $db->query();
    }

    public function updateCurrency($obj) {
        $id   = $obj->currency_id;
        $link = $obj->currency_link;
        $name = $obj->currency_name;
        $code = $obj->currency_code;

        $db = JFactory::getDBO();

        $sql     = "SELECT `currency_id` FROM `#__vm_currency` WHERE `link`='$link'";
        $db->setQuery($sql);
        $checkid = $db->LoadResult();

        if ($checkid > 0) {
            $sql = "UPDATE `#__vm_currency` SET `currency_name`='$name', `currency_code`='$code' WHERE `link`='$link'";
        } else {
            $sql = "INSERT INTO `#__vm_currency` (`currency_id`, `link`,`currency_name`,`currency_code`) VALUES ('$id', '$link','$name','$code')";
        }
        $db->setQuery($sql);
        $db->query();
    }

    public function create_small($name_big, $name_small, $max_x, $max_y) {
        if (is_file($name_big)) {
            system('c:/ImageMagick/convert -quality 90 -resize ' . $max_x . 'x' . $max_y . ' ' . $name_big . ' ' . $name_small);
        }
    }

    public function exportOrders() {
        $db = JFactory::getDBO();
    }

}

?>
