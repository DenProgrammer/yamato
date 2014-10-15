<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
// подключаем библеотеку modelitem Joomla 
jimport('joomla.application.component.modelitem');
// Создаем класс модели
class YfaqModelYfaq extends JModel
	{	
		public function getData() 
			{
				$db	= $this->getDbo();//получение экземпляра базы данных
				$id = JRequest::getInt('id');
				$p = JRequest::getInt('p');
				
				if (!$p>0) $p = 0;
				$pmax = 10;
				$a = $p*$pmax;
				
				$arr = null;
				if ($id>0)
					{
						$sql = 'SELECT * FROM `#__yfaq` WHERE `id`='.$id.' LIMIT 1';
						$db->setQuery($sql);
						$arr = $db->loadObject();
					}
				else 
					{
						$count = 5;
						$sql = 'SELECT * FROM `#__yfaq` ORDER BY `cdate` DESC LIMIT '.$a.', '.$pmax;
						$db->setQuery($sql);
						$arr = $db->loadObjectList();
					}
				
				return $arr;
			}	
		public function getDelete() 
			{
				$db	= $this->getDbo();
				$id = JRequest::getInt('id');
				
				$sql = "DELETE FROM `#__yfaq` WHERE `id`='$id'";
				$db->setQuery($sql);
				$db->query();
			}
		public function getSave() 
			{
				$db		=	JFactory::getDbo();
				$id		=	JRequest::getInt("id");
				
				// Добавление категорий переменные
				$answer	=	mysql_real_escape_string(JRequest::getVar("answer"));
				$objid	=	JRequest::getInt("objid");
				$publication	=	JRequest::getVar("publication");
				
				$mdate =  time();
				
				if ($objid>0)
					{
						$sql = "UPDATE `#__yfaq` 
								SET `mdate` = '$mdate', `answer` = '$answer', `publication` = '$publication' 
								WHERE `id` ='$objid'";				
						$db->setQuery($sql);
						$db->query();
					}
			}
	}

