<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

?>
<ul class="usercabmenu">
	<?php
		foreach($this->usermenu as $um)
			{
				$active = ($um->active == 1) ? ' class="active" ' : '';
				echo '<li '.$active.'><a href="'.$um->url.'">'.$um->name.'</a></li>';
			}
	?>
</ul>
Здесь будет общая информация о пользователе и его заказах и платежах
