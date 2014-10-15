
<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

$database 	=& JFactory::getDBO();

//$query = "SELECT * FROM #__vm_product GROUP BY model;";
$query = "SELECT DISTINCT model FROM #__vm_product;";

$database->setQuery($query);

$c = $database->loadObjectList();
$len = count($c);
?>

<div class="cataloghead">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr height="33">
			<td class="title">Каталог автомобилей</td>
			<td>&nbsp;</td>
			<td class="select chright">Валюта</td>
			<td width="34"><div class="chright"></div></td>
			<td class="select chright">Марка Авто</td>
			<td width="34">
				<div class="chright" id="div_select_auto">
					<select class="select_auto" style="position: relative; right: 105px; top: 5px; z-index: 3;">
						<?php 
							$carModel = JRequest::getVar('cm');
							
							for($i = 0; $i < $len; $i++)
								{
									if($c[$i]->model == ''){}
									else if($c[$i]->model == $carModel)
										echo '<option value="'.$c[$i]->model.'" selected="true">'.$c[$i]->model.'</option>';
									else 
										echo '<option value="'.$c[$i]->model.'">'.$c[$i]->model.'</option>';
								}
						?> 
					</select>
				</div>
			</td>
		</tr>
	</table>
</div>

<?php

$carModel = JRequest::getVar('cm');

$query2 = "SELECT * FROM #__vm_product WHERE model = '$carModel';";
$database->setQuery($query2);
$d = $database->loadObjectList();

echo '<pre>';
	//print_r($d);
echo '</pre>';
	
$carsNumber = count($d);
echo '<div id="vmMainPage">
		<div class="buttons_heading"> </div>
		<h3>Автомобили</h3>
		<div style="text-align:left;"> </div>
	';
	
for($j = 0; $j < $carsNumber; $j++)
{
	echo "<div class='browseProductContainer2' style='float: left; width: 210px; margin-left: 10px;' onclick=\"document.location='index.php?page=shop.product_details&flypage=flypage.tpl&product_id=".$d[$j]->product_id."&category_id=1&option=com_virtuemart&Itemid=1'\">";
	echo "<div style='color: #AA0101; position: relative; font: bold 18px Calibri; right: 20px; top: 15px; float: right; z-index: 3;'> $0.00 </div>";
	echo "<div style='overflow:hidden;width:190px;height:135px; margin: auto; padding-top: -15px; position: relative; z-index: 2;'>
			<img class='browseProductImage' border='0' width='190' height='129' alt='".$d[$j]->product_name."' title='".$d[$j]->product_name."' src='http://yamato.kg/new/components/com_virtuemart/themes/default/images/noimage.gif'>
		 </div>";
	echo "<div style='padding-top: -18px; font-size: 12px;'>".$d[$j]->product_name."</div>";			
	echo "</div>";
}

echo '</div>';
echo "<div id='end' style='clear: both;'></div>";
echo "<br/>";
/*
echo "<h1>".$carsNumber."</h1>";
echo "<hr />"; */
?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

<script>
	$(document).ready(function(){
		$('.select_auto').change(function(){
			$chosenModel = $('.select_auto').val();
			location = "http://yamato.kg/new/index.php?option=com_virtuemart&Itemid=2&cm=" + $chosenModel;
		});
		
		$('.moduletable').hide();
		
		//index.php?option=com_carfiltr&view=carfiltr
		$('#div_select_auto').click(function(){
			//$('#select_auto').click();
			//$('#select_auto').css("z-index: 3");
			//alert("11");
		});
	});
</script>

