
<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

$database 	=& JFactory::getDBO();

//$query = "SELECT * FROM #__vm_product GROUP BY model;";
$query = "SELECT DISTINCT marka FROM #__vm_product;";

$database->setQuery($query);

$c = $database->loadObjectList();
$len = count($c);
?>

<div class="cataloghead">
	<!--<table cellpadding="0" cellspacing="0">
		<tr height="25">
			<td width="5">&nbsp;</td>
			<td class="select chright currency_listtd currency_listopen">
				<div style="position:relative;"><div class="currency_list"></div></div>
				<span>Валюта</span>
			</td>
			<td width="34"><div class="chright currency_listopen" id="div_select_currency"></div></td>
		</tr>
	</table>-->
	<ul class="currency_list2"></ul>
</div>
<script>
	var selectcurrencyopen = false;
	var selectmarkaopen = false;
	jQuery(document).ready(function(){
		jQuery("body").click(function(){
			if (!selectcurrencyopen) jQuery(".currency_list").css("display","none");
			selectcurrencyopen = false;
			
			if (!selectmarkaopen) jQuery(".marka_list").css("display","none");
			selectmarkaopen = false;
		});
		jQuery('#select_auto').change(function(){
			var chosenModel = jQuery('#select_auto').val();
			location = "index.php?option=com_virtuemart&Itemid=2&cm=" + chosenModel;
			
		});
		//выбор валюты
		var option_cur = '';
		var sel = '';
		jQuery(".currency select option").each(function(i,elem){
			if (jQuery(this).attr("selected")) sel = 'class="sel"'; else sel = '';
			//option_cur += '<div '+sel+' onclick="setSelect(\''+jQuery(this).attr("value")+'\',\''+jQuery(this).text()+'\',event)">'+jQuery(this).text()+'</div>';
			option_cur += '<li '+sel+' onclick="setSelect(\''+jQuery(this).attr("value")+'\',\''+jQuery(this).text()+'\',event)">'+jQuery(this).text()+'</li>';
		});
		
		jQuery(".currency_list2").html(option_cur);
		
		jQuery(".currency_listopen").click(function(){
			jQuery(".currency_list").css("display","block");
			selectcurrencyopen = true;
		});
		jQuery(".currency_listtd span").html(jQuery(".currency select option:selected").val());
		
		//выбор марки авто
		var option_marka = '';
		var selm = '';
		jQuery("#select_auto option").each(function(i,elem){
			if (jQuery(this).attr("selected")) sel = 'class="sel"'; else sel = '';
			option_marka += '<div '+sel+' onclick="setMarka(\''+jQuery(this).attr("value")+'\',\''+jQuery(this).text()+'\',event)">'+jQuery(this).text()+'</div>';
		});
		
		jQuery(".marka_list").html(option_marka);
		
		jQuery(".marka_listopen").click(function(){
			jQuery(".marka_list").css("display","block");
			selectmarkaopen = true;
		});
		jQuery(".marka_listtd span").html(jQuery("#select_auto option:selected").html());
	});
	function setSelect(id,value,event)
		{
			event.stopPropagation();
			jQuery(".currency_list").css("display","none");
			jQuery(".currency_listtd span").html(value);
			jQuery(".currency select").val(id).change();
		}
	function setMarka(id,value,event)
		{
			event.stopPropagation();
			jQuery(".marka_list").css("display","none");
			jQuery(".marka_listtd span").html(value);
			jQuery("#select_auto").val(id).change();
		}
</script>

