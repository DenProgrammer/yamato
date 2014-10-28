<?php
/**
 * @version		$Id: article.php 21148 2011-04-14 17:30:08Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

/**
 * Item Model for an Article.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 * @since		1.6
 */
class AukModelMail extends JModel
{
	public function sendMail($link)
		{	
			$thisuser = JFactory::getUser();
			$owner = $thisuser->name;
			$mailer =& JFactory::getMailer();

			$config =& JFactory::getConfig();
			$sender = array($config->getValue('config.mailfrom'), $config->getValue('config.fromname') );
			$mailer->setSender($sender);

			$user =& JFactory::getUser(62);//администратор
			$recipient = $user->email;
			$mailer->addRecipient($recipient);
			
			$body   = "Пользователь $owner заказал автомобиль - <a href='$link'>перейти на аукционы ASNET</a>";
			$mailer->isHTML(true);
			$mailer->setSubject('Новый заказ с аукциона ASNET');
			$mailer->setBody($body);

			$isOK = $mailer->Send();
			
			if ($isOK) $res = 'Сообщение отправлено'; else $res = 'Ошибка отправки сообщения';
			
			return $res;
		}
}
