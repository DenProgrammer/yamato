<?php // no direct access
defined('_JEXEC') or die('Restricted access');
 ?>
<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
	});
// -->
</script>
<?php
	if(isset($this->message)){
		$this->display('message');
	}
?>
<style>
.moduletable-brdcrumbs{display:none;}
</style>
<form action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">

<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><?php echo 'Регистрация нового пользователя'; ?></div>
<?php endif; ?>

<table cellpadding="0" cellspacing="0" border="0" width="500" style="margin:0 auto;" class="contentpane">
<tr>
	<td width="30%" height="40" align="left">
		<label id="namemsg" for="name">
			Как вас зовут:
		</label>
	</td>
  	<td>
  		<input type="text" name="name" id="name" size="40" value="<?php echo $this->escape($this->user->get( 'name' ));?>" class="inputbox required" maxlength="50" /> *
  	</td>
</tr>
<tr>
	<td height="40" align="left">
		<label id="usernamemsg" for="username">
			Имя пользователя для входа:
		</label>
	</td>
	<td>
		<input type="text" id="username" name="username" size="40" value="<?php echo $this->escape($this->user->get( 'username' ));?>" class="inputbox required validate-username" maxlength="25" /> *
	</td>
</tr>
<tr>
	<td height="40" align="left">
		<label id="emailmsg" for="email">
			<?php echo JText::_( 'Email' ); ?>:
		</label>
	</td>
	<td>
		<input type="text" id="email" name="email" size="40" value="<?php echo $this->escape($this->user->get( 'email' ));?>" class="inputbox required validate-email" maxlength="100" /> *
	</td>
</tr>
<tr>
	<td height="40" align="left">
		<label id="addresmsg" for="addres">
			Адрес:
		</label>
	</td>
	<td>
		<input type="text" id="addres" name="params[addres]" size="40" value="" class="inputbox" maxlength="100" /> &nbsp;&nbsp;
	</td>
</tr>
<tr>
	<td height="40" align="left">
		<label id="phonemsg" for="phone">
			Телефон:
		</label>
	</td>
	<td>
		<input type="text" id="phone" name="params[phone]" size="40" value="" class="inputbox" maxlength="100" /> &nbsp;&nbsp;
	</td>
</tr>
<tr>
	<td height="40" align="left">
		<label id="pwmsg" for="password">
			<?php echo JText::_( 'Password' ); ?>:
		</label>
	</td>
  	<td>
  		<input class="inputbox required validate-password" type="password" id="password" name="password" size="40" value="" /> *
  	</td>
</tr>
<tr>
	<td height="40" align="left">
		<label id="pw2msg" for="password2">
			Пароль еще раз:
		</label>
	</td>
	<td>
		<input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" /> *
	</td>
</tr>
<tr>
	<td height="40" align="left">
		<label id="kpmsg" for="kcaptcha">
			<?php echo JText::_( 'Подтвердите что вы человек' ); ?>:
		</label>
	</td>
  	<td>
		<img src="kcaptcha.php" />
  		<input class="inputbox required validate-kcaptcha" type="text" id="kcaptcha" name="kcaptcha" size="40" value="" /> *
  	</td>
</tr>
<tr>
	<td colspan="2" height="40">
		<?php echo JText::_( 'REGISTER_REQUIRED' ); ?>
	</td>
</tr>
</table>
	<button class="button validate" type="submit">Отправить</button>
	<input type="hidden" name="task" value="register_save" />
	<input type="hidden" name="id" value="0" />
	<input type="hidden" name="gid" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
