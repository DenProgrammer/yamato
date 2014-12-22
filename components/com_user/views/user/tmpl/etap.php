<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

$db = JFactory::getDBO();

$product_id = JRequest::getInt('id');

$sql   = 'SELECT p.*, ('
        . ' select nomer_sredstva_dostavki from #__cagents_avto where avto_link = p.`link`'
        . ') NumSrDost '
        . 'FROM `#__vm_product` p '
        . 'WHERE p.`product_id`=' . $product_id . ' '
        . 'LIMIT 1';
$db->setQuery($sql);
$prod  = $db->LoadObject();
//pr($prod);
$title = $prod->marka . ' ' . $prod->model . ' (' . $prod->NomerKuzov . ')';

$img = $prod->product_thumb_image;

/* * **************************************************************** */

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
$param     = array('ID' => $prod->link);
$req       = $client->MK_GetCarsDeliveryStatuses($param);

if ($req->return == 'Error') {
    $obj = new stdClass;
} else {
    $obj = new SimpleXMLElement($req->return);
}
unset($obj->column);

/* * ****************************************************************** */

$prewlink = 'index.php?option=com_user&view=user&layout=avto&Itemid=' . $_GET['Itemid'];
$editlink = 'index.php?option=com_user&view=user&layout=avto&Itemid=' . $_GET['Itemid'] . '&id=' . $product_id;
?>
<div style="text-align:left;" class="avtolist" >
    <h1><a href="<?php echo $editlink; ?>" ><?php echo $title; ?></a></h1>
    <a style="display:inline-block;width:120px;float:left;margin-right:10px;" href="<?php echo $editlink; ?>" >
        <img style="width:120px;border-radius:5px;" src="<?php echo $img; ?>" />
    </a> 
    <p>Детальная информация об этапах доставки автомобиля</p>
    <p>
        <a href="<?php echo $prewlink; ?>" >Вернутся к списку</a>&nbsp;|&nbsp;
        <a href="<?php echo $editlink; ?>" >Редактировать этот автомобиль</a>
    </p>
    <div style="clear:both;margin-bottom:10px;" ></div>
    <table border="0" class="etapdetail">
        <thead>
        <th>Дата</th>
        <th>Этап</th>
        <th>Средство</th>
        </thead>
        <tbody>
            <tr>
                <td><?php if ($prod->DataPokupki) echo date("d.m.Y", strtotime($prod->DataPokupki)); ?></td>
                <td>Куплен </td>
                <td> дней с момента покупки - <?php echo intval($prod->DneiSMomentaPokupki); ?></td>
            </tr>
            <?php
            if ($obj->row)
                foreach ($obj->row as $item) {

                    $DeliveryStage = (string) $item->Value[1];
                    $DeliveryType  = (string) $item->Value[3];
                    $Sender        = (string) $item->Value[5];
                    $Recipient     = (string) $item->Value[7];
                    $DateIn        = (string) $item->Value[9];
                    $DateOut       = (string) $item->Value[8];
                    $NunSrDost     = (string) $item->Value[8];

                    $time = (int) strtotime($DateIn);
                    if ($time > 0) {
                        $data = date("d.m.Y", strtotime($DateIn));
                    } elseif (strtotime($DateOut) > 0) {
                        $data = date("d.m.Y", strtotime($DateOut));
                    } else {
                        $data = ' - ';
                    }

                    echo '<tr>
				<td>' . $data . '</td>
				<td>' . $DeliveryStage . '</td>
				<td>' . $DeliveryType . '</td>
			</tr>';
                }
            ?>
            <tr>
                <td>&nbsp;</td>
                <td>Номер средства доставки</td>
                <td><?php echo $prod->NumSrDost; ?></td>
            </tr>
        </tbody>
    </table>
</div>