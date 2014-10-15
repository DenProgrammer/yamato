<?php
/**
 * @version		$Id: categories.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Weblinks Component Categories Model
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class SincroniseModelMakmal extends JModel
{
	public function getData()
		{
			$link = JRequest::getVar('link');
			$db = JFactory::getDBO();
			
			$xml = "<?xml version='1.0' ?>
	<root>
		<message>$link</message>
	</root>";

			$dop_param = array('login'=>"ДляСайта", 'password'=>"YamatoKG13");
			$client = new SoapClient('http://212.112.123.205/YaMoto/ws/yamoto.1cws?wsdl',$dop_param);
			$param = array('Message'=>$xml);
			$req = $client->MK_GetListOfWorkOrders($param);
			
			if ($req->return == 'Error')
				{
					$obj = new stdClass;
				}
			else
				{
					$obj = new SimpleXMLElement($req->return);
				}
			return $obj;
		}
	public function saveData()
		{
			$db = JFactory::getDBO();
			
			$save_link = JRequest::getVar('save_link');
			$item_link = JRequest::getVar('RabotaLink');
			$all_links = JRequest::getVar('all_links');
			
			$links = explode(',',$all_links);
			$mas = array();
			
			$items = '';
			foreach($links as $l)
				{
					if ($item_link["'$l'"]) $r = 1; else $r = 0;
					$mas[$l] = $r;
					$t = explode('___',$l);
					$avtoLink = $t[1];
					$RabotaLink = $t[0];
					$items .= "	
		<item>
			<AvtoLink>$avtoLink</AvtoLink>
			<RabotaLink>$RabotaLink</RabotaLink>
			<Status>$r</Status>
		</item>";
				}
			
			$xml = "<?xml version='1.0' ?>
<root>
	<order_link>$save_link</order_link>
	<items>$items
	</items>
</root>";
		
			$dop_param = array('login'=>"ДляСайта", 'password'=>"YamatoKG13");
			$client = new SoapClient('http://212.112.123.205/YaMoto/ws/yamoto.1cws?wsdl',$dop_param);
			$param = array('Message'=>$xml);
			$req = $client->MK_UploadListOfWorkOrders($param);
			echo 'save ok';
			return true;
		}
	public function sendMail()
		{
			$mailer = JFactory::getMailer();

			$config = JFactory::getConfig();
			$sender = array($config->getValue('config.mailfrom'), $config->getValue('config.fromname') );
			$mailer->setSender($sender);

			$recipient = $email;
			$mailer->addRecipient($recipient);

			$body   = "<h4>Здравствуйте, $name!</h4>
			<br>
			<p>Это автоматическое приглашение на сайт www.yamato.kg, 
			где вы можете посмотреть свои личные данные, автомобили и узнать другую полезную информацию.</p>
			<br>
			<p>Для входа на сайт, воспользуйтесь следующими реквизитами:</p>
			<p>имя пользователя: $username</p>
			<p>пароль: $origpass</p>
			<br>
			<p>После входа вы можете сменить ваши логин и пароль в разделе 'Настройки'.</p>
			<br>
			<p>Спасибо, что вы с нами!</p>
			<p>С уважением, автосалон 'Ямато'</p>";
			$mailer->isHTML(true);
			$mailer->setSubject('Your subject string');
			$mailer->setBody($body);

			$mailer->Send();
		}
}
?>
