<?php
if (!defined('_JEXEC')) die('Direct Access');

$user = JFactory::getUser();
$password = $params->get('password');

if ($user->id>0) {
?>
<div style="text-align:left;vertical-align:top;margin-top:10px;margin-bottom:0px;">
	<br />
	<form target="_blank" action="http://makmal.jthing.com/cars/login.asp?lang=Russian" method="post" name="loginForm"> 
		<input name="goto" value="/cars/search.asp" type="hidden" /> 
		<input name="login" value="<?php echo $user->email; ?>" type="hidden" /> 
		<input name="pass" value="<?php echo $password; ?>" type="hidden" /> 
		<input class="btn" style="background:url(http://jauto.kg/images/wn.png) center center no-repeat;width: 185px; height: 90px;border:none;cursor:pointer;" value=" " title="Перейти к аукционам WorldNavi" type="submit" /> 
	</form>
</div>
<br clear="all" />
<div style="text-align:left;vertical-align:top;margin-top:5px;margin-bottom:15px;" >
<a title="Перейти к аукционам ASNET" href="/index.php?option=com_auk&amp;view=auk&amp;Itemid=25" target="_blank" ><img style="vertical-align:middle;" src="http://jauto.kg/images/an.png" /></a>
</div>
<div style="text-align:left;vertical-align:top;margin-bottom:15px;" >
<a title="Перейти к аукционам Сток World Navi" href="http://www.worldnavi.jp/Offer.mvc" target="_blank" ><img style="vertical-align:middle;" src="images/stock.jpg" /></a>
</div>
<?php } else { ?>
<div style="text-align:left;vertical-align:top;margin-top:10px;margin-bottom:15px;">
	<br />
	<form action="http://makmal.jthing.com/cars/login.asp" method="post" name="loginForm" target="_blank" > 
		<input name="login" value="demojp" type="hidden" /> 
		<input name="pass" value="123456" type="hidden" /> 
		<input class="btn" style="background:url(images/makmall.jpg) center center no-repeat;width: 608px; height: 90px;border:none;cursor:pointer;" value=" " title="Перейти к аукционам WorldNavi" type="submit" /> 
	</form>
</div>
<?php } ?>
<div style="text-align:left;vertical-align:top;margin-top:5px;margin-bottom:15px;" >
<a title="Перейти к аукционам www.exportofcars.com" target="_blank" href="http://www.exportofcars.com/carsearch/" ><img style="vertical-align:middle;" src="images/eoc.jpg" /></a>
</div>