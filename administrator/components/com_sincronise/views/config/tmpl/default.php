<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript" src="../templates/beez/javascript/jquery.js"></script>
<script>
	jQuery.noConflict();
	
	function getDataFromXML(data,tag)
		{
			var st_tag = '<'+tag+'>';
			var ed_tag = '</'+tag+'>';
			var st = data.indexOf(st_tag)+st_tag.length;
			var ed = data.indexOf(ed_tag);
			
			return data.substring(st,ed);
		}
	function loadExcel()
		{
			var url = 'index.php?option=com_sincronise&view=config&type=loadExcel&tmpl=component';
			
			jQuery.get(url,{},function(data){
				var content = getDataFromXML(data,'content');
				var status = getDataFromXML(content,'status');
				var count = getDataFromXML(content,'count');
				
				alert('Загузка завершена, обновлено '+count+' записей')
			});
		}
</script>
<a href="index.php?option=com_sincronise&view=sincronise">К тарифам</a>
<br>
<br>
<form method="post" action="">
	<table>
		<tr><td>ip адрес 1С сервера</td><td><input size="100" type="text" value="<?php echo $this->conf['server1cip']; ?>" name="conf[server1cip]"/></td></tr>
		<tr><td>логин 1С сервера</td><td><input size="100" type="text" value="<?php echo $this->conf['server1clogin']; ?>" name="conf[server1clogin]"/></td></tr>
		<tr><td>пароль 1С сервера</td><td><input size="100" type="text" value="<?php echo $this->conf['server1cpass']; ?>" name="conf[server1cpass]"/></td></tr>
	</table>
	<input type="submit" name="btnsave" value="Сохранить"/>
	<input type="hidden" name="action" value="saveconf"/>
</form>
<br>
<br>
<input type="button" value="Загрузить данные из файлов EXCEL" onclick="loadExcel()"/>
