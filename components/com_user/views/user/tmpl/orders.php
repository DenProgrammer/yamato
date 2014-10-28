<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

?>
<script>
	var num = 1;
	function showReport()
		{
			var date1 = jQuery("#Date1").attr("value");
			var date2 = jQuery("#Date2").attr("value");
			var url = 'index.php?option=com_sincronise&type=showOrderFinans&ajax=1';
			
			jQuery.get(url,{date1:date1,date2:date2},function(data){
				jQuery("#reportresult").html(data);
				
				if (jQuery('#total_currency'))
					{
						jQuery('#total_currency').change(function(){
							var val = parseInt(jQuery(this).val());
							
							jQuery('.sc_currences').css('display','none');
							if (val>0)
								{
									jQuery('.sc_'+val).css('display','table-row');
								}
							else
								{
									jQuery('.sc_currences').css('display','table-row');
								}
						});
					}
			});
		}
	function showDoc(link)
		{
			var winname = 'newwin'+num;
			window.open('index.php?option=com_sincronise&type=showDoc&ajax=1&link='+link+'&tmpl=ajax', winname, 'width=800,height=600,menubar=1,scrollbars=1,target=_blank');
			num++;
		}
	jQuery("document").ready(function(){
		jQuery("#Date1").datepicker({dateFormat: 'dd.mm.yy'});
		jQuery("#Date2").datepicker({dateFormat: 'dd.mm.yy'});
		
		showReport();
	});
</script>
<div class="kabinet">
	<h1>Отчеты</h1>
	<p>
		Стандартный отчет - 
		<a href="index.php?option=com_user&view=user&layout=orders2&Itemid=7">Детализированный отчет</a> - 
		<a href="index.php?option=com_user&view=user&layout=orders3&Itemid=7">Детализированный отчет новый</a>
	</p>
	Начиная с: <input type="text" readonly value="<?php $time = strtotime("-1 year", time()); echo date("d.m.Y",$time) ?>" id="Date1"/>
	по: <input type="text" readonly value="<?php echo date("d.m.Y") ?>" id="Date2"/>
	<input type="button" value="Сформировать" onclick="showReport()"/>
	<div id="reportresult"></div>
	
</div>