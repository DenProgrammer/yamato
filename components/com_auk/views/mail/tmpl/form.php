<?php
/**
 * @version		$Id: view.html.php 20801 2011-02-21 19:22:18Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;
?>
<div id="send_msg_body" >
	<div id="send_msg_win" >
		<div style="position:relative" >
			<div class="send_close" >X</div>
		</div>
		<div class="send_title" >Отправка ссылки на <?php echo $this->product_name; ?></div>
		<table width="100%" class="send_table" >
			<tr>
				<td class="send_td">
					<div class="row" >
						<div class="label label-red" >Ваше имя</div>
						<input type="text" id="send_name" value="" />
					</div>
					<div class="row" >
						<div class="label label-red" >Ваша электронная почта</div>
						<input type="text" id="send_email_from" value="" />
					</div>
					<div class="row" >
						<div class="label label-red" >Электронная почта получателя</div>
						<input type="text" id="send_email_to" value="" />
					</div>
					<div class="row" >
						<div class="label" >Ваш комментарий</div>
						<textarea id="send_comment" ></textarea>
					</div>
				</td>
				<td>
					<div class="note" >
						<hr />
						<div>
							Нужно обязательно<br />
							заполнить поля<br /> 
							с подписями<br />
							красного цвета
						</div>
					</div>
					<input type="button" value="Отправить" id="btn_send" />
				</td>
			</tr>
		</table>
	</div>
</div>