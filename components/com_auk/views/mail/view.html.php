<?php
/**
 * @version		$Id: view.html.php 20801 2011-02-21 19:22:18Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit an article.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class AukViewMail extends JView
	{
		public function display($tpl = null)
			{
				$link = JRequest::getVar('link');
				
				if ((isset($_REQUEST['sendlink'])) and ($_REQUEST['sendlink'] == 'form'))
					{
						$id = (int) $_REQUEST['id'];
						
						$sql = 'SELECT `product_name` FROM `#__vm_product` WHERE `product_id`='.$id;
						$db = JFactory::getDBO();
						$db->setQuery($sql);
						$this->product_name = $db->LoadResult();
						
					}
				if ((isset($_REQUEST['sendlink'])) and ($_REQUEST['sendlink'] == 'save'))
					{
						$send_name = $_REQUEST['send_name'];
						$send_email_from = $_REQUEST['send_email_from'];
						$send_email_to = $_REQUEST['send_email_to'];
						$send_comment = $_REQUEST['send_comment'];
						$id = (int) $_REQUEST['id'];
						
						if (($send_name) and ($send_email_from) and ($send_email_to))
							{
								$sql = 'SELECT `product_name`, `product_type` FROM `#__vm_product` WHERE `product_id`='.$id;
								$db = JFactory::getDBO();
								$db->setQuery($sql);
								$product = $db->LoadObject();
								$product_name = $product->product_name;
								$product_type = $product->product_type;
								
								$flypage = ($product_type == 'automobil') ? '' : 2;
								
								$mailer =& JFactory::getMailer();

								$config =& JFactory::getConfig();
								$sender = array($send_email_from, $send_name );
								$mailer->setSender($sender);
								$mailer->addRecipient($send_email_to);
								$link = 'http://yamato.kg/index.php?page=shop.product_details&flypage=flypage'.$flypage.'.tpl&product_id='.$id.'&option=com_virtuemart';
								
								$body   = "Добрый день!<br />\r\n
								<br />\r\n
								Посмотрите <a href='$link'>$product_name</a> на yamato.kg.<br />\r\n
								<br />\r\n
								$send_comment<br />\r\n
								<br />\r\n
								$send_name";
								$mailer->isHTML(true);
								$mailer->setSubject('С вами поделились ссылкой на сайт yamato.kg');
								$mailer->setBody($body);

								$isOK = $mailer->Send();
								
								if ($isOK) $res = 'Сообщение отправлено
												<br />
												<br />
												<br />
												<br />
												<br />
												<br />
												<br />
												<br />
												<input type="button" value="Закрыть" onclick="jQuery(\'#send_msg_body\').remove();" class="btn_close send_close" />'; else $res = 'Ошибка отправки сообщения';
							}
						else
							{
								$res = 'Заполните все поля';
							}
						
						echo $res;
						exit;
					}
				
				$this->res = '';
				if ($link) 
					{
						$this->res = AukModelMail::sendMail($link);
					}
				
				parent::display($tpl);
			}
	}