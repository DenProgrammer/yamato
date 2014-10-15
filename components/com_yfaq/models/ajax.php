<?php
// Защита от прямого доступа к файлу
defined('_JEXEC') or die('Restricted access');
// подключаем библеотеку modelitem Joomla 
jimport('joomla.application.component.modelitem');
// Создаем класс модели
class YfaqModelAjax extends JModel
	{	
		public function getMonthName($month)
			{
				$month = (int) $month;
				$m = array(
						'0'=>'',
						'1'=>'Января',
						'2'=>'Февраля',
						'3'=>'Марта',
						'4'=>'Апреля',
						'5'=>'Мая',
						'6'=>'Июня',
						'7'=>'Июля',
						'8'=>'Августа',
						'9'=>'Сентября',
						'10'=>'Октября',
						'11'=>'Ноября',
						'12'=>'Декабря'
					);
				return $m[$month];
			}
		public function getSave() 
			{
				$db	= JFactory::getDbo();
				
				$name = JRequest::getVar("name");
				$email = JRequest::getVar("email");
				$qwest = JRequest::getVar("qwest");
				$capcha = JRequest::getVar("capcha");
				
				$obj->msg = '';
				$obj->error = 0;
				
				if ($_SESSION['yfaq_capcha']!=trim($capcha)) 
					{
						$obj->msg = 'Неверно указана капча';
						$obj->error = 1;
						return $obj;
					}
				$cdate = time();
				
				if (($name) and ($email) and ($qwest))
					{
						$sql = "INSERT INTO `#__yfaq` (
								`cdate`, `qwest`, `answer`, `name`, `email`, `publication`
								) VALUES (
								'$cdate', '$qwest', '', '$name', '$email', '0')";
						$db->setQuery($sql);
						$res = $db->query($sql);
						
						$obj->msg = 'Спасибо за ваш вопрос. В ближайшее время мы ответим на него, ответ можно будет увидеть на этой странице';
						$obj->error = 0;
						return $obj;
					}
				else 
					{
						$obj->msg = 'Сохранение не удалось, заполните все поля';
						$obj->error = 2;
						return $obj;
					}
			}
		public function getData() 
			{
				$db	= JFactory::getDbo();
				
				$step = JRequest::getInt("step");
				$maxcount = 10;
				
				$sql = "SELECT COUNT(`id`) AS `countid` 
						FROM `#__yfaq` 
						WHERE `publication`=1";
				$db->setQuery($sql);
				$count = $db->LoadResult();
				
				$p = ($step-1)*$maxcount;
				$sql = "SELECT * 
						FROM `#__yfaq` 
						WHERE `publication`=1
						ORDER BY `id` DESC
						LIMIT $p, $maxcount";
				$db->setQuery($sql);
				$rows = $db->LoadObjectList();
				$data = '';
				$uname = 'Автоцентр Yamato';
				foreach($rows as $row)
					{
						$id = $row->id;
						$cdate = ($row->cdate>0) ? date("d",$row->cdate).' '.$this->getMonthName(date("m",$row->cdate)).' '.date("Y H:i",$row->cdate) : '';
						$mdate = ($row->mdate>0) ? date("d",$row->cdate).' '.$this->getMonthName(date("m",$row->cdate)).' '.date("Y H:i",$row->cdate) : '';
						$qwest = $row->qwest;
						$answer = $row->answer;
						$name = $row->name;
						
						$data .= "	<div class='yfaq_qwest'>
										<div class='yfaq_qwest_name'>$name</div>
										<div class='yfaq_cdate'>$cdate</div>
										<div class='yfaq_qwest_text'>$qwest</div>
										<div class='yfaq_answer'>
											<div class='yfaq_answer_name'>$uname</div>
											<div class='yfaq_mdate'>$mdate</div>
											<div class='yfaq_answer_text'>$answer</div>
										</div>
									</div>";
					}
					
				$data .= YfaqController::getPagination($maxcount,$count,$step);
				$obj->msg = $data;
				$obj->error = 0;
				
				return $obj;
			}
	}

