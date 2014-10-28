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
class ManagerModelManager extends JModel {

    public $limit = 50;

    public function getCars($filter, $usertype) {
        $db = JFactory::getDbo();

        $sql = 'SELECT p.*, (
                                SELECT product_price 
                                FROM #__vm_product_price 
                                WHERE product_id = p.product_id 
                                ORDER BY product_price_id
                                LIMIT 1 
                                ) AS price, (
                                SELECT product_currency 
                                FROM #__vm_product_price 
                                WHERE product_id = p.product_id 
                                ORDER BY product_price_id
                                LIMIT 1 
                                ) AS currency,
                                u.name AS cagent
                        FROM #__vm_product AS p 
                        LEFT JOIN #__cagents_avto AS ca ON p.link = ca.avto_link
                        LEFT JOIN #__users AS u ON u.link = ca.cagent_link
                        WHERE p.product_type = "automobil" ';

        if ($filter->search) {
            $filter->offset = 0;
            $sql .= ' AND (
                                    p.product_name LIKE "%' . $filter->search . '%" OR 
                                    p.model LIKE "%' . $filter->search . '%" OR 
                                    p.marka LIKE "%' . $filter->search . '%" OR
                                    p.NomerKuzov LIKE "%' . $filter->search . '%" 
					) ';
        }
        if ($filter->marka) {
            $sql .= ' AND p.marka = "' . $filter->marka . '" ';
        }
        if ($filter->model) {
            $sql .= ' AND p.model = "' . $filter->model . '" ';
        }
        if (($filter->year1 > 0) and ($filter->year2 > 0)) {
            $sql .= ' AND (p.year >= "' . $filter->year1 . '" AND p.year <= "' . $filter->year2 . '") ';
        }
        if (($filter->cagent) and ($filter->cagent != 'undefined')) {
            if( $filter->cagent>0){
            $sql .= ' AND p.link IN (
                        SELECT avto_link 
                        FROM #__cagents_avto 
                        WHERE cagent_link = (
                                SELECT link 
                                FROM #__users 
                                WHERE id = ' . $filter->cagent . ' 
                                LIMIT 1)) ';
            }else{
                $sql .= ' AND ca.cagent_link IS NULL ';
            }
        }
        if ($usertype == 'Manager') {
            $sql .= ' AND p.status != "sold" ';
        }

        if ($filter->status['all'] != 'true') {
            $status   = array();
            if ($filter->status['delivered'] == 'true'){
                $status[] = " `p`.`status` = 'delivered' ";
            }
            if ($filter->status['sold'] == 'true'){
                $status[] = " `p`.`status` = 'sold' ";
            }
            if ($filter->status['fresh'] == 'true'){
                $status[] = " `p`.`status` = 'fresh' ";
            }
            if (count($status) > 0) {
                $sql .= ' AND (' . implode(' OR ', $status) . ') ';
            }
        }

        $limit  = $this->limit;
        $offset = intval($filter->offset);
        $sql .= " ORDER BY p.cdate DESC";
        $sql .= " LIMIT $offset, $limit"; 
        $db->setQuery($sql);

        return $db->LoadObjectList();
    }

    //check lost page
    public function checkLost($filter) {
        $db = JFactory::getDbo();

        $sql = 'SELECT COUNT(p.product_id) AS countid
                FROM #__vm_product AS p 
                WHERE p.product_type = "automobil" ';

        if ($filter->search) {
            $sql .= ' AND (
                        p.product_name LIKE "%' . $filter->search . '%" OR 
                        p.model LIKE "%' . $filter->search . '%" OR 
                        p.marka LIKE "%' . $filter->search . '%" OR
                        p.NomerKuzov LIKE "%' . $filter->search . '%" 
                        ) ';
        }
        if ($filter->marka) {
            $sql .= ' AND p.marka = "' . $filter->marka . '" ';
        }
        if ($filter->model) {
            $sql .= ' AND p.model = "' . $filter->model . '" ';
        }
        if ($filter->year) {
            $sql .= ' AND p.year = "' . $filter->year . '" ';
        }
        if (($filter->cagent) and ($filter->cagent != 'undefined')) {
            $sql .= ' AND p.link IN (
                                    SELECT avto_link 
                                    FROM #__cagents_avto 
                                    WHERE cagent_link = (
                                            SELECT link 
                                            FROM #__users 
                                            WHERE id = ' . $filter->cagent . ' 
                                            LIMIT 1)) ';
        }
        $offset    = intval($filter->offset);
        $db->setQuery($sql);
        $count_row = $db->LoadResult();

        return ($this->limit + $offset >= $count_row) ? true : false;
    }

    //get single car
    public function getSingleCar($car_id) {
        $db = JFactory::getDbo();

        $sql = 'SELECT p.*, (
                                SELECT product_price 
                                FROM #__vm_product_price 
                                WHERE product_id = p.product_id 
                                ORDER BY product_price_id
                                LIMIT 1 
                                ) AS price, (
                                SELECT product_currency 
                                FROM #__vm_product_price 
                                WHERE product_id = p.product_id 
                                ORDER BY product_price_id
                                LIMIT 1 
                                ) AS currency
                        FROM #__vm_product AS p 
                        WHERE p.product_type = "automobil" AND p.product_id = ' . $car_id;
        $db->setQuery($sql);
        $car = $db->LoadObject();

        $sql         = 'SELECT * FROM #__vm_product_files WHERE file_published =1 AND file_product_id = ' . $car_id;
        $db->setQuery($sql);
        $car->images = $db->LoadObjectList();

        return $car;
    }

    //get car model list
    public function getCarModelList($marka) {
        $db  = JFactory::getDBO();
        $sql = 'SELECT DISTINCT `model` 
                        FROM `#__vm_product` 
                        WHERE `model` IS NOT NULL AND `marka`=\'' . $marka . '\' AND `product_type` = \'automobil\' 
                        ORDER BY `model`';
        $db->setQuery($sql);
        return $db->LoadObjectList();
    }

    //get car marka list
    public function getCarMarkaList() {
        $db  = JFactory::getDBO();
        $sql = 'SELECT DISTINCT `marka` 
                        FROM `#__vm_product` 
                        WHERE `marka` IS NOT NULL AND `marka`!=\'NONE\' AND `product_type` = \'automobil\' 
                        ORDER BY `marka`';
        $db->setQuery($sql);
        return $db->LoadObjectList();
    }

    //get contragent list
    public function getCAgentsList() {
        $db  = JFactory::getDBO();
        $sql = 'SELECT * FROM `#__users` WHERE `gid` = 19 ORDER BY `name`';
        $db->setQuery($sql);
        return $db->LoadObjectList();
    }

    //get stages of dilevery
    public function getStagesOfDilevery($car_id) {
        $db = JFactory::getDBO();

        $sql  = 'SELECT `link` FROM `#__vm_product` WHERE `product_id`=' . $car_id;
        $db->setQuery($sql);
        $link = $db->LoadResult();

        $sql = 'SELECT `params` FROM `#__components` WHERE `option`=\'com_sincronise\'';
        $db->setQuery($sql);
        $str = $db->LoadResult();
        $mas = unserialize($str);

        $soap->url  = $mas['server1cip'];
        $soap->user = $mas['server1clogin'];
        $soap->pass = $mas['server1cpass'];

        ini_set("soap.wsdl_cache_enabled", "0");

        $dop_param = array('login' => $soap->user, 'password' => $soap->pass);
        $client    = new SoapClient($soap->url, $dop_param);
        $param     = array('ID' => $link);
        $req       = $client->MK_GetCarsDeliveryStatuses($param);

        $staiges = array();
        if ($req->return != 'Error') {
            $obj     = new SimpleXMLElement($req->return); //pr($obj);
            unset($obj->column);
            $staiges = array();
            if ($obj) {
                $i = 0;
                foreach ($obj as $item) {
                    $DeliveryStage = (string) $item->Value[1];
                    $DeliveryType  = (string) $item->Value[3];
                    $Sender        = (string) $item->Value[5];
                    $Recipient     = (string) $item->Value[7];
                    $DateIn        = (string) $item->Value[9];
                    $DateOut       = (string) $item->Value[8];
                    $time          = (intval(strtotime($DateIn)) > 0) ? intval(strtotime($DateIn)) : intval(strtotime($DateOut));

                    $staiges[($time + $i)]->DeliveryStage = $DeliveryStage;
                    $staiges[($time + $i)]->DeliveryType  = $DeliveryType;
                    $staiges[($time + $i)]->time          = $time;

                    $i++;
                }
            }
        }
        ksort($staiges);

        return $staiges;
    }

    public function uploadImage($product_id) {
        $db   = JFactory::getDbo();
        $user = JFactory::getUser();

        $access_type = array('image/png', 'image/jpeg');

        $tempfile = $_FILES['newimage']['tmp_name'];
        $filetype = $_FILES['newimage']['type'];
        switch ($filetype) {
            case 'image/png': {
                    $ext = 'png';
                    break;
                }
            case 'image/jpeg': {
                    $ext = 'jpg';
                    break;
                }
        }
        $filename = 'U' . $user->id . 'T' . time() . 'R' . rand(1000, 9999).".$ext";

        if (!in_array($filetype, $access_type)) {
            return false;
        }

        $img = getimagesize($tempfile);

        $w = $img[0];
        $h = $img[1];

        $wb = ($w > 800) ? 800 : $w;
        $hb = ($w > 600) ? 600 : $h;

        $fullpath = '../image.yamato.kg/' . $filename;

        system("C:/ImageMagick/convert.exe -quality 90 -resize $wb" . 'x' . "$hb $tempfile $fullpath");

        $sql  = 'SELECT * FROM `#__vm_product` WHERE `product_id` = ' . $product_id;
        $db->setQuery($sql);
        $prod = $db->LoadObject();

        if ($prod->product_full_image) {
            $sql = "INSERT INTO `#__vm_product_files` (
                    `file_product_id`, `file_name`, `file_title`, `file_description`, 
                    `file_extension`, `file_mimetype`, `file_url`, `file_published`,
                    `file_is_image`, `file_image_height`, `file_image_width`, `file_image_thumb_height`, 
                    `file_image_thumb_width`, `uploaded_from1C`, `image_hash`
                    ) VALUES (
                    '$product_id', '$filename', '$filename', '', 
                    '$ext', '$filetype', 'http://image.yamato.kg/$filename', '1', 
                    '1', '800', '600', '280', 
                    '200', '0', '')";
        } else {
            $sql = "UPDATE `#__vm_product` SET
                    `product_thumb_image`='http://image.yamato.kg/$filename', 
                    `product_full_image`='http://image.yamato.kg/$filename', 
                    `image_hash` = ''
                    WHERE `product_id`=$product_id";
        }
        $db->setQuery($sql);
        $db->query();

        return true;
    }

}
